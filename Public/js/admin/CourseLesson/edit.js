define(function(require, exports, module) {
  var $ = require('jquery-3.3.1')
  var Notify = require('common/bootstrap-notify')

  function getEditorContent(editor){
      editor.updateElement();
      var z = editor.getData();
      var x = editor.getData().match(/<embed[\s\S]*?\/>/g);
      if (x) {
          for (var i = x.length - 1; i >= 0; i--) {
             var y = x[i].replace(/\/>/g,"wmode='Opaque' \/>");
             var z =  z.replace(x[i],y);
          };
      }
      return z;
  }

  exports.run = function () {
    var $content = $('input[name="content"]');
    var $form = $("#course-lesson-form");
    var Validator = require('bootstrap.validator')
    var validator = new Validator({
        element: '#course-lesson-form',
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

    validator.on('formValidate', function(elemetn, event) {
        var content = getEditorContent(editor);
        $content.val(content);
    });

    validator.addItem({
      element: '[name="title"]', 
      required: true,
      display: '标题'
    });

    var $form = $("#course-lesson-form")

    $form.on('change', '[name=type]', function(e) {
        var type = $(this).val();

        $form.removeClass('lesson-form-video').removeClass("lesson-form-text")
        $form.addClass("lesson-form-" + type);
    });

    $form.find('[name="type"]:checked').trigger('change');

    window.CKEDITOR_BASEPATH = '/Public/lib/ckeditor/4.6.7/'
    require('ckeditor')

    var editor = CKEDITOR.replace('lesson-content-field', {
        toolbar: 'Full',
        filebrowserImageUploadUrl: $('#lesson-content-field').data('imageUploadUrl'),
        filebrowserFlashUploadUrl: $('#lesson-content-field').data('flashUploadUrl'),
        height: 180
    });

    require('uploader');
    require('uploader-css');

    var $progress = $('.progress');
    var $progressBar = $('.progress .progress-bar');
    var $message = $('.file-chooser-uploader-progress-message');

    $("#file-selected").dmUploader({
      url: '/Admin/File/add',
      extraData: {
         "course_id": $('input[name="course_id"]').val()
      },
      extFilter: ["mp4"],
      onBeforeUpload: function(id) {
        $progress.show();
      },
      onUploadProgress: function (id, percent) {
        $progressBar.width(percent+'%');
      },
      onUploadSuccess: function (id, data) {
        $progress.hide();

        if (data.success) {
          $message.text('上传成功！').fadeIn();
          setTimeout(function(){
            $message.text('').fadeOut();
          }, 2000);

          $('#media-name').text(data.file.name);
          $('input[name="media_name"]').val(data.file.name);
          $('input[name="media_id"]').val(data.file.id);
          $('input[name="media_uri"]').val(data.file.uri);
        }

      },
      onUploadError: function (id, xhr, status, errorThrown) {
        $progress.hide();
        $message.text(errorThrown).fadeIn();
        setTimeout(function(){
          $message.text('').fadeOut();
        }, 2000);
      }
      
    });

    $('#file-browser .item').click(function(){
      var $this = $(this)
      $('#file-browser .item').removeClass('alert-danger');
      $this.addClass('alert-danger');
      $('#media-name').text($this.data('file-title'));
      $('input[name="media_name"]').val($this.data('file-title'));
      $('input[name="media_id"]').val($this.data('file-id'));
      $('input[name="media_uri"]').val($this.data('file-uri'));
    });



  };

})