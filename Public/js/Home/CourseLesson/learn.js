define(function(require, exports, module) {
  require('perfect-scrollbar-css')
  var $ = require('jquery')
  var Notify = require('common/bootstrap-notify')
  require('perfect-scrollbar')
  

  var lesson = window.lesson

  $('#dashboard-toolbar .toolbar-nav >li').click(function () {
    $this = $(this)
    if ($this.hasClass('active')) {
      $('#course-learn-dashboard').removeClass('course-learn-dashboard-open')

      $this.removeClass('active')
    } else {
      $('#dashboard-toolbar .toolbar-nav >li').removeClass('active')
      $('#dashboard-toolbar .tab-pane').removeClass('active')
      $this.addClass('active')
      $($this.children('a').eq(0).attr('href')).addClass('active')
      $('#course-learn-dashboard').addClass('course-learn-dashboard-open')
    }
    return false;
  })

  // 课时内容
  if (lesson.type == 'video') {
    var playerUrl = 'playVideo/course_id/' + lesson.courseId + '/lesson_id/' + lesson.id;
    var html = '<iframe src=\''+playerUrl+'\' name=\'viewerIframe\' id=\'viewerIframe\' width=\'100%\'allowfullscreen webkitallowfullscreen height=\'100%\' style=\'border:0px\'></iframe>';

    $("#lesson-video-content").html(html);
  } else if (lesson.type == 'text') {
    $("#lesson-text-content").find('.content').html(lesson.content)
    $("#lesson-text-content").perfectScrollbar({wheelSpeed:50})
    $("#lesson-text-content").scrollTop(0)
    $("#lesson-text-content").perfectScrollbar('update')
  }
  
  // 工具栏-课时列表
  $.get('/Home/Course/ajaxGetLessonItems?course_id=' + lesson.courseId, function(res){
    if (res.success) {
      $("#toolbar-lesson-list").html(res.content)
      $("#toolbar-lesson-list").perfectScrollbar({wheelSpeed:50})
      $("#toolbar-lesson-list").scrollTop(0)
      $("#toolbar-lesson-list").perfectScrollbar('update')
    } else {
      Notify.danger(res.message)
    }

  })

  // 工具栏-课程资料
  $("#toolbar-files").perfectScrollbar({wheelSpeed:50})
  // 工具栏-课程话题
  $("#toolbar-topic").perfectScrollbar({wheelSpeed:50})

})