<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới hotline</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/hotline">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin hotline</a>
                </li>
            </ul>
            <div id="tabs-1" >
                <div id="Div1">
                    <table class="admintable" width="100%">
                        <tbody><tr>
                            <td style="height: 5px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Tiêu đề
                            </td>
                            <td>
                                <?php echo form_error('hotlineTitle'); ?>
                                <input name="hotlineTitle" type="text" value="" id="hotlineTitle" style="width:400px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">
                                            Tiêu đề</p>
                                        <p class="tooltipmessage">
                                            Tiêu đề hiển thị của hotline
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Số điện thoại
                            </td>
                            <td>
                                <?php echo form_error('hotlinePhone'); ?>
                                <input name="hotlinePhone" type="text" value="" id="hotlinePhone" style="width:400px;">
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Số điện thoại</p>
                                    <p class="tooltipmessage">
                                        Số điên thoại hỗ trợ
                                    </p>
                                </span></span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="hotlinePublish" id="hotlinePublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị hotline</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị hotline ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="key">Thứ tự hiển thị</td>
                            <td>
                                <input name="hotlineOrders" type="text" value="" id="hotlineOrders" style="width:40px;">    
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thứ tự hiển thị hotline</p>
                                        <p class="tooltipmessage">Thứ tự hiển thị của hotline</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        
                    </tbody></table>
                </div>
            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/hotline">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
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
                            $('body').css('overflow','auto');
                        }
                    }
                },
                'No'    : {
                    'class' : 'gray',
                    'action': function(){
                        // if(action == 'delete' || action == 'update' || action == 'uploadimg') {
                        //     $('body').css('overflow','auto');
                        // }
                        $('body').css('overflow','auto');
                    }
                }
            }
        });
    }


</script>
<script type="text/javascript">
    function scrollToError(yeah) {
        $('html, body').animate({scrollTop:$('#'+yeah).offset().top - 50}, 'slow');
    }

    function submitform() {
        $("#form-edit").submit();
    }

    //$.jQuery(document).ready(function($) {
    $('#form-edit').submit(function() {
        $(".error").remove();
        var idElementError = "";
        var hasError = false;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        var hotlineTitle = $("#hotlineTitle").val();
        if(hotlineTitle == '') {
            $("#hotlineTitle").before('<span class="error Required  ">Tiêu đề hotline không được trống</span>');
            hasError = true;
            if (idElementError == "") idElementError = "hotlineTitle";
        }

        var hotlinePhone = $("#hotlinePhone").val();
        if(hotlinePhone == '') {
            $("#hotlinePhone").before('<span class="error Required  ">Tiêu đề hotline không được trống</span>');
            hasError = true;
            if (idElementError == "") idElementError = "hotlinePhone";
        }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);
        
        return false;
    });
    //});
    
</script>