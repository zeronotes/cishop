<div class="grid_12">
	<div class="header-content">Danh sách sản phẩm</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/products">Quay lại danh sách</a></span>
        <span><a href="<?= base_url()?>administrator/products/add">Thêm mới</a></span>
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
                          <td>
                            <b>Tên hoặc mã SP</b>
                            <input name="key" value="<?php if($this -> input -> get('key')) echo $this -> input -> get('key');?>" type="text" id="txtSearch" style="width:200px;">          
                            &nbsp;&nbsp; <b>Danh mục</b>
                            &nbsp;
                            <select name="cate" id="ddlCate" style="width:200px;">
                              <option selected="selected" value="">Tất cả</option> 
                              <?php foreach ($categories_list as $key) :?>
                                  <option <?php if($this -> input -> get('cate') && $this -> input -> get('cate') == $key['CategoriesProductsID']) echo 'selected';?> value="<?= $key['CategoriesProductsID']?>"><?= $key['Title']?></option>
                              <?php endforeach;?>
                            </select>
                            &nbsp;&nbsp; <b>Thương hiệu</b>
                            &nbsp;
                            <select name="brand" id="ddlBrand" style="width:200px;">
                              <option selected="selected" value="">Tất cả</option> 
                              <?php foreach ($brand_list as $key) :?>
                                  <option <?php if($this -> input -> get('brand') && $this -> input -> get('brand') == $key['SortingBrandID']) echo 'selected';?> value="<?= $key['SortingBrandID']?>"><?= $key['Title']?></option>
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
	        			<th>Sản phẩm</th>
                <th>Mã SP</th>
                <th>Mới</th>
                <th>Nổi bật</th>
                <th>Bán chạy</th>
                <th>Khuyến mãi</th>
                <th>Còn hàng</th>
	        			<th>Hiển thị</th>
                <th>Thứ tự</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($products_list) > 0 ) {?>  
  	        		<?php $i = 1; foreach ($products_list as $key) :?>
  		        		<tr id="Row<?= $key['ProductsID']?>">
  		        			<td align="center" style="width:20px;text-align:center;"><?= $i?></td>
  		        			<td align="center" style="width:60px;text-align:center;"><img src="<?= base_url()?>resources/uploads/images/automatic/thumbs/<?= $key['ImageURL']?>" height="30" width="50"/></td>
  		        			<td><a id="txtPrdName<?= $key['ProductsID']?>" href="<?= base_url()?>administrator/products/edit/<?= $key['ProductsID']?>"><?= $key['Title']?></a></td>
  		        			<td><a id="txtSKU<?= $key['ProductsID']?>" href="<?= base_url()?>administrator/products/edit/<?= $key['ProductsID']?>"><?= $key['SKU']?></a></td>
                    <td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsNew<?= $key['ProductsID']?>" <?php if($key['IsNew'] == 1) echo 'checked="checked"'?> onclick="UpdateIsNew(<?= $key['ProductsID']?>);"/></td>
                    <td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsHot<?= $key['ProductsID']?>" <?php if($key['IsHot'] == 1) echo 'checked="checked"'?> onclick="UpdateIsHot(<?= $key['ProductsID']?>);"/></td>
                    <td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsSellers<?= $key['ProductsID']?>" <?php if($key['IsSellers'] == 1) echo 'checked="checked"'?> onclick="UpdateIsSellers(<?= $key['ProductsID']?>);"/></td>
                    <td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsPromotion<?= $key['ProductsID']?>" <?php if($key['IsPromotion'] == 1) echo 'checked="checked"'?> onclick="UpdateIsPromotion(<?= $key['ProductsID']?>);"/></td>
                    <td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsStock<?= $key['ProductsID']?>" <?php if($key['IsStock'] == 1) echo 'checked="checked"'?> onclick="UpdateIsStock(<?= $key['ProductsID']?>);"/></td>
                    <td align="center" style="width:60px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['ProductsID']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['ProductsID']?>);"/></td>
  		        			<td align="center" style="width:60px;text-align:center;"><input type="text" id="txtPrdOrders<?= $key['ProductsID']?>" style="width: 60px; text-align:right;" value="<?= $key['Orders']?>" onchange="UpdateOrders(<?= $key['ProductsID']?>,this);"/></td>
                    <td align="center" style="width:150px;text-align:center;"><a href="<?= base_url()?>administrator/products/edit/<?= $key['ProductsID']?>">Chỉnh sửa</a> | <a href="<?= base_url()?>administrator/products/clone/<?= $key['ProductsID']?>">Nhân bản</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['ProductsID']?>,'Xác thực xóa sản phẩm','Bạn có chắc muốn xóa sản phẩm này?','delete');">xóa</a></td>
  		        		</tr>
  		        	<?php $i++; endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="13">Chưa có sản phẩm nào cả</td>
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
        <span><a href="<?= base_url()?>administrator/products">Quay lại danh sách</a></span>
        <span><a href="<?= base_url()?>administrator/products/add">Thêm mới</a></span>
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
          url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Update_Publish",
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

  function UpdateOrders(id,element) {
        var orders = $("#txtPrdOrders"+id).val();
        if(!isNaN(orders)) {
            $.ajax( {
                  type: "POST",
                  url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Update_Orders",
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
            $("#txtPrdOrders"+id).val(element.defaultValue);
            notice('Thứ tự phải là chữ số');
        }
  }

  function UpdateIsNew(id) {
    var IsNew;
    if($("#cbIsNew"+id).attr('checked')){
      IsNew = 1;  
    }else {
      IsNew = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Update_IsNew",
          data: { id: id,IsNew: IsNew},
          dataType: "json",
          success: function(data) {
            if(data == 0) {
              notice('Đã có lỗi! Thực hiện lại sau.');
            }else if(data == 1) {
              notice("Đã cập nhật trạng thái Mới cho sản phẩm.");
            }else {
              notice(data.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
          }
    });
  }

  function UpdateIsHot(id) {
    var IsHot;
    if($("#cbIsHot"+id).attr('checked')){
      IsHot = 1;  
    }else {
      IsHot = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Update_IsHot",
          data: { id: id,IsHot: IsHot},
          dataType: "json",
          success: function(data) {
            if(data == 0) {
              notice('Đã có lỗi! Thực hiện lại sau.');
            }else if(data == 1) {
              notice("Đã cập nhật trạng thái Nổi bật cho sản phẩm.");
            }else {
              notice(data.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
          }
    });
  }

  function UpdateIsSellers(id) {
    var IsSellers;
    if($("#cbIsSellers"+id).attr('checked')){
      IsSellers = 1;  
    }else {
      IsSellers = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Update_IsSellers",
          data: { id: id,IsSellers: IsSellers},
          dataType: "json",
          success: function(data) {
            if(data == 0) {
              notice('Đã có lỗi! Thực hiện lại sau.');
            }else if(data == 1) {
              notice("Đã cập nhật trạng thái Bán chạy cho sản phẩm.");
            }else {
              notice(data.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
          }
    });
  }

  function UpdateIsPromotion(id) {
    var IsPromotion;
    if($("#cbIsPromotion"+id).attr('checked')){
      IsPromotion = 1;  
    }else {
      IsPromotion = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Update_IsPromotion",
          data: { id: id,IsPromotion: IsPromotion},
          dataType: "json",
          success: function(data) {
            if(data == 0) {
              notice('Đã có lỗi! Thực hiện lại sau.');
            }else if(data == 1) {
              notice("Đã cập nhật trạng thái Khuyến mãi cho sản phẩm.");
            }else {
              notice(data.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
          }
    });
  }

  function UpdateIsStock(id) {
    var IsStock;
    if($("#cbIsStock"+id).attr('checked')){
      IsStock = 1;  
    }else {
      IsStock = 0;
    }
    $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Update_IsStock",
          data: { id: id,IsStock: IsStock},
          dataType: "json",
          success: function(data) {
            if(data == 0) {
              notice('Đã có lỗi! Thực hiện lại sau.');
            }else if(data == 1) {
              notice("Đã cập nhật trạng thái Còn hàng cho sản phẩm.");
            }else {
              notice(data.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
          }
    });
  }

	function UpdateSKU(id) {
		var SKU = $("#txtSKU"+id).val();
		$.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/updateSKU",
          data: { id: id,SKU: SKU},
          dataType: "json",
          success: function(data) {
          	if(data == 0) {
          		notice('Đã có lỗi! Thực hiện lại sau.');
          	}else if(data == 1) {
              notice('Đã cập nhật mã.');
            }else {
              notice(data.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
          }
    });
	}

	function UpdateSellPrice(id,element) {
    //var txtPrdName = $('#txtPrdName'+id).val();
		var SellPrice = Number($("#txtSellPrice"+id).val());
    if(!isNaN(SellPrice)) {
  		$.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/updateSellPrice",
            data: { id: id,SellPrice: SellPrice},
            dataType: "json",
            success: function(data) {
            	if(data == 0) {
            		notice('Đã có lỗi! Thực hiện lại sau.');
            	}else if(data == 1) {
                element.defaultValue = SellPrice;
                notice('Đã cập nhật giá bán.');
              }else {
                notice(data.msg);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
      });
    }else {
      $("#txtSellPrice"+id).val(element.defaultValue);
      notice('Giá bán phải là chữ số.');
    }
	}

	function UpdateListPrice(id,element) {
		var ListPrice = Number($("#txtListPrice"+id).val());
    if(!isNaN(ListPrice)) {
  		$.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/updateListPrice",
            data: { id: id,ListPrice: ListPrice},
            dataType: "json",
            success: function(data) {
            	if(data == 0) {
            		notice('Đã có lỗi! Thực hiện lại sau.');
            	}else if(data == 1) {
                element.defaultValue = ListPrice;
                notice('Đã cập nhật giá cũ.');
              }else {
                notice(data.msg);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
      });
    }else {
      $("#txtListPrice"+id).val(element.defaultValue);
      notice('Giá cũ phải là chữ số.');
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
                            Delete_Products(id);
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

    function Delete_Products(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_products",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa sản phẩm thành công!');
                  $('#Row'+id).fadeOut(400);
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