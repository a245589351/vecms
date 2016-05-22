<?php
namespace Common\Model;

use Think\Model;

class NewsContentModel extends Model
{
	private $_db = '';

	public function __construct()
	{
		$this->_db = M('News_content');
	}

	/**
	 * 新增一个文章详情
	 * @param array $data
	 * @return int|mixed
	 */
	public function insert($data = array())
	{
		if (!$data || !is_array($data)) {
			return 0;
		}
		$data['create_time'] = time();
		if (isset($data['content']) && $data['content']) {
			$data['content'] = htmlspecialchars($data['content']);
		}
		return $this->_db->add($data);
	}

	/**
	 * 根据id获取文章详情数据
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
	 * 更新文章副表
	 * @param $id
	 * @param $data
	 * @return bool
	 */
	public function updateNewsById($id, $data)
	{
		if (!$id || !is_numeric($id)) {
			throw_exception('ID不合法');
		}
		if (!$data || !is_array($data)) {
			throw_exception('更新数据不合法');
		}
		if (isset($data['content']) && $data['content']) {
			$data['content'] = htmlspecialchars($data['content']);
		}

		return $this->_db->where('news_id=' . $id)->save($data);
	}
}