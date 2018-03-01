<div class="grid_12">
    <form method="post" action="<?= current_url();?>/save" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thôn tin footer - liên hệ</div>
        <div class="clear"></div>
        <div class="command">
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin footer</a>
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
                                &nbsp;Nội dung
                            </td>
                            <td>
                                <?php echo form_error('footerBody'); ?>
                                <textarea name="footerBody" id="footerBody"><?= $footer['Footer']?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('footerBody',
                                            {
                                                language: 'vi',
                                                height: 300,
                                            }
                                        );
                                    });
                                </script>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Nội dung liên hệ
                            </td>
                            <td>
                                <?php echo form_error('contactText'); ?>
                                <textarea name="contactText" id="contactText"><?= $footer['ContactText']?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('contactText',
                                            {
                                                language: 'vi',
                                                height: 300,
                                            }
                                        );
                                    });
                                </script>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Email
                            </td>
                            <td>
                                <input name="footerEmail" type="text" value="<?= $footer['EmailForm']?>" id="footerEmail" style="width:400px;">
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Email</p>
                                    <p class="tooltipmessage">
                                        Email chủ sở hữu site
                                    </p>
                                </span></span>
                            </td>
                        </tr>

                    </tbody></table>
                </div>
            </div>
        </div>
        <div class="command">
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

    function scrollToError(yeah) {
        $('html, body').animate({scrollTop:$('#'+yeah).offset().top - 50}, 'slow');
    }

    $('form').submit(function() {
        return true;
    });
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

        var footerBody = CKEDITOR.instances.footerBody.getData();
        if(footerBody == '') {
            $("#footerBody").before('<span class="error Required  ">Nội dung footer không được trống</span>');
            hasError = true;
            if (idElementError == "") idElementError = "footerBody";
        }

        var prdTitle = $("#footerEmail").val();
        if(prdTitle == '') {
            $("#footerEmail").before('<div class="error Required">Email không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "footerEmail";
        }else if(!emailReg.test(prdTitle)) {
            $("#footerEmail").before('<div class="error Required">Email không đúng định dạng (Ex:sample@yah.com)</div>');
            hasError = true;
            if (idElementError == "") idElementError = "footerEmail";
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