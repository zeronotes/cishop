<div class="grid_12">
	<div class="header-content">Quản lý logo</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/logo/add">Thêm mới</a></span>
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
	        			<th>Tiêu đề</th>
	        			<th>Mô tả</th>
                <th>Hiển thị</th>
	        			<th>Ngày đăng</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($logo_list) > 0 ) {?>
  	        		<?php $i = 1; foreach ($logo_list as $key) :?>
  		        		<tr id="logo<?= $key['LogosID']?>">
  		        			<td align="center" style="width:20px;text-align:center;"><?= $i?></td>
  		        			<td style="width:60px;text-align:center;"><img src="<?= base_url();?>resources/uploads/images/automatic/thumbs/<?= $key['ImageURL']?>" height="30" widt="50" /></td>
                    <td style="width:160px;text-align:left;"><?= $key['Title']?></td>
  		        			<td align="center" ><?= $key['Description']?></td>
  		        			<td style="width:60px;text-align:center;"><input type="radio" name="mainimg" <?php if($key['IsMain'] == 1) echo "checked";?> onclick="Update_main_logo(<?= $key['LogosID']?>)"/></td>
                    <td align="center" style="width:120px;text-align:center;"><?= $key['CreatedDate']?></td>
  		        			<td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/logo/edit/<?= $key['LogosID']?>">Chỉnh sửa</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['LogosID']?>,'Xác thực xóa logo','Bạn có chắc muốn xóa logo này?','delete');">xóa</a></td>
  		        		</tr>
  		        	<?php $i++; endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="7">Chưa có logo nào cả</td>
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
        <span><a href="<?= base_url()?>administrator/logo/add">Thêm mới</a></span>
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
                            Delete_logo(id);
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

    function Delete_logo(id) {
      $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_logo",
            data: { id: id},
            dataType: "json",
            success: function(data) {
              if(data == 0) {
                notice('Đã có lỗi! Thực hiện lại sau.');
              }else if(data == 1) {
                notice("Đã xóa thành công.");
                $('#logo'+id).fadeOut();
              }else {
                notice(data.msg);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
      });
    }

    function Update_main_logo(id) {
      $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_main_logo",
            data: { id: id},
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