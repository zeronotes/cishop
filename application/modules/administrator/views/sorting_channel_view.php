<div class="grid_12">
    <div class="header-content">Danh sách số kênh</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/sorting/channel/add">Thêm mới</a></span>
    </div>
    <div class="clear"></div>
    <div class="wrap-main-body">
        <div class="page-link"><?= $link?></div>
        <div style="padding:1px;">
            <table class="table-view">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Danh mục</th>
                        <!-- <th>Tiêu biểu</th> -->
                        <th>Hiển thị</th>
                        <th>Thứ tự</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; foreach ($category_list as $key) :?>
                        <tr id="Row<?= $key['SortingChannelID']?>">
                            <td align="center" style="width:20px;text-align:center;"><?= $i?></td>
                            <td align="center"><a href="<?= base_url()?>administrator/sorting/channel/edit/<?= $key['SortingChannelID']?>"><?= $key['Title']?></a></td>
                            <!-- <td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsTop<?= $key['SortingChannelID']?>" <?php if($key['IsTop'] == 1) echo 'checked="checked"'?> onclick="UpdateIsTop(<?= $key['SortingChannelID']?>);"/></td> -->
                            <td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['SortingChannelID']?>" <?php if($key['Publish']) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['SortingChannelID']?>,this);"/></td>
                            <td align="center" style="width:60px;text-align:center;"><input type="text" onfocus="this.oldvalue = this.value;" id="txtOrders<?= $key['SortingChannelID']?>" style="width: 50px; text-align:right;" value="<?= $key['Orders']?>" onchange="UpdateOrders(<?= $key['SortingChannelID']?>,this);"/></td>
                            <td align="center" style="width:150px;text-align:center;"><a href="<?= base_url()?>administrator/sorting/channel/edit/<?= $key['SortingChannelID']?>">Chỉnh sửa</a> | <a href="<?= base_url()?>administrator/sorting/channel/clone/<?= $key['SortingChannelID']?>">Nhân bản</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['SortingChannelID']?>,'Xác thực xóa danh mục','Xóa danh mục đồng nghĩa với việc xóa tất cả tin bán bất động sản thuộc danh mục này.<br/><br/>Bạn có chắc muốn xóa danh mục tin này?','delete')">xóa</a></td>
                        </tr>
                    <?php $i++; endforeach;?>
                </tbody>

                <tfoot>

                </tfoot>
            </table>
        </div>
        <div class="wrap-page-link">
            <div class="page-link"><?= $link?></div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/sorting/channel/add">Thêm mới</a></span>
    </div>
</div>
<script type="text/javascript">
 //<![CDATA[
    function UpdatePublishStatus(id) {
        var Publish;
        if($("#cbIsVisible"+id).attr('checked')){
            Publish = 1;    
        }else {
            Publish = 0;
        }
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/sorting_channel_ajaxhandler/Update_Publish",
            data: { id: id,Publish: Publish},
            dataType: "json",
            success: function(data) {
                if(data == 0) {
                    notice('Đã có lỗi! Thực hiện lại sau.');
                }else if(data == 1){
                    notice('Đã cập nhật trạng thái hiển thị.');
                }else {
                  notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    // function UpdateIsTop(id) {
    //     var IsTop;
    //     if($("#cbIsTop"+id).attr('checked')){
    //       IsTop = 1;  
    //     }else {
    //       IsTop = 0;
    //     }
    //     $.ajax( {
    //           type: "POST",
    //           url: "<?= base_url()?>ajaxhandle/sorting_channel_ajaxhandler/Update_IsTop",
    //           data: { id: id,IsTop: IsTop},
    //           dataType: "json",
    //           success: function(data) {
    //             if(data == 0) {
    //               notice('Đã có lỗi! Thực hiện lại sau.');
    //             }else if(data == 1) {
    //               notice("Đã cập nhật trạng thái Tiêu biểu.");
    //             }else {
    //               notice(data.msg);
    //             }
    //           },
    //           error: function(XMLHttpRequest, textStatus, errorThrown) {
    //             notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
    //           }
    //     });
    // }

    function UpdateOrders(id,element) {
        var orders = $("#txtOrders"+id).val();
        if(!isNaN(orders)) {
            $.ajax( {
                  type: "POST",
                  url: "<?= base_url()?>ajaxhandle/sorting_channel_ajaxhandler/Update_Orders",
                  data: { id: id,orders: orders},
                  dataType: "json",
                  success: function(data) {
                    if(data == 0) {
                        notice('Đã có lỗi! Thực hiện lại sau.');
                    }else if(data == 1) {
                        element.defaultValue = orders;
                        notice('Đã thay đổi thứ tự hiển thị.');
                    }else {
                      notice(data.msg);
                    }
                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                        notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
                  }
            });
        }else {
            $("#txtOrders"+id).val(element.defaultValue);
            notice('Thứ tự phải là chữ số');
        }
    }

    function showconfirm(id,title,message,action){
        //var elem = $(this).closest('.item');
        $('body').css('overflow','hidden');
        $.confirm({
            'title'     : title,
            'message'   : message,
            'buttons'   : {
                'Yes'   : {
                    'class' : 'blue',
                    'action': function(){
                        if(action == 'delete') {
                            Delete_Categories_Channel(id);
                            $('body').css('overflow','auto');
                        }
                    }
                },
                'No'    : {
                    'class' : 'gray',
                    'action': function(){
                        $('body').css('overflow','auto');
                    }
                }
            }
        });
    }

    function Delete_Categories_Channel(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_sorting_channel",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa thành công!');
                  $('#Row'+id).fadeOut(400);
                }else if(data.msg != "") {
                  notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }
//]]>
</script>