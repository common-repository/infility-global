/*
@author Ben
 */

(function($) {
    $(document).ready(function(){
        $("#chatList_tbody").dragsort({ itemSelector: "tr", dragSelector: ".i", dragBetween: true,dragEnd: saveOrder1, placeHolderTemplate: "<tr></tr>" });
    });
    function saveOrder1() {
        let data = $("#chatList_tbody tr .i").map(function(i) {
            return $(this).siblings('.control').find('input[name=RId\\[\\]]').val()+'|'+i;
        }).get();
        $("#listhaoSortOrder").val(data.join(","));
        data = data.join(",");

        let save = {'action':'infility_chat_tool','do_action':'save', 'u_sort':data};

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            dataType: 'json',
            data: save,
            success: function(res){
                if (res.ret==1) {
                    if (data.do_action=='save') {
                        global_obj.win_alert('保存成功','');
                    }else if(data.do_action=='del'){
                        window.location.reload();
                    }
                };
            }
        });
    };

    $('#chatList').on('click','.save,.del',function(){
        var _this = $(this),
            RId = _this.siblings('input[name=RId\\[\\]]').val(),
            tr = _this.parents('tr'),
            data = {RId:RId,'action':'infility_chat_tool'};

        if (_this.hasClass('save')) {
            data['do_action'] = 'save';
            data['service'] = $('input[name=service\\['+RId+'\\]]').val();
            data['username'] = $('input[name=username\\['+RId+'\\]]').val();
            data['background_color'] = $('input[name=background_color\\['+RId+'\\]]').val();
            data['image'] = $('input[name=image\\['+RId+'\\]]').val();


            ListAjax(_this,data);
        }else if(_this.hasClass('del')){
            data['do_action'] = 'del';

            global_obj.win_alert('确认删除？ 删除后无法恢复。',function(result){
                if (result==1) {
                    ListAjax(_this,data);
                };
            },1,'confirm')
        }
    })

    $('#save_chat_tool').on('submit',function(){
        var _this = $(this);
        if(global_obj.check_form(_this.find('*[notnull]'), _this.find('*[format]'))) return false;

        let post = _this.serialize()+'&action=infility_chat_tool&do_action=save';

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            dataType: 'json',
            data: post,
            success: function(res){
                if (res.ret==1) {
                    window.location.href=_this.find('input[name=jumpUrl]').val();
                }else{
                    global_obj.win_alert(res.msg,'');
                }
            }
        });

        return false;
    });

    $('.addBtn input[type="file"]').on('change',function(){
        var _this = $(this),
            filePath = _this.val(), //获取到input的value，里面是文件的路径
            box = _this.parents('.addBtn').siblings('.imgBox'),
            fileFormat = filePath.substring(filePath.lastIndexOf(".")).toLowerCase(),
            src = window.URL.createObjectURL(this.files[0]), //转成可以在本地预览的格式
            RId = _this.parents('tr').find('input[name=RId\\[\\]]').val();

        if(RId){
            let background = _this.parents('tr').find('input[name=background_color\\['+RId+'\\]]').val();
            box.html('<div style="width:50px;height:50px;border-radius: 500px;background: '+background+' url('+src+') no-repeat center center;background-size:20px;"><input type="hidden" name="image['+RId+']" value="" /></div>');
            blobToBase64(this.files[0], function(data) {box.find('input[name="image\\['+RId+'\\]"]').val(data);});
        }else{
            let background = $('input[name=background_color]').val();
            box.html('<div style="width:50px;height:50px;border-radius: 500px;background: '+background+' url('+src+') no-repeat center center;background-size:20px;"><input type="hidden" name="image" value="" /></div>');
            blobToBase64(this.files[0], function(data) {box.find('input[name="image"]').val(data);});
        }

        // box.find('img').on('click',function(){
        //     box.html('');
        //     _this.val('');
        // })
    })

    function blobToBase64(blob, callback) {
        var a = new FileReader();
        a.onload = function(e) {
            callback(e.target.result);
        }
        a.readAsDataURL(blob);
    }

    function ListAjax(_this,data){
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(res){
                if (res.ret==1) {
                    if (data.do_action=='save') {
                        global_obj.win_alert('保存成功','');
                    }else if(data.do_action=='del'){
                        window.location.reload();
                    }
                };
            }
        });
    }
})( jQuery );