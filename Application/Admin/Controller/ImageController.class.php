<?php
/**
 * 上传图片的控制器
 */
namespace Admin\Controller;

use Think\Controller;

class ImageController extends CommonController
{
	private $_uploadObj;

	public function __construct()
	{
	}

	public function ajaxuploadimage()
	{
		$upload = D('UploadImage');
		$res = $upload->imageUpload();
		if (false === $res) {
			return show(0, '上传失败', '');
		} else {
			return show(1, '上传成功', $res);
		}
	}
}