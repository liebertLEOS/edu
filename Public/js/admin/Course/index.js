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

	var Validator = require('bootstrap.validator');

	var validator = new Validator({
      element: $('#course-form'),
      onFormValidated: function(error, results, $form) {
          if (error) {
              return false
          }
          
          $('#submit').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;提交中，请稍等...').addClass('disabled').attr('disabled', 'disabled')

          return false
      },
      failSilently: true
    })

	validator.addItem({
      element: '[name="title"]', 
      required: true,
      display: '标题'
    })

})