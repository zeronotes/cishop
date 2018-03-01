<div class="grid_12">
    <form method="post" action="<?= current_url();?>/save" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content"><img src="<?= base_url()?>resources/ui_images/background/recruitments.png"/></div>
        <div class="clear"></div>
        <div class="command">
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin tuyển dụng</a>
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
                                <textarea name="recruitmentBody" id="recuitmentBody"><?php if(count($recruitment) > 0 ) echo $recruitment['Description'];?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('recuitmentBody',
                                            {
                                                language: 'vi',
                                                height: 300,
                                                filebrowserBrowseUrl: '<?= base_url();?>ckeditor/kcfinder/browse.php?type=files',
                                                filebrowserImageBrowseUrl: '<?= base_url();?>ckeditor/kcfinder/browse.php?type=images',
                                                filebrowserFlashBrowseUrl: '<?= base_url();?>ckeditor/kcfinder/browse.php?type=flash',
                                                filebrowserUploadUrl: '<?= base_url();?>ckeditor/kcfinder/upload.php?type=files',
                                                filebrowserImageUploadUrl: '<?= base_url();?>ckeditor/kcfinder/upload.php?type=images',
                                                filebrowserFlashUploadUrl: '<?= base_url();?>ckeditor/kcfinder/upload.php?type=flash'
                                            }
                                        );
                                    });
                                </script>
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

        var recuitmentBody = CKEDITOR.instances.recuitmentBody.getData();
        if(recuitmentBody == '') {
            $("#recuitmentBody").before('<span class="error Required  ">Nội dung footer không được trống</span>');
            hasError = true;
            if (idElementError == "") idElementError = "recuitmentBody";
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