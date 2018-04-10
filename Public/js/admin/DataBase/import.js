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

	require('notify')

	$('.import').click(function () {
		var file = $(this).attr('data-file')

		// 使用ajax提交数据
		$.ajax({
			url: '/Admin/DataBase/doImport',
			type: 'POST',
			data: {
				file: file
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
					window.location.reload();

				} else {
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
							timer: 1000
						}
					)
				}
			}
		})
	})

	$('.delete').click(function () {
		var file = $(this).attr('data-file')

		// 使用ajax提交数据
		$.ajax({
			url: '/Admin/DataBase/deleteBackupFile',
			type: 'POST',
			data: {
				file: file
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
					window.location.reload();

				} else {
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
							timer: 1000
						}
					)
				}
			}
		})
	})

})