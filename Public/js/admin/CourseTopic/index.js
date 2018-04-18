/**
 * Created by lenovo on 2018/4/5.
 */
define(function(require, exports, module){
	var $ = require('jquery-3.3.1')
	var Notify = require('common/bootstrap-notify')
	var Validator = require('bootstrap.validator')


	var $checkbox = $('input[name="check"]')

	var check = []

	$('.checkall').click(function(){
		var checked = this.checked

		$checkbox.each(function(){
			this.checked = checked
		})
	})

	$('.ajax-op').click(function(){
		var $this = $(this)

		$.get($this.data('url'), function (res) {
			if (res.success) {
				Notify.success(res.message)
				window.location.reload()
			} else {
				Notify.danger(res.message)
			}
		})
	})

})