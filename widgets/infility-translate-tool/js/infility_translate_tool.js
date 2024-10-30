/*
@author Ben
 */

(function($) {
    $('#translate_tool_setting').on('click',".install_plugins",function(){
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            dataType:'html',
            data: {action:'install_translation',upload:'transposh-translation-filter'},
            success: function(res){
                $("#translate_tool_setting .result1").html(res);
            }
        });

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            dataType:'json',
            data: {action:'install_translation',slug:'language-switcher-for-transposh'},
            success: function(res){
                let data = res.data;
                if(res.success===true){
                    $("#translate_tool_setting .result2").html(data.pluginName+' 安装成功！');
                }else{
                    $("#translate_tool_setting .result2").html(data.pluginName+' '+data.errorMessage);
                }

            }
        });
    })

    $('#translate_tool_setting').on('click',".open_plugins",function() {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            dataType: 'html',
            data: {action: 'open_translation'},
            success: function (res) {
                $("#translate_tool_setting .open_result").html('启动成功');
            }
        });
    });

    $("#translate_tool_setting").on('click',".choose_position",function(){
        let position = $("input[name='position']:checked").val();

        $("#translate_tool_setting .position_result").html('正在修改...');
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            dataType:'json',
            data: {action:'translate_position',position:position},
            success: function(res){
                $("#translate_tool_setting .position_result").html(res.msg);
            }
        });
    });
})( jQuery );