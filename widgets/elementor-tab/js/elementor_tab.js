/*
elementor_tab
@author CJJ
 */
var elementor_tab_obj = {
	silde_box_init:function(){
		var contentBox = $('.infility_tab .infility_tab_content.effect_slide');
		if (contentBox.length > 0) {
			contentBox.each(function(){
				var _this = $(this);
				if (_this.hasClass('init')) return true;

				var boxW = parseInt(_this.outerWidth());
				_this.find('.title_items_content').each(function(){
					var item = $(this),
						itemW = boxW - ( parseInt(item.css('margin-left')) + parseInt(item.css('margin-right')) );

					item.css({width:itemW});
				})

				_this.addClass('init').attr('offset',boxW);
			})
		};
	}
};


(function($) {
	$('body').on('click','.infility_tab .infility_tab_title .title_items',function(){
		var _this = $(this),
			index = _this.attr('key'),
			obj = _this.parents('.infility_tab'),
			contentBox = obj.find('.infility_tab_content'),
			content = obj.find('.title_items_content');

		
		_this.addClass('cur').siblings('.title_items').removeClass('cur');
		if (contentBox.hasClass('effect_fade')) {
			obj.find('.infility_tab_content .title_items_content.cur').hide();
			obj.find('.infility_tab_content .title_items_content[key='+index+']').removeClass('load').fadeIn();
		}else if(contentBox.hasClass('effect_slide')){
			if (!contentBox.hasClass('init')) {
				elementor_tab_obj.silde_box_init();
				// return false;
			}

			var offset = parseInt(contentBox.attr('offset')) * parseInt(index) * -1;
			contentBox.find('.slide_box').css('margin-left',offset)
		}
		content.removeClass('cur');
		obj.find('.infility_tab_content .title_items_content[key='+index+']').addClass('cur').removeClass('load');
	})


	elementor_tab_obj.silde_box_init();
})( jQuery );