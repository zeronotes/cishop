<div class="grid_12">
    <form method="post" action="<?= current_url();?>
        /save" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Hỗ trợ trực tuyến<div class="clear"></div></div>
        <div class="command">
            <span>
                <span><a href="<?= base_url()?>administrator/supportonline/add">Thêm mới</a></span>
            </span>
        </div>
        <div class="wrap-main-body">
            
            <div class="wrap-page-link">
                <div class="page-link">
                    <?= $link?></div>
            </div>
            <div style="padding:1px;">
                <table class="table-view">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề</th>
                            <th style="width:80;text-align:center;">Thứ tự</th>
                            <th style="width:80;text-align:center;">Hiển thị</th>
                            <th style="width:80;text-align:center;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(count($support_list) >0 ) {?>
                            <?php $i = 1; foreach ($support_list as $key) :?>
                            <tr id="support<?= $key['SupportOnlineID']?>">
                                <td align="center" style="width:20px;text-align:center;"><?= $i?></td>
                                <td>
                                    <a id="txtNewsTitle<?= $key['SupportOnlineID']?>" href="<?= base_url()?>administrator/supportonline/edit/<?= $key['SupportOnlineID']?>"><?= $key['Title']?></a>
                                </td>
                                <td align="center" style="width:80px;text-align:center;">
                                   <input type="text" onfocus="this.oldvalue = this.value;" id="txtOrders<?= $key['SupportOnlineID']?>" style="width: 50px; text-align:right;" value="<?= $key['Orders']?>" onchange="UpdateOrders(<?= $key['SupportOnlineID']?>,this);"/>
                                </td>
                                <td align="center" style="width:80px;text-align:center;">
                                    <input type="checkbox" value="1" id="cbIsVisible<?= $key['SupportOnlineID']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['SupportOnlineID']?>);"/>
                                </td>
                                <td align="center" style="width:120px;text-align:center;">
                                    <a href="<?= base_url()?>administrator/supportonline/edit/<?= $key['SupportOnlineID']?>">Chỉnh sửa</a>|
                                    <a href="javascript:void(0);" onclick="showconfirm(<?= $key['SupportOnlineID']?>,'Xác thực xóa hỗ trợ online','Bạn có chắc muốn xóa thông tin hỗ trợ online này?','delete');">xóa</a>
                                </td>
                            </tr>
                            <?php $i++; endforeach;?>
                        <?php }else {?>
                            <tr>
                                <td colspan="6">Chưa có thông tin hỗ trợ nào cả</td>
                            </tr>
                        <?php }?></tbody>

                    <tfoot></tfoot>
                </table>
            </div>
            <div class="wrap-page-link">
                <div class="page-link">
                    <?= $link?></div>
            </div>
        </div>
        <div class="command">
            <span>
                <span><a href="<?= base_url()?>administrator/supportonline/add">Thêm mới</a></span>
            </span>
        </div>
    </form>
</div>

<script type="text/javascript">

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
                        if(action == 'save') {
                            submitform();
                        }else if(action == 'delete') {
                            Delete_Support(id);
                        }
                        $('body').css('overflow','auto');
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

    function UpdateOrders(id,element) {
        var orders = $("#txtOrders"+id).val();
        if(!isNaN(orders)) {
            $.ajax( {
                  type: "POST",
                  url: "<?= base_url()?>ajaxhandle/admin_support_online_ajaxhandler/Update_orders",
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

    function UpdatePublishStatus(id) {
        var Publish;
        if($("#cbIsVisible"+id).attr('checked')){
            Publish = 1;    
        }else {
            Publish = 0;
        }
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_support_online_ajaxhandler/Update_publish",
            data: { id: id,Publish: Publish},
            dataType: "json",
            success: function(data) {
                if(data == 0) {
                    notice('Đã có lỗi! Thực hiện lại sau.');
                }else if(data == 1) {
                    notice("Đã cập nhật trạng thái hiển thị.");
                }else {
                    notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function Delete_Support(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_support",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa thông tin hỗ trợ thành công!');
                  $('#support'+id).fadeOut(400);
                }else {
                  notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function scrollToError(yeah) {
        $('html, body').animate({scrollTop:$('#'+yeah).offset().top - 50}, 'slow');
    }

    function submitform() {
        $("#form-edit").submit();
    }

    $('form').submit(function() {
        return true;
    });
</script>