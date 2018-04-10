<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/4/5
 * Time: 15:44
 */

/**
 * @param $userid
 * @param $module
 * @param $action
 * @param $message
 * @param string $data
 * @param string $level
 * @return int|mixed
 */
function saveLog( $userid, $module, $action, $message, $data='', $level='info' )
{
    // 参数检验
    if ( !$userid || !$module || !$action || !$message){
        return 0;
    }
    // 添加日志到数据库中
    $id = M('log')->data(array(
        'userId' => $userid,
        'module' => $module,
        'action' => $action,
        'message' => $message,
        'data' => $data,
        'ip' => get_client_ip(),
        'createdTime' => time(),
        'level' => $level
    ))->add();

    return $id;
}

/**
 * @param $menuId
 * @return mixed
 */
function getSideBar($menuId = 0)
{
    // 读取菜单

    // 建立菜单树

    return C('MENU');
}

function addFile($uid, $file, $groupId = 1) {
    // 用户权限过滤


    // 保存文件到上传目录下
    $upload = new Think\Upload(array(
        'maxSize'       =>  C('UPLOAD_MAXSIZE_ADMIN'), //上传的文件大小限制 (0-不做限制)
        'exts'          =>  C('UPLOAD_FILE_TYPE'), //允许上传的文件后缀
        'rootPath'      =>  C('UPLOAD_DIR'), //保存根路径
    ));

    $info = $upload->uploadOne($file);

    // 上传失败
    if (!$info) {
        return array(
            'type' => 1,
            'error' => $upload->getError()
        );

    }

    // 写入文件相关信息到数据库
    $createdTime = time();

    $file = array(
        'groupId' => $groupId,
        'userId'  => $uid,
        'uri'     => $info['savepath'].$info['savename'],
        'mime'    => $info['type'],
        'ext'     => $info['ext'],
        'size'    => $info['size'],
        'originName'    => $info['name'],
        'createdTime' => $createdTime
    );
    $data = M('file')->add($file);

    // 返回操作情况
    if ($data) {
        return array(
            'type' => 0,
            'file'  => array(
                'id'     => $data,
                'userId' => $uid,
                'key'    => $data,
                'uri'    => $info['savepath'].$info['savename'],
                'mime'   => $info['type'],
                'ext'    => $info['ext'],
                'createdTime' => $createdTime
            )
        );
    } else {
        return array(
            'error' => 2,
            'message' => '保存数据库失败'
        );
    }
}


/**
 * ¸ñÊ½»¯×Ö½Ú´óÐ¡
 * @param  number $size
 * @param  string $delimiter
 * @return string
 * @author liebert
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}
