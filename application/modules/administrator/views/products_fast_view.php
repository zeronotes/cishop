<div class="grid_12">
    <form method="post"  name="form-add" id="form-add" accept-charset="utf-8">
        <div class="header-content">Thêm mới sản phẩm</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/products">Quay lại danh sách</a></span>
        </div>
        <div class="clear"></div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Nhập sản phẩm nhanh</a>
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
            </ul>
            <div id="tabs-1">
                <input type="hidden" name="submit_type" id="submit_type">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key">
                                <span class="Required">*</span>
                                &nbsp;Danh mục
                            </td>
                            <td>
                                <?php echo form_error('prdCategoriesProductsID'); ?>
                                <select size="10" name="prdCategoriesProductsID" id="prdCategoriesProductsID" style="width:400px;">
                                    <?php foreach ($categories as $key) :?>
                                        <option value="<?= $key['CategoriesProductsID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Danh mục sản phẩm</p>
                                        <p class="tooltipmessage">Lựa chọn danh mục chứa sản phẩm</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                <span class="Required">*</span>
                                &nbsp;Thương hiệu
                            </td>
                            <td>
                                <?php echo form_error('prdSortingBrandID'); ?>
                                <select size="10" name="prdSortingBrandID" id="prdSortingBrandID" style="width:400px;">
                                    <?php foreach ($brand_list as $key) :?>
                                        <option value="<?= $key['SortingBrandID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thương hiệu sản phẩm</p>
                                        <p class="tooltipmessage">Lựa chọn Thương hiệu chứa sản phẩm</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/products">Quay lại danh sách</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[
    var thutu = 0;

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
                            submitform('single');
                            $('body').css('overflow','auto');
                        }
                        else if(action == 'save_multi') {
                            submitform('multi');
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

    function submitform(type) {
        $("#submit_type").val(type);
        $("#form-add").submit();
    }

    

    //$.jQuery(document).ready(function($) {
    $('#form-add').submit(function() {
        $(".error").remove();
        var idElementError = "";
        var hasError = false;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        var prdTitle = $("#prdTitle").val();
        if(prdTitle == '') {
            $("#prdTitle").before('<div class="error Required">Tên sản phẩm không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "prdTitle";
        }
        //} else if(!emailReg.test(prdTitle)) { test email regax

        if (!$("#prdCategoriesProductsID option:selected").length) {
            $("#prdCategoriesProductsID").before('<div class="error Required">Danh mục sản phẩm phải được chọn</div>');
            hasError = true;
            if (idElementError == "") idElementError = "prdCategoriesProductsID";
            //$('html, body').animate({scrollTop:$('#prdCategoriesProductsID').offset().top - 50}, 'slow');
        }

        if (!$("#prdSortingBrandID option:selected").length) {
            $("#prdSortingBrandID").before('<div class="error Required">Thương hiệu sản phẩm phải được chọn</div>');
            hasError = true;
            if (idElementError == "") idElementError = "prdSortingBrandID";
            //$('html, body').animate({scrollTop:$('#prdSortingBrandID').offset().top - 50}, 'slow');
        }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
    //});
</script>