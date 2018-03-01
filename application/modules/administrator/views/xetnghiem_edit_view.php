<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Chỉnh sửa thông tin xét nghiệm</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/xetnghiem">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/xetnghiem/add">Thêm mới</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
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
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Mã xét nghiệm
                            </td>
                            <td>
                                <?php echo form_error('ma_xet_nghiem'); ?>
                                <input name="ma_xet_nghiem" type="text" value="<?= $xetnghiem['ma_xet_nghiem']?>" maxlength="500" id="ma_xet_nghiem" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Họ tên
                            </td>
                            <td>
                                <?php echo form_error('ho_ten'); ?>
                                <input name="ho_ten" type="text" value="<?= $xetnghiem['ho_ten']?>" maxlength="500" id="ho_ten" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Ảnh đại diện</td>
                            <td>
                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img id="img_upload" src="<?= base_url()?>resources/uploads/images/thumbs/<?= $xetnghiem['anh_xet_nghiem']?>">
                                                <input type="hidden" name="anh_xet_nghiem" id="anh_xet_nghiem" value="<?= $xetnghiem['anh_xet_nghiem']?>">
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
                            <td class="key" style="width: 150px;">
                                &nbsp;Địa chỉ
                            </td>
                            <td>
                                <?php echo form_error('dia_chi'); ?>
                                <input name="dia_chi" type="text" value="<?= $xetnghiem['dia_chi']?>" maxlength="500" id="dia_chi" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                &nbsp;Điện thoại
                            </td>
                            <td>
                                <?php echo form_error('so_dien_thoai'); ?>
                                <input name="so_dien_thoai" type="text" value="<?= $xetnghiem['so_dien_thoai']?>" maxlength="500" id="so_dien_thoai" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                &nbsp;Email
                            </td>
                            <td>
                                <?php echo form_error('email'); ?>
                                <input name="email" type="text" value="<?= $xetnghiem['email']?>" maxlength="500" id="email" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;File tài liệu tiếng Anh<br>
                                <span>(doc,docx,xls,xlsx,txt,pdf)</span>
                            </td>
                            <td>
                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php echo form_error('attachment_file'); ?>
                                                <a id="link_upload_en" target="_blank" href="<?php if(isset($xetnghiem['attachment_file']) && $xetnghiem['attachment_file'] != '') echo base_url().'resources/uploads/files/'.$xetnghiem['attachment_file']; ?>">Tải</a>
                                                <input type="hidden" name="attachment_file" id="attachment_file" value="<?= $xetnghiem['attachment_file']?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="userfile_en" id="userfile_en" size="20" />
                                                <a onclick="showconfirm('','Xác thực Upload','Bạn muốn upload file này?','upload_file_en');" class="linkbtn">Upload</a>

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
                            <td><span class="lbl-key"><?php if($xetnghiem['CreatedBy'] =='') echo '<span class="lbl-key-nan">Không xác định</span>'; else echo '<span class="lbl-key">'.$xetnghiem['CreatedBy'].'</span>';?></span>
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
                            <td><span class="lbl-key"><?= $xetnghiem['CreatedDate']?></span>
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
                            <td><?php if($xetnghiem['ModifiedBy'] =='') echo '<span class="lbl-key">Không xác định</span>'; else echo '<span class="lbl-key">'.$xetnghiem['ModifiedBy'].'</span>';?>
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
                            <td><?php if($xetnghiem['ModifiedDate'] =='') echo '<span class="lbl-key-nan">Chưa từng sửa</span>'; else echo '<span class="lbl-key">'.$xetnghiem['ModifiedDate'].'</span>';?>
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
            <span><a href="<?= base_url()?>administrator/xetnghiem">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/xetnghiem/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

    function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_xetnghiem_ajaxhandler/imageUpload",
            secureuri      :false,
            fileElementId  :'userfile',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.msg == "" && data.imgname != "") {
                    $('#img_upload').attr('src',data.url);
                    $('#anh_xet_nghiem').attr('value',data.imgname);
                }
                else if(data.msg != "")
                    notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
         });
   }

   function upload_file_en() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_ajaxhandler/Upload_file/userfile_en",
            secureuri      :false,
            fileElementId  :'userfile_en',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.file_name != "") {
                    $('#link_upload_en').attr('href',data.url);
                    $('#attachment_file').attr('value',data.file_name);
                    notice(data.msg);
                }else
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
                        }else if(action == 'upload_file_en') {
                            upload_file_en();
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

        var ma_xet_nghiem = $("#ma_xet_nghiem").val();
        if(ma_xet_nghiem == '') {
            $("#ma_xet_nghiem").before('<div class="error Required">Mã xét nghiệm không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "ma_xet_nghiem";
        }

        var ho_ten = $("#ho_ten").val();
        if(ho_ten == '') {
            $("#ho_ten").before('<div class="error Required">Họ tên không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "ho_ten";
        }

        // var xetnghiemDescription = $("#xetnghiemDescription").val();
        // if(xetnghiemDescription == '') {
        //     $("#xetnghiemDescription").before('<div class="error Required">Mô tả ngắn không được trống</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "xetnghiemDescription";
        // }

        // var xetnghiemBody = CKEDITOR.instances.xetnghiemBody.getData();
        // if(xetnghiemBody == '') {
        //     $("#xetnghiemBody").before('<span class="error Required  ">Nội dung chi tiết không được trống</span>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "xetnghiemBody";
        // }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
</script>