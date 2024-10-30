/*
CF7 - 控件
@author CJJ
 */
(function($) {
	$('#CFP_plugins_setting').on('submit',function(){
		var _this = $(this);
		if(global_obj.check_form(_this.find('*[notnull]'), _this.find('*[format]'))) return false;
	}).on('change','select[name=post_id]',function(){
		var _this = $(this),
			option = _this.find('option[value='+_this.val()+']'),
			url = option.attr('url');

		window.location.href=url;
	})
})( jQuery );