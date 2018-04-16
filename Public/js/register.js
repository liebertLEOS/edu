define(function(require, exports, module) {
  var $ = require('jquery-3.3.1')
  var Notify = require('common/bootstrap-notify')
  var Validator = require('bootstrap.validator');
  require('common/validator-rules').inject(Validator);

  var $form = $('#register-form')

  var validator = new Validator({
      element: '#register-form',
      failSilently: true,
      autoSubmit: false,
      onFormValidated: function(error, results, $form) {
          if (error) {
              return
          }

          $('#submit').button('loading')

          $.post($form.attr('action'), $form.serialize(), function(response){
            if (response.success) {
              Notify.success(response.message)
              window.location = response.url
            } else {
              $('#submit').button('reset')
              Notify.danger(response.message)
            }
          })
      }
      
    })

    validator.addItem({
      element: '[name="username"]', 
      required: true,
      rule: 'chinese_alphanumeric byte_minlength{min:4} byte_maxlength{max:18} remote'
    })

    validator.addItem({
        element: '[name="email"]',
        required: true,
        rule: 'email email_remote'
    })

    validator.addItem({
      element: '[name="password"]',
      required: true,
      rule: 'minlength{min:5} maxlength{max:20}',
      display: '密码'
    })

    validator.addItem({
      element: '[name="password_repeat"]',
      required: true,
      rule: 'equaltopassword{password:"password"}',
    })

});