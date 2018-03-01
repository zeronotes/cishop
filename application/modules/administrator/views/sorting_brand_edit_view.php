<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Chỉnh sửa thương hiệu</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/sorting/brand">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/sorting/brand/add">Thêm mới</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
                </li>
                <li>
                    <a href="#tabs-2">Thông tin khác</a>
                </li>
                <!-- <li>
                    <a href="#tabs-3">Cấu hình SEO</a>
                </li> -->
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
                                <input type="hidden" value="<?= $category['SortingBrandID']?>" id="cateID">
                                <?php echo form_error('cateTitle'); ?>
                                <input name="cateTitle" type="text" value="<?= $category['Title']?><?php echo set_value('cateTitle'); ?>" maxlength="500" id="cateTitle" class="TextInput" style="width:400px;" onchange="checkTitle(this);">
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
                                <input name="cateTitle_en" type="text" value="<?= $category['Title_en']?><?php echo set_value('cateTitle_en'); ?>" maxlength="500" id="cateTitle_en" class="TextInput" style="width:400px;">
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
                                <input name="cateTitle_fr" type="text" value="<?= $category['Title_fr']?><?php echo set_value('cateTitle_fr'); ?>" maxlength="500" id="cateTitle_fr" class="TextInput" style="width:400px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tên danh mục</p>
                                        <p class="tooltipmessage">Nhập tên của danh mục</p>
                                    </span>
                                </span>
                            </td>
                        </tr> -->

                        <!-- <tr>
                            <td class="key">
                                &nbsp;Danh mục cha
                            </td>
                            <td>
                                <select size="10" name="cateParentID" id="cateParentID" style="width:400px;">
                                    <option <?php if($category['ParentID'] == 0) echo 'selected';?> value="0">Gốc</option>
                                    <?php foreach ($parentcategories as $key) :?>
                                        <option <?php if($category['ParentID'] == $key['SortingBrandID']) echo 'selected';?> value="<?= $key['SortingBrandID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Danh mục cha</p>
                                        <p class="tooltipmessage">Lưa chọn danh mục cha</p>
                                    </span>
                                </span>
                            </td>
                        </tr> -->

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="catePublish" id="catePublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option <?php if(!$category['Publish']) echo 'selected="selected"';?> value="0">Không</option>
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
                            <td class="key">Thứ tự hiển thị</td>
                            <td>
                                <input name="cateOrders" type="text" value="<?= $category['Orders']?>" id="cateOrders" style="width:40px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thứ tự hiển thị danh mục</p>
                                        <p class="tooltipmessage">Thứ tự hiển thị của danh mục</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Ảnh đại diện
                                <span class="recommend-res">(Kích thước khuyến nghị ...)</span>
                            </td>
                            <td>
                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img id="img_upload" src="<?= base_url()?>resources/uploads/images/automatic/thumbs/<?= $category['ImagesURL']?>">
                                                <input type="hidden" name="cateImagesURL" id="ImagesURL" value="<?= $category['ImagesURL']?>">
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
                            <td class="key">Mô tả</td>
                            <td>
                                <textarea rows="2" cols="20" style="height:96px;width:400px;" name="cateDescription"><?= $category['Description']?></textarea>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="key">Nội dung</td>
                            <td>
                                <textarea name="cateBody"><?= $category['Body']?></textarea>
                                <script>
                                    CKEDITOR.replace( 'cateBody',
                                        {
                                            language: 'vi',
                                        }
                                    );
                                </script>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <div id="tabs-2">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <!-- <tr>
                            <td class="key">Tùy chọn</td>
                            <td>
                                <input id="cateIsTop" type="checkbox" <?php if($category['IsTop'] == 1) echo "checked";?> name="cateIsTop" >
                                <label for="cateIsTop">Tiêu biểu</label>
                            </td>
                        </tr> -->

                        <tr>
                            <td class="key">Người khởi tạo</td>
                            <td><span class="lbl-key"><?php if($category['CreatedBy'] =='') echo '<span class="lbl-key-nan">Không xác định</span>'; else echo '<span class="lbl-key">'.$category['CreatedBy'].'</span>';?></span>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Người khởi tạo</p>
                                        <p class="tooltipmessage">Tên tài khoản của người đã tạo ra danh mục này</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Ngày khởi tạo</td>
                            <td><span class="lbl-key"><?= $category['CreatedDate']?></span>
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
                            <td><?php if($category['ModifiedBy'] =='') echo '<span class="lbl-key">Không xác định</span>'; else echo '<span class="lbl-key">'.$category['ModifiedBy'].'</span>';?>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Người chỉnh sửa</p>
                                        <p class="tooltipmessage">Tên tài khoản của người đã chỉnh sửa danh mục này</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Ngày chỉnh sửa</td>
                            <td><?php if($category['ModifiedDate'] =='') echo '<span class="lbl-key-nan">Chưa từng sửa</span>'; else echo '<span class="lbl-key">'.$category['ModifiedDate'].'</span>';?>
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
            <!-- <div id="tabs-3" >
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
                                <input name="catePageTitle" type="text" maxlength="500" id="txtPageTitle" value="<?= $category['SEOTitle']?>" style="width:400px;">
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
                                <input name="cateMetaKeywords" type="text" id="txtMetaKeywords" value="<?= $category['SEOKeyword']?>" style="width:400px;">
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
                                <textarea name="cateMetaDesc" id="txtMetaDesc" rows="5" style="width:400px;"><?= $category['SEODescription']?></textarea>
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
            </div> -->
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/sorting/brand">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/sorting/brand/add">Thêm mới</a></span>
        </div>
    </form>
</div>

<script type="text/javascript">
 //<![CDATA[

    function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/sorting_brand_ajaxhandler/imageUpload",
            secureuri      :false,
            fileElementId  :'userfile',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.msg == "" && data.imgname != "") {
                    $('#img_upload').attr('src',data.url);
                    $('#ImagesURL').attr('value',data.imgname);
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
        var id = $("#cateID").val();
        var title = $("#cateTitle").val();
        $.ajax({
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/sorting_brand_ajaxhandler/Check_Title_Except",
            data: { id: id, title: title},
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