<div class="grid_12">
    <div class="header-content">Danh sách ý kiến khách hàng</div>
    <div class="clear"></div>
    <div class="command">
        <span>
            <span><a href="<?= base_url()?>administrator/testimonials/add">Thêm mới</a></span>
        </span>
    </div>
    <div class="wrap-main-body">

        <div class="wrap-page-link">
            <div class="page-link">
                <?= $link?></div>
        </div>
        <div style="padding:1px;">
        <form id="formPost" method="post" name="formPost" accept-charset="utf-8">
            <table class="table-view">
                <thead>
                    <tr>
                        <th></th>
                        <th>Họ tên</th>
                        <th>Hiển thị</th>
                        <th>Thứ tự</th>
                        <th>Ngày khởi tạo</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(!empty($testimonials_list)) {?>
                        <?php $i = 1; foreach ($testimonials_list as $key) :?>
                        <tr id="faq<?= $key['TestimonialsID']?>" class="faq">
                            <td align="center" style="width:20px;text-align:center;"><?= $i?></td>
                            <td><b><?= $key['FullName']?></b></td>
                            <td align="center" style="width:120px;text-align:center;">
                                <input type="checkbox" value="1" id="cbIsVisible<?= $key['TestimonialsID']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="UpdatePublish(<?= $key['TestimonialsID']?>);"/>
                            </td>
                            <td align="center" style="width:60px;text-align:center;">
                                <input type="text" id="txtOrders<?= $key['TestimonialsID']?>" style="width: 50px; text-align:right;" value="<?= $key['Orders']?>" onchange="UpdateOrders(<?= $key['TestimonialsID']?>,this);"/>
                            </td>
                            <td align="center" style="width:120px;text-align:center;"><?= $key['CreatedDate']?></td>
                            <td align="center" style="width:120px;text-align:center;">
                                <a href="<?= base_url()?>administrator/testimonials/edit/<?= $key['TestimonialsID']?>">Chi tiết</a>|
                                <a href="javascript:void(0);" onclick="showconfirm(<?= $key['TestimonialsID']?>,'Xác thực xóa','Bạn có chắc muốn xóa thông tin này?','delete')">xóa</a>
                            </td>
                        </tr>
                        <?php $i++; endforeach;?>
                    <?php }else {?>
                        <tr>
                            <td colspan="6">Chưa có ý kiến khách hàng nào cả</td>
                        </tr>
                    <?php }?></tbody>

                <tfoot></tfoot>
            </table>
        </form>
        </div>
        <div class="wrap-page-link">
            <div class="page-link">
                <?= $link?></div>
        </div>
    </div>
    <div class="command">
        <span>
            <span><a href="<?= base_url()?>administrator/testimonials/add">Thêm mới</a></span>
        </span>
    </div>
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
                            Delete_testimonial(id);
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

    function Delete_testimonial(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/deleteTestimonial",
            data: { Id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa thành công!');
                  $('#faq'+id).fadeOut(400);
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
        var Orders = $("#txtOrders"+id).val();
        if(!isNaN(Orders)) {
            $.ajax( {
                  type: "POST",
                  url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/updateTestimonialsOrders",
                  data: { Id: id,Orders: Orders},
                  dataType: "json",
                  success: function(data) {
                    if(data == 0) {
                        notice('Đã có lỗi! Thực hiện lại sau.');
                    }else if(data == 1) {
                        element.defaultValue = Orders;
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

    function UpdatePublish(id) {
        var Publish;
        if($("#cbIsVisible"+id).attr('checked')){
            Publish = 1;
        }else {
            Publish = 0;
        }
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/updateTestimonialsPublish",
            data: { Id: id,Publish: Publish},
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

    function scrollToError(yeah) {
        $('html, body').animate({scrollTop:$('#'+yeah).offset().top - 50}, 'slow');
    }

    function submitform() {
        $("#form-edit").submit();
    }

    $('form#form-edit').submit(function() {
        return true;
    });
</script>

<script type="text/javascript">

    function CheckAll() {
        $(".selectedId").attr('checked', $("#chkTickAll").is(":checked"));
        if($('.selectedId').filter(":checked").length > 0 ) {
            $("#menu-trigger").attr('onclick','ShowActinMenu();');
            $("table.table-view tbody tr.faq td").css('background-color','#F0F0F0');
        }else {
            $("#menu-trigger").removeAttr('onclick');
            $(".action-menu").hide();
            $("table.table-view tbody tr.faq td").css('background-color','');
        }

    }

    function ChkTick(id) {

        if($('.selectedId').filter(":checked").length > 0 && $("#chkTick"+id).is(":checked")) {
            $("#menu-trigger").attr('onclick','ShowActinMenu();');
            $("table.table-view tbody tr#faq"+id+" td").css('background-color','#F0F0F0');
        }else if($('.selectedId').filter(":checked").length == 0 && !$("#chkTick"+id).is(":checked")){
            $("#menu-trigger").removeAttr('onclick');
            $(".action-menu").hide();
            $("table.table-view tbody tr#faq"+id+" td").css('background-color','');
        }else {
            $(".action-menu").hide();
            $("table.table-view tbody tr#faq"+id+" td").css('background-color','');
        }

        var check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
        $('#chkTickAll').prop("checked", check);
    }

    function ShowActinMenu() {
        if ($(".action-menu").is(":visible"))
        {
            $(".action-menu").slideUp(100);
            $("#menu-trigger").removeClass("open");
        }else
        {
            $(".action-menu").slideDown(100);
            $("#menu-trigger").addClass("open");
        }
    }

    var funcName = "";

    function DeleteChk() {
        $('#chkTickAll').prop("checked", false);
        $("#menu-trigger").removeClass("open");
        $("#menu-trigger").removeAttr('onclick');
        $(".action-menu").hide();
        funcName = "Delete_faq_chk";
        $("#formPost").submit();
    }

    function TrashChk() {
        $('#chkTickAll').prop("checked", false);
        $("#menu-trigger").removeClass("open");
        $("#menu-trigger").removeAttr('onclick');
        $(".action-menu").hide();
        funcName = "Trash_faq_chk";
        $("#formPost").submit();
    }

    function temp() {
        var form = document.formPost;

        var dataString = $(form).serialize();

        $.ajax({
            type:'POST',
            url:'<?= base_url()?>ajaxhandle/admin_testimonials_ajaxhandler/'+funcName,
            data: dataString,
            dataType: 'json',
            success: function(data){
                $.each(data.array, function(i, item) {
                    $("#faq"+item).remove();
                });

                notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function submitFormPost(){
        $("#formPost").submit();
    }

    $('form#formPost').submit(function(){
        temp();
        return true;
    });

</script>