<?php
/**
 * 菜单管理
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;
use Think\Page;

class MenuController extends CommonController
{
	public function index()
	{
		$data = array();

		// 过滤
		if (isset($_REQUEST['type']) && in_array($_REQUEST['type'], array(0, 1))) {
			$data['type'] = (int)$_REQUEST['type'];
			$this->assign('type', $data['type']);
		} else {
			$this->assign('type', -100);
		}

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
			$menuId = isset($_POST['menu_id']) ? (int)$_POST['menu_id'] : 0;
			$data['name']   = isset($_POST['name']) ? trim($_POST['name']) : '';
			$data['type']   = isset($_POST['type']) ? (int)$_POST['type'] : 0;
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

			if ($menuId) {
				return $this->_save($data, $menuId);
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

	public function edit()
	{
		$menuId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
		$menu = D('Menu')->find($menuId);
		$this->assign('menu', $menu);
		$this->display();
	}

	public function setStatus()
	{
		try {
			if ($_POST) {
				$id     = isset($_POST['id']) ? (int)$_POST['id'] : 0;
				$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;

				// 执行数据更新操作
				$res = D('Menu')->updateStatusById($id, $status);
				if (false === $res) {
					return show(0, '操作失败');
				}
				return show(1, '操作成功');
			}
		} catch(Exception $e) {
			return show(0, $e->getMessage());
		}

		return show(0, '没有提交的数据');
	}

	public function listorder()
	{
		$listorder = isset($_POST['listorder']) ? $_POST['listorder'] : array();
		$jumpUrl   = $_SERVER['HTTP_REFERER'];
		$errors    = array();
		if ($listorder) {
			try {
				foreach($listorder as $menuId => $val) {
					// 执行更新
					$id = D('Menu')->updateMenuListorderById($menuId, $val);
					if (false === $id) {
						$errors[] = $menuId;
					}
				}
			} catch (Exception $e) {
				return show(0, $e->getMessage(), array('jump_url' => $jumpUrl));
			}

			if ($errors) {// 有某条数据更新失败
				return show(0, '排序失败' . implode(',', $errors), array('jump_url' => $jumpUrl));
			}

			// 排序成功
			return show(1, '排序成功', array('jump_url' => $jumpUrl));
		}

		return show(0, '排序数据失败', array('jump_url' => $jumpUrl));
	}

	/**
	 * 更新菜单
	 * @param array $data
	 * @param int $menuId
	 */
	private function _save($data, $menuId)
	{
		try {
			$id = D('Menu')->updateMenuById($data, $menuId);
			if (false === $id) {
				return show(0, '更新失败');
			}
			return show(1, '更新成功');
		} catch (Exception $e) {
			return show(0, $e->getMessage());
		}
	}
}