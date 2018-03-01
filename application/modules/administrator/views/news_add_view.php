<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới tin tức</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/news">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/news/add">Thêm mới</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
                </li>
                <!-- <li>
                    <a href="#tabs-1-a">Thông tin tiếng Việt</a>
                </li>
                <li>
                    <a href="#tabs-1-b">Thông tin tiếng Anh</a>
                </li>
                <li>
                    <a href="#tabs-1-c">Thông tin tiếng Pháp</a>
                </li> -->
                <li>
                    <a href="#tabs-2">Thông tin khác</a>
                </li>
                <li>
                    <a href="#tabs-3">Cấu hình SEO</a>
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
                                <input name="newsTitle" type="text" value="" maxlength="500" id="newsTitle" class="TextInput" onchange="checkTitle(this);">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tiêu đề tin</p>
                                        <p class="tooltipmessage">Nhập tiêu đề của tin tức</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tiêu đề tiếng Anh
                            </td>
                            <td>
                                <input name="newsTitle_en" type="text" value="" maxlength="500" id="newsTitle_en" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tiêu đề tin</p>
                                        <p class="tooltipmessage">Nhập tiêu đề của tin tức</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tiêu đề tiếng Pháp
                            </td>
                            <td>
                                <input name="newsTitle_fr" type="text" value="" maxlength="500" id="newsTitle_fr" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tiêu đề tin</p>
                                        <p class="tooltipmessage">Nhập tiêu đề của tin tức</p>
                                    </span>
                                </span>
                            </td>
                        </tr> -->
                        <tr>
                            <td class="key">Thuộc danh mục</td>
                            <td>
                                <select name="newsCategoryID" id="newsCategoryID" class="TextInput">
                                    <?php foreach ($categoriesnews as $key) :?>
                                        <option value="<?= $key['CategoriesNewsID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Loại tin</p>
                                        <p class="tooltipmessage">Lựa chọn danh mục chứa tin tức</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Tin liên quan</td>
                            <td>
                                <select name="newsHightlight[]" multiple id="newsHightlight" class="TextInput" placeholder="Chọn các tin liên quan">
                                    <?php foreach ($hightlightnews as $key) :?>
                                        <option value="<?= $key['NewsID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tin liên quan</p>
                                        <p class="tooltipmessage">Những tin liên quan</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Danh sách tag</td>
                            <td>
                                <select name="newsTags[]" multiple id="newsTags" class="TextInput" placeholder="Chọn các tag">
                                    <?php foreach ($tags as $key) :?>
                                        <option value="<?= $key['TagsID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Danh sách tag</p>
                                        <p class="tooltipmessage">Danh sách tag</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Ảnh chính
                                <span class="recommend-res">(Kích thước đề nghị 330 x 220 pixels)</span>
                            <td>
                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img id="img_upload" src="">
                                                <input type="hidden" name="newsMainImage" id="newsMainImage" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="userfile" id="userfile" size="20" />
                                                <a onclick="showconfirm('','Xác thực Upload ảnh','Bạn muốn upload hình ảnh này?','uploadimg');" class="linkbtn">Upload</a>
                                                <span class="tooltip">
                                                    <span class="tooltipContent">
                                                        <p class="tooltiptitle">Ảnh chính</p>
                                                        <p class="tooltipmessage">Ảnh chính của tin tức, hiển thị cùng với tiêu đề và mô tả ngắn</p>
                                                    </span>
                                                </span>
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
                                <input name="newsImageTitle" type="text" value="" maxlength="500" id="newsImageTitle" class="TextInput">
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
                                <input name="newsImageAlt" type="text" value="" maxlength="500" id="newsImageAlt" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thẻ Alt của ảnh</p>
                                        <p class="tooltipmessage">Nhập thẻ Alt của ảnh</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="newsPublish" id="newsPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị tin tức</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị tin tức ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Thứ tự hiển thị</td>
                            <td>
                                <input name="newsOrders" type="text" value="" id="newsOrders" style="width:40px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thứ tự hiển thị tin tức</p>
                                        <p class="tooltipmessage">Thứ tự hiển thị của tin tức</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Tóm tắt
                            </td>
                            <td>
                                <textarea name="newsDescription" rows="2" cols="20" id="newsDescription" class="TextInput" style="height:96px;width:400px;"></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Nội dung tóm tắt</p>
                                        <p class="tooltipmessage">
                                            Nội dung tóm tắt sẽ hiển thị trên các trang danh sách tin, trang chủ
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                &nbsp;Nội dung chi tiết
                            </td>
                            <td>
                                <textarea name="newsBody" id="newsBody"></textarea>
                                <script type="text/javascript">
                                    CKEDITOR.replace('newsBody',{language: 'vi'});
                                    $("#newsHightlight").chosen({search_contains:true});
                                    $("#newsTags").chosen({search_contains:true});
                                </script>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <div id="tabs-1-a">
                <table class="admintable"  width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Tóm tắt
                            </td>
                            <td>
                                <textarea name="newsDescription" rows="2" cols="20" id="newsDescription" class="TextInput" style="height:96px;width:400px;"></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Nội dung tóm tắt</p>
                                        <p class="tooltipmessage">
                                            Nội dung tóm tắt sẽ hiển thị trên các trang danh sách tin, trang chủ
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                &nbsp;Nội dung chi tiết
                            </td>
                            <td>
                                <textarea name="newsBody" id="newsBody"></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('newsBody',{language: 'vi'});
                                    });
                                </script>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tabs-1-b">
                <table class="admintable"  width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Tóm tắt tiếng Anh
                            </td>
                            <td>
                                <textarea name="newsDescription_en" rows="2" cols="20" id="newsDescription_en" class="TextInput" style="height:96px;width:400px;"></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Nội dung tóm tắt</p>
                                        <p class="tooltipmessage">
                                            Nội dung tóm tắt sẽ hiển thị trên các trang danh sách tin, trang chủ
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                &nbsp;Nội dung chi tiết tiếng Anh
                            </td>
                            <td>
                                <textarea name="newsBody_en" id="newsBody_en"></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('newsBody_en',{language: 'vi'});
                                    });
                                </script>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tabs-1-c">
                <table class="admintable"  width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Tóm tắt tiếng Pháp
                            </td>
                            <td>
                                <textarea name="newsDescription_fr" rows="2" cols="20" id="newsDescription_fr" class="TextInput" style="height:96px;width:400px;"></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Nội dung tóm tắt</p>
                                        <p class="tooltipmessage">
                                            Nội dung tóm tắt sẽ hiển thị trên các trang danh sách tin, trang chủ
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                &nbsp;Nội dung chi tiết tiếng Pháp
                            </td>
                            <td>
                                <textarea name="newsBody_fr" id="newsBody_fr"></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('newsBody_fr',{language: 'vi'});
                                    });
                                </script>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="height: 5px;"></td>
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
                            <td class="key">Tùy chọn</td>
                            <td>
                                <input id="newsIsHot" type="checkbox" name="newsIsHot" >
                                <label for="newsIsHot">Tin nổi bật</label>
                            </td>
                            <td>
                                <input id="newsIsBanner" type="checkbox" name="newsIsBanner" >
                                <label for="newsIsBanner">Tin banner</label>
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
            <span><a href="<?= base_url()?>administrator/news">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/news/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

    function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_news_ajaxhandler/Main_Image_Upload",
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
   }// end upload_images_product

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

        var newsTitle = $("#newsTitle").val();
        if(newsTitle == '') {
            $("#newsTitle").before('<div class="error Required">Tiêu đề tin tức không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "newsTitle";
        }

        var img_upload = $("#img_upload").attr("src");
        if(img_upload == '') {
            $("#img_upload").before('<div class="error Required">Ảnh chính không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "img_upload";
        }

        var newsOrders = $("#newsOrders").val();
        if(isNaN(newsOrders) || newsOrders < 0) {
            $("#newsOrders").before('<span class="error Required  ">Thứ tự phải là các chữ số và lớn hơn 0</span>');
            hasError = true;
            if (idElementError == "") idElementError = "newsOrders";
        }

        if (!$("#newsCategoryID option:selected").length) {
            $("#newsCategoryID").before('<div class="error Required">Danh mục tin tức phải được chọn</div>');
            hasError = true;
            if (idElementError == "") idElementError = "newsCategoryID";
            //$('html, body').animate({scrollTop:$('#prdCategoriesProductsID').offset().top - 50}, 'slow');
        }

        // var newsDescription = $("#newsDescription").val();
        // if(newsDescription == '') {
        //     $("#newsDescription").before('<div class="error Required">Mô tả ngắn không được trống</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "newsDescription";
        // }

        // var newsBody = CKEDITOR.instances.newsBody.getData();
        // if(newsBody == '') {
        //     $("#newsBody").before('<span class="error Required  ">Nội dung chi tiết không được trống</span>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "newsBody";
        // }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });

    function checkTitle(element) {
        var title = $("#newsTitle").val();
        $.ajax({
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_news_ajaxhandler/Check_Title",
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