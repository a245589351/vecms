(function(){
	/**
	 * 添加按钮操作
	 */
	$('#button-add').click(function(){
		var url = SCOPE.add_url;
		window.location.href = url;
	});

	/**
	 * 提交form表单操作
	 */
	$('#vecms-button-submit').click(function(){
		var data = $('#vecms-form').serializeArray();
		var postData = {};
		$(data).each(function(i){
			postData[this.name] = this.value;
		});

		// 将获取到的数据post到服务器
		url = SCOPE.save_url;
		var jump_url = SCOPE.jump_url;
		$.post(url, postData, function(result){
			if (result.status == 1) { // 成功
				return dialog.success(result.message, jump_url);
			} else if (result.status == 0) { // 失败
				return dialog.error(result.message);
			}
		}, 'JSON');
	});

	/**
	 * 编辑模型
	 */
	$('.vecms-table #vecms-edit').on('click', function(){
		var id  = $(this).attr('attr-id');
		var url = SCOPE.edit_url + '&id=' + id;
		window.location.href = url;
	});
})();