<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/4/5
 * Time: 22:23
 */


function getUserById($userId)
{
    if (!$userId) {return false;}

    $userModel = M('user');

    $user = $userModel->where("`id`={$userId}")->find();

    if (is_null($user['avatar']) || $user['avatar'] == '') {
        $user['avatar'] = C('DEFAULT_AVATAR');
    }


    return $user;
}


function getPathByTree($root, $url){

    if ($root == null) { return null; }

    $len = count($root);

    for ($i = 0; $i < $len; $i++) {

        if ('' == $root[$i]['url'] || '#' == $root[$i]['url'] || strtolower(U($root[$i]['url'], '', false)) != strtolower($url)) {
            $path = getPathByTree($root[$i]['children'], $url);

            if ($path) { return $path; }

        } else {
            return $root[$i]['path'];
        }

    }
    return null;
}