<?php
namespace Common\Model;

use Think\Model;

class NewsModel extends Model
{
	private $_db = '';

	public function __construct()
	{
		$this->_db = M('News');
	}

	/**
	 * 新增一篇文章
	 * @param array $data
	 * @return int|mixed
	 */
	public function insert($data = array())
	{
		if (!$data || !is_array($data)) {
			return 0;
		}
		$data['create_time'] = time();
		$data['username']    = getLoginUsername();
		return $this->_db->add($data);
	}

	/**
	 * 获取文章分页数据
	 * @param $where
	 * @param $page
	 * @param $pageSize
	 * @return mixed
	 */
	public function getNews($where, $page, $pageSize)
	{
		$where['status'] = array('neq', -1);
		$option = array(
			'where' => $where,
			'order' => 'listorder desc, news_id desc'
		);
		if (isset($where['title']) && $where['title']) {
			$option['where']['title'] = array('like', '%' . $where['title'] . '%');
		}
		if (isset($where['catid']) && $where['catid']) {
			$option['where']['catid'] = (int)$where['catid'];
		}

		$offset = ($page - 1) * $pageSize;
		$list = $this->_db->where($option['where'])->order($option['order'])->limit($offset, $pageSize)->select();
		return $list;
	}

	/**
	 * 根据条件获取文章的条数
	 * @param array $where
	 * @return mixed
	 */
	public function getNewsCount($where = array())
	{
		$where['status'] = array('neq', -1);
		$option = array(
			'where' => $where
		);
		if (isset($where['title']) && $where['title']) {
			$option['where']['title'] = array('like', '%' . $where['title'] . '%');
		}
		if (isset($where['catid']) && $where['catid']) {
			$option['where']['catid'] = (int)$where['catid'];
		}

		return $this->_db->where($option['where'])->count();
	}

	/**
	 * 根据id获取文章数据
	 * @param array|mixed $id
	 * @return array|mixed
	 */
	public function find($id)
	{
		if (!$id || !is_numeric($id)) {
			return array();
		}
		$data = $this->_db->where('news_id=' . $id)->find();
		return $data;
	}

	/**
	 * 更新文章主表
	 * @param $id
	 * @param $data
	 * @return bool
	 */
	public function updateById($id, $data)
	{
		if (!$id || !is_numeric($id)) {
			throw_exception('ID不合法');
		}
		if (!$data || !is_array($data)) {
			throw_exception('更新数据不合法');
		}

		return $this->_db->where('news_id=' . $id)->save($data);
	}
}