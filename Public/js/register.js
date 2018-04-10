// define(function(require, exports, module){
//   var $ = require('jquery-3.3.1')
//   require('jquery-validation')

//   $.validator.setDefaults({
//     errorClass: "error",
//     errorElement: "span",
//     // errorLabelContainer: $('.form-group .help-block').data
//   })

//   $('#register-form').validate({
//     rules: {
//       username: {
//         required: true,
//         minlength: 2
//       },
//       password: {
//         required: true,
//         rangelength:[5,20]
//       },
//       password_repeat: {
//         equalTo: '#form_password'
//       },
//       email: {
//         required: true,
//         email: true
//       }
//     },
//     messages: {
//       password: {
//         rangelength: $.validator.format('密码长度在{0}和{1}之间')
//       },
//       password_repeat: {
//         equalTo: '密码不一致'
//       },
//       // email: {
//       //   email: '邮件地址不合法！'
//       // }
//     }

//   })

//   // 校验用户是否已经存在
//   $('#form_username').focusout(function () {
//     var _this = this

//     if (!_this.value) {
//       return
//     }

//     $.ajax({
//         type: 'POST',
//         url: 'checkUserName',
//         data: {
//           username: _this.value
//         },
//         success: function (data) {
//           if (data.status) {
//             console.log('用户名通过')
//           } else {
            
//             // 已存在
//             console.log('用户名已存在')
//           }
//         },
//         error: function (res) {
//           // 服务器响应失败
//         }
//       })
//   })


//  //  var Validator = require('bootstrap.validator');
//  //  require('common/validator-rules').inject(Validator);

//  // var validator = new Validator({
//  //    element: '#register-form',
//  //    onFormValidated: function(error, results, $form) {
//  //        if (error) {
//  //            return false;
//  //        }
//  //        $('#submit').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;提交中，请稍等...').addClass('disabled').attr('disabled', 'disabled')
//  //    },
//  //    failSilently: true
//  //  });

//  //  validator.addItem({
//  //      element: '[name="username"]',
//  //      required: true
//  //  });

//  //  validator.addItem({
//  //      element: '[name="password"]',
//  //      required: true
//  //  });

//  //  validator.addItem({
//  //      element: '[name="email"]',
//  //      required: true,
//  //      rule: 'email email_remote'
//  //  });



// })


define(function(require, exports, module) {
  var $ = require('jquery')
  var Validator = require('bootstrap.validator');
  require('common/validator-rules').inject(Validator);

  // Validator.addRule(
  //   'email_or_mobile_check',
  //   function(options, commit) {
  //     var emailOrMobile = options.element.val();
  //     var reg_email = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  //     var reg_mobile = /^1\d{10}$/;
  //     var result =false;
  //     var isEmail = reg_email.test(emailOrMobile);
  //     var isMobile = reg_mobile.test(emailOrMobile);
  //     if(isMobile){
  //         $(".email_mobile_msg").removeClass('hidden');
  //         $('.js-captcha').addClass('hidden');
  //         $('.js-sms-send').removeClass('disabled');
  //     }else {
  //         $(".email_mobile_msg").addClass('hidden');
  //         $('.js-sms-send').addClass('disabled');
  //         $('.js-captcha').removeClass('hidden');
  //     }
  //     if (isEmail || isMobile) {
  //         result = true;
  //     }
  //     return  result;  
  //   },
  // )

  var validator = new Validator({
      element: $('#register-form'),
      // onFormValidated: function(error, results, $form) {
      //     // if (error) {
      //     //     return false
      //     // }
      //     $('#submit').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;提交中，请稍等...').addClass('disabled').attr('disabled', 'disabled')
      // },
      failSilently: true
    })

    // if ($("#getcode_num").length > 0){
        
    //   $("#getcode_num").click(function(){ 
    //       $(this).attr("src",$("#getcode_num").data("url")+ "?" + Math.random()); 
    //   }); 

    //   validator.addItem({
    //     element: '[name="captcha_code"]',
    //     required: true,
    //     rule: 'alphanumeric remote',
    //     onItemValidated: function(error, message, eleme) {
    //       if (message == "验证码错误"){
    //         $("#getcode_num").attr("src",$("#getcode_num").data("url")+ "?" + Math.random()); 
    //       }
    //     }                
    //   });
    // };

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