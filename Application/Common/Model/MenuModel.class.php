<?php
namespace Common\Model;

use Think\Model;

class MenuModel extends Model
{
	private $_db = '';

	public function __construct()
	{
		$this->_db = M('menu');
	}

	public function insert($data = array())
	{
		if (empty($data) || !is_array($data)) {
			return 0;
		}
		return $this->_db->add($data);
	}

	public function getMenus($data, $page, $pageSize = 10)
	{
		$data['status'] = array('neq', -1);
		$offset = ($page - 1) * $pageSize;
		$list   = $this->_db->where($data)->order('menu_id desc')->limit($offset, $pageSize)->select();
		return $list;
	}

	public function getMenusCount($data = array())
	{
		$data['status'] = array('neq', -1);
		return $this->_db->where($data)->count();
	}

	public function find($id)
	{
		if ($id < 1) {
			return array();
		}
		return $this->_db->where('menu_id=' . $id)->find();
	}

	/**
	 * 根据id更新菜单
	 * @param array $data
	 * @param int $id
	 * @return bool
	 */
	public function updateMenuById($data, $id)
	{
		if (!$id || !is_numeric($id)) {
			throw_exception('ID不合法');
		}
		if (!$data || !is_array($data)) {
			throw_exception('更新的数据不合法');
		}

		return $this->_db->where('menu_id=' . $id)->save($data);
	}

	/**
	 * 根据id更新菜单状态
	 * @param int $id
	 * @param int $status
	 * @return bool
	 */
	public function updateStatusById($id, $status)
	{
		if (!$id || !is_numeric($id)) {
			throw_exception('ID不合法');
		}
		if (!$status || !is_numeric($status)) {
			throw_exception('状态不合法');
		}

		$data['status'] = $status;
		return $this->_db->where('menu_id=' . $id)->save($data);
	}
}