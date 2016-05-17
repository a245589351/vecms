<?php
/**
 * 公用方法
 */

/**
 * 显示结果
 * @param $status
 * @param $message
 * @param array $data
 */
function show($status, $message, $data = array()) {
    $result = array(
        'status'   => $status,
        'message' => $message,
        'data'     => $data
    );
    exit(json_encode($result));
}

/**
 * 将密码进行md5加密
 * @param string $password
 * @return string
 */
function getMd5Password($password) {
    return md5($password . C('MD5_PRE'));
}