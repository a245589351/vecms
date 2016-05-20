<?php
/**
 * 文章管理
 */
namespace Admin\Controller;

use Think\Controller;

class ContentController extends CommonController
{
	public function index()
	{
		$this->display();
	}

	public function add()
	{
		$websiteMenus   = D('Menu')->getBarMenus();
		$titleFontColor = C('TITLE_FONT_COLOR');
		$copyFrom = C('COPY_FROM');

		$this->assign('websiteMenus', $websiteMenus);
		$this->assign('titleFontColor', $titleFontColor);
		$this->assign('copyFrom', $copyFrom);
		$this->display();
	}

	public function addPost()
	{
		if ($_POST) {

			// 加载数据
			$data['title']       = isset($_POST['title']) ? trim($_POST['title']) : '';
			$data['small_title'] = isset($_POST['small_title']) ? trim($_POST['small_title']) : '';
			$data['thumb']       = isset($_POST['thumb']) ? trim($_POST['thumb']) : '';
			$data['catid']       = isset($_POST['catid']) ? (int)$_POST['catid'] : 0;
			$data['copyfrom']    = isset($_POST['copyfrom']) ? (int)$_POST['copyfrom'] : 0;
			$data['keywords']    = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
			$data['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
			$data['title_font_color'] = isset($_POST['title_font_color']) ? trim($_POST['title_font_color']) : '';

			$newsContentData['content'] = isset($_POST['content']) ? trim($_POST['content']) : '';

			// 验证数据
			if (empty($data['title'])) {
				return show(0, '标题不能为空');
			}
			if (empty($data['small_title'])) {
				return show(0, '短标题不能为空');
			}
			if (empty($data['catid'])) {
				return show(0, '文章栏目不能为空');
			}
			if (empty($data['keywords'])) {
				return show(0, '关键字不能为空');
			}
			if (empty($newsContentData['content'])) {
				return show(0, 'content不能为空');
			}

			// 添加数据
			$newsId = D('News')->insert($data);
			if ($newsId) {
				$newsContentData['news_id'] = $newsId;
				$id = D('NewsContent')->insert($newsContentData);
				if ($id) {
					return show(1, '新增成功');
				}
				return show(1, '主表插入成功，副表插入失败');
			}
			return show(0, '新增失败');
		}
		return show(0, '没有提交数据');
	}
}