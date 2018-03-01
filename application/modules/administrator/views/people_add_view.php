<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới nhân lực</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/people">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/people/add">Thêm mới</a></span>
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
                                &nbsp;Họ tên
                            </td>
                            <td>
                                <?php echo form_error('FullName'); ?>
                                <input name="FullName" type="text" value="" maxlength="500" id="bannerTitle" class="TextInput">

                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Họ tên tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('FullName_en'); ?>
                                <input name="FullName_en" type="text" value="" maxlength="500" id="bannerTitle_en" class="TextInput">

                            </td>
                        </tr>

                        <tr>
                            <td class="key">Thuộc</td>
                            <td>
                                <select name="tabs_nhansu" id="tabs_nhansu" class="TextInput">
                                    <?php foreach ($tabs as $key) :?>
                                        <option value="<?= $key['Id']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Vị trí
                            </td>
                            <td>
                                <?php echo form_error('Position'); ?>
                                <input name="Position" type="text" value="" maxlength="500" id="Position" class="TextInput">

                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Vị trí tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('Position_en'); ?>
                                <input name="Position_en" type="text" value="" maxlength="500" id="Position_en" class="TextInput">

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
                                                <?php echo form_error('ImageURL'); ?>
                                                <img id="img_upload" src="">
                                                <input type="hidden" name="ImageURL" id="ImageURL" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="userfile" id="userfile" size="20" />
                                                <a onclick="showconfirm('','Xác thực Upload ảnh','Bạn muốn upload hình ảnh này?','uploadimg');" class="linkbtn">Upload</a>
                                                <span class="tooltip">
                                                    <span class="tooltipContent">
                                                        <p class="tooltiptitle">Ảnh</p>
                                                        <p class="tooltipmessage">Ảnh sẽ hiển thị ngoài website</p>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Ảnh chứa thông tin cá nhân
                            </td>
                            <td>
                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php echo form_error('ImgInformation'); ?>
                                                <img id="img_infor_upload" src="">
                                                <input type="hidden" name="ImgInformation" id="ImageURLinfor" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="userfile_infor" id="userfile_infor" size="20" />
                                                <a onclick="showconfirm('','Xác thực Upload ảnh','Bạn muốn upload hình ảnh này?','uploadimg_infor');" class="linkbtn">Upload</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Ảnh chứa thông tin cá nhân bằng tiếng Anh
                            </td>
                            <td>
                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php echo form_error('ImgInformation_en'); ?>
                                                <img id="img_infor_en_upload" src="">
                                                <input type="hidden" name="ImgInformation_en" id="ImageURLinfor_en" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="userfile_infor_en" id="userfile_infor_en" size="20" />
                                                <a onclick="showconfirm('','Xác thực Upload ảnh','Bạn muốn upload hình ảnh này?','uploadimg_infor_en');" class="linkbtn">Upload</a>
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
                                <input name="Orders" type="text" value="" id="bannerOrders" style="width:70px;">
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="Publish" id="bannerPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option value="0">Không</option>
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
            <span><a href="<?= base_url()?>administrator/people">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/people/add">Thêm mới</a></span>
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
            data        : {element_name:'userfile_infor'},
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
            data        : {element_name:'userfile_infor_en'},
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

        var Position = $("#Position").val();
        if(Position == '') {
            $("#Position").before('<div class="error Required">Vị trí không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "Position";
        }

        var Position_en = $("#Position_en").val();
        if(Position_en == '') {
            $("#Position_en").before('<div class="error Required">Vị trí tiếng Anh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "Position_en";
        }

        var img_upload = $("#img_upload").attr("src");
        if(img_upload == '') {
            $("#img_upload").before('<div class="error Required">Ảnh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "img_upload";
        }

        var img_infor_upload = $("#img_infor_upload").attr("src");
        if(img_infor_upload == '') {
            $("#img_infor_upload").before('<div class="error Required">Ảnh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "img_infor_upload";
        }

        var img_infor_en_upload = $("#img_infor_en_upload").attr("src");
        if(img_infor_en_upload == '') {
            $("#img_infor_en_upload").before('<div class="error Required">Ảnh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "img_infor_en_upload";
        }

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