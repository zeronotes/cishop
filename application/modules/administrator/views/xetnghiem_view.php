<div class="grid_12">
	<div class="header-content">Danh sách xét nghiệm</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/xetnghiem">Quay lại danh sách</a></span>
        <span><a href="<?= base_url()?>administrator/xetnghiem/add">Thêm mới</a></span>
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
                          <td> <b>Họ tên</b>
                            <input name="key" value="<?php if($this -> input -> get('key')) echo $this -> input -> get('key');?>" type="text" id="txtSearch" style="width:200px;">
                            &nbsp;&nbsp; <b>Mã xét nghiệm</b>
                            &nbsp;
                          </td>
                          <td>
                            <input name="dicode" value="<?php if($this -> input -> get('dicode')) echo $this -> input -> get('dicode');?>" type="text" id="txtSearch" style="width:200px;">
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
          <!-- <div id="small-tool-bar">
            <ul>
              <li><a href="<?= base_url()?>administrator/xetnghiem/trash" class="small-btn trash">Thùng rác</a></li>
            </ul>
          </div> -->
        </div>
        <div style="padding:1px;">
          <form id="formPost" method="post" name="formPost" accept-charset="utf-8">
          	<table class="table-view">
  	        	<thead>
  	        		<tr>
                  <th>#</th>
  	        			<th>Ảnh</th>
  	        			<th>Họ tên</th>
                  <th>Mã xét nghiệm</th>
                  <th>File</th>
  	        			<th>Ngày đăng</th>
  	        			<th></th>
  	        		</tr>
  	        	</thead>

  	        	<tbody>
                <?php if(!empty($xetnghiem_list) ) {?>
    	        		<?php $i = 1; foreach ($xetnghiem_list as $key) :?>
    		        		<tr class="xetnghiem" id="xetnghiem<?= $key['Id']?>">
                      <td align="center" style="width:20px;text-align:center;"><?= $i?></td>
    		        			<td align="center" style="width:20px;text-align:center;"><img height="80" width="80" src="<?= base_url()?>resources/uploads/images/thumbs/<?= $key['anh_xet_nghiem']?>"></td>
    		        			<td><a id="txtNewsTitle<?= $key['Id']?>" href="<?= base_url()?>administrator/xetnghiem/edit/<?= $key['Id']?>"><?= $key['ho_ten']?></a></td>
                      <td align="center" style="width:120px;text-align:center;"><?= $key['ma_xet_nghiem']?></td>
                      <td align="center" style="width:120px;text-align:center;"><a target="_blank" href="<?= base_url()?>resources/uploads/files/<?= $key['attachment_file']?>">Tải</a></td>
    		        			<td align="center" style="width:120px;text-align:center;"><?= $key['CreatedDate']?></td>
    		        			<td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/xetnghiem/edit/<?= $key['Id']?>">Chỉnh sửa</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['Id']?>,'Xác thực xóa tin tức','Bạn có chắc muốn xóa tin tức này?','delete');">xóa</a></td>
    		        		</tr>
    		        	<?php $i++; endforeach;?>
                <?php }else {?>
                    <tr>
                      <td colspan="7">Chưa có xét nghiệm nào cả</td>
                    </tr>
                <?php }?>
  	        	</tbody>

  	        	<tfoot>

  	        	</tfoot>
  	        </table>
          </form>
	    </div>
      <div class="wrap-page-link">
        <div class="page-link"><?= $link?></div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/xetnghiem">Quay lại danh sách</a></span>
        <span><a href="<?= base_url()?>administrator/xetnghiem/add">Thêm mới</a></span>
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
                            Delete_xetnghiem(id);
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

    function Delete_xetnghiem(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_xetnghiem_ajaxhandler/delete",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa thành công!');
                  $('#xetnghiem'+id).fadeOut(400);
                }else if(data.msg != "") {
                  notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }
//]]>
</script>