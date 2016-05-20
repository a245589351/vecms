<?php
/**
 * 文章管理
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Page;

class ContentController extends CommonController
{
	public function index()
	{
		// 加载数据
		$where = array();
		$title = isset($_GET['title']) ? trim($_GET['title']) : '';
		$catid = isset($_GET['catid']) ? (int)$_GET['catid'] : 0;
		$page  = isset($_REQUEST['p']) ? (int)$_REQUEST['p'] : 1;
		$pageSize = 10;

		if ($title) {
			$where['title'] = $title;
		}
		if ($catid) {
			$where['catid'] = $catid;
		}

		$news  = D('News')->getNews($where, $page, $pageSize);
		$count = D('News')->getNewsCount($where);

		// 分页类
		$res = new Page($count, $pageSize);
		$pageRes = $res->show();

		// 栏目列表
		$this->assign('websiteMenus', D('Menu')->getBarMenus());
		$this->assign('pageRes', $pageRes);
		$this->assign('news', $news);
		$this->assign('title', $title);
		$this->assign('catid', $catid);

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

	public function edit()
	{
		$newsId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
		if ($newsId < 0) { // id不合法
			$this->redirect('admin.php?c=content');
		}

		$news = D('News')->find($newsId);
		if (!$news) {
			$this->redirect('admin.php?c=content');
		}
		$newsContent = D('NewsContent')->find($newsId);
		if ($newsContent) { // 新闻详情
			$news['content'] = $newsContent['content'];
		}

		// 栏目列表
		$this->assign('websiteMenus', D('Menu')->getBarMenus());
		// 标题颜色
		$this->assign('titleFontColor', C('TITLE_FONT_COLOR'));
		// 来源
		$this->assign('copyFrom', C('COPY_FROM'));

		$this->assign('news', $news);
		$this->display();
	}
}