<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Cập nhật tag sản phẩm</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/productstags">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/productstags/add">Thêm mới</a></span>
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
                                &nbsp;Tên tags
                            </td>
                            <td>
                                <?php echo form_error('tagsError'); ?>
                                <label name="tagsError"></label>
                                <?php echo form_error('tagsTitle'); ?>
                                <input name="tagsTitle" type="text" value="<?= $tags['Title']; ?>" maxlength="500" id="cateTitle" class="TextInput" style="width:400px;"/>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tên tags</p>
                                        <p class="tooltipmessage">Nhập tên của tags</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="tagsPublish" id="tagsPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option <?php if(!$tags['Publish']) echo 'selected="selected"';?> value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị tags</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị tags ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Thứ tự hiển thị</td>
                            <td>
                                <input name="tagsOrders" type="text" value="<?= $tags['Orders']?>" id="tagsOrders" style="width:40px;"/>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thứ tự hiển thị tags</p>
                                        <p class="tooltipmessage">Thứ tự hiển thị của tags</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả</td>
                            <td>
                                <textarea name="tagsDescription" rows="2" cols="20" id="tagsDescription" class="TextInput" style="height:96px;width:400px;"><?= $tags['Description']?></textarea>
                            </td>
                        </tr>
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
                                <input name="tagsPageTitle" value="<?= $tags['SEOTitle']?>" type="text" maxlength="500" id="txtPageTitle" style="width:400px;"/>
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
                                <input name="tagsMetaKeywords" type="text" value="<?= $tags['SEOKeyword']?>" id="txtMetaKeywords" style="width:400px;"/>
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
                                <textarea name="tagsMetaDesc" id="txtMetaDesc" rows="5" style="width:400px;"><?= $tags['SEODescription']?></textarea>
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
            <span><a href="<?= base_url()?>administrator/productstags">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/productstags/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

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
                            upload_images_product();
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

        var cateTitle = $("#tagsTitle").val();
        if(cateTitle == '') {
            $("#tagsTitle").before('<div class="error Required">Tên tags không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "tagsTitle";
        }

        var cateOrders = $("#tagsOrders").val();
        if(isNaN(cateOrders)) {
            $("#tagsOrders").before('<span class="error Required  ">Thứ tự phải là các chữ số</span>');
            hasError = true;
            if (idElementError == "") idElementError = "tagsOrders";
        }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
</script>