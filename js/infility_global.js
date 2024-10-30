(function($) {
	$('#CFP_plugins_setting').on('change','.plugin_swtich',function(){
		var _this = $(this),
			key = _this.attr('key'),
			isChecked = _this.is(':checked');

		if (_this.hasClass('load')) return false;
		_this.addClass('load');
		global_obj.auto_alert('Loading','loading',-1);

		$.post(ajax_object.ajax_url,{action:'infility_global_ajax',do_action:'plugin_swtich',key:key,isChecked:(isChecked?1:0)},function(data){
			if (data.ret==1) {
				global_obj.auto_alert(data.msg,'success');
			}else{
				global_obj.auto_alert(data.msg,'fail');
			}
			_this.removeClass('load');			
		},'json')
	})
})( jQuery );