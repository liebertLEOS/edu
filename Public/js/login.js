define(function(require, exports, module){
  var $ = require('jquery')

  $('.form-group').each(function(){
    var $this = $(this)
    var tip = $this.find('.help-block')
    var input = $this.find('input').eq(0)

    input.focusout(function(){
      //this=.form-group
      if ($(this).val() === '') {
        $this.addClass('has-error')
        tip.html('<span class="text-danger">不能为空</span>')
        // if(tip.find('span').length == 0) {
        //   tip.append('<span class="text-danger">不能为空</span>')
        // }
      }
    })

    input.mousedown(function(){
      tip.children().remove()
      $this.removeClass('has-error')
    })

  })
  
  $('#login-form').submit(function(e){
    var username = this.username.value
    var password = this.password.value
    var remember_me = this.remember_me.checked
    var returnUrl = this.return_url.value

    if (username && password) {
      // 显示提交中，请等待   禁止按钮
      $('#submit').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;提交中，请稍等...').addClass('disabled').attr('disabled', 'disabled')
      $('.msg').html('')
      // 使用ajax提交
      $.ajax({
        type: 'POST',
        url: 'login',
        data: {
          username: username,
          password: password,
          remember_me: remember_me,
          return_url: returnUrl
        },
        success: function (data) {
          if (data.status) {
            // 登录成功
            window.location = data.return_url
          } else {
            $('#submit').text('登录').removeClass('disabled').attr('disabled', null)
            $('.msg').html('<span class="text-danger">' + data.msg + '</span>')
          }
        },
        error: function (res) {
          // 服务器响应失败
        }
      })
    } else {
      $('.form-group').each(function(){
        var $this = $(this)
        var tip = $this.find('.help-block')
        if ($this.find('input').val() == ''){
          $this.addClass('has-error')
          if(tip.find('span').length == 0) {
            tip.append('<span class="text-danger">不能为空</span>')
          }
        }
      })
    }
    
    return false
  })

})