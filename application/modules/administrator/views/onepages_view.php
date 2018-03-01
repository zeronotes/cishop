<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content"><?= $header_title?></div>
        <div class="clear"></div>
        <div class="command">
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
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
                                <input name="Title" type="text" value="<?= $news['Title']?>" maxlength="500" id="newsTitle" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tiêu đề tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('Title_en'); ?>
                                <input name="Title_en" type="text" value="<?= $news['Title_en']?>" maxlength="500" id="newsTitle_en" class="TextInput">
                            </td>
                        </tr>

                        <!-- <tr>
                            <td class="key" valign="top">
                                <span class="Required">*</span>
                                &nbsp;Tóm tắt
                            </td>
                            <td>
                                <?php echo form_error('newsDescription'); ?>
                                <textarea name="newsDescription" rows="2" cols="20" id="newsDescription" class="TextInput" style="height:96px;width:400px;"><?= $news['Description']?></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Nội dung tóm tắt</p>
                                        <p class="tooltipmessage">
                                            Nội dung tóm tắt sẽ hiển thị
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" valign="top">
                                <span class="Required">*</span>
                                &nbsp;Tóm tắt tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('newsDescription_en'); ?>
                                <textarea name="newsDescription_en" rows="2" cols="20" id="newsDescription_en" class="TextInput" style="height:96px;width:400px;"><?= $news['Description_en']?></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Nội dung tóm tắt</p>
                                        <p class="tooltipmessage">
                                            Nội dung tóm tắt sẽ hiển thị
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr> -->

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Nội dung chi tiết
                            </td>
                            <td>
                                <?php echo form_error('Body'); ?>
                                <textarea name="Body" id="newsBody"><?= $news['Content']?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('newsBody',
                                            {
                                                language: 'vi',
                                            }
                                        );
                                    });
                                </script>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Nội dung chi tiết tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('Body_en'); ?>
                                <textarea name="Body_en" id="newsBody_en"><?= $news['Content_en']?></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('newsBody_en',
                                            {
                                                language: 'vi',
                                            }
                                        );
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
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
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
                        if(action == 'save') {
                            submitform();
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
            $("#newsTitle").before('<div class="error Required">Tiêu đề không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "newsTitle";
        }

        var newsTitle_en = $("#newsTitle_en").val();
        if(newsTitle_en == '') {
            $("#newsTitle_en").before('<div class="error Required">Tiêu đề tiếng Anh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "newsTitle_en";
        }

        var newsDescription = $("#newsDescription").val();
        if(newsDescription == '') {
            $("#newsDescription").before('<div class="error Required">Mô tả ngắn không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "newsDescription";
        }

        var newsDescription_en = $("#newsDescription_en").val();
        if(newsDescription_en == '') {
            $("#newsDescription_en").before('<div class="error Required">Mô tả ngắn tiếng Anh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "newsDescription_en";
        }

        var newsBody = CKEDITOR.instances.newsBody.getData();
        if(newsBody == '') {
            $("#newsBody").before('<span class="error Required  ">Nội dung chi tiết không được trống</span>');
            hasError = true;
            if (idElementError == "") idElementError = "newsBody";
        }

        var newsBody_en = CKEDITOR.instances.newsBody_en.getData();
        if(newsBody_en == '') {
            $("#newsBody_en").before('<span class="error Required  ">Nội dung tiếng Anh chi tiết không được trống</span>');
            hasError = true;
            if (idElementError == "") idElementError = "newsBody_en";
        }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
</script>