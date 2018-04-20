define(function(require, exports, module) {

	var $ = require('jquery-3.3.1')
	require('bootstrap')
	require('modal.hack2')
	require('tree')
	require('layout')
	require('pushmenu')

	$('[data-toggle="push-menu"]').pushMenu()

	exports.load = function(name) {

		seajs.use(name, function(module) {
			if ($.isFunction(module.run)) {
				module.run()
			}
		})

	}

	exports.loadScript = function(scripts) {
		for(var index in scripts) {
			exports.load(scripts[index])
		}
		
	}

	window.app.load = exports.load

	// 页面的全部ajaxError处理
  $(document).ajaxError(function(event, jqxhr, settings, exception) {
    var json = jQuery.parseJSON(jqxhr.responseText)
      info = json.info
	    if (!info) {
	      return 
	    }

	    if (info == 'unlogin') {
	      $('.modal').modal('hide')

	      $("#login-modal").modal('show')
	      $.get($('#login-modal').data('url'), function(html){
	        $("#login-modal").html(html)
	      })
	    }
  })

})