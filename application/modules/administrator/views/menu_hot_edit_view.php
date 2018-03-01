<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Cập nhật menu phụ</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/menuhot">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/menuhot/add">Thêm mới</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
                </li>
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
                                <?php echo form_error('Title'); ?>
                                <input name="Title" type="text" value="<?= $menu['Title']?>" maxlength="500" id="Title" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tiêu đề menu</p>
                                        <p class="tooltipmessage">Nhập tiêu đề của menu</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Mô tả
                            </td>

                            <td>
                                <textarea name="Description" rows="2" cols="20" id="Description" class="TextInput" style="height:96px;width:400px;"><?= $menu['Description']?></textarea>
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

                        <!-- <tr>
                            <td class="key" valign="top">
                                &nbsp;Mô tả Tiếng Anh
                            </td>
                            <td>
                                <textarea name="Description_en" rows="2" cols="20" id="Description_en" class="TextInput" style="height:96px;width:400px;"><?= $menu['Description_en']?></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Nội dung tóm tắt</p>
                                        <p class="tooltipmessage">
                                            Nội dung tóm tắt sẽ hiển thị trên các trang danh sách tin, trang chủ
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr> -->
                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="Publish" id="Publish">
                                    <option selected="selected" value="1">Có</option>
                                    <option <?php if($menu['Publish'] != 1) echo 'selected="selected"';?> value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị menu</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị menu ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Click</td>
                            <td>
                                <select name="IsClick" id="IsClick">
                                    <option selected="selected" value="1">Có</option>
                                    <option <?php if($menu['IsClick'] != 1) echo 'selected="selected"';?> value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Click menu</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị menu ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <!-- <tr>
                            <td class="key">Trang tĩnh</td>
                            <td>
                                <input id="rdoIsStatic" type="radio" name="IsStatic" value="1"  checked="checked" onclick="ChangeStatic(0);"><label for="rdoIsStatic">&nbsp;Yes&nbsp;&nbsp;</label>
                                <input id="rdoNotStatic" type="radio" name="IsStatic" value="0" <?php if($menu['IsStatic'] == 0) echo 'checked="checked"';?> onclick="ChangeStatic(1);"><label for="rdoNotStatic">&nbsp;No&nbsp;&nbsp;</label>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">
                                            Trang tĩnh</p>
                                        <p class="tooltipmessage">
                                            Trang hiện tại có nội dung tĩnh hay không (chỉ có văn bản)
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr id="tr-static-content" style="display:none;">
                            <td class="key">Nội dung tĩnh</td>
                            <td>
                                <textarea name="StaticContent" id="StaticContent"><?= $menu['StaticContent']?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('StaticContent',
                                            {
                                                language: 'vi',
                                            }
                                        );
                                    });
                                </script>
                            </td>
                        </tr> -->

                        <tr id="tr-link" style="display:none;">
                            <td class="key">Link</td>
                            <td>
                                <div style="margin-bottom: 4px;">
                                    <input id="rdoInternal" class="linktype" type="radio" name="linktype" value="Internal" checked="checked" onclick="ChangeLink(0);"><label for="rdoInternal">&nbsp;Trang trong&nbsp;&nbsp;</label>
                                    <input id="rdoExternal" class="linktype" type="radio" name="linktype" value="External" <?php if($menu['Types'] == "External") echo "checked=\"checked\""?> onclick="ChangeLink(1);"><label for="rdoExternal">&nbsp;Trang ngoài&nbsp;&nbsp;</label>
                                    <input id="rdoNewsCategories" class="linktype" type="radio" name="linktype" value="NewsCategories" <?php if($menu['Types'] == "NewsCategories") echo "checked=\"checked\""?> onclick="ChangeLink(2);"><label for="rdoNewsCategories">&nbsp;Danh mục tin tức&nbsp;&nbsp;</label>
                                    <input id="rdoNews" class="linktype" type="radio" name="linktype" value="News" <?php if($menu['Types'] == "News") echo "checked=\"checked\""?> onclick="ChangeLink(3);"><label for="rdoNews">&nbsp;Danh sách tin tức&nbsp;&nbsp;</label>
                                    <input id="rdoProductCategories" class="linktype" type="radio" name="linktype" value="ProductCategories" <?php if($menu['Types'] == "ProductCategories") echo "checked=\"checked\""?> onclick="ChangeLink(5);"><label for="rdoProductCategories">&nbsp;Danh mục sản phẩm&nbsp;&nbsp;</label>
                                    <input id="rdoProducts" class="linktype" type="radio" name="linktype" value="Products" <?php if($menu['Types'] == "Products") echo "checked=\"checked\""?> onclick="ChangeLink(6);"><label for="rdoProducts">&nbsp;Danh sách sản phẩm&nbsp;&nbsp;</label>
                                    <span class="tooltip"><span class="tooltipContent">
                                            <p class="tooltiptitle">
                                                Link Menu</p>
                                            <p class="tooltipmessage"></p>
                                        </span>
                                    </span>
                                </div>
                                <div id="panel-content">

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">
                                <span class="Required">*</span> Menu cha
                            </td>
                            <td>
                                <select size="7" name="ParentID" id="ParentID" class="TextInput" style="width:306px;">
                                    <option <?php if($menu['ParentID'] == 0) echo 'selected';?> value="0">Gốc</option>
                                    <?php foreach ($parentmenu_list as $key => $value) :?>
                                        <option <?php if($menu['ParentID'] == $value['MenuID']) echo 'selected="selected"';?> value="<?= $value['MenuID']?>"><?= $value['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip"><span class="tooltipContent">
                                        <p class="tooltiptitle">
                                            Menu cha</p>
                                        <p class="tooltipmessage">
                                            Chọn menu cha
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">
                                Thứ tự
                            </td>
                            <td>
                                <input name="Orders" type="text" value="<?php echo $menu['Orders']?>" id="Orders" class="TextInput" style="width:50px;">
                                <span class="tooltip"><span class="tooltipContent">
                                        <p class="tooltiptitle">
                                            Thứ tự hiển thị</p>
                                        <p class="tooltipmessage">
                                            Thứ tự hiển thị menu ngoài website
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Tab mới</td>
                            <td>
                                <input id="IsNewTab" type="checkbox" name="IsNewTab" <?php if($menu['IsNewTab'] == 1) echo 'checked="checked"'?> />
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tab mới</p>
                                        <p class="tooltipmessage">Khi click vào link thì cho phép hiển thị nội dung sang 1 tab mới hay không</p>
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
            <div id="tabs-2">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>

                        <tr>
                            <td class="key">Người khởi tạo</td>
                            <td><span class="lbl-key"><?php if($menu['CreatedBy'] =='') echo '<span class="lbl-key-nan">Không xác định</span>'; else echo '<span class="lbl-key">'.$menu['CreatedBy'].'</span>';?></span>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Người khởi tạo</p>
                                        <p class="tooltipmessage">Tên tài khoản của người đã tạo ra menu này</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Ngày khởi tạo</td>
                            <td><?php if($menu['CreatedDate'] =='') echo '<span class="lbl-key-nan">Không xác định</span>'; else echo '<span class="lbl-key">'.$menu['CreatedDate'].'</span>';?>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Ngày khởi tạo</p>
                                        <p class="tooltipmessage">Ngày giờ menu được khởi tạo</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Người đã chỉnh sửa</td>
                            <td><?php if($menu['ModifiedBy'] =='') echo '<span class="lbl-key">Không xác định</span>'; else echo '<span class="lbl-key">'.$menu['ModifiedBy'].'</span>';?>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Người chỉnh sửa</p>
                                        <p class="tooltipmessage">Tên tài khoản của người đã chỉnh sửa menu này</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Ngày chỉnh sửa</td>
                            <td><?php if($menu['ModifiedDate'] =='') echo '<span class="lbl-key-nan">Chưa từng sửa</span>'; else echo '<span class="lbl-key">'.$menu['ModifiedDate'].'</span>';?>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Ngày chỉnh sửa</p>
                                        <p class="tooltipmessage">Ngày giờ menu được chỉnh sửa</p>
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
                                <input name="menuPageTitle" type="text" maxlength="500" value="<?= $menu['SEOTitle']?>" id="txtPageTitle" style="width:400px;">
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Tiêu đề trang</p>
                                    <p class="tooltipmessage">
                                        Nội dung được hiển thị dưới dạng tiêu đề trong kết quả tìm kiếm và trên trình duyệt của người dùng.
                                    </p>
                                </span></span>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="key" style="width: 150px;">
                                Tiêu đề trang Tiếng Anh
                            </td>
                            <td>
                                <input name="menuPageTitle_en" type="text" maxlength="500" value="<?= $menu['SEOTitle_en']?>" id="txtPageTitle_en" style="width:400px;">
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Tiêu đề trang Tiếng Anh</p>
                                    <p class="tooltipmessage">
                                        Nội dung được hiển thị dưới dạng tiêu đề trong kết quả tìm kiếm và trên trình duyệt của người dùng.
                                    </p>
                                </span></span>
                            </td>
                        </tr> -->
                        <tr>
                            <td class="key">
                                Thẻ từ khóa
                            </td>
                            <td>
                                <input name="menuMetaKeywords" type="text" value="<?= $menu['SEOKeyword']?>" id="txtMetaKeywords" style="width:400px;">
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
                                <textarea name="menuMetaDesc" id="txtMetaDesc" rows="5" style="width:400px;"><?= $menu['SEODescription']?></textarea>
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
            <span><a href="<?= base_url()?>administrator/menuhot">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/menuhot/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[
    jQuery(document).ready(function($) {
        var myRadio1 = $('input[id=rdoIsStatic]');
        var value1 = myRadio1.filter(':checked').val();
        //alert(value1);
        if(value1) {
            // var html = "";
            //     html += "<tr id=\"tr-static-content\" style=\"display:none;\"><td class=\"key\">Nội dung tĩnh<\/td><td><textarea name=\"StaticContent\" id=\"StaticContent\"><\/textarea><script type=\"text\/javascript\">$(document).ready(function() {CKEDITOR.replace('StaticContent',{language: 'vi',});});<\/script><\/td><\/tr>";
            //$('#tr-link').before(html);
            $('#tr-link').hide();
            $('#tr-static-content').show();
            $('#tr-static-content-en').show();
            //$('#tr-link').remove();
        }else {
            $('#tr-link').show();
            $('#tr-static-content').hide();
            $('#tr-static-content-en').hide();
            //$('#tr-static-content').remove();

            if($('input[id=rdoProductCategories]').filter(':checked').val()) {
                ShowProdCate();
            }else if($('input[id=rdoProducts]').filter(':checked').val()) {
                ShowProd();
            }else if($('input[id=rdoNewsCategories]').filter(':checked').val()) {
                ShowNewsCate();
            }else if($('input[id=rdoNews]').filter(':checked').val()) {
                ShowNews();
            }else if($('input[id=rdoExternal]').filter(':checked').val()) {
                ChangeLink(1);
            }else if($('input[id=rdoInternal]').filter(':checked').val()){
                ChangeLink(0);
            }
        }
    });

    function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_menu_hot_ajaxhandler/Main_Image_Upload",
            secureuri      :false,
            fileElementId  :'userfile',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.msg == "" && data.imgname != "") {
                    $('#img_upload').attr('src',data.url);
                    $('#menuMainImage').attr('value',data.imgname);
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
 //<![CDATA[
    var slug = "<?= $menu['Slug']?>";
    function scrollToError(yeah) {
        $('html, body').animate({scrollTop:$('#'+yeah).offset().top - 50}, 'slow');
    }

    function submitform() {
        $("#form-edit").submit();
    }

    function ChangeStatic(index) {
        if(index == 0) {
            // var html = "";
            //     html += '<tr id="tr-static-content\" style=\"display:none;\"><td class=\"key\">Nội dung tĩnh<\/td><td><textarea name=\"StaticContent\" id=\"StaticContent\"><\/textarea><script type=\"text\/javascript\">$(document).ready(function() {CKEDITOR.replace("StaticContent",{language: "vi",});});<\/script><\/td><\/tr>';
            //$('#tr-link').before(html);
            //$('#StaticContent').innerHTML = ;
            $('#tr-static-content').fadeIn('slow');
            $('#tr-static-content-en').fadeIn('slow');
            $('#tr-link').fadeOut('slow');
            //ChangeLink(0);
            //$('#tr-link').remove();
            //$('#tr-static-content').fadeIn(200);
        }else if(index == 1) {
            // var html = "";
            //     html += "<tr id=\"tr-link\" style=\"display:none;\"> <td class=\"key\">Link<\/td> <td><input id=\"rdoInternal\" type=\"radio\" name=\"link\" value=\"rdoInternal\" checked=\"checked\" onclick=\"javascript:ChangeLink(0);\"><label for=\"rdoInternal\"> Trang trong  <\/label> <input id=\"rdoExternal\" type=\"radio\" name=\"link\" value=\"rdoExternal\" onclick=\"javascript:ChangeLink(1);\"><label for=\"rdoExternal\"> Trang ngoài  <\/label> <input id=\"rdoNewsCategories\" type=\"radio\" name=\"link\" value=\"rdoNewsCategories\" onclick=\"ChangeLink(2);\"><label for=\"rdoNewsCategories\"> Danh mục tin tức  <\/label> <input id=\"rdoProductCategories\" type=\"radio\" name=\"link\" value=\"rdoProductCategories\" onclick=\"ChangeLink(3);\"><label for=\"rdoProductCategories\"> Danh mục sản phẩm  <\/label> <input id=\"rdoCustomCategories\" type=\"radio\" name=\"link\" value=\"rdoCustomCategories\" onclick=\"ChangeLink(4);\"><label for=\"rdoCustomCategories\"> Danh mục tùy chọn  <\/label> <input id=\"rdoVendors\" type=\"radio\" name=\"link\" value=\"rdoVendors\" onclick=\"ChangeLink(5);\"><label for=\"rdoVendors\"> Hãng sản xuất  <\/label><span class=\"tooltip\"><span class=\"tooltipContent\"> <p class=\"tooltiptitle\"> Link Menu<\/p> <p class=\"tooltipmessage\"><\/p> <\/span> <\/span> <\/div><div id=\"panel-content\"><\/div> <\/td> <\/tr>";
            //$('#tr-static-content').after(html);
            $('#tr-static-content').fadeOut('slow');
            $('#tr-static-content-en').fadeOut('slow');
            $('#tr-link').fadeIn('slow');
            //$('#tr-static-content').remove();
            //$('#tr-link').fadeIn(200);
        }
    }
    var htmlduongdan = "";
    var htmlLinkInside = "";
    function ChangeLink(index) {
        if(index == 0) {
            $("#Url-1").hide();
            $("#Url-2").hide();
            $("#Url-3").hide();
            $("#Url-5").hide();
            $("#Url-6").hide();
            //$("#panel-content").append("<p>Trang trong</p>");
            if(htmlLinkInside == "") {
                htmlLinkInside = '<div id=\"Url-4\"><select size=\"7\" name=\"Url\" class=\"TextInput\" style=\"width:306px;\">';

                    htmlLinkInside += "     <option";

                    if(slug == 'trang-chu') {
                        htmlLinkInside += " selected=\"selected\"";
                    }

                    htmlLinkInside += " value=\"trang-chu\">"+"Trang chủ"+"</option>";

                     htmlLinkInside += "     <option";

                    if(slug == 'san-pham') {
                        htmlLinkInside += " selected=\"selected\"";
                    }

                    htmlLinkInside += " value=\"san-pham\">"+"Sản phẩm"+"</option>";

                    htmlLinkInside += "     <option";

                    if(slug == 'lien-he') {
                        htmlLinkInside += " selected=\"selected\"";
                    }

                    htmlLinkInside += " value=\"lien-he\">"+"Liên hệ"+"</option>";

                    htmlLinkInside += "     <option";

                    if(slug == 'gio-hang') {
                        htmlLinkInside += " selected=\"selected\"";
                    }

                    htmlLinkInside += " value=\"gio-hang\">"+"Giỏ hàng"+"</option>";

                htmlLinkInside += "<\/select><\/div>";

                $("#panel-content").append(htmlLinkInside);
            }else {
                $("#Url-4").show();
            }

        }else if(index == 1) {
            $("#Url-1").hide();
            $("#Url-2").hide();
            $("#Url-4").hide();
            $("#Url-5").hide();
            $("#Url-6").hide();
            if(htmlduongdan == "") {
                var currentLink = <?php echo json_encode($menu['Url']); ?>;
                htmlduongdan = "<div id=\"Url-3\" ><b >Đường dẫn </b><input class=\"TextInput\" type=\"text\" name=\"Url\" placeholder=\"Đường dẫn\" value=\""+currentLink+"\"></div>";
                $("#panel-content").append(htmlduongdan);
            }else {
                $("#Url-3").show();
            }
            //$("#panel-content").append("<b>Đường dẫn </b><input class=\"TextInput\" type=\"text\" name=\"Url\"  placeholder=\"Đường dẫn\">");
        }else if(index == 2) {
            ShowNewsCate();
        }else if(index == 3) {
            ShowNews();
        }else if(index == 5) {
            ShowProdCate();
        }else if(index == 6) {
            ShowProd();
        }
    }

    var htmlLinkNewsCate = "";
    function ShowNewsCate() {
        $("#Url-2").hide();
        $("#Url-3").hide();
        $("#Url-4").hide();
        $("#Url-5").hide();
        $("#Url-6").hide();
        if(htmlLinkNewsCate == "") {
            $.ajax( {
                type: "POST",
                url: "<?= base_url()?>ajaxhandle/admin_menu_hot_ajaxhandler/Get_NewsCate",
                data: {},
                dataType: "json",
                success: function(data) {
                    var key, count = 0;
                    for(key in data) {
                        count++;
                        if(count > 0)
                            break;
                    }
                    if(count != 0) {

                        htmlLinkNewsCate = '<div id=\"Url-1\"><select size=\"7\" name=\"Url\" class=\"TextInput\" style=\"width:306px;\">';

                        $.each(data, function(i,value){

                            htmlLinkNewsCate += "<option";

                            if(slug == value.Slug) {
                                htmlLinkNewsCate += " selected=\"selected\"";
                            }

                            htmlLinkNewsCate += " value=\""+value.Slug+"\">"+value.Title+"</option>";
                        });

                        htmlLinkNewsCate += "<\/select><\/div>";

                        $("#panel-content").append(htmlLinkNewsCate);

                    }else {
                        notice("not available!");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
                }
            });
        }else {
            //$("#panel-content").html(htmlLinkNewsCate);
            $("#Url-1").show();
        }
    }

    var htmlLinkNews = "";
    function ShowNews() {
        $("#Url-1").hide();
        $("#Url-3").hide();
        $("#Url-4").hide();
        $("#Url-5").hide();
        $("#Url-6").hide();
        if(htmlLinkNews == "") {
            $.ajax( {
                type: "POST",
                url: "<?= base_url()?>ajaxhandle/admin_menu_hot_ajaxhandler/Get_News",
                data: {},
                dataType: "json",
                success: function(data) {
                    var key, count = 0;
                    for(key in data) {
                        count++;
                        if(count > 0)
                            break;
                    }
                    if(count != 0) {

                        htmlLinkNews = '<div id=\"Url-2\"><select class=\"chosen\" size=\"15\" name=\"Url\" class=\"TextInput\" style=\"width:306px;\">';

                        $.each(data, function(i,value){
                            htmlLinkNews += "<option";
                            if(slug == value.Slug) {
                                htmlLinkNews += " selected=\"selected\"";
                            }
                            htmlLinkNews += " value=\""+value.Slug+"\">"+value.Title+"</option>";
                        });

                        htmlLinkNews += "<\/select><\/div>";

                        $("#panel-content").append(htmlLinkNews);
                        $(".chosen").chosen({search_contains:true});
                    }else {
                        notice("not available!");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
                }
            });
        }else {
            //$("#panel-content").html(htmlLinkNews);
            $("#Url-2").show();
        }
    }

    var htmlLinkProdCate = "";
    function ShowProdCate() {
        $("#Url-1").hide();
        $("#Url-2").hide();
        $("#Url-3").hide();
        $("#Url-4").hide();
        $("#Url-6").hide();
        if(htmlLinkProdCate == "") {
            $.ajax( {
                type: "POST",
                url: "<?= base_url()?>ajaxhandle/admin_menu_hot_ajaxhandler/Get_ProdCate",
                data: {},
                dataType: "json",
                success: function(data) {
                    var key, count = 0;
                    for(key in data) {
                        count++;
                        if(count > 0)
                            break;
                    }
                    if(count != 0) {

                        htmlLinkProdCate = '<div id=\"Url-5\"><select size=\"7\" name=\"Url\" class=\"TextInput\" style=\"width:306px;\">';

                        $.each(data, function(i,value){

                            htmlLinkProdCate += "<option";

                            if(slug == value.Slug) {
                                htmlLinkProdCate += " selected=\"selected\"";
                            }

                            htmlLinkProdCate += " value=\""+value.Slug+"\">"+value.Title+"</option>";
                        });

                        htmlLinkProdCate += "<\/select><\/div>";

                        $("#panel-content").append(htmlLinkProdCate);

                    }else {
                        notice("not available!");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
                }
            });
        }else {
            //$("#panel-content").html(htmlLinkProdCate);
            $("#Url-5").show();
        }
    }

    var htmlLinkProd = "";
    function ShowProd() {
        $("#Url-1").hide();
        $("#Url-2").hide();
        $("#Url-3").hide();
        $("#Url-4").hide();
        $("#Url-5").hide();
        if(htmlLinkProd == "") {
            $.ajax( {
                type: "POST",
                url: "<?= base_url()?>ajaxhandle/admin_menu_hot_ajaxhandler/Get_Prod",
                data: {},
                dataType: "json",
                success: function(data) {
                    var key, count = 0;
                    for(key in data) {
                        count++;
                        if(count > 0)
                            break;
                    }
                    if(count != 0) {

                        htmlLinkProd = '<div id=\"Url-6\"><select class=\"chosen\" size=\"15\" name=\"Url\" class=\"TextInput\" style=\"width:306px;\">';

                        $.each(data, function(i,value){
                            htmlLinkProd += "<option";
                            if(slug == value.Slug) {
                                htmlLinkProd += " selected=\"selected\"";
                            }
                            htmlLinkProd += " value=\""+value.Slug+"\">"+value.Title+"</option>";
                        });

                        htmlLinkProd += "<\/select><\/div>";

                        $("#panel-content").append(htmlLinkProd);
                        $(".chosen").chosen({search_contains:true});
                    }else {
                        notice("not available!");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
                }
            });
        }else {
            //$("#panel-content").html(htmlLinkProd);
            $("#Url-6").show();
        }
    }



    $('form').submit(function() {
        $(".error").remove();
        var idElementError = "";
        var hasError = false;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        var Title = $("#Title").val();
        if(Title == '') {
            $("#Title").before('<div class="error Required">Tiêu đề menu không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "Title";
        }

        // if (!$("#menuCategoryID option:selected").length) {
        //     $("#menuCategoryID").before('<div class="error Required">menu menu phải được chọn</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "menuCategoryID";
        //     //$('html, body').animate({scrollTop:$('#prdCategoriesProductsID').offset().top - 50}, 'slow');
        // }

        // var Description = $("#Description").val();
        // if(Description == '') {
        //     $("#Description").before('<div class="error Required">Mô tả ngắn không được trống</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "Description";
        // }

        // var menuBody = CKEDITOR.instances.menuBody.getData();
        // if(menuBody == '') {
        //     $("#menuBody").before('<span class="error Required  ">Nội dung chi tiết không được trống</span>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "menuBody";
        // }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
//]]>
</script>