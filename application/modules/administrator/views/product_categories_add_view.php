<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới danh mục sản phẩm</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/categories/product">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
            
            <span><a href="<?= base_url()?>administrator/categories/product/add">Thêm mới</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
                </li>
                <!-- <li>
                    <a href="#tabs-4">Cấu hình tìm kiếm</a>
                </li> -->
                <li>
                    <a href="#tabs-2">Thông tin khác</a>
                </li>
                <li>
                    <a href="#tabs-3">Cấu hình SEO</a>
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
                                <input name="cateTitle" type="text" value="<?php echo set_value('cateTitle'); ?>" maxlength="500" id="cateTitle" class="TextInput" style="width:400px;" onchange="checkTitle(this);">    
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
                                <input name="cateTitle_en" type="text" value="<?php echo set_value('cateTitle_en'); ?>" maxlength="500" id="cateTitle" class="TextInput" style="width:400px;">    
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
                                <input name="cateTitle_fr" type="text" value="<?php echo set_value('cateTitle_fr'); ?>" maxlength="500" id="cateTitle" class="TextInput" style="width:400px;">    
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
                                        <option value="<?= $key['CategoriesProductsID']?>"><?= $key['Title']?></option>
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

                        <!-- <tr>
                            <td class="key">Danh sách Keyword</td>
                            <td>
                                <ul id="Keywords"></ul>
                            </td>
                        </tr> -->
                        <!--
                        <script type="text/javascript">
                            $("#Keywords").tagit({fieldName:"cateKeywords",allowSpaces:true,singleField:true});
                        </script>
                        -->

                        <!-- <tr>
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
                                                <img id="img_upload" src="">
                                                <input type="hidden" name="cateImagesURL" id="ImagesURL" value="">
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
                        </tr> -->

                        <!-- <tr>
                            <td class="key">Mô tả</td>
                            <td>
                                <textarea name="cateDescription"></textarea>
                                <script>
                                    CKEDITOR.replace( 'cateDescription');
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Nội dung</td>
                            <td>
                                <textarea name="cateBody"></textarea>
                                <script>
                                    CKEDITOR.replace( 'cateBody');
                                </script>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <!-- <div id="tabs-4">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td class="key">Khung giá</td>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td width="45%">
                                            <select style="width:100%;height:184px;" name="from2" id="undo_redo2" multiple="multiple">
                                            <?php foreach ($sortingprice as $sp) { ?>
                                                <option value="<?= $sp['SortingPriceID'] ?>"><?= $sp['Title'] ?></option>
                                            <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td width="10%">
                                            <button type="button" class="button_sort" id="undo_redo2_undo">undo</button>
                                            <button type="button" class="button_sort" id="undo_redo2_rightAll">&gt;&gt;</button>
                                            <button type="button" class="button_sort" id="undo_redo2_rightSelected">&gt;</button>
                                            <button type="button" class="button_sort" id="undo_redo2_leftSelected">&lt;</button>
                                            <button type="button" class="button_sort" id="undo_redo2_leftAll">&lt;&lt;</button>
                                            <button type="button" class="button_sort" id="undo_redo2_redo">redo</button>
                                        </td>
                                        
                                        <td width="45%">
                                            <select style="width:100%;height:184px;" name="cateSortingPrice[]" id="undo_redo2_to" multiple="multiple"></select>
                                        </td>
                                    </tr>
                                </table>
                                <script>
                                    $('#undo_redo2').multiselect({keepRenderingSort:true});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Thương hiệu</td>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td width="45%">
                                            <select style="width:100%;height:184px;" name="from" id="undo_redo" multiple="multiple">
                                            <?php foreach ($sortingbrand as $br) { ?>
                                                <option value="<?= $br['SortingBrandID'] ?>"><?= $br['Title'] ?></option>
                                            <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td width="10%">
                                            <button type="button" class="button_sort" id="undo_redo_undo">undo</button>
                                            <button type="button" class="button_sort" id="undo_redo_rightAll">&gt;&gt;</button>
                                            <button type="button" class="button_sort" id="undo_redo_rightSelected">&gt;</button>
                                            <button type="button" class="button_sort" id="undo_redo_leftSelected">&lt;</button>
                                            <button type="button" class="button_sort" id="undo_redo_leftAll">&lt;&lt;</button>
                                            <button type="button" class="button_sort" id="undo_redo_redo">redo</button>
                                        </td>
                                        
                                        <td width="45%">
                                            <select style="width:100%;height:184px;" name="cateSortingBrand[]" id="undo_redo_to" multiple="multiple"></select>
                                        </td>
                                    </tr>
                                </table>
                                <script>
                                    $('#undo_redo').multiselect({keepRenderingSort:true});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Độ phân giải
                            <span class="recommend-res"> (Nếu là camera)</span>
                            </td>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td width="45%">
                                            <select style="width:100%;height:184px;" name="from3" id="undo_redo3" multiple="multiple">
                                            <?php foreach ($sortingres as $sr) { ?>
                                                <option value="<?= $sr['SortingResID'] ?>"><?= $sr['Title'] ?></option>
                                            <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td width="10%">
                                            <button type="button" class="button_sort" id="undo_redo3_undo">undo</button>
                                            <button type="button" class="button_sort" id="undo_redo3_rightAll">&gt;&gt;</button>
                                            <button type="button" class="button_sort" id="undo_redo3_rightSelected">&gt;</button>
                                            <button type="button" class="button_sort" id="undo_redo3_leftSelected">&lt;</button>
                                            <button type="button" class="button_sort" id="undo_redo3_leftAll">&lt;&lt;</button>
                                            <button type="button" class="button_sort" id="undo_redo3_redo">redo</button>
                                        </td>
                                        
                                        <td width="45%">
                                            <select style="width:100%;height:184px;" name="cateSortingRes[]" id="undo_redo3_to" multiple="multiple"></select>
                                        </td>
                                    </tr>
                                </table>
                                <script>
                                    $('#undo_redo3').multiselect({keepRenderingSort:true});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Số kênh
                            <span class="recommend-res"> (Nếu là đầu ghi)</span>
                            </td>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td width="45%">
                                            <select style="width:100%;height:184px;" name="from4" id="undo_redo4" multiple="multiple">
                                            <?php foreach ($sortingchannel as $sc) { ?>
                                                <option value="<?= $sc['SortingResID'] ?>"><?= $sc['Title'] ?></option>
                                            <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td width="10%">
                                            <button type="button" class="button_sort" id="undo_redo4_undo">undo</button>
                                            <button type="button" class="button_sort" id="undo_redo4_rightAll">&gt;&gt;</button>
                                            <button type="button" class="button_sort" id="undo_redo4_rightSelected">&gt;</button>
                                            <button type="button" class="button_sort" id="undo_redo4_leftSelected">&lt;</button>
                                            <button type="button" class="button_sort" id="undo_redo4_leftAll">&lt;&lt;</button>
                                            <button type="button" class="button_sort" id="undo_redo4_redo">redo</button>
                                        </td>
                                        
                                        <td width="45%">
                                            <select style="width:100%;height:184px;" name="cateSortingChannel[]" id="undo_redo4_to" multiple="multiple"></select>
                                        </td>
                                    </tr>
                                </table>
                                <script>
                                    $('#undo_redo4').multiselect({keepRenderingSort:true});
                                </script>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
            <div id="tabs-2">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>

                        <tr>
                            <td class="key">Tiêu biểu</td>
                            <td>
                                <input id="cateIsTop" type="checkbox" name="cateIsTop" >
                                <label for="cateIsTop">Tiêu biểu</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tabs-3" >
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
                                <input name="catePageTitle" type="text" maxlength="500" id="txtPageTitle" value="" style="width:400px;">
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
                                <input name="cateMetaKeywords" type="text" id="txtMetaKeywords" value="" style="width:400px;">
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
                                <textarea name="cateMetaDesc" id="txtMetaDesc" rows="5" style="width:400px;"></textarea>
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
            <span><a href="<?= base_url()?>administrator/categories/product">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
            
            <span><a href="<?= base_url()?>administrator/categories/product/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

    function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_products_categories_ajaxhandler/imageUpload",
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
                        if(action == 'delete') {
                            delete_image(id);
                            $('body').css('overflow','auto');
                        }
                        else if(action == 'save') {
                            submitform();
                            $('body').css('overflow','auto');
                        }
                        else if(action == 'create') {
                            create_album_category_menu();
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
            url: "<?= base_url()?>ajaxhandle/admin_products_categories_ajaxhandler/Check_Title",
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