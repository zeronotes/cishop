<div class="grid_12">
	<div class="header-content">Quản lý menu</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/menu/add">Thêm mới</a></span>
    </div>
    <div class="clear"></div>
    <div class="wrap-main-body">
      	<div class="wrap-page-link">
          <div class="page-link"><?= $link?></div>
        </div>
        <div style="padding:1px;">
          <?php if(count($menu_list) > 0 ) {?>
          	<table class="table-view">
  	        	<thead>
  	        		<tr>
  	        			<th>#</th>
  	        			<th>Tên menu</th>
  	        			<th>Mở tab mới</th>
  	        			<th>Hiển thị</th>
                  <th>Click</th>
                  <th>Thứ tự</th>
  	        			<th></th>
  	        		</tr>
  	        	</thead>

  	        	<tbody>
    	        		<?php $i = 1; foreach ($menu_list as $key) :?>
    		        		<tr id="menu<?= $key['MenuID']?>">
    		        			<td align="center" style="width:20px;text-align:center;"><?= $i?></td>
    		        			<td><a id="Title<?= $key['MenuID']?>" href="<?= base_url()?>administrator/menu/edit/<?= $key['MenuID']?>"><?= $key['Title']?></a></td>
    		        			<td align="center" style="width:80px;text-align:center;"><input type="checkbox" value="1" id="cbIsNewTab<?= $key['MenuID']?>" <?php if($key['IsNewTab'] == 1) echo 'checked="checked"'?> onclick="UpdateNewTabStatus(<?= $key['MenuID']?>);"/></td>
    		        			<td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['MenuID']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['MenuID']?>);"/></td>
                      <td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsClick<?= $key['MenuID']?>" <?php if($key['IsClick'] == 1) echo 'checked="checked"'?> onclick="UpdateIsClickStatus(<?= $key['MenuID']?>);"/></td>
    		        			<td align="center" style="width:60px;text-align:center;"><input type="text" id="txtOrders<?= $key['MenuID']?>" style="width: 50px; text-align:right;" value="<?= $key['Orders']?>" onchange="UpdateOrders(<?= $key['MenuID']?>,this);"/></td>
                      <td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/menu/edit/<?= $key['MenuID']?>">Chỉnh sửa</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['MenuID']?>,'Xác thực xóa menu','Xóa menu đồng nghĩa với việc xóa tất cả các menu con thuộc menu này. <br/><br/> Bạn có chắc muốn xóa menu?','delete');">xóa</a></td>
    		        		</tr>
    		        	<?php $i++; endforeach;?>
  	        	</tbody>

  	        	<tfoot>

  	        	</tfoot>
  	        </table>
          <?php }else {?>
                  <p>Chưa có menu nào cả</p>
          <?php }?>
	    </div>
      <div class="wrap-page-link">
        <div class="page-link"><?= $link?></div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/menu/add">Thêm mới</a></span>
    </div>
</div>

<script type="text/javascript">
 //<![CDATA[
  function UpdateNewTabStatus(id) {
    var IsNewTab;
    if($("#cbIsNewTab"+id).attr('checked')){
      IsNewTab = 1;  
    }else {
      IsNewTab = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_menu_ajaxhandler/Update_NewTab",
          data: { id: id,IsNewTab: IsNewTab},
          dataType: "json",
          success: function(data) {
            if(data == 0) {
              notice('Đã có lỗi! Thực hiện lại sau.');
            }else if(data == 1) {
              notice("Đã cập nhật thuộc tính target");
            }else {
              notice(data.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
          }
    });
  }

  function UpdatePublishStatus(id) {
    var Publish;
    if($("#cbIsVisible"+id).attr('checked')){
      Publish = 1;  
    }else {
      Publish = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_menu_ajaxhandler/Update_Publish",
          data: { id: id,Publish: Publish},
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

  function UpdateIsClickStatus(id) {
    var IsClick;
    if($("#cbIsClick"+id).attr('checked')){
      IsClick = 1;  
    }else {
      IsClick = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_menu_ajaxhandler/Update_IsClick",
          data: { id: id,IsClick: IsClick},
          dataType: "json",
          success: function(data) {
            if(data == 0) {
              notice('Đã có lỗi! Thực hiện lại sau.');
            }else if(data == 1) {
              notice("Đã cập nhật trạng thái click.");
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
        var orders = $("#txtOrders"+id).val();
        if(!isNaN(orders)) {
            $.ajax( {
                  type: "POST",
                  url: "<?= base_url()?>ajaxhandle/admin_menu_ajaxhandler/Update_Orders",
                  data: { id: id,orders: orders},
                  dataType: "json",
                  success: function(data) {
                    if(data == 0) {
                        notice('Đã có lỗi! Thực hiện lại sau.');
                    }else if(data == 1) {
                        element.defaultValue = orders;
                        notice('Đã thay đổi thứ tự hiển thị.');
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
            notice('Thứ tự phải là chữ số');
        }
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
                        if(action == 'delete') {
                            Delete_Menu(id);
                        }
                        $('body').css('overflow','auto');
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

    function Delete_Menu(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_menu",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa menu thành công!');
                  $('#menu'+id).fadeOut(400);
                }else {
                  notice(data.msg);
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