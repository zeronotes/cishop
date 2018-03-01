<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thay đổi thông tin ý kiến khách hàng</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/testimonials">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin hỏi đáp</a>
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
                                &nbsp;Họ tên
                            </td>
                            <td>
                                <?php echo form_error('FullName'); ?>
                                <input name="FullName" type="text" value="<?= $testi['FullName']?>" id="FullName" style="width:400px;">
                            </td>
                        </tr>

                        <tr id="">
                            <td class="key">Nội dung</td>
                            <td>
                                <?php echo form_error('TestimonialContent'); ?>
                                <textarea cols="60" rows="5" name="TestimonialContent" id="TestimonialContent"><?= $testi['TestimonialContent']?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Thứ tự hiển thị</td>
                            <td>
                                <?php echo form_error('Orders'); ?>
                                <input name="Orders" type="text" value="<?= $testi['Orders']?>" id="Orders" style="width:40px;">
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="Publish" id="faqPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option <?php if($testi['Publish'] != 1) echo 'selected="selected"';?> value="0">Không</option>
                                </select>
                            </td>
                        </tr>

                    </tbody></table>
                </div>
            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/testimonials">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">

    var index = <?php if(isset($i)) echo $i; else echo '0';?>;
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
                        }
                        $('body').css('overflow','auto');
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

    function scrollToError(yeah) {
        $('html, body').animate({scrollTop:$('#'+yeah).offset().top - 50}, 'slow');
    }

    function submitform() {
        $("#form-edit").submit();
    }

    $('form').submit(function() {
        $(".error").remove();
        var idElementError = "";
        var hasError = false;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        var Orders = $("#Orders").val();
        if(isNaN(Orders)) {
            $("#Orders").before('<span class="error Required  ">Thứ tự phải là các chữ số</span>');
            hasError = true;
            if (idElementError == "") idElementError = "Orders";
        }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
</script>