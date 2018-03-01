<div class="grid_12">
	<div class="header-content">Nhóm quảng cáo (Không nên Thêm mới/Cập nhật/Xóa)</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/categories/ads/add">Thêm mới</a></span>
    </div>
    <div class="clear"></div>
    <div class="wrap-main-body">
      	<div class="wrap-page-link">
          <div class="page-link"><?= $link?></div>
        </div>
        <div style="padding:1px;">
        	<table class="table-view">
	        	<thead>
	        		<tr>
	        			<th>#</th>
	        			<th >Tên nhóm</th>
	        			<th>Ngày khời tạo</th>
	        			<th>Người khởi tạo</th>
                <th>Ngày chỉnh sửa</th>
                <th>Người chỉnh sửa</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($adsgroups_list) > 0 ) {?>
  	        		<?php $i = 1; foreach ($adsgroups_list as $key) :?>
  		        		<tr id="adsgroups<?= $key['AdsGroupsID']?>">
  		        			<td align="center" style="width:20px;text-align:center;"><?= $i?></td>
  		        			<td align="center" style="text-align:left;"><?= $key['Title']?></td>
                    <td align="center" style="text-align:center;width:110px;"><?= $key['CreatedDate']?></td>
                    <td align="center" style="text-align:center;width:110px;"><span class="lbl-key"><?php if($key['CreatedBy'] =='') echo '<span class="lbl-key-nan">Không xác định</span>'; else echo '<span class="lbl-key">'.$key['CreatedBy'].'</span>';?></span></td>
                    <td align="center" style="text-align:center;width:110px;"><?php if($key['ModifiedDate'] =='') echo '<span class="lbl-key-nan">Chưa từng sửa</span>'; else echo '<span class="lbl-key">'.$key['ModifiedDate'].'</span>';?></td>
                    <td align="center" style="text-align:center;width:110px;"><?php if($key['ModifiedBy'] =='') echo '<span class="lbl-key">Không xác định</span>'; else echo '<span class="lbl-key">'.$key['ModifiedBy'].'</span>';?></td>
  		        			<td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/categories/ads/edit/<?= $key['AdsGroupsID']?>">Chỉnh sửa</a> | <a href="javacript:voi(0);" onclick="showconfirm(<?= $key['AdsGroupsID']?>,'Xác thực xóa nhóm quảng cáo','Bạn có chắc muốn xóa nhóm quảng cáo này?','delete');">xóa</a></td>
  		        		</tr>
  		        	<?php $i++; endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="7">Chưa có nhóm quảng cáo nào cả</td>
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
        <span><a href="<?= base_url()?>administrator/categories/ads/add">Thêm mới</a></span>
    </div>
</div>

<script type="text/javascript">
 //<![CDATA[

	function showconfirm(id,title,message,action){
        $('body').css('overflow','hidden');
        $.confirm({
            'title'     : title,
            'message'   : message,
            'buttons'   : {
                'Yes'   : {
                    'class' : 'blue',
                    'action': function(){
                        if(action == 'delete') {
                            Delete_Ads_Groups(id);
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

    function Delete_Ads_Groups(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_ads_groups/"+id,
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa nhóm quảng Quảng cáo thành công!');
                  $('#adsgroups'+id).fadeOut(400);
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