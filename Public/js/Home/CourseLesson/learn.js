define(function(require, exports, module) {
  var $ = require('jquery')
  var Notify = require('common/bootstrap-notify')

  $.get('/Home/CourseLesson/ajaxGetContent?lesson_id=' + lesson.id, function(lesson) {
    console.log(lesson.content)
    if (lesson.type == 'text') {
      require('perfect-scrollbar')
      require('perfect-scrollbar-css')
      
      $("#lesson-text-content").find('.content').html(lesson.content)
      $("#lesson-text-content").show()
      $("#lesson-text-content").perfectScrollbar({wheelSpeed:50})
      $("#lesson-text-content").scrollTop(0)
      $("#lesson-text-content").perfectScrollbar('update')
    }

  })


})