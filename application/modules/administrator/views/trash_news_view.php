<div class="grid_12">
	<div class="header-content">Thùng rác<!-- <img src="<?= base_url()?>resources/ui_images/admin/background/news_list.png"> --></div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/news">Quay lại danh sách</a></span>
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
                            &nbsp;&nbsp; <b>Danh mục</b>
                            &nbsp;
                          </td>
                          <td>
                            <select name="cate" id="ddlCate" style="width:200px;">
                              <option selected="selected" value="">Tất cả</option> 
                              <?php foreach ($categoriesnews_list as $key) :?> 
                                <option <?php if($this -> input -> get('cate') && $this -> input -> get('cate') == $key['CategoriesNewsID']) echo 'selected';?> value="<?= $key['CategoriesNewsID']?>"><?= $key['Title']?></option>
                              <?php endforeach;?>
                            </select>
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
          <form id="formPost" method="post" name="formPost" accept-charset="utf-8">
          	<table class="table-view">
  	        	<thead>
  	        		<tr>
  	        			<th class="th-chkAll">
                      <input type="checkbox" value="1" id="chkTickAll" onclick="CheckAll();"/>
                      <a href="javascript:void(0);" id="menu-trigger" class="">
                        <span class="arrow"></span>
                      </a>
                      <div class="action-menu">
                        <ul>
                          <li><a href="javascript:void(0);" onclick="showconfirm('','Xác thực khôi phục','Bản ghi này sẽ được khôi phục lại!','restoreChk')">Khôi phục</a></li>
                          <li><a href="javascript:void(0);" onclick="showconfirm('','Xác thực xóa vĩnh viễn','Bạn có chắc muốn xóa vĩnh viễn?','deleteChk')">Xóa vĩnh viễn</a></li>
                        </ul>
                      </div>
                    </th>
  	        			<th>Tiêu đề</th>
  	        			<th style="width:120px;text-align:left;">Danh mục tin</th>
  	        			<th>Ngày đăng</th>
  	        			<th></th>
  	        		</tr>
  	        	</thead>

  	        	<tbody>
                <?php if(count($news_list) > 0 ) {?>
    	        		<?php $i = 1; foreach ($news_list as $key) :?>
    		        		<tr class="news" id="news<?= $key['NewsID']?>">
    		        			<td align="center" style="width:20px;text-align:center;"><input type="checkbox" class="selectedId" name="Chk[]" value="<?= $key['NewsID']?>" id="chkTick<?= $key['NewsID']?>" onclick="ChkTick(<?= $key['NewsID']?>);"/></td>
    		        			<td><a id="txtNewsTitle<?= $key['NewsID']?>" href="<?= base_url()?>administrator/news/edit/<?= $key['NewsID']?>"><?= $key['Title']?></a></td>
    		        			<td align="center" style="width:120px;text-align:left;"><a href="<?= base_url()?>administrator/categories/news/edit/<?= $key['CategoriesNewsID']?>"><?= $key['CateTitle']?></a></td>
    		        			<td align="center" style="width:120px;text-align:center;"><?= $key['CreatedDate']?></td>
    		        			<td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/news/edit/<?= $key['NewsID']?>">Chỉnh sửa</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['NewsID']?>,'Xác thực xóa tin tức','Bạn có chắc muốn xóa tin tức này?','delete');">xóa</a></td>
    		        		</tr>
    		        	<?php $i++; endforeach;?>
                <?php }else {?>
                    <tr>
                      <td colspan="5">Chưa có tin tức nào cả</td>
                    </tr>
                <?php }?>
  	        	</tbody>

  	        	<tfoot>

  	        	</tfoot>
  	        </table>
          </form>
          <script type="text/javascript">
            function CheckAll() {
              $(".selectedId").attr('checked', $("#chkTickAll").is(":checked"));
              if($('.selectedId').filter(":checked").length > 0 ) {
                $("#menu-trigger").attr('onclick','ShowActinMenu();');
                $("table.table-view tbody tr.news td").css('background-color','#F0F0F0');
              }else {
                $("#menu-trigger").removeAttr('onclick');
                $(".action-menu").hide();
                $("table.table-view tbody tr.news td").css('background-color','');
              }

            }

            function ChkTick(id) {

              if($('.selectedId').filter(":checked").length > 0 && $("#chkTick"+id).is(":checked")) {
                $("#menu-trigger").attr('onclick','ShowActinMenu();');
                $("table.table-view tbody tr#news"+id+" td").css('background-color','#F0F0F0');
              }else if($('.selectedId').filter(":checked").length == 0 && !$("#chkTick"+id).is(":checked")){
                $("#menu-trigger").removeAttr('onclick');
                $(".action-menu").hide();
                $("table.table-view tbody tr#news"+id+" td").css('background-color','');
              }else {
                $(".action-menu").hide();
                $("table.table-view tbody tr#news"+id+" td").css('background-color','');
              }

              var check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
              $('#chkTickAll').prop("checked", check);
            }

            function ShowActinMenu() {
              if ($(".action-menu").is(":visible"))
              {
                $(".action-menu").slideUp(100);
                $("#menu-trigger").removeClass("open");
              }
              else
              {
                $(".action-menu").slideDown(100);
                $("#menu-trigger").addClass("open");
              }
            }

            var funcName = "";

            function DeleteChk() {
              $('#chkTickAll').prop("checked", false);
              $("#menu-trigger").removeClass("open");
              $("#menu-trigger").removeAttr('onclick');
              $(".action-menu").hide();
              funcName = "Delete_news_chk";
              $("#formPost").submit();
            }

            function RestoreChk() {
              $('#chkTickAll').prop("checked", false);
              $("#menu-trigger").removeClass("open");
              $("#menu-trigger").removeAttr('onclick');
              $(".action-menu").hide();
              funcName = "Restore_news_chk";
              $("#formPost").submit();
            }

            function temp() {
              var form = document.formPost;

              var dataString = $(form).serialize();

              $.ajax({
                  type:'POST',
                  url:'<?= base_url()?>ajaxhandle/admin_ajaxhandler/'+funcName,
                  data: dataString,
                  dataType: 'json',
                  success: function(data){
                      $.each(data.array, function(i, item) {
                        $("#news"+item).remove();
                      });

                      notice(data.msg);
                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                      notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
                  }
              });
            }

            $('form#formPost').submit(function(){
              temp();
              return false;
            });
          </script>

          <script type="text/javascript">
              var lastChecked = null;

              $(document).ready(function() {
                  var $chkboxes = $('.selectedId');
                  $chkboxes.click(function(e) {
                      if(!lastChecked) {
                          lastChecked = this;
                          return;
                      }

                      if(e.shiftKey) {
                          var start = $chkboxes.index(this);
                          var end = $chkboxes.index(lastChecked);

                          $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).css('background-color','#F0F0F0');

                          $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).attr('checked', lastChecked.checked);
                      }

                      lastChecked = this;
                  });
              });
          </script>
	    </div>
      <div class="wrap-page-link">
        <div class="page-link"><?= $link?></div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/news">Quay lại danh sách</a></span>
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
                            Delete_News(id);
                        }else if(action == 'deleteChk') {
                            DeleteChk();
                        }else if(action == 'restoreChk') {
                            RestoreChk();
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

    function Delete_News(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_news",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa tin tức thành công!');
                  $('#news'+id).fadeOut(400);
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