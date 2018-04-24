define(function(require, exports, module) {
  require('video-js-css')
  var $ = require('jquery')
  var Notify = require('common/bootstrap-notify')
  var VideoJS = require('video-js')
  var url = $('#lesson-video-content').data("url")

  var player = VideoJS('lesson-video-content', {
    techOrder: ['flash','html5'],
    autoplay: true
  })

  player.dimensions('100%', '100%')
  player.src(url)

  player.on('error', function(error){
      this.set("hasPlayerError", true)
      alert('您的浏览器不能播放当前视频。')
  })

  // player.on('fullscreenchange', function(e) {
  //     if ($(e.target).hasClass('vjs-fullscreen')) {
  //     }
  // })

  player.on('ended', function(e){
    alert('本课时学习完毕')
  })

  // player.on('timeupdate', function(e){

  // })

  // player.on('loadedmetadata' ,function(e){

  // })

  // player.on("play", function(e){

  // })

  // player.on("pause", function(e){

  // })

  // player.play()
})