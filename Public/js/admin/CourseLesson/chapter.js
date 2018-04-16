/**
 * Created by lenovo on 2018/4/5.
 */
define(function(require, exports, module){

	var $ = require('jquery-3.3.1')
  var Notify = require('common/bootstrap-notify')
	var Validator = require('bootstrap.validator')

	exports.run = function () {

    var validator = new Validator({
        element: '#course-chapter-form',
        failSilently: true,
        autoSubmit: false,
        onFormValidated: function(error, msg, $form)  {
          if (error) {
              return ;
          }
          $('#submit').button('loading')

          $.post($form.attr('action'), $form.serialize(), function(response){
            if (response.success) {
              Notify.success(response.message)
              window.location.reload()
            } else {
              $('#submit').button('reset')
              Notify.danger(response.message)
            }
          })
        }
      })

    validator.addItem({
      element: '[name="title"]', 
      required: true,
      display: '标题'
    })

  }

})