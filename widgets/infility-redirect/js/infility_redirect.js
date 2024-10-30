/*
@author CJJ
 */
(function($) {
	$('#redirectList').on('click','.save,.del',function(){
		var _this = $(this),
			RId = _this.siblings('input[name=RId\\[\\]]').val(),
			tr = _this.parents('tr'),
			data = {RId:RId,'action':'infility_redirect'};

		if (_this.hasClass('save')) {
			data['do_action'] = 'save_redirect_action';
			data['old_link'] = $('input[name=old_link\\['+RId+'\\]]').val();
			data['redirect_link'] = $('input[name=redirect_link\\['+RId+'\\]]').val();

			redirectAjax(_this,data);			
		}else if(_this.hasClass('del')){
			data['do_action'] = 'del_redirect_action';

			global_obj.win_alert('确认删除？ 删除后无法恢复。',function(result){
				if (result==1) {
					redirectAjax(_this,data);					
				};
			},1,'confirm')
		}

		
	})

	function redirectAjax(_this,data){
		$.post(ajax_object.ajax_url,data,function(result){
			if (result.ret==1) {
				if (data.do_action=='save_redirect_action') {
					global_obj.win_alert('保存成功','');
				}else if(data.do_action=='del_redirect_action'){
					window.location.reload();
				}
			};
			_this.removeClass('load');
		},'json')			
	}

	$('#save_redirect').on('submit',function(){
		var _this = $(this),
			data = {'action':'infility_redirect','do_action':'save_redirect_form'};
		

		if(global_obj.check_form(_this.find('*[notnull]'), _this.find('*[format]'))) return false;

		if (_this.hasClass('load')) return false;
		_this.addClass('load');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
		$.post(ajax_object.ajax_url,_this.serialize()+'&action=infility_redirect&do_action=save_redirect_form',function(data){
			if (data.ret==1) {
				window.location.href=_this.find('input[name=jumpUrl]').val(); 
			}else{
				global_obj.win_alert(data.msg,'');				
			}               
			_this.removeClass('load');
		},'json')	

		return false;
	})

	$('#set_redirect').on('submit',function(){
		var _this = $(this);		

		if(global_obj.check_form(_this.find('*[notnull]'), _this.find('*[format]'))) return false;

		if (_this.hasClass('load')) return false;
		_this.addClass('load');
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
		$.post(ajax_object.ajax_url,_this.serialize()+'&action=infility_redirect&do_action=infility_redirect_set',function(data){
			if (data.ret==1) {
				window.location.href=_this.find('input[name=jumpUrl]').val(); 
			}else{
				global_obj.win_alert(data.msg,'');				
			}               
			_this.removeClass('load');
		},'json')	

		return false;
	})


	$('#upload_redirect').on('submit',function(){
		var _this = $(this);
		if(global_obj.check_form(_this.find('*[notnull]'), _this.find('*[format]'))) return false;

		if(_this.hasClass('load')) return false;
		_this.addClass('load');
		AjaxForm(_this);
		_this.removeClass('load');
		return false;
	})

	function AjaxForm(_this, options) {
		var form = _this;
		//将form对象直接作为参数 new FormData对象
		var formData = new FormData(form[0]);


		// $("input[type='file']").each(function (item, i) {
		// 	//获取file对象 即相当于可以直接post的$_FILES数据
		// 	var domFile = $(this)[0].files[0];
		// 	//追加file 对象
		// 	formData.append('file', domFile);
		// })

		// console.log(formData);return false;
		if (!options)options = {};
		options.url = ajax_object.ajax_url;
		options.type = 'post';
		options.dataType = 'json';
		options.data = formData;
		options.processData = false;     // tell jQuery not to process the data
		options.contentType = false;     // tell jQuery not to set contentType
		options.xhr = options.xhr ? options.xhr : function () {
			//这是关键  获取原生的xhr对象  做以前做的所有事情
			var xhr = $.ajaxSettings.xhr();
			xhr.upload.onload = function () {
				console.log("onload");
			}

			xhr.upload.onprogress = function (ev) {
				if (ev.lengthComputable) {
					var percent = 100 * ev.loaded / ev.total;
					console.log(percent, ev)
				}
			}
			return xhr;
		};
		options.success = function(data){
			global_obj.win_alert(data.msg,function(){
				if (data.ret==1) {
					window.location.reload();
				}
			});					
		}

		$.ajax(options);
	}
})( jQuery );