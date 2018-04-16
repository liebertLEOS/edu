define(function(require, exports, module) {

	window.$ = window.jQuery = require('jquery');

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

});