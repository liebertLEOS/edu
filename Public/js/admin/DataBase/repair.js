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

	var tables = []

	$('#checkall').click(function(){
		var checked = this.checked

		$checkbox.each(function(){
			this.checked = checked
		})
	})

	require('notify')

	$('#optimize').click(function () {
		$checkbox.each(function(){
			if(this.checked){
				tables.push($(this).attr('data-table'))
			}
		})

		if (tables.length <= 0) {
			$.notify(
				{
					// options
					icon: 'glyphicon glyphicon-info-sign',
					message: '请选择至少一张表'
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
			url: '/Admin/DataBase/doOptimize',
			type: 'POST',
			data: {
				tables: tables
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

	$('#repair').click(function () {
		$checkbox.each(function(){
			if(this.checked){
				tables.push($(this).attr('data-table'))
			}
		})

		if (tables.length <= 0) {
			$.notify(
				{
					// options
					icon: 'glyphicon glyphicon-info-sign',
					message: '请选择至少一张表'
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
			url: '/Admin/DataBase/doRepair',
			type: 'POST',
			data: {
				tables: tables
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