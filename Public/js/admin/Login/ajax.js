define(function(require, exports, module){
  var $ = require('jquery-3.3.1')
  var Validator = require('bootstrap.validator')

  var $form = $('#login-form-ajax')

  var validator = new Validator({
      element: '#login-form-ajax',
      failSilently: true,
      autoSubmit: false,
      onFormValidated: function(error, msg, $form)  {
        if (error) {
            return ;
        }
        $form.find('.alert-danger').hide();
        $('#submit').button('loading')

        $.post($form.attr('action'), $form.serialize(), function(res){
          if (res.success) {
            window.location.reload();
          } else {
            $('#submit').button('reset')
            $form.find('.alert-danger').html(res.message).show()
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