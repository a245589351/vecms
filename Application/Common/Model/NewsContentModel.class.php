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
}