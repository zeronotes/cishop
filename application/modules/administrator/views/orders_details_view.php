<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Chi tiết đơn hàng</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/orders">Quay lại danh sách</a></span>
            <!-- <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span> -->
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
                </li>
                <li>
                    <a href="#tabs-2">Thông tin khác</a>
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
                                &nbsp;Tên khách hàng
                            </td>
                            <td>
                                <a href="<?= base_url()?>administrator/customers/edit/<?= $order['CustomersID']?>"><?= $order['FullName']?></a>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tên khách hàng</p>
                                        <p class="tooltipmessage">Tên của khách hàng đã tạo hóa đơn này</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="key">
                                &nbsp;Địa chỉ
                            </td>
                            <td>
                                <textarea name="CusAddress" rows="5" cols="20" id="CusAddress" class="TextInput" ><?= $order['CusAddress']?></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Địa chỉ</p>
                                        <p class="tooltipmessage">Địa chỉ của khách hàng</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="key">Điện thoại</td>
                            <td>
                                <span><?= $order['CusPhone']?></span>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Điện thoại</p>
                                        <p class="tooltipmessage">Điện thoại của khách hàng</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Email</td>
                            <td>
                                <span><?= $order['CusEmail']?></span>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Email</p>
                                        <p class="tooltipmessage">Email của khách hàng</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Ghi chú</td>
                            <td>
                                <textarea name="OrderNotes" rows="5" cols="20" id="OrderNotes" class="TextInput" ><?= $order['Notes']?></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Ghi chú</p>
                                        <p class="tooltipmessage">Ghi chú của đơn hàng</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;font-size:13px;text-transform:uppercase;">Chi tiết đơn hàng</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="table-view">
                                    <thead>
                                        <th>#</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Ghi chú</th>
                                        <th>Giá tiền</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </thead>
                                    <tbody>
                                        <?php if(count($order['orderitems_list']) > 0 ) {?>
                                            <?php $i = 1; foreach ($order['orderitems_list'] as $key) :?>
                                                <tr>
                                                    <td style="width:20px;"><?= $i?></td>
                                                    <td style="width:180px;"><a href="<?= base_url()?>administrator/products/edit/<?= $key['ProductsID']?>" title=""><?= $key['ProductTitle'] ?></a></td>
                                                    <td><?= $key['Notes']?></td>
                                                    <td style="width:100px;text-align:right;"><?= number_format($key['Price'],0,".",".")  ?> VNĐ</td>
                                                    <td style="width:50px;text-align:right;"><?= $key['Quantity'] ?></td>
                                                    <td style="text-align:right;width:120px;"><?= number_format($key['Total'],0,".",".")  ?> VNĐ</td>
                                                </tr>
                                            <?php $i++; endforeach;?>
                                        <?php }else {?>
                                            <tr>
                                                <td colspan="6">Chưa có hóa đơn nào cả</td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                    <?php if(count($order['orderitems_list']) > 0 ) {?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align:right;">Thành tiền</td>
                                                <td style="text-align:right;"><?= number_format($order['TotalPrice'],0,".",".") ?> VNĐ</td>
                                            </tr>
                                        </tfoot>
                                    <?php }?>

                                </table>
                            </td>
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
                            <td class="key">Ngày khởi tạo</td>
                            <td><span class="lbl-key"><?= $order['CreatedDate']?></span>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Ngày khởi tạo</p>
                                        <p class="tooltipmessage">Ngày giờ đơn hàng được khởi tạo</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Người đã chỉnh sửa</td>
                            <td><?php if($order['ModifiedBy'] =='') echo '<span class="lbl-key">Không xác định</span>'; else echo '<span class="lbl-key">'.$order['ModifiedBy'].'</span>';?>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Người chỉnh sửa</p>
                                        <p class="tooltipmessage">Tên tài khoản của người đã chỉnh sửa đơn hàng này</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Ngày chỉnh sửa</td>
                            <td><?php if($order['ModifiedDate'] =='') echo '<span class="lbl-key-nan">Chưa từng sửa</span>'; else echo '<span class="lbl-key">'.$order['ModifiedDate'].'</span>';?>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Ngày chỉnh sửa</p>
                                        <p class="tooltipmessage">Ngày giờ đơn hàng được chỉnh sửa</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/orders">Quay lại danh sách</a></span>
            <!-- <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span> -->
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
</script>