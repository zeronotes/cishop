<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Chỉnh sửa FavIcon</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/favicons">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
            
            <span><a href="<?= base_url()?>administrator/favicons/add">Thêm mới</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Favicon</a>
                </li>
                <li>
                    <a href="#tabs-2">Thông tin khác</a>
                </li>
            </ul>
            <div id="tabs-1">
                <table class="admintable"  width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        
                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Icon (32x32)</td>
                            <td>

                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php echo form_error('IconURL'); ?>
                                                <img id="img_upload" src="<?= base_url()?>resources/uploads/images/automatic/thumbs/<?= $favicons['IconURL']?>">
                                                <input type="hidden" name="IconURL" id="ImageURL" value="<?= $favicons['IconURL']?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="userfile" id="userfile" size="20" />
                                                <a onclick="showconfirm('','Xác thực Upload ảnh','Bạn muốn upload hình ảnh này?','uploadimg');" class="linkbtn">Upload</a>    
                                                <span class="tooltip">
                                                    <span class="tooltipContent">
                                                        <p class="tooltiptitle">Ảnh</p>
                                                        <p class="tooltipmessage">Ảnh sẽ làm icon trên tab của trình duyệt
                                                               <br/> Kích thước tối đa 32x32
                                                            </p>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tabs-2">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        
                        <tr>
                            <td class="key">Người khởi tạo</td>
                            <td><span class="lbl-key"><?php if($favicons['CreatedBy'] =='') echo '<span class="lbl-key-nan">Không xác định</span>'; else echo '<span class="lbl-key">'.$favicons['CreatedBy'].'</span>';?></span>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Người khởi tạo</p>
                                        <p class="tooltipmessage">Tên tài khoản của người đã tạo ra tin tức này</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Ngày khởi tạo</td>
                            <td><span class="lbl-key"><?= $favicons['CreatedDate']?></span>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Ngày khởi tạo</p>
                                        <p class="tooltipmessage">Ngày giờ danh mục được khởi tạo</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Người đã chỉnh sửa</td>
                            <td><?php if($favicons['ModifiedBy'] =='') echo '<span class="lbl-key">Không xác định</span>'; else echo '<span class="lbl-key">'.$favicons['ModifiedBy'].'</span>';?>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Người chỉnh sửa</p>
                                        <p class="tooltipmessage">Tên tài khoản của người đã chỉnh sửa tin tức này</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Ngày chỉnh sửa</td>
                            <td><?php if($favicons['ModifiedDate'] =='') echo '<span class="lbl-key-nan">Chưa từng sửa</span>'; else echo '<span class="lbl-key">'.$favicons['ModifiedDate'].'</span>';?>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Ngày chỉnh sửa</p>
                                        <p class="tooltipmessage">Ngày giờ dah mục được chỉnh sửa</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/favicons">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
            
            <span><a href="<?= base_url()?>administrator/favicons/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

    function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_ajaxhandler/Favicons_upload_image",
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

        var img_upload = $("#img_upload").attr("src");
        if(img_upload == '') {
            $("#img_upload").before('<div class="error Required">Icon không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "img_upload";
        }

        
        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);
        
        return false;
    });
</script>