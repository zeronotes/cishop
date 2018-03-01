<div class="grid_12">
	<div class="header-content">Danh sách khung giá</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/sorting/price/add">Thêm mới</a></span>
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
	        			<th style="width:120px;text-align:left;">Khung giá</th>
	        			<th>Hiển thị</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($category_list) > 0 ) {?>
  	        		<?php $i = 1; foreach ($category_list as $key) :?>
  		        		<tr data-parentid="<?= $key['ParentID']?>" id="sortingprice<?= $key['SortingPriceID']?>">
  		        			<td align="center" style="width:20px;text-align:center;"><?php if($key['ParentID'] == 0) { echo $i; $i++;}?></td>
  		        			<td align="center" style="text-align:left;">
                        Từ <input class="numberformat" type="text" id="txtPriceFrom<?= $key['SortingPriceID']?>" style="width: 60px; text-align:right;" value="<?= $key['PriceFrom']?>" onblur="UpdatePrice(<?= $key['SortingPriceID']?>,this);"/> đến <input class="numberformat" type="text" id="txtPriceTo<?= $key['SortingPriceID']?>" style="width: 60px; text-align:right;" value="<?= $key['PriceTo']?>" onblur="UpdatePrice(<?= $key['SortingPriceID']?>,this);"/>
                    </td>
  		        			<td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['SortingPriceID']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['SortingPriceID']?>);"/></td>
                    <td align="center" style="width:150px;text-align:center;"><a href="javascript:voi(0);" onclick="showconfirm(<?= $key['SortingPriceID']?>,'Xác thực xóa danh mục tin','Xóa danh mục tin đồng nghĩa với việc xóa tất cả tin tức thuộc danh mục tin này.<br/><br/>Bạn có chắc muốn xóa danh mục tin này?','delete')">xóa</a></td>
  		        		</tr>
  		        	<?php endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="5">Chưa có khung giá nào cả</td>
                  </tr>
              <?php }?>
	        	</tbody>

	        	<tfoot>

	        	</tfoot>
	        </table>
          <script>
            $('input.numberformat').number(true, 0, ',', '.' );
          </script>
	    </div>
      <div class="wrap-page-link">
        <div class="page-link"><?= $link?></div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/sorting/price/add">Thêm mới</a></span>
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
          url: "<?= base_url()?>ajaxhandle/sorting_price_ajaxhandler/Update_Publish",
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

  function UpdatePrice(id,element) {
    var pricefrom = $("#txtPriceFrom"+id).val();
    var priceto = $("#txtPriceTo"+id).val();
    if(!isNaN(pricefrom) && !isNaN(priceto)) {
        $.ajax( {
              type: "POST",
              url: "<?= base_url()?>ajaxhandle/sorting_price_ajaxhandler/Update_Price",
              data: { id: id,pricefrom: pricefrom,priceto: priceto},
              dataType: "json",
              success: function(data) {
                if(data == 0) {
                    notice('Đã có lỗi! Thực hiện lại sau.');
                }else if(data == 1) {
                    element.defaultValue = pricefrom;
                    notice('Đã thay đổi Giá thành công.');
                }else {
                  notice(data.msg);
                }
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                    notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
              }
        });
    }else {
        $("#txtPriceFrom"+id).val(element.defaultValue);
        notice('Giá trị phải là chữ số');
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
                            Delete_Sorting_Price(id);
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

    function Delete_Sorting_Price(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_sorting_price",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa khung giá thành công!');
                  $('#sortingprice'+id).fadeOut(400);
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