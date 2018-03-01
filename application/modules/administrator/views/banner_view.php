<div class="grid_12">
	<div class="header-content">Quản lý banner trang chủ</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/banners/add">Thêm mới</a></span>
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
                          <td> <b>Tiêu đề</b>
                            <input name="key" value="<?php if($this -> input -> get('key')) echo $this -> input -> get('key');?>" type="text" id="txtSearch" style="width:200px;">          
                            &nbsp;&nbsp;
                          </td>
                          <td>
                            &nbsp;&nbsp;
                            <a class="linkbtn" onclick="javascript:submit();">Tìm kiếm</a></td>
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
                <th>Ảnh</th>
	        			<th>Tiêu đề</th>
                <th>Thứ tự</th>
	        			<th>Hiển thị</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($banners_list) > 0 ) {?>
  	        		<?php $i = 1; foreach ($banners_list as $key) :?>
  		        		<tr id="banner<?= $key['BannerID']?>">
  		        			<td align="center" style="width:20px;text-align:center;"><?= $i?></td>
  		        			<td style="width:120px;text-align:center;"><img src="<?= base_url();?>resources/uploads/images/automatic/thumbs/<?= $key['ImageURL']?>" height="70" width="120" /></td>
                    <td style="text-align:left;"><?= $key['Title']?></td>
                    <td align="center" style="width:60px;text-align:center;"><input type="text"  id="txtOrders<?= $key['BannerID']?>" style="width: 60px; text-align:right;" value="<?= $key['Orders']?>"  onchange="UpdateOrders(<?= $key['BannerID']?>,this);"/></td>
  		        			<td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['BannerID']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['BannerID']?>);"/></td>
  		        			<td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/banners/edit/<?= $key['BannerID']?>">Chỉnh sửa</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['BannerID']?>,'Xác thực xóa banner','Bạn có chắc muốn xóa banner này?','delete');">xóa</a></td>
  		        		</tr>
  		        	<?php $i++; endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="6">Chưa có banner nào cả</td>
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
        <span><a href="<?= base_url()?>administrator/banners/add">Thêm mới</a></span>
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
                            Delete_banner(id);
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

    function UpdatePublishStatus(id) {
      var Publish;
      if($("#cbIsVisible"+id).attr('checked')){
        Publish = 1;  
      }else {
        Publish = 0;
      }
      $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_publish_banner",
            data: { id: id,publish: Publish},
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
              url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_orders_banner",
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

    function Delete_banner(id) {
      $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_banner",
            data: { id: id},
            dataType: "json",
            success: function(data) {
              if(data == 0) {
                notice('Đã có lỗi! Thực hiện lại sau.');
              }else if(data == 1) {
                notice("Đã xóa thành công.");
                $('#banner'+id).fadeOut();
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