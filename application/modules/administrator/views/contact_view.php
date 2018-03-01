<div class="grid_12">
    <form method="post" action="<?= current_url();?>
        /save" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thông tin khách hàng liên hệ</div>
        <div class="clear"></div>
        <div class="command">
            <span>

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
                            <th>Tên</th>
                            <th style="width:120px;text-align:center;">Số điện thoại</th>
                            <th style="width:230px;text-align:center;">Email</th>
                            <th >Ngày gửi</th>
                            <th style="width:80;text-align:center;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(count($contact_list) >0 ) {?>
                            <?php $i = 1; foreach ($contact_list as $key) :?>
                            <tr id="contact<?= $key['Id']?>">
                                <td align="center" style="width:20px;text-align:center;"><?= $i?></td>
                                <td><b><?= $key['Name']?></b></td>
                                <td align="center" style="width:120px;text-align:center;"><?= $key['Phone']?></td>
                                <td align="center" style="width:230px;text-align:center;"><?= $key['Email']?></td>
                                <td align="center" style="width:120px;text-align:center;"><?= $key['CreatedDate']?></td>
                                <td align="center" style="width:120px;text-align:center;">
                                    <a href="<?= base_url()?>administrator/contact/customers/edit/<?= $key['Id']?>">Chi tiết</a>|
                                    <a href="javascript:void(0);" onclick="showconfirm(<?= $key['Id']?>,'Xác thực xóa','Bạn có chắc muốn xóa thông tin này?','delete')">xóa</a>
                                </td>
                            </tr>
                            <?php $i++; endforeach;?>
                        <?php }else {?>
                            <tr>
                                <td colspan="6">Chưa có liên hệ nào cả</td>
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
                            Delete_Hotline(id);
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

    function Delete_Hotline(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_contact",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa thành công!');
                  $('#contact'+id).fadeOut(400);
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