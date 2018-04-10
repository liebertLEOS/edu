/**
 * Created by lenovo on 2018/4/5.
 */
define(function(require, exports, module){
	var $ = require('jquery-3.3.1')

	require('bootstrap')

	require('tree')

	require('layout')

	require('pushmenu')

	$('[data-toggle="push-menu"]').pushMenu()

	// fileinput
	//

	require('fileinput')
	/**
	 * Convert automatically file inputs with class 'file' into a bootstrap fileinput control.
	 */
	//var $input = $('input.file[type=file]').fileinput({
	//	uploadUrl: '/Admin/File/add',
	//	showRemove: false,
	//	initialPreviewConfig: [
	//		{
	//			url: '/Admin/File/delete'
	//		}
	//	]
	//}).on('fileuploaded', function(event, data, previewId, index) {
	//	var response =  data.response
    //
	//	previewId = response.file.id
	//	console.log(data);
	//}).on('filesuccessremove', function(event, id) {
	//	console.log(id);
	//});
	var $input = $('input.file[type=file]').fileinput({
		showRemove: false,
		showUpload: false
	});

})