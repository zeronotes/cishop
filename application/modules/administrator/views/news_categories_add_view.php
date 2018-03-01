<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới danh mục tin tức</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/categories/news">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/categories/news/add">Thêm mới</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
                </li>
                <li>
                    <a href="#tabs-2">Cấu hình SEO</a>
                </li>
            </ul>
            <div id="tabs-1">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tên danh mục
                            </td>
                            <td>
                                <?php echo form_error('cateTitle'); ?>
                                <input name="cateTitle" type="text" value="<?php echo set_value('cateTitle'); ?>" maxlength="500" id="cateTitle" class="TextInput" onchange="checkTitle(this);" style="width:400px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tên danh mục</p>
                                        <p class="tooltipmessage">Nhập tên của danh mục</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tên danh mục tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('cateTitle_en'); ?>
                                <input name="cateTitle_en" type="text" value="<?php echo set_value('cateTitle_en'); ?>" maxlength="500" id="cateTitle_en" class="TextInput" style="width:400px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tên danh mục</p>
                                        <p class="tooltipmessage">Nhập tên của danh mục</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tên danh mục tiếng Pháp
                            </td>
                            <td>
                                <?php echo form_error('cateTitle_fr'); ?>
                                <input name="cateTitle_fr" type="text" value="<?php echo set_value('cateTitle_fr'); ?>" maxlength="500" id="cateTitle_fr" class="TextInput" style="width:400px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tên danh mục</p>
                                        <p class="tooltipmessage">Nhập tên của danh mục</p>
                                    </span>
                                </span>
                            </td>
                        </tr> -->

                        <tr>
                            <td class="key">
                                &nbsp;Danh mục cha
                            </td>
                            <td>
                                <select size="10" name="cateParentID" id="cateParentID" style="width:400px;">
                                    <option value="0">Gốc</option>
                                    <?php foreach ($categories as $key) :?>
                                        <option value="<?= $key['CategoriesNewsID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Danh mục cha</p>
                                        <p class="tooltipmessage">Lưa chọn danh mục cha</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="catePublish" id="catePublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị danh mục</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị danh mục ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Ảnh
                                <span class="recommend-res">(Kích thước đề nghị 410 x 280 pixels)</span>
                            </td>
                            <td>
                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img id="img_upload" src="">
                                                <input type="hidden" name="Banner" id="newsMainImage" value="">
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
                                &nbsp;Thẻ Title của ảnh
                            </td>
                            <td>
                                <input name="cateImageTitle" type="text" value="" maxlength="500" id="cateImageTitle" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thẻ Title của ảnh</p>
                                        <p class="tooltipmessage">Nhập thẻ Title của ảnh</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                &nbsp;Thẻ Alt của ảnh
                            </td>
                            <td>
                                <input name="cateImageAlt" type="text" value="" maxlength="500" id="cateImageAlt" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thẻ Alt của ảnh</p>
                                        <p class="tooltipmessage">Nhập thẻ Alt của ảnh</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Thứ tự hiển thị</td>
                            <td>
                                <input name="cateOrders" type="text" value="" id="cateOrders" style="width:40px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thứ tự hiển thị danh mục</p>
                                        <p class="tooltipmessage">Thứ tự hiển thị của danh mục</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả</td>
                            <td>
                                <textarea name="cateDescription" rows="2" cols="20" id="newsDescription" class="TextInput" style="height:96px;width:400px;"></textarea>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="key">
                                &nbsp;Nội dung chi tiết
                            </td>
                            <td>
                                <textarea name="cateBody" id="cateBody"></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('cateBody',
                                            {
                                                language: 'vi'
                                            }
                                        );
                                    });
                                </script>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <div id="tabs-2" >
                <div id="Div1">
                    <table class="admintable" width="100%">
                        <tbody><tr>
                            <td style="height: 5px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                Tiêu đề trang
                            </td>
                            <td>
                                <input name="newsPageTitle" type="text" maxlength="500" id="txtPageTitle" style="width:400px;">
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Tiêu đề trang</p>
                                    <p class="tooltipmessage">
                                        Nội dung được hiển thị dưới dạng tiêu đề trong kết quả tìm kiếm và trên trình duyệt của người dùng.
                                    </p>
                                </span></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                Thẻ từ khóa
                            </td>
                            <td>
                                <input name="newsMetaKeywords" type="text" id="txtMetaKeywords" style="width:400px;">
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Thẻ từ khóa</p>
                                    <p class="tooltipmessage">
                                        Mô tả các từ khóa chính của website
                                    </p>
                                </span></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                Thẻ mô tả
                            </td>
                            <td>
                                <textarea name="newsMetaDesc" id="txtMetaDesc" rows="5" style="width:400px;"></textarea>
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Thẻ mô tả</p>
                                    <p class="tooltipmessage">
                                        Cung cấp một mô tả ngắn của trang. Trong vài trường hợp, mô tả này được sử dụng như một phần của đoạn trích được hiển thị trong kết quả tìm kiếm.
                                    </p>
                                </span></span>
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/categories/news">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/categories/news/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

 function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_news_categories_ajaxhandler/imageUpload",
            secureuri      :false,
            fileElementId  :'userfile',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.msg == "" && data.imgname != "") {
                    $('#img_upload').attr('src',data.url);
                    $('#newsMainImage').attr('value',data.imgname);
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
                        if(action == 'delete') {
                            delete_image(id);
                        }else if(action == 'save') {
                            submitform();
                        }else if(action == 'uploadimg') {
                            upload_images();
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

        var cateTitle = $("#cateTitle").val();
        if(cateTitle == '') {
            $("#cateTitle").before('<div class="error Required">Tên danh mục không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "cateTitle";
        }

        var cateOrders = $("#cateOrders").val();
        if(isNaN(cateOrders)) {
            $("#cateOrders").before('<span class="error Required  ">Thứ tự phải là các chữ số</span>');
            hasError = true;
            if (idElementError == "") idElementError = "cateOrders";
        }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });

    function checkTitle(element) {
        var title = $("#cateTitle").val();
        $.ajax({
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_news_categories_ajaxhandler/Check_Title",
            data: { title: title},
            dataType: "json",
            success: function(data) {
                if(data == 0) {
                    notice('Tiêu đề chưa tồn tại và có thể sử dụng.');
                }else if(data == 1) {
                    element.defaultValue = title;
                    notice('Tiêu đề đã tồn tại ! Vui lòng đổi lại tiêu đề khác.');
                }else {
                    notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }
</script>