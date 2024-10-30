var $ = jQuery;
var global_obj={
	timer:'',
	check_form:function(notnull_list, format_list){
		var result = false;
		if (notnull_list) {
			notnull_list.each(function(){
				var _this = $(this);
				if (!_this.find('input').length && $.trim(_this.val()) == '') {
					if (_this.attr('parent_null')) {
						_this.parent().addClass('null').css('border', '1px solid red');
						_this.parents('[parent_null]').addClass('null').css('border', '1px solid red');
					} else {
						_this.addClass('null').css('border', '1px solid red');
					}
					if(result == false) _this.focus();
					result = true;
				} else {
					if (_this.attr('parent_null')) {
						_this.parents('[parent_null]').removeClass('null').removeAttr('style');
					} else {
						_this.removeClass('null').removeAttr('style');
					}
				}
			});
			if (result){ return result; };
		}

		if(format_list){
			var reg={
				'MobilePhone':/^1[34578]\d{9}$/,
				'Telephone':/^(0\d{2,3})(-)?(\d{7,8})(-)?(\d{3,})?$/,
				'Fax':/^(0\d{2,3})(-)?(\d{7,8})(-)?(\d{3,})?$/,
				'Email':/^\w+[a-zA-Z0-9-.+_]+@[a-zA-Z0-9-.+_]+\.\w*$/,
				'Length':/^.*/
			};
			
			format_list.each(function(){
				var _this=$(this);
				if($.trim(_this.val())){
					if(reg[_this.attr('format')].test($.trim(_this.val()))===false){
						_this.addClass('null').css('border', '1px solid red');
						_this.focus();
						result=true;
					}
				}
			});
		}
		return result;
	},

	div_mask:function(remove){
		var obj=(typeof(arguments[1])=='undefined')?'':arguments[1],
			$obj = $('body');
			if (typeof(obj) == 'object') $obj = obj;
		if(remove==1){
			$('#mask_box').remove();
		}else{
			if(!$('#mask_box').length){
				$obj.prepend('<div id="mask_box"></div>');
				$('#mask_box').css({width:'100%', height:$(document).height(), overflow:'hidden', position:'fixed', top:0, left:0, background:'#000', opacity:0.6, 'z-index':10000});
			}
		}
	},

	auto_alert:function(tips, status, time, no_remove_mask){ //浮窗自动取消
		var status=(typeof(arguments[1])=='undefined')?'await':arguments[1],
			time=(typeof(arguments[2])=='undefined' || !arguments[2])?'2000':arguments[2],
			no_remove_mask=(typeof(arguments[3])=='undefined')?1:arguments[3],
			html='';
			pos_top='10%';
		if(no_remove_mask) $('#mask_box, .auto_alert').remove();//优先清空多余的弹出框
		if(status!='loading' || (status=='loading' && time==-1)){
			//除了loading Or 固定显示loading
			html+='<div class="auto_alert win_alert_auto_close'+(status=='loading'?' win_alert_loading':'')+'">';
			html+=	'<div class="win_tips"><i class="icon_status '+status+'"></i>'+tips+'</div>';
			html+='</div>';
			$('body').prepend(html);
			$('.auto_alert').css({left:$(window).width()/2-$('.auto_alert').outerWidth(true)/2, top:pos_top});
		}
		clearTimeout(global_obj.timer);
		if(status!='loading' || (status=='loading' && time>=0)){
			//除了loading Or 计时自动关闭loading
			global_obj.timer=setTimeout(function(){
				$('.auto_alert').fadeOut(400,'swing',function(){
					$('.auto_alert').remove();
				})
			}, time);
		}
		return false;
	},

	win_alert:function(tips, callback, remove_div_mask, type ,div_mask){  //弹窗or 确认框
		var div_mask=(typeof(arguments[4])=='undefined')?1:0;
		if (div_mask) global_obj.div_mask();
		$('.win_alert').remove();
		var type=(typeof(arguments[3])=='undefined')?'alert':arguments[3];
		var html='<div class="win_alert">';
			html+='<div class="win_close"><span class="close">×</span></div>';
			html+='<div class="win_tips">'+tips+'</div>';
			html+='<div class="win_btns"><button class="btn btn_sure">确认</button>';
			if(type=='confirm') html+='<button class="btn btn_cancel">取消</button>';
			html+='</div>';
			html+='</div>';
		$('body').prepend(html);
		// $('.win_alert').css({left:$(window).width()/2-200});
		if(type=='confirm'){
			$('.win_alert').delegate('.close, .btn_cancel', 'click', function(){
				$('.win_alert').remove();
				remove_div_mask!=0 && global_obj.div_mask(1);
				$.isFunction(callback) && callback(0);
			}).delegate('.btn_sure', 'click', function(){
				$('.win_alert').remove();
				remove_div_mask!=0 && global_obj.div_mask(1);
				$.isFunction(callback) && callback(1);
			});
		}else{
			$('.win_alert').delegate('.close, .btn_sure', 'click', function(){
				$('.win_alert').remove();
				remove_div_mask!=0 && global_obj.div_mask(1);
				$.isFunction(callback) && callback(1);
			});
		}
		$('.win_alert').click(function(e){
			e.stopPropagation();
		});
		return false;
	},

	urlencode:function(str) {
		str = (str + '').toString();
		return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
	},

	json_encode_data:function(value){
		var result=new Object();
		if(typeof(value)=='string' && value){
			if(typeof(JSON)=='object'){
				result=JSON.parse(value);
			}else{
				var ary, arr, key;
				ary=value.substr(1,value.length-2).split(',"');//踢走{}
				for(var i=0; i<ary.length; i++){
					arr=ary[i].split(':');
					key=parseInt(isNaN(arr[0]) ? (i==0?arr[0].substr(1,arr[0].length-2):arr[0].substr(0,arr[0].length-1)): arr[0]);//确保键是数字
					if(arr[1].substr(0,1)=='['){//值为数组
						result[key]=arr[1].substr(1,arr[1].length-2).split(',');
					}else{
						result[key]=arr[1];
					}
				}
			}
		}else{
			result=value;
		}
		return result;
	},

	json_decode_data:function(value){
		var result;
		if(typeof(value)=='object'){
			if(typeof(JSON)=='object'){
				result=JSON.stringify(value);
			}else{
				result='';
				for(k in value){
					if(global_obj.is_array(value[k])){
						result+=('"'+k+'":['+value[k]+'],');
					}else{
						result+=('"'+k+'":"'+value[k]+'",');
					}
				}
				result='{'+result.substr(0,result.length-1)+'}';
			}
		}else{
			result=value;
		}
		return result;
	},

	in_array:function(needle, arr){
		for(var i=0; i<arr.length && arr[i]!=needle; i++);
		return !(i==arr.length);
	},

	is_array:function(data){
		if(Object.prototype.toString.call(data)=='[object Array]'){
			return true;
		}else{
			return false;
		}
	},

	base64_encode:function(str){
		var c1, c2, c3;
		var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
		var i = 0, len= str.length, string = '';
		while (i < len){
			c1 = str.charCodeAt(i++) & 0xff;
			if (i == len){
				string += base64EncodeChars.charAt(c1 >> 2);
				string += base64EncodeChars.charAt((c1 & 0x3) << 4);
				string += "==";
				break;
			}
			c2 = str.charCodeAt(i++);
			if (i == len){
				string += base64EncodeChars.charAt(c1 >> 2);
				string += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
				string += base64EncodeChars.charAt((c2 & 0xF) << 2);
				string += "=";
				break;
			}
			c3 = str.charCodeAt(i++);
			string += base64EncodeChars.charAt(c1 >> 2);
			string += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
			string += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
			string += base64EncodeChars.charAt(c3 & 0x3F)
		}
		return string
	},

	htmlspecialchars:function(str){
		str = str.replace(/&/g, '&amp;');
		str = str.replace(/</g, '&lt;');
		str = str.replace(/>/g, '&gt;');
		str = str.replace(/"/g, '&quot;');
		str = str.replace(/'/g, '&#039;');
		return str;
	},

	htmlspecialchars_decode:function(str){
		str = str.replace(/&amp;/g, '&');
		str = str.replace(/&lt;/g, '<');
		str = str.replace(/&gt;/g, '>');
		str = str.replace(/&quot;/g, '"');
		str = str.replace(/&#039;/g, "'");
		return str;
    },

	setCookie:function(name, value, expiredays){
		var exdate=new Date();
		exdate.setDate(exdate.getDate()+expiredays);
		document.cookie=name+"="+escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
	},

	getCookie:function(name){
		if(document.cookie.length>0){
			start=document.cookie.indexOf(name+"=");
			if(start!=-1){
				start=start+(name.length+1);
				end=document.cookie.indexOf(";", start);
				if(end==-1) end=document.cookie.length;
				return unescape(document.cookie.substring(start, end));
			}
		}
		return "";
	},

	delCookie:function(name, expiredays){
		var exdate=new Date();
		exdate.setDate(exdate.getDate()-1);
		var value=global_obj.getCookie(name)
		if(value){
			document.cookie=name+"="+escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
		}
	},

	checkCharLength:function(box,content){ //字长判断
		var e=$(box);
		e.change(function(event){
			var curLength=e.val().length;
			var maxlength=e.attr('maxlength');
			if(curLength>maxlength){
				e.val($.trim(e.val()).substr(0,maxlength)).trigger('change');
				return;
			}
			$('#review_form .font_tips em').text(curLength);
			$(content).text(maxlength-curLength).parent().toggleClass('red', curLength>maxlength);
		}).keyup(function(){
			e.trigger('change');
		});
	},

	/**
	 *  获取当前地址url的get参数
	 *  @param value[string] 需要获取get的参数
	 *  @param selecter[string]  选择器，一般不需要，有些在iframe里面的，这里就写parent
	 */
	query_get:function(value, selecter)
	{
		if (selecter == 'parent') {
			var query = window.parent.location.search.substring(1);
		} else {
			var query = window.location.search.substring(1);
		}
		var vars = query.split("&");
		for (var i = 0; i < vars.length; i++) {
			var pair = vars[i].split("=");
			if(pair[0] == value) return pair[1];
		}
		return false;
	},
}
