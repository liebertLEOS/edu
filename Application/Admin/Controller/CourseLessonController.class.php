<?php
/**
 *          CourseLessonController(Admin\Controller\CourseController.class.php)
 *
 *    功　　能：课程课时管理控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/10 16:53
 *    修　　改：2018/04/10
 *
 */

namespace Admin\Controller;
use Think\Upload;
use Think\Page;

class CourseLessonController extends BaseController {

    /**
     * 显示课程课时列表
     */
    public function index()
    {
        $courseId = I('request.course_id', 0);

        // 必须要有课程id
        if ($courseId == 0) {
            $this->error('参数不完整');
        }

        // 获取课程信息
        $course = M('Course')->where("id={$courseId}")->find();

        // 获取课时列表
        $items = $this->getCourseLessonItems($courseId);

        // var_dump($items);

        $this->assign('courseId', $courseId);
        $this->assign('course', $course);
        $this->assign('items', $items);
        $this->display();
    }

    public function addLesson()
    {
        $courseId = I('request.course_id', 0);

        if ($courseId ==0 ){
            return '参数不完整';
        }

        if (IS_POST) {
            $title = I('post.title');
            $summary = I('post.summary', '');
            $content = I('post.content', '');
            $type = I('post.type', 'text');

            if ('' == $title) {
                $this->ajaxReturn(array(
                    'success' => false,
                    'message' => '标题不能为空！'
                ));
            }

            // 获取课程设置数据
            $sourseSetting = M('setting')->where('name="course"')->find();
            $sourseSetting = unserialize($sourseSetting);

            $lesson = array(
                'courseId' => $courseId,
                'chapterId' => 0,
                'free' => 0,
                'title' => $title,
                'summary' => $summary,
                'tags' => array(),
                'type' => $type,
                'content' => $content,
                'media' => array(),
                'mediaId' => 0,
                'length' => 0,
                'startTime' => 0,
                'giveCredit' => 0,
                'requireCredit' => 0,
                'liveProvider' => 'none',
                'copyId'=>0
            );

            $course = $this->getCourse($lesson['courseId']);
            if (empty($course)) {
                $this->ajaxReturn(array(
                    'success' => false,
                    'message' => '添加课时失败，课程不存在。'
                ));
            }

            // 课程处于发布状态时，新增课时，课时默认的状态为“未发布"
            $lesson['status'] = $course['status'] == 'published' ? 'unpublished' : 'published';
            $lesson['free'] = empty($lesson['free']) ? 0 : 1;
            $lesson['number'] = $this->getNextLessonNumber($lesson['courseId']);
            $lesson['seq'] = $this->getNextCourseItemSeq($lesson['courseId']);
            $lesson['userId'] = $this->uid;
            $lesson['createdTime'] = time();

            $lastChapter = $this->getLastChapterByCourseId($lesson['courseId']);
            $lesson['chapterId'] = empty($lastChapter) ? 0 : $lastChapter['id'];

            if(array_key_exists('copyId', $lesson)){
                $lesson['copyId']=$lesson['copyId'];
            }

            $id = M('courseLesson')->data($lesson)->add();

            if ($id) {
                $this->ajaxReturn(array(
                    'success' => true,
                    'message' => '添加课时成功！'
                ));
            }

            $this->ajaxReturn(array(
                'success' => false,
                'message' => '添加课时失败！'
            ));
        }

        $materialList = D('CourseMaterialView')->where("courseId={$courseId} AND ext IN('mp4','avi')")->limit(100)->select();
        
        $this->assign('courseId', $courseId);
        $this->assign('materialList', $materialList);
        $this->display('edit');

    }

    /**
     * 课时排序
     */
    public function sort()
    {
        $itemIds = I('request.ids');
        $courseId = I('request.course_id', 0);

        if ($courseId == 0 ){
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '参数不完整'
            ));
        }

        $items = $this->getCourseLessonItems($courseId);

        $existedItemIds = array_keys($items);
        if (count($itemIds) != count($existedItemIds)) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => 'itemdIds参数不正确'
            ));
        }

        $diffItemIds = array_diff($itemIds, array_keys($items));
        if (!empty($diffItemIds)) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => 'itemdIds参数不正确'
            ));
        }

        $lessonNum = $chapterNum = $unitNum = $seq = 0;
        $currentChapter = $rootChapter = array('id' => 0);

        foreach ($itemIds as $itemId) {
            $seq ++;
            list($type, ) = explode('-', $itemId);
            switch ($type) {
                case 'lesson':
                    $lessonNum ++;
                    $item = $items[$itemId];
                    $fields = array('number' => $lessonNum, 'seq' => $seq, 'chapterId' => $currentChapter['id']);
                    if ($fields['number'] != $item['number'] || $fields['seq'] != $item['seq'] || $fields['chapterId'] != $item['chapterId']) {
                        $this->updateLesson($courseId,$item['id'], $fields);
                    }
                    break;
                case 'chapter':
                    $item = $currentChapter = $items[$itemId];
                    $chapter = $this->getChapter($courseId, $item['id']);
                    if ($item['type'] == 'unit') {
                        $unitNum ++;
                        $fields = array('number' => $unitNum, 'seq' => $seq, 'parentId' => $rootChapter['id'],'title'=>$chapter['title']);
                    } else {
                        $chapterNum ++;
                        $unitNum = 0;
                        $rootChapter = $item;
                        $fields = array('number' => $chapterNum, 'seq' => $seq, 'parentId' => 0,'title'=>$chapter['title']);
                    }
                    if ($fields['parentId'] != $item['parentId'] || $fields['number'] != $item['number'] || $fields['seq'] != $item['seq']) {
                        $argument = $fields;
                        $this->updateChapter($courseId,$item['id'], $fields);
                    }

                    break;
            }
        }

        $this->ajaxReturn(array(
            'success' => true,
            'message' => '排序成功！'
        ));
    }

    public function addChapter()
    {
        $courseId   = I('request.course_id', 0);
        $type       = I('request.type', 'chapter');
        
        if ($courseId == 0){
            $this->error('参数不完整');
        }

        if (IS_POST) {

            if (!in_array( $type, array('chapter', 'unit'))) {
                $this->error('章节类型不正确，添加失败！');
            }

            $title      = I('request.title', '');
            $number = 1;
            $parentId = 0;
            $seq = 1;

            if ($type == 'unit') {
                list($number, $parentId) = $this->getNextUnitNumberAndParentId($courseId);
            } else {
                $number = $this->getNextChapterNumber($courseId);
            }

            // if(array_key_exists('copyId', $chapter)){
            //     $chapter['copyId']=$chapter['copyId'];
            // }

            $seq = $this->getNextCourseItemSeq($courseId);
            $courseChapterModel = M('CourseChapter');

            $id = $courseChapterModel->add(array(
                'courseId' => $courseId,
                'type'  => $type,
                'parentId' => $parentId,
                'number' => $number,
                'seq'   => $seq,
                'title' => $title,
                'createdTime' => time(),

            ));

            if ($id) {
                $this->ajaxReturn(array(
                    'success' => true,
                    'message' => '成功添加！'
                ));
            } else {
                $this->ajaxReturn(array(
                    'success' => false,
                    'message' => $courseChapterModel->getError()
                ));
            }

        }

        $this->assign('type', $type);
        $this->assign('courseId', $courseId);
        $this->display('chapter');
    }

    public function editChapter()
    {
        $chapterId   = I('request.chapter_id', 0);
        
        if ($chapterId == 0){
            $this->error('参数不完整');
        }

        if (IS_POST) {
            $title      = I('request.title', '');

            if ('' == $title) {
                $this->ajaxReturn(array(
                    'success' => false,
                    'message' => '标题不能为空！'
                ));
            }

            M('CourseChapter')->save(array(
                'id' => $chapterId,
                'title' => $title,
            ));

            $this->ajaxReturn(array(
                'success' => true,
                'message' => '更新成功'
            ));
        }

        $chapter = M('CourseChapter')->where("id={$chapterId}")->find();

        if (false) {
            $this->error('章节不存在');
        }

        $this->assign('chapter', $chapter);
        $this->display();
    }

    public function editLesson()
    {
        $lessonId   = I('request.lesson_id', 0);
        
        if ($lessonId == 0){
            $this->error('参数不完整');
        }

        // 更新课时信息
        if (IS_POST) {
            $lesson = M('CourseLesson')->field('id')->where("id={$lessonId}")->find();
        
            if ($lesson == false) {
                $this->error('课时不存在!');
            }

            $title = I('post.title');
            $summary = I('post.summary', '');
            $content = I('post.content', '');
            $type = I('post.type', 'text');
            $free = I('post.free', 0);
            $mediaId = I('post.media_id', 0);

            if ('' == $title || '' == $lessonId) {
                $this->ajaxReturn(array(
                    'success' => false,
                    'message' => '参数不完整!'
                ));
            }

            $lesson = array(
                'id' => $lessonId,
                'title' => $title,
                'summary' => $summary,
                'free' => $free,
                'type' => $type,
                'content' => $content,
                'mediaId' => $mediaId,
            );

            $id = M('courseLesson')->save($lesson);

            $this->ajaxReturn(array(
                'success' => true,
                'message' => '更新成功!'
            ));
        }

        // 查询课程信息
        $lesson = D('CourseLessonMaterialView')->where("course_lesson.id={$lessonId}")->find();
        
        $materialList = D('CourseMaterialView')->where("courseId={$lesson['courseid']} AND ext IN('mp4','avi')")->limit(100)->select();
        
        $this->assign('lesson', $lesson);
        $this->assign('materialList', $materialList);

        $this->display();
    }

    protected function getNextUnitNumberAndParentId($courseId)
    {
        $CourseChapterModel = M('CourseChapter');

        $lastChapter = $CourseChapterModel->field('id')->where("courseId={$courseId} AND type='chapter'")->find();

        $parentId = empty($lastChapter) ? 0 : $lastChapter['id'];

        $unitNum = 1 + $CourseChapterModel->where("courseId={$courseId} AND type='unit' AND parentId={$parentId}")->count();

        return array($unitNum, $parentId);
    }

    protected function getNextChapterNumber($courseId)
    {
        $counter = M('CourseChapter')->where("courseId={$courseId} AND type='chapter'")->count();
        return $counter + 1;
    }

    public function getNextLessonNumber($courseId)
    {
        $counter = M('CourseLesson')->where("courseId={$courseId}")->count();
        return $counter + 1;
    }

    protected function getNextCourseItemSeq($courseId)
    {
        $chapterMaxSeq = M('CourseChapter')->where("courseId={$courseId}")->max('seq');
        $lessonMaxSeq = M('CourseLesson')->where("courseId={$courseId}")->max('seq');
        return ($chapterMaxSeq > $lessonMaxSeq ? $chapterMaxSeq : $lessonMaxSeq) + 1;
    }

    protected function getCourseLessonItems($courseId)
    {
        $courseChapter = M('CourseChapter')->field('id, title, type, parentId, number, seq')->where("courseId={$courseId}")->select();
        $courseLesson = M('CourseLesson')->field('id, title, chapterId, number, seq, status')->where("courseId={$courseId}")->select();

        // 顺序编排seq
        $items = array();
        foreach ($courseLesson as $lesson) {
            $lesson['itemType'] = 'lesson';
            $items["lesson-{$lesson['id']}"] = $lesson;
        }

        foreach ($courseChapter as $chapter) {
            $chapter['itemType'] = $chapter['type'] == 'unit' ? 'chapter-unit' : 'chapter';
            $items["chapter-{$chapter['id']}"] = $chapter;
        }

        uasort($items, function($item1, $item2){
            return $item1['seq'] > $item2['seq'];
        });

        return $items;
    }

    protected function updateLesson($courseId,$id, $fields)
    {
        M('CourseLesson')->where("id={$id}")->save(array(
            'chapterId' => $fields['chapterId'],
            'number'    => $fields['number'],
            'seq'       => $fields['seq']
        ));
    }

    protected function updateChapter($courseId,$id, $fields)
    {
        M('CourseChapter')->where("id={$id}")->save(array(
            'parentId'  => $fields['parentId'],
            'number'    => $fields['number'],
            'seq'       => $fields['seq']
        ));
    }

    protected function getChapter($courseId, $id)
    {
        return M('CourseChapter')->where("id={$id} AND courseId={$courseId}")->find();
    }

    protected function getCourse($courseId)
    {
        return M('Course')->where("id={$courseId}")->find();
    }

    protected function getLastChapterByCourseId($courseId)
    {
        return M('CourseChapter')->where("courseId={$courseId}")->order('seq DESC')->find();
    }


}