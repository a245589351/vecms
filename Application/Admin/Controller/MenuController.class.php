<?php
/**
 * 菜单管理
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Page;

class MenuController extends CommonController
{
	public function index()
	{
		$data = array();
		// 分页操作逻辑
		$page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
		$pageSize   = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 10;
		$menus      = D('Menu')->getMenus($data, $page, $pageSize);
		$menusCount = D('Menu')->getMenusCount($data);

		$res = new Page($menusCount, $pageSize);
		$pageRes = $res->show();
		$this->assign('pageRes', $pageRes);
		$this->assign('menus', $menus);
		$this->display();
	}

	public function add()
	{
		if ($_POST) { // 更新数据

			// 加载数据
			$data['name']   = isset($_POST['name']) ? trim($_POST['name']) : '';
			$data['type']   = isset($_POST['type']) ? (int)$_POST['name'] : 0;
			$data['m']      = isset($_POST['m']) ? trim($_POST['m']) : '';
			$data['c']      = isset($_POST['c']) ? trim($_POST['c']) : '';
			$data['f']      = isset($_POST['f']) ? trim($_POST['f']) : '';
			$data['status'] = isset($_POST['status']) ? (int)$_POST['status'] : 0;

			// 验证数据
			if (empty($data['name'])) {
				return show(0, '菜单名不能为空');
			}
			if (empty($data['m'])) {
				return show(0, '模块名不能为空');
			}
			if (empty($data['c'])) {
				return show(0, '控制器不能为空');
			}
			if (empty($data['f'])) {
				return show(0, '方法名不能为空');
			}

			// 加入数据库
			$menuId = D('Menu')->insert($data);
			if ($menuId) {
				return show(1, '新增成功', $menuId);
			}
			return show(0, '新增失败', $menuId);
		} else {
			$this->display();
		}
	}
}