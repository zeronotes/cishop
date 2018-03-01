<div class="grid_12">
	<div class="header-content">Danh mục tin tức</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/categories/news/add">Thêm mới</a></span>
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
	        			<th style="width:120px;text-align:left;">Tên danh mục</th>
	        			<th>Mô tả</th>
	        			<th>Hiển thị</th>
                <th>Cột chính</th>
                <th>Cột phụ</th>
                <th>Thứ tự</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($category_list) > 0 ) {?>
  	        		<?php $i = 1; foreach ($category_list as $key) :?>
  		        		<tr data-parentid="<?= $key['ParentID']?>" id="catenews<?= $key['CategoriesNewsID']?>">
  		        			<td align="center" style="width:20px;text-align:center;"><?php if($key['ParentID'] == 0) { echo $i; $i++;}?></td>
  		        			<td align="center" style="text-align:left;"><a id="txtCateNewsTitle<?= $key['CategoriesNewsID']?>" href="<?= base_url()?>administrator/categories/news/edit/<?= $key['CategoriesNewsID']?>"><?= $key['Title']?></a></td>
  		        			<td style="width:200px"><?= $key['Description']?></td>
  		        			<td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['CategoriesNewsID']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['CategoriesNewsID']?>);"/></td>
                    <td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsHot<?= $key['CategoriesNewsID']?>" <?php if($key['IsHot'] == 1) echo 'checked="checked"'?> onclick="UpdateHotStatus(<?= $key['CategoriesNewsID']?>);"/></td>
                    <td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsCool<?= $key['CategoriesNewsID']?>" <?php if($key['IsCool'] == 1) echo 'checked="checked"'?> onclick="UpdateCoolStatus(<?= $key['CategoriesNewsID']?>);"/></td>
  		        			<td align="center" style="width:70px;text-align:center;"><input type="text" id="txtCateNewsOrders<?= $key['CategoriesNewsID']?>" style="width: 60px; text-align:right;" value="<?= $key['Orders']?>" onchange="UpdateOrders(<?= $key['CategoriesNewsID']?>,this);"/></td>
                    <td align="center" style="width:150px;text-align:center;"><a href="<?= base_url()?>administrator/categories/news/edit/<?= $key['CategoriesNewsID']?>">Chỉnh sửa</a> | <a href="<?= base_url()?>administrator/categories/news/clone/<?= $key['CategoriesNewsID']?>">Nhân bản</a> | <a href="javascript:voi(0);" onclick="showconfirm(<?= $key['CategoriesNewsID']?>,'Xác thực xóa danh mục tin','Xóa danh mục tin đồng nghĩa với việc xóa tất cả tin tức thuộc danh mục tin này.<br/><br/>Bạn có chắc muốn xóa danh mục tin này?','delete')">xóa</a></td>
  		        		</tr>
  		        	<?php endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="6">Chưa có danh mục tin tức nào cả</td>
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
        <span><a href="<?= base_url()?>administrator/categories/news/add">Thêm mới</a></span>
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
          url: "<?= base_url()?>ajaxhandle/admin_news_categories_ajaxhandler/Update_Publish",
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

  function UpdateHotStatus(id) {
    var IsHot;
    if($("#cbIsHot"+id).attr('checked')){
      IsHot = 1;  
    }else {
      IsHot = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_news_categories_ajaxhandler/Update_IsHot",
          data: { id: id,IsHot: IsHot},
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

  function UpdateCoolStatus(id) {
    var IsCool;
    if($("#cbIsCool"+id).attr('checked')){
      IsCool = 1;  
    }else {
      IsCool = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_news_categories_ajaxhandler/Update_IsCool",
          data: { id: id,IsCool: IsCool},
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
        var orders = $("#txtCateNewsOrders"+id).val();
        if(!isNaN(orders)) {
            $.ajax( {
                  type: "POST",
                  url: "<?= base_url()?>ajaxhandle/admin_news_categories_ajaxhandler/Update_Orders",
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
                            Delete_Categories_News(id);
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

    function Delete_Categories_News(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_categories_news",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa Danh mục tin thành công!');
                  $('#catenews'+id).fadeOut(400);
                  $('tr[data-parentid="'+id+'""]').fadeOut(400);
                }else if(data.msg != "") {
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