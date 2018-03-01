<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-add" id="form-add" accept-charset="utf-8">
        <div class="header-content">Cập nhật hỗ trợ trực tuyến</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/supportonline">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin hỗ trợ trực tuyến</a>
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
                                    <?php echo form_error('supportTitle'); ?>
                                    <input name="supportTitle" type="text" value="" id="supportTitle" style="width:400px;">
                                    <span class="tooltip">
                                        <span class="tooltipContent">
                                            <p class="tooltiptitle">
                                                Tiêu đề
                                            </p>
                                            <p class="tooltipmessage">
                                                Tiêu đề hiển thị của người hỗ trợ
                                            </p>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="key">
                                    &nbsp;Họ và tên
                                </td>
                                <td>
                                    <input name="supportName" type="text" value="" id="supportName" style="width:400px;">
                                    <span class="tooltip">
                                        <span class="tooltipContent">
                                            <p class="tooltiptitle">
                                                Họ tên
                                            </p>
                                            <p class="tooltipmessage">
                                                Họ tên hiển thị của người hỗ trợ
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
                                    <?php echo form_error('supportPhone'); ?>
                                    <input name="supportPhone" type="text" value="" id="supportPhone" style="width:400px;">
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
                                <td class="key"><span class="Required">*</span>
                                    &nbsp;Email
                                </td>
                                <td>
                                    <?php echo form_error('supportEmail'); ?>
                                    <input name="supportEmail" type="text" value="" id="supportEmail" style="width:400px;">
                                    <span class="tooltip"><span class="tooltipContent">
                                        <p class="tooltiptitle">
                                            Email</p>
                                        <p class="tooltipmessage">
                                            Email của người hỗ trợ
                                        </p>
                                    </span></span>
                                </td>
                            </tr>

                            <tr>
                                <td class="key">
                                    &nbsp;Skype
                                </td>
                                <td>
                                    <input name="supportSkype" type="text" value="" id="supportSkype" style="width:400px;">
                                    <span class="tooltip"><span class="tooltipContent">
                                        <p class="tooltiptitle">
                                            Skype</p>
                                        <p class="tooltipmessage">
                                            Skype của người hỗ trợ
                                        </p>
                                    </span></span>
                                </td>
                            </tr>

                            <tr>
                                <td class="key">
                                    &nbsp;Yahoo
                                </td>
                                <td>
                                    <input name="supportYahoo" type="text" value="" id="supportYahoo" style="width:400px;">
                                    <span class="tooltip"><span class="tooltipContent">
                                        <p class="tooltiptitle">
                                            Yahoo</p>
                                        <p class="tooltipmessage">
                                            Yahoo của người hỗ trợ
                                        </p>
                                    </span></span>
                                </td>
                            </tr>

                            <tr>
                                <td class="key">Hiển thị</td>
                                <td>
                                    <select name="supportPublish" id="supportPublish">
                                        <option selected="selected" value="1">Có</option>
                                        <option value="0">Không</option>
                                    </select>
                                    <span class="tooltip">
                                        <span class="tooltipContent">
                                            <p class="tooltiptitle">Hiển thị thông tin hỗ trợ</p>
                                            <p class="tooltipmessage">Lựa chọn để hiển thị thông tin hỗ trợ ngoài website.</p>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="key">Thứ tự hiển thị</td>
                                <td>
                                    <input name="supportOrders" type="text" value="" id="supportOrders" style="width:40px;">    
                                    <span class="tooltip">
                                        <span class="tooltipContent">
                                            <p class="tooltiptitle">Thứ tự hiển thị support</p>
                                            <p class="tooltipmessage">Thứ tự hiển thị của support</p>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/supportonline">Quay lại danh sách</a></span>
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
        $("form").submit();
    }

    //$.jQuery(document).ready(function($) {
    $('#form-add').submit(function() {
        $(".error").remove();
        var idElementError = "";
        var hasError = false;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        var supportTitle = $("#supportTitle").val();
        if(supportTitle == '') {
            $("#supportTitle").before('<span class="error Required  ">Tiêu đề không được trống</span>');
            hasError = true;
            if (idElementError == "") idElementError = "supportTitle";
        }

        var supportPhone = $("#supportPhone").val();
        if(supportPhone == '') {
            $("#supportPhone").before('<span class="error Required  ">Số điện thoại không được trống</span>');
            hasError = true;
            if (idElementError == "") idElementError = "supportPhone";
        }

        var supportEmail = $("#supportEmail").val();
        if(supportEmail == '') {
            $("#supportEmail").before('<div class="error Required">Email không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "supportEmail";
        }else if(!emailReg.test(supportEmail)) { 
            $("#supportEmail").before('<div class="error Required">Email không đúng định dạng (Ex:sample@yah.com)</div>');
            hasError = true;
            if (idElementError == "") idElementError = "supportEmail";
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