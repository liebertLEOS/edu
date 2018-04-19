define(function(require, exports, module){
  var $ = require('jquery-3.3.1')
  var Notify = require('common/bootstrap-notify')
  var Validator = require('bootstrap.validator')

  var validator = new Validator({
      element: '#login-form',
      failSilently: true,
      autoSubmit: false,
      onFormValidated: function(error, msg, $form)  {
        if (error) {
            return ;
        }
        $('#submit').button('loading')

        $.post($form.attr('action'), $form.serialize(), function(res){
          if (res.success) {
            window.location = res.goto
          } else {
            $('#submit').button('reset')
            Notify.danger(res.message)
          }
        })
      }
    })

  validator.addItem({
    element: '[name="username"]', 
    required: true,
    display: '用户名'
  })

  validator.addItem({
    element: '[name="password"]', 
    required: true,
    display: '密码'
  })

})