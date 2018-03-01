<div class="grid_12">
	<div class="header-content">Danh sách tag tin tức</div>
    <div class="clear"></div>
    <div class="command">
        <span><a href="<?= base_url()?>administrator/newstags/add">Thêm mới</a></span>
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
                            <input name="key" value="<?php if($this -> input -> get('key')) echo $this -> input -> get('key');?>" type="text" id="txtSearch" style="width:200px;"/>
                          </td>
                          <td>
                            <a class="linkbtn" onclick="javascript:ohyeahF();">Tìm kiếm</a>
                          </td>
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
	        			<th style="width:120px;text-align:left;">Tên Tags</th>
	        			<th>Hiển thị</th>
                        <th>Thứ tự</th>
	        			<th></th>
	        		</tr>
	        	</thead>

	        	<tbody>
              <?php if(count($tags_list) > 0 ) {?>
  	        		<?php $i = 1; foreach ($tags_list as $key) :?>
  		        		<tr id="tags<?= $key['TagsID']?>">
  		        			<td align="center" style="width:20px;text-align:center;"><?= $i?></td>
  		        			<td align="center" style="text-align:left;"><a id="txtTagsTitle<?= $key['TagsID']?>" href="<?= base_url()?>administrator/newstags/edit/<?= $key['TagsID']?>"><?= $key['Title']?></a></td>
  		        			<td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['TagsID']?>" <?php if($key['Publish']) echo 'checked="checked"'?> onclick="UpdatePublishStatus(<?= $key['TagsID']?>);"/></td>
  		        			<td align="center" style="width:70px;text-align:center;"><input type="text" id="txtTagsOrders<?= $key['TagsID']?>" style="width: 60px; text-align:right;" value="<?= $key['Orders']?>" onchange="UpdateOrders(<?= $key['TagsID']?>,this);"/></td>
                    <td align="center" style="width:120px;text-align:center;"><a href="<?= base_url()?>administrator/newstags/edit/<?= $key['TagsID']?>">Chỉnh sửa</a> | <a href="javascript:voi(0);" onclick="showconfirm(<?= $key['TagsID']?>,'Xác thực xóa tags','Bạn có muốn xóa tags này','delete')">xóa</a></td>
  		        		</tr>
  		        	<?php $i++; endforeach;?>
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
        <span><a href="<?= base_url()?>administrator/newstags/add">Thêm mới</a></span>
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
          url: "<?= base_url()?>ajaxhandle/admin_news_tags_ajaxhandler/Update_Publish",
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
        var orders = $("#txtTagsOrders"+id).val();
        if(!isNaN(orders)) {
            $.ajax( {
                  type: "POST",
                  url: "<?= base_url()?>ajaxhandle/admin_news_tags_ajaxhandler/Update_Orders",
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
            $("#txtTagsOrders"+id).val(element.defaultValue);
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
                            Delete_Tags(id);
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

    function Delete_Tags(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_ajaxhandler/Delete_news_tags",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa tags thành công!');
                  $('#tags'+id).fadeOut(400);
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

<!--[if lt IE 9]>
<script 
    src="<?= base_url()?>resources/js/jqueries/html5shiv.js">
</script>
<![endif]-->
<script type="text/javascript" charset="utf-8">
    $(function () {
        $("#loading").ajaxStart(function () {
            $(this).fadeIn(200);
            $("#lightbox").fadeIn(200);
            
        });

        $("#loading").ajaxStop(function () {
            $(this).fadeOut(200);
            $("#lightbox").fadeOut(200);
        });

        $("#loading").ajaxError (function () {
            $(this).fadeOut(200);
            $("#lightbox").fadeOut(200);
        });

        var sT = $(window).scrollTop();
        if ($(window).scrollTop() != "0")
            $("#go_top").fadeIn("slow");
        var scrollDiv = $("#go_top");
        $(window).scroll(function () {
            if ($(window).scrollTop() == "0")
                $(scrollDiv).fadeOut("slow")
            else
                $(scrollDiv).fadeIn("slow")
        });
        $("#go_top").click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, "slow")
        });

        anchorForm('loading');
    });

    function anchorForm(idform) {
        $("#"+idform).css('margin-top', ($("#lightbox").height() - $("#"+idform).height()) / 2);
        $("#"+idform).css('margin-left', ($("#lightbox").width() - $("#"+idform).width()) / 2);
    }

    function ConvertPrice(numberText, culture) {
        if(numberText == "") return 0;
        var number = 0;
        if(culture == "vi-VN") {
            number = numberText.replace(/\./g, "");
            return Number(number);
        }
        else {
            var s = numberText.length - 2;
            var c = numberText.substring(s - 1, s);
            if(c == ".") {
                number = numberText.replace(/\,/g, "");
                return Number(number);
            }
            if(c == ",") {
                number = numberText.replace(/\./g, "");
                number = number.replace(/\,/g, ".");
                return Number(number);
            }
        }
        return Number(numberText);
    }
</script>
<!-- Scripts end here -->