/**
 * Created by lenovo on 2018/4/5.
 */
define(function(require, exports, module){
	var $ = require('jquery-3.3.1')

	require('bootstrap')

	require('tree')

	require('layout')

	require('pushmenu')

	$('[data-toggle="push-menu"]').pushMenu()

	var $checkbox = $('input[name="check"]')

	var check = []

	$('#checkall').click(function(){
		var checked = this.checked

		$checkbox.each(function(){
			this.checked = checked
		})
		//this.checked ? $checkbox.attr('checked', 'checked') : $checkbox.removeAttr('checked')
	})

	$('.delete').tooltip()

	require('confirmation')
	require('notify')

	$('.delete').confirmation({
		title: '确认要删除吗？',
		singleton: true,
		btnOkLabel: '是',
		btnCancelLabel: '否',
		onConfirm: function(){
			var id = this.$element.attr('data-id')
			var checkIds = []

			checkIds.push(id)

			// 使用ajax提交数据
			$.ajax({
				url: '/Admin/File/delete',
				type: 'POST',
				data: {
					check_ids: checkIds
				},
				success: function(data){
					if (data.success) {
						// 提示删除成功
						$.notify(
							{
								// options
								icon: 'glyphicon glyphicon-ok-sign',
								message: data.message
							},
							{
								// settings
								type: 'success',
								offset: {
									x: 10,
									y: 60
								}
							}
						)
						// 刷新页面
							window.location.reload();

					} else {
						// 提示删除失败
						$.notify(
							{
								// options
								icon: 'glyphicon glyphicon-remove-sign',
								//title: '提示',
								message: data.message
							},
							{
								// settings
								type: 'danger',
								placement: {
									from: "top",
									align: "right"
								},
								offset: {
									x: 10,
									y: 60
								},
								spacing: 10,
								z_index: 1031,
								delay: 3000,
								timer: 1000,
								//animate: {
								//	enter: 'animated fadeInDown',
								//	exit: 'animated fadeOutUp'
								//}
							}
						)
					}
				}
			})
		}
	})

	//$('.delete').click(function () {
	//	// 弹出对话框 确认是否要删除
    //
	//	var id = $(this).attr('data-id')
    //
	//	// 使用ajax提交数据
	//	$.ajax('POST', {
	//		url: '',
	//		data: {
	//			id: id
	//		},
	//		success: function(data){
	//			if (data.success) {
    //
	//			} else {
    //
	//			}
	//		}
	//	})
    //
	//})

	//$('#deleteAll').click(function(){
	//	// 弹出对话框 确认是否要删除
	//	var checkIds = []
    //
	//	$checkbox.each(function(){
	//		if(this.checked){
	//			checkIds.push(this.value)
	//		}
	//	})
    //
	//	//console.log(checkIds)
    //
	//	// 使用ajax提交数据
	//	$.ajax('POST', {
	//		url: '',
	//		data: {
	//			check_ids: checkIds
	//		},
	//		success: function(data){
	//			if (data.success) {
    //
	//			} else {
    //
	//			}
	//		}
	//	})
	//})

	$('#deleteAll').confirmation({
		title: '确认要删除吗？',
		singleton: true,
		btnOkLabel: '是',
		btnCancelLabel: '否',
		onConfirm: function(){
			var checkIds = []

			$checkbox.each(function(){
				if(this.checked){
					checkIds.push(this.value)
				}
			})

			if (checkIds.length <= 0) {
				$.notify(
					{
						// options
						icon: 'glyphicon glyphicon-info-sign',
						message: '请选择至少一条记录'
					},
					{
						// settings
						type: 'warning',
						offset: {
							x: 10,
							y: 60
						}
					}
				)
				return
			}

			// 使用ajax提交数据
			$.ajax({
				url: '/Admin/File/delete',
				type: 'POST',
				data: {
					check_ids: checkIds
				},
				success: function(data){
					if (data.success) {
						$.notify(
							{
								// options
								icon: 'glyphicon glyphicon-ok-sign',
								message: data.message
							},
							{
								// settings
								type: 'success',
								offset: {
									x: 10,
									y: 60
								}
							}
						)

						// 刷新页面
						setTimeout(function(){
							window.location.reload();
						}, 3000)

					} else {
						$.notify(
							{
								// options
								icon: 'glyphicon glyphicon-remove-sign',
								message: data.message
							},
							{
								// settings
								type: 'danger',
								offset: {
									x: 10,
									y: 60
								}
							}
						)
					}
				}
			})
		}
	})

})