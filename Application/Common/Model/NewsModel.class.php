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
}