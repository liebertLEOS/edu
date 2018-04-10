<?php
/**
 *          DataBaseController(Admin\Controller\DataBaseController.class.php)
 *
 *    功　　能：文件管理控制器
 *
 *    作　　者：李康
 *    完成时间：2018/04/09 11:22
 *    修　　改：2018/04/09
 *
 */

namespace Admin\Controller;

use Think\Db;
use Org\Util\DataBase;

class DataBaseController extends BaseController {


    public function repair()
    {
        $data = $this->getTables();

        $this->assign('data', $data);
        $this->display();
    }

    /**
     * import
     * @description 数据恢复
     * @author liebert
     */
    public function import()
    {
        $data = $this->getImportList();

        $this->assign('data', $data);
        $this->display();
    }

    /**
     * getImport
     * @description 获取备份项目列表
     * @author liebert
     */
    private function getImportList(){
        //列出备份文件列表
        $path = C('DATA_BACKUP_PATH');
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }
        $path = realpath($path);
        $glob = new \FilesystemIterator($path, \FilesystemIterator::KEY_AS_PATHNAME);

        $list = array();
        // 遍历项目列表
        foreach ($glob as $n => $f) {
            // 一个项目为一个文件夹
            if(is_dir($n)){
                $files =  new \FilesystemIterator($n, \FilesystemIterator::KEY_AS_FILENAME);
                // 遍历卷文件，计算项目信息
                foreach( $files as $name => $file ){
                    if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)){
                        $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                        $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                        $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                        $part = $name[6];

                        if(isset($list["{$date} {$time}"])){
                            $info = $list["{$date} {$time}"];
                            $info['part'] = max($info['part'], $part);
                            $info['size'] = $info['size'] + $file->getSize();
                        } else {
                            $info['part'] = $part;
                            $info['size'] = $file->getSize();
                        }
                        $extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                        $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                        $info['time']     =  "{$date} {$time}";
                        $info['name']     =  date('Ymd-His', strtotime("{$date} {$time}"));

                        $list["{$date} {$time}"] = $info;
                    }
                }
            }

        }
        $list = array_values($list);
        $list  = array_map(function($value){
            $value['size'] = format_bytes($value['size']);
            return $value;
        }, $list);

        return $list;
    }

    /**
     * 执行恢复操作
     * @author liebert
     */
    public function doImport(){
        $name = I('post.file');

        // check param
        if( !$name ){
            $this->ajaxReturn(array(
                "success" => 0,
                "message"   => "参数不完整"
            ));
        }

        // 初始化基本参数
        // 获取备份文件信息
        $path  = realpath(C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $name . '-*.sql*';;
        $files = glob($path);
        // 获取备份卷列表
        $list  = array();
        foreach($files as $name){
            $basename = basename($name);
            $match    = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
            $gz       = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
            $list[$match[6]] = array($match[6], $name, $gz);
        }

        ksort($list);

        //检测文件正确性
        $last = end($list);
        if(count($list) !== $last[0]){
            $this->ajaxReturn(array(
                "success" => 0,
                "message"   => "备份文件可能已经损坏，请检查！"
            ));
        }

        // 恢复数据
        $start = null;
        foreach( $list as $key => $value){
            $db = new Database($value, array(
                'path'     => realpath(C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR .$name .DIRECTORY_SEPARATOR,
                'compress' => $value[2]));
            // 导入数据
            $start = $db->import($start);
            if( $start === false ){
                $this->ajaxReturn(array(
                    "success" => 0,
                    "message"   => "还原卷[{$key}]失败！"
                ));
            }
        }

        $this->ajaxReturn(array(
            "success" => 1,
            "message"   => "恢复数据成功！"
        ));

    }

    /**
     * export
     * @description 数据备份
     * @author liebert
     */
    public function export()
    {
        $data = $this->getTables();

        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 执行备份
     * @description 数据过大时，将分为多个卷
     * @param  String  $tables 表名数组
     * @param  Integer $id     表ID
     * @param  Integer $start  起始行数
     * @author liebert
     */
    public function doExport(){
        $tables = I('post.tables');

        // check param
        if( !$tables ){
            $this->ajaxReturn(array(
                "success" => 0,
                "message"   => "参数不完整"
            ));
        }

        // check if there is one running task
        $lock = C('DATA_BACKUP_PATH') . DIRECTORY_SEPARATOR . 'backup.lock';

        if(is_file($lock)){
            $this->ajaxReturn(array(
                "success" => 0,
                "message"   => "检测到有一个备份任务正在执行，请稍后再试！"
            ));
        } else {
            // 创建资源互斥锁文件 避免多次备份出现异常
            file_put_contents($lock, NOW_TIME);
        }

        // get path config
        $path = C('DATA_BACKUP_PATH') . DIRECTORY_SEPARATOR . date('Ymd-His', NOW_TIME);
        // 如果目录不存在，即时创建
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }

        // get backup config
        $config = array(
            'path'     => realpath($path) . DIRECTORY_SEPARATOR,// 数据库备份根路径
            'part'     => C('DATA_BACKUP_PART_SIZE'),           // 数据库备份卷大小
            'compress' => C('DATA_BACKUP_COMPRESS'),            // 数据库备份文件是否启用压缩
            'level'    => C('DATA_BACKUP_COMPRESS_LEVEL'),      // 数据库备份文件压缩级别
        );

        //检查备份目录是否可写
        is_writeable($config['path']) || $this->ajaxReturn(array(
            "success" => 0,
            "message"   => "备份目录不存在或不可写，请检查后重试！"
        ));

        // 生成备份文件信息
        $file = array(
            'name' => date('Ymd-His', NOW_TIME),// 卷名
            'part' => 1,// 卷号
        );

        // 创建备份操作对象
        $Database = new DataBase($file, $config);

        // 初始化备份操作对象
        if(false === $Database->create()){
            $this->ajaxReturn(array(
                "success" => 0,
                "message"   => "初始化备份操作对象失败，备份文件创建失败！"
            ));
        }

        $start = 0;
        // 执行备份操作
        foreach( $tables as $key => $table ){
            $start  = $Database->backup( $table, $start );
            if( false === $start ){
                $this->ajaxReturn(array(
                    "success" => 0,
                    "message"   => "备份表[{$table}]失败！"
                ));
            }
            while( $start !==0 ){// 每1000条记录备份一次，返回0表示下一个表
                $start  = $Database->backup( $table, $start );
                if( false === $start ){
                    $this->ajaxReturn(array(
                        "success" => 0,
                        "message"   => "备份表[{$table}]失败！"
                    ));
                }
            }
        }

        unlink($lock);

        $this->ajaxReturn(array(
            "success" => 1,
            "message"   => "备份成功！"
        ));

    }

    /**
     * 优化表
     * @param  String $tables 表名
     * @author liebert
     */
    public function doOptimize($tables = null)
    {
        $tables = I('post.tables');

        // 数据校验
        if (count($tables) <= 0) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '请指定要优化的表'
            ));
        }

        $Db   = Db::getInstance();
        $tables = implode('`,`', $tables);
        $list = $Db->query("OPTIMIZE TABLE `{$tables}`");

        if($list){
            $this->ajaxReturn(array(
                "success" => 1,
                "message"   => "数据表优化完成！"
            ));
        } else {
            $this->ajaxReturn(array(
                "success" => 0,
                "message"   => "数据表优化出错请重试！"
            ));
        }
    }

    /**
     * 修复表
     * @param  String $tables 表名
     * @author liebert
     */
    public function doRepair($tables = null)
    {
        $tables = I('post.tables');

        // 数据校验
        if (count($tables) <= 0) {
            $this->ajaxReturn(array(
                'success' => false,
                'message' => '请指定要修复的表'
            ));
        }

        $Db   = Db::getInstance();
        $tables = implode('`,`', $tables);
        $list = $Db->query("REPAIR TABLE `{$tables}`");

        if($list){
            $this->ajaxReturn(array(
                "success" => 1,
                "message"   => "数据表修复完成！"
            ));
        } else {
            $this->ajaxReturn(array(
                "success" => 0,
                "message"   => "数据表修复出错请重试！"
            ));
        }

    }

    /**
     * 删除备份文件
     * @param  Integer $time 备份时间
     * @author liebert
     */
    public function deleteBackupFile(){
        $name = I('post.file');

        // check param
        if( !$name ){
            $this->ajaxReturn(array(
                "success" => 0,
                "message"   => "参数不完整"
            ));
        }

        $files = realpath(C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . '*';
        $dir   = realpath(C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR . $name;

        // delete files
        array_map("unlink", glob($files));

        if( count(glob($files)) || !rmdir($dir)  ){
            $this->ajaxReturn(array(
                "success" => 0,
                "messagev"   => "备份项目删除失败，请检查权限！"
            ));
        } else {
            $this->ajaxReturn(array(
                "success" => 1,
                "message"   => "备份项目删除成功！"
            ));
        }
    }


    private function getTables()
    {
        $Db    = Db::getInstance();
        $data  = $Db->query('SHOW TABLE STATUS');

        $data  = array_map(function($value){
            $value['data_length'] = format_bytes($value['data_length']);
            return $value;
        }, $data);

        return $data;
    }

}