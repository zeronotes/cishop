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
                                <?php echo form_error('newsTitle'); ?>
                                <input type="hidden" value="<?= $news['NewsID']?>" id="newsID">
                                <input name="newsTitle" type="text" value="Clone of <?= $news['Title']?>" maxlength="500" id="newsTitle" class="TextInput" onchange="checkTitle(this);">
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
                                <?php echo form_error('newsTitle_en'); ?>
                                <input name="newsTitle_en" type="text" value="<?= $news['Title_en']?>" maxlength="500" id="newsTitle_en" class="TextInput">
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
                                <?php echo form_error('newsTitle_fr'); ?>
                                <input name="newsTitle_fr" type="text" value="<?= $news['Title_fr']?>" maxlength="500" id="newsTitle_fr" class="TextInput">
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
                                    <?php foreach ($categoriesnews_list as $key) :?>
                                        <option <?php if($news['CategoriesNewsID'] == $key['CategoriesNewsID']) echo 'selected';?> value="<?= $key['CategoriesNewsID']?>"><?= $key['Title']?></option>
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
                                        <option <?php if(in_array($key['NewsID'], explode(",", $news['Hightlight']))) echo 'selected';?> value="<?= $key['NewsID']?>"><?= $key['Title']?></option>
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
                                        <option <?php if(in_array($key['TagsID'], explode(",", $news['Tags']))) echo 'selected';?> value="<?= $key['TagsID']?>"><?= $key['Title']?></option>
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
                                                <img id="img_upload" src="<?= base_url()?>resources/uploads/images/automatic/thumbs/<?= $news['ImageURL']?>">
                                                <input type="hidden" name="newsMainImage" id="newsMainImage" value="<?= $news['ImageURL']?>">
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
                                <?php echo form_error('newsImageTitle'); ?>
                                <input name="newsImageTitle" type="text" value="<?= $news['ImageTitle']?>" maxlength="500" id="newsImageTitle" class="TextInput">
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
                                <?php echo form_error('newsImageAlt'); ?>
                                <input name="newsImageAlt" type="text" value="<?= $news['ImageAlt']?>" maxlength="500" id="newsImageAlt" class="TextInput">
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
                                    <option <?php if($news['Publish'] != 1) echo 'selected="selected"';?> value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị sản phẩm</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị sản phẩm ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Thứ tự hiển thị</td>
                            <td>
                                <?php echo form_error('newsOrders'); ?>
                                <input name="newsOrders" type="text" value="<?= $news['Orders']?>" id="newsOrders" style="width:70px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thứ tự</p>
                                        <p class="tooltipmessage">
                                            Thứ tự hiển thị tin tức
                                        </p>
                                    </span>
                                </span>

                            </td>
                        </tr>

                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Tóm tắt
                            </td>
                            <td>
                                <?php echo form_error('newsDescription'); ?>
                                <textarea name="newsDescription" rows="2" cols="20" id="newsDescription" class="TextInput" style="height:96px;width:400px;"><?= $news['Description']?></textarea>
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
                                <?php echo form_error('newsBody'); ?>
                                <textarea name="newsBody" id="newsBody"><?= $news['Body']?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('newsBody',{language: 'vi'});
                                        $("#newsHightlight").chosen({search_contains:true});
                                        $("#newsTags").chosen({search_contains:true});
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

            <!-- <div id="tabs-1-a">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Tóm tắt
                            </td>
                            <td>
                                <?php echo form_error('newsDescription'); ?>
                                <textarea name="newsDescription" rows="2" cols="20" id="newsDescription" class="TextInput" style="height:96px;width:400px;"><?= $news['Description']?></textarea>
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
                                <?php echo form_error('newsBody'); ?>
                                <textarea name="newsBody" id="newsBody"><?= $news['Body']?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('newsBody',{language: 'vi'});
                                    });
                                </script>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="tabs-1-b">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Tóm tắt tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('newsDescription_en'); ?>
                                <textarea name="newsDescription_en" rows="2" cols="20" id="newsDescription_en" class="TextInput" style="height:96px;width:400px;"><?= $news['Description_en']?></textarea>
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
                                <?php echo form_error('newsBody_en'); ?>
                                <textarea name="newsBody_en" id="newsBody_en"><?= $news['Body_en']?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('newsBody_en',{language: 'vi'});
                                    });
                                </script>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="tabs-1-c">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Tóm tắt tiếng Pháp
                            </td>
                            <td>
                                <?php echo form_error('newsDescription_fr'); ?>
                                <textarea name="newsDescription_fr" rows="2" cols="20" id="newsDescription_fr" class="TextInput" style="height:96px;width:400px;"><?= $news['Description_fr']?></textarea>
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
                                <?php echo form_error('newsBody_fr'); ?>
                                <textarea name="newsBody_fr" id="newsBody_fr"><?= $news['Body_fr']?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('newsBody_fr',{language: 'vi'});
                                    });
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
                            <td class="key">Tùy chọn</td>
                            <td>
                                <input id="newsIsHot" type="checkbox" <?php if($news['IsHot'] == 1) echo "checked";?> name="newsIsHot" >
                                <label for="newsIsHot">Tin nổi bật</label>
                            </td>
                            <td>
                                <input id="newsIsBanner" type="checkbox" <?php if($news['IsBanner'] == 1) echo "checked";?> name="newsIsBanner" >
                                <label for="newsIsBanner">Tin banner</label>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Người khởi tạo</td>
                            <td><span class="lbl-key"><?php if($news['CreatedBy'] =='') echo '<span class="lbl-key-nan">Không xác định</span>'; else echo '<span class="lbl-key">'.$news['CreatedBy'].'</span>';?></span>
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
                            <td><span class="lbl-key"><?= $news['CreatedDate']?></span>
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
                            <td><?php if($news['ModifiedBy'] =='') echo '<span class="lbl-key">Không xác định</span>'; else echo '<span class="lbl-key">'.$news['ModifiedBy'].'</span>';?>
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
                            <td><?php if($news['ModifiedDate'] =='') echo '<span class="lbl-key-nan">Chưa từng sửa</span>'; else echo '<span class="lbl-key">'.$news['ModifiedDate'].'</span>';?>
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
                                <input name="newsPageTitle" type="text" maxlength="500" value='<?= $news['SEOTitle']?>' id="txtPageTitle" style="width:400px;">
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
                                <input name="newsMetaKeywords" type="text" value="<?= $news['SEOKeyword']?>" id="txtMetaKeywords" style="width:400px;">
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
                                <textarea name="newsMetaDesc" id="txtMetaDesc" rows="5" style="width:400px;"><?= $news['SEODescription']?></textarea>
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

        var newsTitle = $("#newsTitle").val();
        if(newsTitle == '') {
            $("#newsTitle").before('<div class="error Required">Tiêu đề tin tức không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "newsTitle";
        }

        if (!$("#newsCategoryID option:selected").length) {
            $("#newsCategoryID").before('<div class="error Required">Danh mục tin tức phải được chọn</div>');
            hasError = true;
            if (idElementError == "") idElementError = "newsCategoryID";
            //$('html, body').animate({scrollTop:$('#prdCategoriesProductsID').offset().top - 50}, 'slow');
        }

        var newsOrders = $("#newsOrders").val();
        if(isNaN(newsOrders) || newsOrders < 0) {
            $("#newsOrders").before('<span class="error Required  ">Thứ tự phải là các chữ số và lớn hơn 0</span>');
            hasError = true;
            if (idElementError == "") idElementError = "newsOrders";
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