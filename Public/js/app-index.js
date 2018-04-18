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
				module.run();
			}
		});

	};

	exports.loadScript = function(scripts) {
		for(var index in scripts) {
			exports.load(scripts[index]);
		}
		
	}

	window.app.load = exports.load;
  $("li.nav-hover").mouseenter(function(event) {
    $(this).addClass("open");
  }).mouseleave(function(event) {
    $(this).removeClass("open");
  });

	$(".search").focus(function () {
    $(this).prop("placeholder", "").addClass("active");
  }).blur(function () {
    $(this).prop("placeholder", "搜索").removeClass("active");
  });

});
