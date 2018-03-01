<div class="grid_12">
	<div class="header-content">Danh sách tin tức</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/news/add">Thêm mới</a></span>
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
                          <li><a href="javascript:void(0);" onclick="showconfirm('','Xác thực xóa tạm','Thông tin này sẽ được lưu trong bộ nhớ tạm!','trashChk')">Xóa tạm</a></li>
                          <li><a href="javascript:void(0);" onclick="showconfirm('','Xác thực xóa vĩnh viễn','Bạn có chắc muốn xóa vĩnh viễn?','deleteChk')">Xóa vĩnh viễn</a></li>
                        </ul>
                      </div>
                    </th>
  	        			<th>Tiêu đề</th>
  	        			<th style="width:120px;text-align:left;">Danh mục tin</th>
                  <th>Hiển thị</th>
                  <th>Tiêu biểu</th>
                  <!-- <th>Banner</th> -->
                  <th>Thứ tự</th>
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
    		        			<td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['NewsID']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['NewsID']?>);"/></td>
                      <td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsHot<?= $key['NewsID']?>" <?php if($key['IsHot'] == 1) echo 'checked="checked"'?> onclick="UpdateHotStatus(<?= $key['NewsID']?>);"/></td>
                      <!-- <td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsBanner<?= $key['NewsID']?>" <?php if($key['IsBanner'] == 1) echo 'checked="checked"'?> onclick="UpdateBannerStatus(<?= $key['NewsID']?>);"/></td> -->
                      <td align="center" style="width:70px;text-align:center;"><input type="text" id="txtNewsOrders<?= $key['NewsID']?>" style="width: 60px; text-align:right;" value="<?= $key['Orders']?>" onchange="UpdateOrders(<?= $key['NewsID']?>,this);"/></td>
                      <td align="center" style="width:120px;text-align:center;"><?= $key['CreatedDate']?></td>
    		        			<td align="center" style="width:150px;text-align:center;"><a href="<?= base_url()?>administrator/news/edit/<?= $key['NewsID']?>">Chỉnh sửa</a> | <a href="<?= base_url()?>administrator/news/clone/<?= $key['NewsID']?>">Nhân bản</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['NewsID']?>,'Xác thực xóa tin tức','Bạn có chắc muốn xóa tin tức này?','delete');">xóa</a></td>
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

            function TrashChk() {
              $('#chkTickAll').prop("checked", false);
              $("#menu-trigger").removeClass("open");
              $("#menu-trigger").removeAttr('onclick');
              $(".action-menu").hide();
              funcName = "Trash_news_chk";
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
        <span><a href="<?= base_url()?>administrator/news/add">Thêm mới</a></span>
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
          url: "<?= base_url()?>ajaxhandle/admin_news_ajaxhandler/Update_Publish",
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
          url: "<?= base_url()?>ajaxhandle/admin_news_ajaxhandler/Update_IsHot",
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

  // function UpdateBannerStatus(id) {
  //   var IsBanner;
  //   if($("#cbIsBanner"+id).attr('checked')){
  //     IsBanner = 1;  
  //   }else {
  //     IsBanner = 0;
  //   }
  //   $.ajax( {
  //         type: "POST",
  //         url: "<?= base_url()?>ajaxhandle/admin_news_ajaxhandler/Update_IsBanner",
  //         data: { id: id,IsBanner: IsBanner},
  //         dataType: "json",
  //         success: function(data) {
  //           if(data == 0) {
  //             notice('Đã có lỗi! Thực hiện lại sau.');
  //           }else if(data == 1) {
  //             notice("Đã cập nhật trạng thái hiển thị.");
  //           }else {
  //             notice(data.msg);
  //           }
  //         },
  //         error: function(XMLHttpRequest, textStatus, errorThrown) {
  //           notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
  //         }
  //   });
  // }

  function UpdateOrders(id,element) {
        var orders = $("#txtNewsOrders"+id).val();
        if(!isNaN(orders)) {
            $.ajax( {
                  type: "POST",
                  url: "<?= base_url()?>ajaxhandle/admin_news_ajaxhandler/Update_Orders",
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
            $("#txtNewsOrders"+id).val(element.defaultValue);
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
                            Delete_News(id);
                        }else if(action == 'deleteChk') {
                            DeleteChk();
                        }else if(action == 'trashChk') {
                            TrashChk();
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