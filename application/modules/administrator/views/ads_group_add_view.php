<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới nhóm quảng cáo (Không nên)</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/categories/ads">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin nhóm quảng cáo</a>
                </li>
            </ul>
            <div id="tabs-1" >
                <div id="Div1">
                    <table class="admintable" width="100%">
                        <tbody>
                            <tr>
                                <td style="height: 5px;">
                                </td>
                            </tr>
                            <tr>
                                <td class="key" style="width: 150px;">
                                    <span class="Required">*</span>
                                    &nbsp;Tiêu đề
                                </td>
                                <td>
                                    <?php echo form_error('Title'); ?>
                                    <input name="Title" type="text" maxlength="500" value="" id="Title" style="width:400px;">
                                    <span class="tooltip">
                                        <span class="tooltipContent">
                                            <p class="tooltiptitle">
                                                Tiêu đề</p>
                                            <p class="tooltipmessage">
                                                Tiêu đề của nhóm quảng cáo.
                                            </p>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td class="key">
                                    &nbsp;Danh mục sản phẩm
                                </td>
                                <td>
                                    <?php echo form_error('CategoriesProductsID'); ?>
                                    <select size="10" name="CategoriesProductsID" id="CategoriesProductsID" style="width:400px;">
                                        <option value="0">Gốc</option>
                                        <?php foreach ($categories_list as $key) :?>
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
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/categories/ads">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
    </form>
</div>

<script type="text/javascript">

   function showconfirm(id,title,message,action){
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
        return true;
    });
</script>