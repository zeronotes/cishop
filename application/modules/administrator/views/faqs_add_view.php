<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới hỏi đáp</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/faqs">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin hỏi đáp</a>
                </li>
                <li>
                    <a href="#tabs-2">Thông tin khác</a>
                </li>
            </ul>
            <div id="tabs-1" >
                <div id="Div1">
                    <table class="admintable" width="100%">
                        <tbody><tr>
                            <td style="height: 5px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Câu hỏi
                            </td>
                            <td>
                                <?php echo form_error('Question'); ?>
                                <input name="Question" type="text" value="" id="Question" style="width:400px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Câu hỏi tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('Question_en'); ?>
                                <input name="Question_en" type="text" value="" id="Question_en" style="width:400px;">
                            </td>
                        </tr>

                        <tr id="">
                            <td class="key">Trả lời</td>
                            <td>
                                <?php echo form_error('Answer'); ?>
                                <textarea name="Answer" id="Answer"></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('Answer',
                                            {
                                                language: 'vi',
                                            }
                                        );
                                    });
                                </script>
                            </td>
                        </tr>

                        <tr id="">
                            <td class="key">Trả lời tiếng Anh</td>
                            <td>
                                <?php echo form_error('Answer_en'); ?>
                                <textarea name="Answer_en" id="Answer_en"></textarea>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        CKEDITOR.replace('Answer_en',
                                            {
                                                language: 'vi',
                                            }
                                        );
                                    });
                                </script>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Thứ tự hiển thị</td>
                            <td>
                                <?php echo form_error('Orders'); ?>
                                <input name="Orders" type="text" value="" id="Orders" style="width:40px;">
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="Publish" id="faqPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                            </td>
                        </tr>

                    </tbody></table>
                </div>
            </div>
            <div id="tabs-2">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>

                        <tr>
                            <td class="key">Tùy chọn</td>
                            <td>
                                <input id="IsShowFooter" type="checkbox" name="IsShowFooter" >
                                <label for="IsShowFooter">7 FAQs hiển thị footer</label>
                                &nbsp;&nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/faqs">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
    var index = <?php if(isset($i)) echo $i; else echo '0';?>;
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

        var Question = $("#Question").val();
        if(Question == '') {
            $("#Question").before('<div class="error Required">Tiêu đề faq không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "Question";
        }

        var Question_en = $("#Question_en").val();
        if(Question_en == '') {
            $("#Question_en").before('<div class="error Required">Tiêu đề faq tiếng Anh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "Question_en";
        }

        var Orders = $("#Orders").val();
        if(isNaN(Orders)) {
            $("#Orders").before('<span class="error Required  ">Thứ tự phải là các chữ số</span>');
            hasError = true;
            if (idElementError == "") idElementError = "Orders";
        }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
</script>