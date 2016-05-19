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

	/**
	 * 删除模型
	 */
	$('.vecms-table #vecms-delete').on('click', function(){
		var id = $(this).attr('attr-id');
		var a  = $(this).attr('attr-a');
		var message = $(this).attr('attr-message');
		var url = SCOPE.set_status_url;

		var data = {};
		data['id'] = id;
		data['status'] = -1;

		layer.open({
			type: 0,
			title: '是否提交',
			btn: ['yes', 'no'],
			icon: 3,
			closeBtn: 2,
			content: '是否确定' + message,
			scrollBar: true,
			yes: function(){
				// 执行相关跳转
				todelect(url, data);
			}
		});
	});

	function todelect(url, data) {
		$.post(url, data, function(result){
			if (result.status == 1) {
				return dialog.success(result.message, '');
			} else {
				return dialog.error(result.message);
			}
		}, 'JSON');
	}
})();