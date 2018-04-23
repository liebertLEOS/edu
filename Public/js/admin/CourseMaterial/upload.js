define(function(require, exports, module) {
  var $ = require('jquery');
  var Notify = require('common/bootstrap-notify');
  var Widget = require('widget');
  require('plupload-queue-css');
  require('plupload-queue');
  require('plupload');
  // 这里require是有顺序要求的
  require('plupload-queue-zh-cn');

  // var VideoQualitySwitcher = require('../widget/video-quality-switcher');

  exports.run = function() {
    var $container = $("#file-uploader-container"),
      targetType = $container.data('targetType'),
      uploadMode = $container.data('uploadMode'),
      hlsEncrypted = $container.data('hlsEncrypted');


    // var switcher = null;
    // if ($('.quality-switcher').length > 0) {
    //   var switcher = new VideoQualitySwitcher({
    //     element: '.quality-switcher'
    //   });
    // }

    var filters = [];
    filters = [{
      title: "Files",
      extensions: 'jpg,jpeg,gif,png,txt,doc,docx,xls,xlsx,pdf,ppt,pptx,pps,ods,odp,mp4,mp3,avi,flv,wmv,wma,zip,rar,gz,tar,7z,swf'
    }];

    var $div = $("#file-chooser-uploader-div");
    var divData = $div.data();

    var uploader = $div.pluploadQueue({
      runtimes: 'flash,html5,html4',
      max_file_size: '2gb',
      url: divData.uploadUrl,
      filters: filters,
      multipart_params: {
        course_id: $('input[name="course_id"]').val()
      },
      preinit: {
                Init: function (up, info) {
                  $("#file-chooser-uploader-div_container").removeAttr("title");
                }
            },      
      init: {
        FileUploaded: function(up, file, info) {
          response = $.parseJSON(info.response);

          if (response.success == false) {
            Notify.success(response.message);
          }

          if (up.total.uploaded == up.files.length) {
            $(".plupload_buttons").css("display", "inline");
            $(".plupload_upload_status").css("display", "inline");
            $(".plupload_start").addClass("plupload_disabled");
          }

        },

        QueueChanged: function(up){
          $(".plupload_start").removeClass("plupload_disabled");
        },

        Error: function(up, args) {
          Notify.danger('文件上传失败，可能的原因: 1.文件大小超出限制. 2.文件不存在. 3.文件不能被写入硬盘. 4.临时目录不存在.', 5);
        },

        UploadComplete: function(up, files) {
          Notify.success('全部上传成功', 3);
          up.refresh();
        },

        BeforeUpload: function(up, file) {
        }

      }

    });

    var $3 = require('jquery-3.3.1');

    $3('#modal').on('hide.bs.modal', function(e) {

      var uploader = $div.pluploadQueue();
      
      if (uploader.files.length > 0 && (uploader.total.uploaded != (uploader.files.length - uploader.total.failed))) {
        
        if (!confirm('当前正在上传的文件将停止上传，确定关闭？')) {
          return false;
        }
      }

      
      window.location.reload();
    });

  };

});