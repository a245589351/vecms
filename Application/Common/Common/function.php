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
function show($status, $message, $data = array())
{
	$result = array(
		'status' => $status,
		'message' => $message,
		'data' => $data
	);
	exit(json_encode($result));
}

/**
 * 将密码进行md5加密
 * @param string $password
 * @return string
 */
function getMd5Password($password)
{
	return md5($password . C('MD5_PRE'));
}

/**
 * 获取后台菜单类型
 * @param int $type
 * @return string
 */
function getMenuType($type)
{
	return $type == 1 ? '后台菜单' : '前端导航';
}

/**
 * 获取菜单的状态
 * @param int $status
 * @return string
 */
function getStatus($status)
{
	if ($status == 0) {
		$str = '<font color="red">关闭</font>';
	} elseif ($status == 1) {
		$str = '<font color="green">正常</font>';
	} elseif ($status == -1) {
		$str = '删除';
	}
	return $str;
}

/**
 * 获取菜单的url
 * @param array $nav
 * @return string
 */
function getAdminMenuUrl($nav)
{
	$url = 'admin.php?c=' . $nav['c'];
	$url .= $nav['f'] == 'index' ? '' : ('&a=' . $nav['f']);
	return $url;
}

/**
 * 获取菜单的选中状态
 * @param string $navc
 * @return string
 */
function getActive($navc)
{
	$c = strtolower(CONTROLLER_NAME);
	if (strtolower($navc) == $c) {
		return 'class="active"';
	}
	return '';
}