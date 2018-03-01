<div class="grid_12">
	<div class="header-content">Quản lý FavIcon</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/favicons/add">Thêm mới</a></span>
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
                <th>Icon</th>
	        			<th>Hiển thị</th>
	        			<th>Ngày khởi tạo</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($favicon_list) > 0 ) {?>
  	        		<?php $i = 1; foreach ($favicon_list as $key) :?>
  		        		<tr id="favicon<?= $key['FaviconsID']?>">
                    <td align="center" style="width:20px;text-align:center;"><?= $i?></td>
                    <td align="center" style="text-align:center;"><img src="<?= base_url()?>resources/uploads/images/automatic/thumbs/<?= $key['IconURL']?>" height="48" width="48" /></td>
                    <td style="width:60px;text-align:center;"><input type="radio" name="IsMain" <?php if($key['IsMain'] == 1) echo "checked";?> onclick="Update_main_favicon(<?= $key['FaviconsID']?>)"/></td>
                    <td align="center" style="text-align:center;width:110px;"><?= $key['CreatedDate']?></td>
                    <td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/favicons/edit/<?= $key['FaviconsID']?>">Chỉnh sửa</a> | <a href="javacript:voi(0);" onclick="showconfirm(<?= $key['FaviconsID']?>,'Xác thực xóa Icon','Bạn có chắc muốn xóa icon này?','delete');">xóa</a></td>
                  </tr>
  		        	<?php $i++; endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="5">Chưa có favicon nào cả</td>
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
        <span><a href="<?= base_url()?>administrator/favicons/add">Thêm mới</a></span>
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
                            Delete_favicon(id);
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

    function Delete_favicon(id) {
      $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_favicon",
            data: { id: id},
            dataType: "json",
            success: function(data) {
              if(data == 0) {
                notice('Đã có lỗi! Thực hiện lại sau.');
              }else if(data == 1) {
                notice("Đã xóa thành công.");
                $('#favicon'+id).fadeOut();
              }else {
                notice(data.msg);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
      });
    }

    function Update_main_favicon(id) {
      $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_main_favicon",
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