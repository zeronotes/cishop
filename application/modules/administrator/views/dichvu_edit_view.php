<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thay đôi thông tin dịch vụ</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/dichvu">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/dichvu/add">Thêm mới</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
                </li>
            </ul>
            <div id="tabs-1">
                <table class="admintable"  width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tiêu đề
                            </td>
                            <td>
                                <?php echo form_error('Title'); ?>
                                <input name="Title" type="text" value="<?= $dichvu['Title']?>" maxlength="500" id="bannerTitle" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tiêu đề tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('Title_en'); ?>
                                <input name="Title_en" type="text" value="<?= $dichvu['Title_en']?>" maxlength="500" id="bannerTitle_en" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Link
                            </td>
                            <td>
                                <?php echo form_error('Link'); ?>
                                <input name="Link" type="text" value="<?= $dichvu['Link']?>" maxlength="500" id="Link" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Mô tả ngắn
                            </td>
                            <td>
                                <textarea name="Description" rows="2" cols="20" id="newsDescription" class="TextInput" style="height:96px;width:400px;"><?= $dichvu['Description']?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Mô tả ngắn tiếng Anh
                            </td>
                            <td>
                                <textarea name="Description_en" rows="2" cols="20" id="newsDescription_en" class="TextInput" style="height:96px;width:400px;"><?= $dichvu['Description_en']?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Ảnh
                            </td>
                            <td>
                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php echo form_error('ImageUrl'); ?>
                                                <img id="img_upload" src="<?= base_url()?>resources/uploads/images/thumbs/<?= $dichvu['ImageUrl']?>">
                                                <input type="hidden" name="ImageUrl" id="ImageURL" value="<?= $dichvu['ImageUrl']?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="userfile" id="userfile" size="20" />
                                                <a onclick="showconfirm('','Xác thực Upload ảnh','Bạn muốn upload hình ảnh này?','uploadimg');" class="linkbtn">Upload</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Thứ tự</td>
                            <td>
                                <?php echo form_error('Orders'); ?>
                                <input name="Orders" type="text" value="<?= $dichvu['Orders']?>" id="bannerOrders" style="width:70px;">
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="Publish" id="bannerPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option  <?php if($dichvu['Publish'] != 1) echo 'selected="selected"'?> value="0">Không</option>
                                </select>
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
            <span><a href="<?= base_url()?>administrator/dichvu">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/dichvu/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

    function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_ajaxhandler/Banner_upload_image",
            secureuri      :false,
            fileElementId  :'userfile',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.msg == "" && data.imgname != "") {
                    $('#img_upload').attr('src',data.url);
                    $('#ImageURL').attr('value',data.imgname);
                }
                else if(data.msg != "")
                    notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
         });
   }

   function upload_images_infor() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_ajaxhandler/Banner_upload_image/userfile_infor",
            secureuri      :false,
            fileElementId  :'userfile_infor',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.msg == "" && data.imgname != "") {
                    $('#img_infor_upload').attr('src',data.url);
                    $('#ImageURLinfor').attr('value',data.imgname);
                }
                else if(data.msg != "")
                    notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
         });
   }

   function upload_images_infor_en() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_ajaxhandler/Banner_upload_image/userfile_infor_en",
            secureuri      :false,
            fileElementId  :'userfile_infor_en',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.msg == "" && data.imgname != "") {
                    $('#img_infor_en_upload').attr('src',data.url);
                    $('#ImageURLinfor_en').attr('value',data.imgname);
                }
                else if(data.msg != "")
                    notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
         });
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
                        if(action == 'save') {
                            submitform();
                        }else if(action == 'uploadimg') {
                            upload_images();
                        }else if(action == 'uploadimg_infor'){
                            upload_images_infor();
                        }else if(action == 'uploadimg_infor_en'){
                            upload_images_infor_en();
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

        var Title = $("#bannerTitle").val();
        if(Title == '') {
            $("#bannerTitle").before('<div class="error Required">Họ tên không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "bannerTitle";
        }

        var Title_en = $("#bannerTitle_en").val();
        if(Title_en == '') {
            $("#bannerTitle_en").before('<div class="error Required">Họ tên tiếng Anh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "bannerTitle_en";
        }

        // var Position = $("#Position").val();
        // if(Position == '') {
        //     $("#Position").before('<div class="error Required">Vị trí không được trống</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "Position";
        // }

        // var Position_en = $("#Position_en").val();
        // if(Position_en == '') {
        //     $("#Position_en").before('<div class="error Required">Vị trí tiếng Anh không được trống</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "Position_en";
        // }

        var img_upload = $("#img_upload").attr("src");
        if(img_upload == '') {
            $("#img_upload").before('<div class="error Required">Ảnh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "img_upload";
        }

        // var img_infor_upload = $("#img_infor_upload").attr("src");
        // if(img_infor_upload == '') {
        //     $("#img_infor_upload").before('<div class="error Required">Ảnh không được trống</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "img_infor_upload";
        // }

        // var img_infor_en_upload = $("#img_infor_en_upload").attr("src");
        // if(img_infor_en_upload == '') {
        //     $("#img_infor_en_upload").before('<div class="error Required">Ảnh không được trống</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "img_infor_en_upload";
        // }

        var bannerOrders = $("#bannerOrders").val();
        if(isNaN(bannerOrders) || bannerOrders < 0) {
            $("#bannerOrders").before('<span class="error Required  ">Thứ tự phải là các chữ số và lớn hơn 0</span>');
            hasError = true;
            if (idElementError == "") idElementError = "bannerOrders";
        }


        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
</script>