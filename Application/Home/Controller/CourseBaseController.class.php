<?php
/**
 *    CourseBaseController(Home\Controller\CourseBaseController.class.php)
 *
 *    功　　能：前台课程基类控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/20 16:37
 *    修　　改：2018/04/20
 *
 */
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class CourseBaseController extends BaseController 
{
     public function getMember($courseId)
     {
          $user = $this->user;

          if (empty($user['id'])) {
               return null;
          }

          if($this->isGrant('ROLE_ADMIN')) {
               $member = array(
                    'id' => 0,
                    'courseId' => $courseId,
                    'userId' => $user['id'],
                    'levelId' => 0,
                    'learnedNum' => 0,
                    'isLearned' => 0,
                    'seq' => 0,
                    'isVisible' => 0,
                    'orderId' => 0,
                    'joinedType' => 'course',
                    'role' => 'teacher',
                    'fake' => true,
                    'locked' => 0,
                    'createdTime' => time(),
                    'deadline' => 0
               );
          } else {
              $member =  $this->getMemberByCourseIdAndUserId($courseId, $user['id']);
          }
          return $member;
          
     }

     public function getMemberByCourseIdAndUserId($courseId, $userId)
     {
          $member = M('CourseMember')->where("courseId={$courseId} AND userId={$userId}")->find();
          return $member;
     }
}