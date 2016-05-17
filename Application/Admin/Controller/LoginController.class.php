<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class LoginController extends Controller
{
    public function index()
    {
        return $this->display();
    }

    public function check()
    {
        // 加载数据
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        // 验证数据
        if (empty($username)) {
            return show(0, '用户帐号不能为空');
        }
        if (empty($password)) {
            return show(0, '用户密码不能为空');
        }

        $ret = D('Admin')->getAdminByUsername($username);
        if (!$ret) {
            return show(0, '该用户不存在');
        }
        if ($ret['password'] != getMd5Password($password)) {
            return show(0, '密码错误');
        }

        session('adminUser', $ret);
        return show(1, '登录成功');
    }
}