/**
 * Created by lenovo on 2018/4/5.
 */
define(function(require, exports, module){

	var $ = require('jquery')
	var Notify = require('common/bootstrap-notify')

	var sortList = function($list) {
		var data = $list.sortable("serialize").get();
		$.post($list.data('sortUrl'), {ids:data}, function(response){

			if (response.success) {
				Notify.success(response.message)
        var lessonNum = chapterNum = unitNum = 0

        $list.find('.item-lesson, .item-chapter, .item-chapter-unit').each(function() {
          var $item = $(this)
          if ($item.hasClass('item-lesson')) {
            lessonNum ++
            $item.find('.number').text(lessonNum)
          } else if ($item.hasClass('item-chapter-unit')) {
            unitNum ++
            $item.find('.number').text(unitNum)
          } else if ($item.hasClass('item-chapter')) {
            chapterNum ++
            unitNum = 0
            $item.find('.number').text(chapterNum)
          }

        });
			} else {
				Notify.danger(response.message)
			}
		});
	};

	require('sortable')

	var $list = $("#course-item-list").sortable({
		distance: 20,
		itemSelector: '.item-lesson, .item-chapter, .item-chapter-unit',
		onDrop: function (item, container, _super) {
			_super(item, container)
			sortList($list);
		},
		serialize: function(parent, children, isContainer) {
			return isContainer ? children : parent.attr('id');
		},
		isValidTarget:function (item, container) {
			if(item.siblings('li').length){
				return true
			}else{
				return false
			}
		}
	})
	

})