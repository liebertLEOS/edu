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

	$('#addCourse').click(function () {
		$('#addModal').modal();
	})

    //var Validator = require('bootstrap.validator');
    //
    //var validator = new Validator({
    //  element: $('#course-form')
    //})

	$('#course-form').submit(function(e){
		//$('#submit').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;提交中，请稍等...').addClass('disabled').attr('disabled', 'disabled')
		$('#submit').button('loading')
		// 使用ajax提交
		$.ajax({
			type: 'POST',
			url: '/Admin/Course/add',
			data: {
				title: this.title.value,
				subtitle: this.subtitle.value,
				serializeMode: this.serializeMode.value
			},
			success: function (data) {
				if (data.success) {
					// 提交成功
					window.location.reload()
				} else {
					//$('#submit').text('提交').removeClass('disabled').attr('disabled', null)
					$('#submit').button('reset')
					$('#msg').html('<span class="text-danger">' + data.message + '</span>')
				}
			},
			error: function (res) {
				// 服务器响应失败
				$('#msg').html('<span class="text-danger">服务器响应失败</span>')
				$('#submit').button('reset')
			}
		})


		return false
	})

})