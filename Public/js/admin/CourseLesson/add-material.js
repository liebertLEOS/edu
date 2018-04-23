/**
 * Created by lenovo on 2018/4/5.
 */
define(function(require, exports, module){

	var $ = require('jquery-3.3.1')
  var Notify = require('common/bootstrap-notify')
	var Validator = require('bootstrap.validator')

	exports.run = function () {

    var validator = new Validator({
        element: '#lesson-material-form',
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
              $('#modal').modal('hide')
            } else {
              Notify.danger(response.message)
            }
            $('#submit').button('reset')
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