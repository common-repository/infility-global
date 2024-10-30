/*
CF7 - 控件
@author CJJ
 */
(function($) {
	let init=function(){
		if ($('.wpcf7[id^=wpcf7]').length>0) {
			$('.wpcf7[id^=wpcf7]').each(function(){
				var _this = $(this).find('form');
				if(_this.hasClass('done')) return true;
				if (_this.find('label').length) {
					var pObj = _this.find('p'),
						obj = $('<div class="flex"></div>');

					_this.find('p').eq(0).before(obj);
					obj.append(pObj);

					obj.find('p').each(function(){
						var _thisP = $(this),
							w = _thisP.find('label').attr('w');

						if (w) {
							_thisP.addClass('w'+w);
						}else{
							_thisP.addClass('w100');
						}
					})
				}
				_this.addClass('done');
			})
		}
		setTimeout(init,1500);
	}
	setTimeout(init,1500);
})( jQuery );