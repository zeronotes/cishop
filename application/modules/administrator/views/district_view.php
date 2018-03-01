<div class="grid_12">
    <div class="header-content">Quận, huyện</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/categories/districts/add">Thêm mới</a></span>
    </div>
    <div class="clear"></div>
    <div class="wrap-main-body">
        <div class="page-link"><?= $link?></div>
        <div style="padding:1px;">
            <table class="table-view">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên quận huyện</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; foreach ($district_list as $key) :?>
                        <tr id="Row<?= $key['Id']?>">
                            <td align="center" style="width:20px;text-align:center;"><?= $i?></td>
                            <td align="center"><a href="<?= base_url()?>administrator/categories/districts/edit/<?= $key['Id']?>"><?= $key['Title']?></a></td>
                            <td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/categories/districts/edit/<?= $key['Id']?>">Chỉnh sửa</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['Id']?>,'Xác thực xóa quận, huyện','Bạn có chắc muốn xóa quận huyện này?','delete')">xóa</a></td>
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
        <span><a href="<?= base_url()?>administrator/categories/districts/add">Thêm mới</a></span>
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
            url: "<?= base_url()?>ajaxhandle/admin_districtss_categories_ajaxhandler/Update_Publish",
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

    function UpdateOrders(id,element) {
        var orders = $("#txtOrders"+id).val();
        if(!isNaN(orders)) {
            $.ajax( {
                  type: "POST",
                  url: "<?= base_url()?>ajaxhandle/admin_districtss_categories_ajaxhandler/Update_Orders",
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
                            Delete_Categories_districts(id);
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

    function Delete_Categories_districts(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_categories_districts",
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