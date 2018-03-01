<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới logo</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/logo">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
            
            <span><a href="<?= base_url()?>administrator/logo/add">Thêm mới</a></span>
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
                                <input name="Title" type="text" value="" maxlength="500" id="logoTitle" >
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tiêu đề tin</p>
                                        <p class="tooltipmessage">Nhập tiêu đề của tin tức</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Logo</td>
                            <td>

                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <!-- <img id="img_upload" src="<?= base_url()?>resources/uploads/images/thumbs/<?= $logo['ImageURL']?>"> -->
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
                                                        <p class="tooltiptitle">Logo</p>
                                                        <p class="tooltipmessage">Logo sẽ hiển thị ngoài website</p>
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
                                <span class="Required">*</span>
                                &nbsp;Mô tả
                            </td>
                            <td>
                                <?php echo form_error('logoDescription'); ?>
                                <textarea name="Description" rows="2" cols="20" id="logoDescription" style="height:96px;width:400px;"></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Mô tả</p>
                                        <p class="tooltipmessage">
                                            Mô tả logo sẽ hiện thị ngoài website
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <!-- 
                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="logoPublish" id="logoPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option <?php if(!$logo['Publish']) echo 'selected="selected"';?> value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị sản phẩm</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị sản phẩm ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr> -->
                        
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/logo">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
            
            <span><a href="<?= base_url()?>administrator/logo/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

    function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_ajaxhandler/Logo_Upload",
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
                        // if(action == 'delete' || action == 'update' || action == 'uploadimg') {
                        //     $('body').css('overflow','auto');
                        // }
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
        
        var logoTitle = $("#logoTitle").val();
        if(logoTitle == '') {
            $("#logoTitle").before('<div class="error Required">Tiêu đề logo không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "logoTitle";
        }

        var img_upload = $("#img_upload").attr("src");
        if(img_upload == '') {
            $("#img_upload").before('<div class="error Required">Logo không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "img_upload";
        }
        
        var logoDescription = $("#logoDescription").val();
        if(logoDescription == '') {
            $("#logoDescription").before('<div class="error Required">Mô tả ngắn không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "logoDescription";
        }

        
        
        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);
        
        return false;
    });
</script>