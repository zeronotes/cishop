<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới banner trang chủ</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/banners">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/banners/add">Thêm mới</a></span>
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
                                <input name="Title" type="text" value="" maxlength="500" id="bannerTitle" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tiêu đề</p>
                                        <p class="tooltipmessage">Nhập tiêu đề của banner</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                &nbsp;Link
                            </td>
                            <td>
                                <?php echo form_error('Link'); ?>
                                <input name="Link" type="text" value="" maxlength="500" id="Link" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Ảnh
                                <span class="recommend-res">(Kích thước đề nghị 815x230 px)</span>
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
                            <td class="key" valign="top">
                                Mô tả
                            </td>
                            <td>
                                <?php echo form_error('Body'); ?>
                                <textarea name="Body" rows="2" cols="20" id="bannerDescription" style="height:96px;width:400px;"></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Mô tả</p>
                                        <p class="tooltipmessage">
                                            Mô tả banner
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Thứ tự</td>
                            <td>
                                <?php echo form_error('Orders'); ?>
                                <input name="Orders" type="text" value="" id="bannerOrders" style="width:70px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thứ tự</p>
                                        <p class="tooltipmessage">
                                            Thứ tự hiển thị banner ngoài website
                                        </p>
                                    </span>
                                </span>

                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="Publish" id="bannerPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị Banner ngoài website.</p>
                                    </span>
                                </span>
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
            <span><a href="<?= base_url()?>administrator/banners">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/banners/add">Thêm mới</a></span>
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

        var Title = $("#bannerTitle").val();
        if(Title == '') {
            $("#bannerTitle").before('<div class="error Required">Tiêu đề không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "bannerTitle";
        }

        var img_upload = $("#img_upload").attr("src");
        if(img_upload == '') {
            $("#img_upload").before('<div class="error Required">Ảnh banner không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "img_upload";
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