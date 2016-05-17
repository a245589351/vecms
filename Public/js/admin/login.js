/**
 * 前端登陆业务类
 * @type {{check: Function}}
 */
var login = {
    check : function() {
        // 获取用户的用户名和密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();

        if (!username) {
            return dialog.error('用户名不能为空');
        }
        if (!password) {
            return dialog.error('密码不能为空');
        }

        var url  = 'http://localhost/vecms/trunk/index.php?m=admin&c=login&a=check';
        var data = {'username': username, 'password': password};
        $.post(url, data, function(result){
            if (result.status == 0) {
                dialog.error(result.message);
            }
            if (result.status == 1) {
                dialog.success(result.message, 'index.php?m=admin&c=index');
            }
        }, 'JSON');
    }
}