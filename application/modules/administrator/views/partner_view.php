<div class="grid_12">
	<div class="header-content">Đối tác</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/partners/add">Thêm mới</a></span>
    </div>
    <div class="clear"></div>
    <div class="wrap-main-body">
        <div>
          <form method="get" accept-charset="utf-8">
            <table border="0" width="100%" style="border-collapse: collapse; margin:5px 0px;">
              <tbody>

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
                <th>Ảnh</th>
	        			<th>Tên đối tác</th>
                <th>Thứ tự</th>
                <th>Hiển thị</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(!empty($partnerList) ) {?>
  	        		<?php $i = 1; foreach ($partnerList as $key) :?>
  		        		<tr id="partners<?= $key['Id']?>">
  		        			<td align="center" style="width:20px;text-align:center;"><?= $i?></td>
  		        			<td style="width:100px;text-align:center;"><img src="<?= base_url();?>resources/uploads/images/automatic/thumbs/<?= $key['ImageUrl']?>" width="90" /></td>
                    <td style="text-align:left;"><?= $key['Title']?></td>
  		        			<td align="center" style="width:60px;text-align:center;"><input type="text"  id="txtOrders<?= $key['Id']?>" style="width: 60px; text-align:right;" value="<?= $key['Orders']?>"  onchange="UpdateOrders(<?= $key['Id']?>,this);"/></td>
                    <td style="width:60px;text-align:center;"><input type="checkbox" id="cbIsVisible<?= $key['Id']?>" name="Publish" <?php if($key['Publish'] == 1) echo "checked";?> onclick="Update_publish(<?= $key['Id']?>)"/></td>
  		        			<td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/partners/edit/<?= $key['Id']?>">Chỉnh sửa</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['Id']?>,'Xác thực xóa partners','Bạn có chắc muốn xóa partners này?','delete');">xóa</a></td>
  		        		</tr>
  		        	<?php $i++; endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="7">Chưa có partners nào cả</td>
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
        <span><a href="<?= base_url()?>administrator/partners/add">Thêm mới</a></span>
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
                            Delete_partners(id);
                            $('body').css('overflow','auto');
                        }
                    }
                },
                'No'    : {
                    'class' : 'gray',
                    'action': function(){
                        if(action == 'delete') {
                            $('body').css('overflow','auto');
                        }
                    }
                }
            }
        });
    }

    function Delete_partners(id) {
      $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_partners",
            data: { id: id},
            dataType: "json",
            success: function(data) {
              if(data == 0) {
                notice('Đã có lỗi! Thực hiện lại sau.');
              }else if(data == 1) {
                notice("Đã xóa thành công.");
                $('#partners'+id).fadeOut();
              }else {
                notice(data.msg);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
      });
    }

    function Update_publish(id) {
      var Publish;
      if($("#cbIsVisible"+id).attr('checked')){
        Publish = 1;
      }else {
        Publish = 0;
      }
      $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_partners_publish",
            data: { id: id,Publish:Publish},
            dataType: "json",
            success: function(data) {
              if(data == 0) {
                notice('Đã có lỗi! Thực hiện lại sau.');
              }else if(data == 1) {
                notice("Đã cập nhật trạng thái hiển thị.");
              }else {
                notice(data.msg);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
      });

    }

    function UpdateOrders(id,element) {
      var orders = Number($("#txtOrders"+id).val());
      if(!isNaN(orders)) {
        $.ajax( {
              type: "POST",
              url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_Orders_Partners",
              data: { id: id,orders: orders},
              dataType: "json",
              success: function(data) {
                if(data == 0) {
                  notice('Đã có lỗi! Thực hiện lại sau.');
                }else if(data == 1) {
                  element.defaultValue = orders;
                  notice('Đã cập nhật thứ tự.');
                }else {
                  notice(data.msg);
                }
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
              }
        });
      }else {
        $("#txtOrders"+id).val(element.defaultValue);
        notice('Thứ tự phải là chữ số.');
      }
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