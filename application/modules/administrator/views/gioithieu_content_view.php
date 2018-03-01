<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content"><?php echo $title;?></div>
        <div class="clear"></div>
        <div class="command">
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin</a>
                </li>
            </ul>
            <div id="tabs-1">
                <table class="admintable"  width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>

                        <tr>
                            <td class="key" valign="top"><span class="Required">*</span>
                                &nbsp;Nội dung giới thiệu
                            </td>
                            <td>
                                <?php echo form_error('Gioithieu'); ?>
                                <textarea name="Gioithieu" rows="2" cols="20" id="Gioithieu" class="TextInput" style="height:96px;width:400px;"><?= $gioithieu['Gioithieu']?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" valign="top"><span class="Required">*</span>
                                &nbsp;Nội dung giới thiệu tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('Gioithieu_en'); ?>
                                <textarea name="Gioithieu_en" rows="2" cols="20" id="Gioithieu_en" class="TextInput" style="height:96px;width:400px;"><?= $gioithieu['Gioithieu_en']?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Frame Video ( kích thước chuẩn là 308x173 )
                            </td>
                            <td>
                                <?php echo form_error('LinkVideoGioithieu'); ?>
                                <textarea name="LinkVideoGioithieu" rows="2" cols="20" id="LinkVideoGioithieu" class="TextInput" style="height:96px;width:400px;"><?= $gioithieu['LinkVideoGioithieu']?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Link chi tiết
                            </td>
                            <td>
                                <?php echo form_error('LinkDetailGioiThieu'); ?>
                                <input name="LinkDetailGioiThieu" type="text" value="<?= $gioithieu['LinkDetailGioiThieu']?>" id="LinkDetailGioiThieu" style="width:400px;">
                            </td>
                        </tr>

                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="command">
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

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
                        }else if(action == 'uploadimg') {
                            upload_images();
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

//]]>
</script>
<script type="text/javascript">
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

        // var img_upload = $("#img_upload").attr("src");
        // if(img_upload == '') {
        //     $("#img_upload").before('<div class="error Required">Ảnh banner không được trống</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "img_upload";
        // }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
</script>