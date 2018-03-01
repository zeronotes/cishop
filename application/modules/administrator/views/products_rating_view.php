<div class="grid_12">
	<div class="header-content"><img src="<?= base_url()?>resources/ui_images/background/rating.png"></div>
    <div class="clear"></div>
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
	        			<th style="width:120px;text-align:left;">Tên sản phẩm</th>
	        			<th>Điểm chất lượng</th>
	        			<th>Nhận xét</th>
                <th>Ngày nhận xét</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($rating_list) > 0 ) {?>
  	        		<?php $i = 1; foreach ($rating_list as $key) :?>
  		        		<tr id="rating<?= $key['ProductsRatingID']?>" <?php if($key['UnRead'] == 1) echo 'class="unread"'?>>
  		        			<td align="center" style="width:20px;text-align:center;"><?= $i?></td>
  		        			<td align="center" style="width:180px;text-align:left;"><a id="txtCateNewsTitle<?= $key['ProductsID']?>" href="<?= base_url()?>administrator/categories/news/edit/<?= $key['ProductsID']?>"><?= $key['Title']?></a></td>
  		        			<td align="center" style="width:100px;text-align:center;"><?= $key['Marks']?></td>
  		        			<td><?= $key['Comments']?></td>
  		        			<td align="center" style="width:120px;text-align:center;"><?= $key['CreatedDate']?></td>
                    <td align="center" style="width:50px;text-align:center;"><a onclick="showconfirm(<?= $key['ProductsRatingID']?>,'Xác thực xóa đánh giá','Bạn có chắc muốn xóa đánh giá sản phẩm này?','delete')">xóa</a></td>
  		        		</tr>
  		        	<?php $i++; endforeach;?>
              <?php }else {?>
                  <tr>
                    <td colspan="6">Chưa có đánh giá nào cả</td>
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
                            delete_rating(id)
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

    function delete_rating(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_products_rating/"+id,
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else {
                  notice('Xóa đánh giá thành công!');
                  $('#rating'+id).fadeOut(400);
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