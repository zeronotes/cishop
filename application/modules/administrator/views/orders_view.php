<div class="grid_12">
    <div class="header-content">Danh sách đơn hàng</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/orders">Quay lại danh sách</a></span>
        <!-- <span><a href="<?= base_url()?>administrator/orders/add">Thêm mới</a></span> -->
    </div>
    <div class="clear"></div>
    <div class="wrap-main-body">
        <div>
          <form method="get" accept-charset="utf-8">
            <table border="0" width="100%" style="border-collapse: collapse; margin:5px 0px;">
              <tbody>
                <tr>
                  <td colspan="2">
                    <table class="SearchForm">
                      <tbody>
                        <tr>
                            <td> <b>Khách hàng</b>&nbsp;
                                <input name="key" value="<?php if($this -> input -> get('key')) echo $this -> input -> get('key');?>" type="text" id="txtSearch" style="width:200px;">          
                                &nbsp;&nbsp; 
                            </td>
                            <!-- <td><b>Người dùng</b>
                                &nbsp;
                                <select name="isu" id="ddIsu" style="width:100px;">
                                    <option <?php if($this -> input -> get('isu') && $this -> input -> get('isu') == 1) echo 'selected';?> value="1">Người dùng</option>
                                    <option <?php if($this -> input -> get('isu') && $this -> input -> get('isu') == 2) echo 'selected';?> value="2">Vãng lai</option>
                                </select>
                            </td> -->
                            <td><b>Trạng thái</b>
                                &nbsp;
                                <select name="stt" id="ddlStt" style="width:100px;">
                                  <option selected="selected" value="">Tất cả</option> 
                                  <?php foreach ($orderstatus_list as $key) :?> 
                                    <option <?php if($this -> input -> get('stt') && $this -> input -> get('stt') == $key['OrderStatusID']) echo 'selected';?> value="<?= $key['OrderStatusID']?>"><?= $key['Title']?></option>
                                  <?php endforeach;?>
                                </select>
                            </td>
                            <!-- <td>&nbsp;&nbsp;<b>Kiểu thanh toán</b>
                                &nbsp;
                                <select name="pay" id="ddlPay" style="width:100px;">
                                  <option selected="selected" value="">Tất cả</option> 
                                  <?php foreach ($payments_list as $key) :?> 
                                    <option <?php if($this -> input -> get('pay') && $this -> input -> get('pay') == $key['PaymentsID']) echo 'selected';?> value="<?= $key['PaymentsID']?>"><?= $key['Title']?></option>
                                  <?php endforeach;?>
                                </select>
                            </td> -->
                            <td>
                                &nbsp;&nbsp;
                                <a class="linkbtn" onclick="javascript:submit();">Tìm kiếm</a>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="height:5px;"></td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
        <div class="wrap-page-link">
          <div class="page-link"><?= $link?></div>
        </div>
        <div style="padding:1px;">
            <table class="table-view">
                <thead>
                    <tr>
                        <th>#</th>
                        <th style="width:120px;text-align:left;">Tên khách hàng</th>
                        <!-- <th>Đối tượng</th> -->
                        <th>Ngày khởi tạo</th>
                        <th>Trạng thái</th>
                        <!-- <th>Thanh toán</th> -->
                        <th></th>
                    </tr>
                </thead>

                <tbody>
              <?php if(count($orders_list) > 0 ) {?>
                    <?php $i = 1; foreach ($orders_list as $key) :?>
                        <tr id="orders<?= $key -> OrdersID ?>" <?php if($key -> UnRead == 1) echo 'class="unread"'?>>
                            <td align="center" style="width:20px;text-align:center;"><?= $i?></td>
                            <td align="center" style="width:120px;text-align:left;"><a><?= $key -> fullname ?></a></td>
                            <!-- <td><?php if (ord($key -> IsUser)== 1) {echo "Thành viên";} else {echo "Khách vãng lai";} ?> -->
                            <td align="center" style="width:120px;text-align:center;"><?= date_format(new DateTime($key -> CreatedDate),"H:i d/m/Y") ?></td>
                            <td align="center" style="width:90px;text-align:center;">
                                <select onchange="UpdateStatus(<?= $key -> OrdersID ?>,this);">
                                    <?php foreach ($orderstatus_list as $key2): ?>
                                        <option <?php if($key -> OrderStatusID == $key2['OrderStatusID']) echo 'selected="selected"';?> value="<?= $key2['OrderStatusID']?>"><?= $key2['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <!-- <td align="center" style="width:90px;text-align:center;">
                                <select onchange="UpdatePayments(<?= $key -> OrdersID ?>,this);">
                                    <?php foreach ($payments_list as $key3): ?>
                                        <option <?php if($key -> PaymentsID == $key3['PaymentsID']) echo 'selected="selected"';?> value="<?= $key3['PaymentsID']?>"><?= $key3['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                            </td> -->
                            <td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/orders/edit/<?= $key -> OrdersID ?>">Chi tiết</a> | <a onclick="showconfirm(<?= $key -> OrdersID ?>,'Xác thực xóa đơn hàng','Bạn có chắc muốn xóa đơn hàng này?','delete');">xóa</a></td>
                        </tr>
                    <?php $i++; endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="7">Chưa có hóa đơn nào cả</td>
                  </tr>
              <?php }?>
                </tbody>

                <tfoot>

                </tfoot>
            </table>
        </div>
      <div class="wrap-page-link">
        <div class="page-link"><?= $link?></div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/orders">Quay lại danh sách</a></span>
       <!--  <span><a href="<?= base_url()?>administrator/orders/add">Thêm mới</a></span> -->
    </div>
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
                            Delete_Orders(id);
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

    function UpdateStatus(id,element) {
        var status = $(element).val();
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_orders_status/"+id,
            data: { id: id,status: status},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else {
                  notice('Cập nhật trạng thái thành công!');
                  $('#orders'+id).removeClass('unread');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function UpdatePayments(id,element) {
        var payments = $(element).val();
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_orders_payments/"+id,
            data: { id: id,payments: payments},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else {
                  notice('Cập nhật phương thức thanh toán thành công!');
                  $('#orders'+id).removeClass('unread');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function Delete_Orders(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_orders/"+id,
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else {
                  notice('Xóa hóa đơn thành công!');
                  $('#orders'+id).fadeOut(400);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function getdate_() {
        var d = new Date();

        var curr_date = d.getDate();

        var curr_month = d.getMonth();

        var curr_year = d.getFullYear();
        curr_month++;
        return curr_month + "/" + curr_date + "/" + curr_year;
    }
//]]>
</script>