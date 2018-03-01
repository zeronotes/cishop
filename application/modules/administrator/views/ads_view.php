<div class="grid_12">
	<div class="header-content">Danh sách quảng cáo</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/ads/add">Thêm mới</a></span>
    </div>
    <div class="clear"></div>
    <div class="wrap-main-body">
        <div>
          <form method="get" id="form-search" accept-charset="utf-8">
            <table border="0" width="100%" style="border-collapse: collapse; margin:5px 0px;">
              <tbody>
                <tr>
                  <td colspan="2">
                    <table class="SearchForm">
                      <tbody>
                        <tr>
                          <td> <b>Quảng cáo</b>
                            <input name="key" value="<?php if($this -> input -> get('key')) echo $this -> input -> get('key');?>" type="text" id="txtSearch" style="width:200px;">          
                            &nbsp;&nbsp; <b>Nhóm quảng cáo</b>
                            &nbsp;
                          </td>
                          <td>
                            <select name="cate" id="ddlCate" style="width:200px;">
                              <option selected="selected" value="">Tất cả</option> 
                              <?php foreach ($adsgroups_list as $key) :?>
                                  <option <?php if($this -> input -> get('cate') && $this -> input -> get('cate') == $key['AdsGroupsID']) echo 'selected';?> value="<?= $key['AdsGroupsID']?>"><?= $key['Title']?></option>
                              <?php endforeach;?>
                            </select>
                            &nbsp;&nbsp;
                            <a class="linkbtn" onclick="javascript:ohyeahF();">Tìm kiếm</a></td>
                        </tr>
                        <script type="text/javascript">
                          function ohyeahF() {
                            $('form#form-search').submit();
                          }
                        </script>
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
	        			<!-- <th>Cao</th>
	        			<th>Dài</th> -->
                <th>Thứ tự</th>
	        			<th>Hiển thị</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($ads_list) > 0 ) {?>
  	        		<?php $i = 1; foreach ($ads_list as $key) :?>
  		        		<tr id="ad<?= $key['AdsID']?>">
  		        			<td align="center" style="width:20px;text-align:center;"><?= $i?></td>
  		        			<td align="center" style="text-align:center;"><img src="<?= base_url()?>resources/uploads/images/automatic/thumbs/<?= $key['ImageURL']?>" width="150"/></td>
  		        			<td><a id="txtPrdName<?= $key['AdsID']?>" href="<?= base_url()?>administrator/ads/edit/<?= $key['AdsID']?>"><?= $key['Title']?></a></td>
  		        			<!-- <td align="center" style="width:100px;text-align:center;"><input type="text" id="txtHeight<?= $key['AdsID']?>" style="width: 60px; text-align:right;" value="<?= $key['Height']?>" onchange="UpdateHeight(<?= $key['AdsID']?>,this);"/></td>
  		        			<td align="center" style="width:70px;text-align:center;"><input type="text" id="txtWidth<?= $key['AdsID']?>" style="width: 60px; text-align:right;" value="<?= $key['Width']?>" onchange="UpdateWidth(<?= $key['AdsID']?>,this);"/></td> -->
  		        			<td align="center" style="width:60px;text-align:center;"><input type="text"  id="txtOrders<?= $key['AdsID']?>" style="width: 60px; text-align:right;" value="<?= $key['Orders']?>"  onchange="UpdateOrders(<?= $key['AdsID']?>,this);"/></td>
                    <td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['AdsID']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['AdsID']?>);"/></td>
  		        			<td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/ads/edit/<?= $key['AdsID']?>">Chỉnh sửa</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['AdsID']?>,'Xác thực xóa quảng cáo','Bạn có chắc muốn xóa quảng cáo này?','delete');">xóa</a></td>
  		        		</tr>
  		        	<?php $i++; endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="8">Chưa có quảng cáo nào cả</td>
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
        <span><a href="<?= base_url()?>administrator/ads/add">Thêm mới</a></span>
    </div>
</div>

<script type="text/javascript">
 //<![CDATA[
	function UpdatePublishStatus(id) {
		var Publish;
		if($("#cbIsVisible"+id).attr('checked')){
			Publish = 1;	
		}else {
			Publish = 0;
		}
		$.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_ads_publish",
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

	function UpdateaaaHeight(id) {
		var height = $("#txtHeight"+id).val();
		$.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_ads_height",
          data: { id: id,height: height},
          dataType: "json",
          success: function(data) {
          	if(data == 0) {
          		notice('Đã có lỗi! Thực hiện lại sau.');
          	}else if(data == 1) {
              notice('Đã cập nhật mã sản phẩm.');
            }else {
              notice(data.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
          }
    });
	}

	function UpdateHeight(id,element) {
		var height = $("#txtHeight"+id).val();
    if(!isNaN(height)) {
  		$.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_ads_height",
            data: { id: id,height: height},
            dataType: "json",
            success: function(data) {
            	if(data == 0) {
            		notice('Đã có lỗi! Thực hiện lại sau.');
            	}else if(data == 1) {
                element.defaultValue = height;
                notice('Đã cập nhật chiều cao.');
              }else {
                notice(data.msg);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
      });
    }else {
      $("#txtHeight"+id).val(element.defaultValue);
      notice('Chiều cao phải là chữ số.');
    }
	}

	function UpdateWidth(id,element) {
		var width = Number($("#txtWidth"+id).val());
    if(!isNaN(width)) {
  		$.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_ads_width",
            data: { id: id,width: width},
            dataType: "json",
            success: function(data) {
            	if(data == 0) {
            		notice('Đã có lỗi! Thực hiện lại sau.');
            	}else if(data == 1) {
                element.defaultValue = width;
                notice('Đã cập nhật chiều dài.');
              }else {
                notice(data.msg);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
      });
    }else {
      $("#txtWidth"+id).val(element.defaultValue);
      notice('Chiều dài phải là chữ số.');
    }
	}

  function UpdateOrders(id,element) {
    var orders = Number($("#txtOrders"+id).val());
    if(!isNaN(orders)) {
      $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_ads_orders",
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
                            Delete_Ads(id);
                            $('body').css('overflow','auto');
                        }
                        if(action == 'update') {
                            update_schedule(id);
                        }
                        if(action == 'create') {
                            create_schedule();
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

    function Delete_Ads(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_ads/"+id,
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else {
                  notice('Xóa Quảng cáo thành công!');
                  $('#ad'+id).fadeOut(400);
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