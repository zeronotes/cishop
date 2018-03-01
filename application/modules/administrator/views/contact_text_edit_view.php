<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thông tin liên hệ</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/contact/text-text">Quay lại danh sách</a></span>
        </div>
        <div id="tabs">
            <ul>
                <?php $i = 1; foreach ($tabs as $key){ ?>
                    <li>
                        <a href="#tabs-<?php echo $i;?>"><?php echo $key['Title']?></a>
                    </li>
                <?php $i++; } ?>
            </ul>

            <?php $j = 1; foreach ($tabs as $itemTabs) {?>
                <div id="tabs-<?php echo $j;?>" >
                    <div id="small-tool-bar">
                        <ul>
                            <!-- <li><a href="javascript:void(0);" onclick="showconfirm('','Xác thực xóa toàn bộ','Bạn có chắc chắn muốn xóa toàn bộ lịch sử đặt lệnh của tài khoản này?','delete_all_lenh');" class="small-btn skull">Xóa toàn bộ</a></li> -->
                            <li><a href="javascript:void(0);" id="clicker" class="small-btn add clicker-edit" onclick="addPanel(<?= $itemTabs['Id']?>);">Thêm mới</a></li>
                        </ul>
                    </div>
                    <table class="table-view">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tiêu đề</th>
                                <th>Tiêu đề tiếng Anh</th>
                                <th>Hiển thị</th>
                                <th>Thứ tự</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(sizeof($itemTabs['lienhe_list']) > 0 ) {?>
                                <?php $i = 1; foreach ($itemTabs['lienhe_list'] as $key) {?>
                                    <tr id="tabs<?php echo $key['tabs_lienhe'];?>-<?php echo $key['Id'];?>">
                                        <td align="center" style="width:20px;text-align:center;"><?php echo $i;?></td>
                                        <td><a id="Title<?= $key['Id']?>" href="javascriot:void(0);" ><?= $key['Title']?></a></td>
                                        <td><a id="Title_en<?= $key['Id']?>" href="javascriot:void(0);"><?= $key['Title_en']?></a></td>
                                        <td align="center" style="width:50px;text-align:center;"><input type="checkbox" value="1" id="cbIsVisible<?= $key['tabs_lienhe']?>-<?= $key['Id']?>" <?php if($key['Publish'] == 1) echo 'checked="checked"'?> onclick="updatePublish('<?= $key['tabs_lienhe']?>-<?= $key['Id']?>');"/></td>
                                        <td align="center" style="width:60px;text-align:center;"><input type="text" id="txtOrders<?= $key['tabs_lienhe']?>-<?= $key['Id']?>" style="width: 50px; text-align:right;" value="<?= $key['Orders']?>" onchange="updateOrders('<?= $key['tabs_lienhe']?>-<?= $key['Id']?>',this);"/></td>
                                        <td align="center" style="width:120px;text-align:center;"><a href="javascript:void(0);" onclick="showEditPanel('<?= $key['tabs_lienhe']?>-<?= $key['Id']?>');">Chỉnh sửa</a> | <a href="javascript:void(0);" onclick="showconfirm(<?= $key['Id']?>,'Xác thực xóa menu','Xóa menu đồng nghĩa với việc xóa tất cả các menu con thuộc menu này. <br/><br/> Bạn có chắc muốn xóa menu?','delete');">xóa</a></td>
                                    </tr>
                                    <?php if($i == 10000) {?>
                                        <tr id="tr-infor-tabs<?= $key['tabs_lienhe']?>">
                                            <td colspan="6">
                                                <table style="width:100%;" class="admintable">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:150px;">Tiêu đề</td>
                                                            <td><input type="text" id="txtTitle-tabs<?= $key['tabs_lienhe']?>" value="lkashjdajksh" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tiêu đề tiếng Anh</td>
                                                            <td><input type="text" id="txtTitle_en-tabs<?= $key['tabs_lienhe']?>" value="lkashjdajksh" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nội dung</td>
                                                            <td><textarea id="txtContent-tabs<?= $key['tabs_lienhe']?>" value="lkashjdajksh"> </textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nội dung tiếng Anh</td>
                                                            <td><textarea id="txtContent_en-tabs<?= $key['tabs_lienhe']?>" value="lkashjdajksh"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Location ( tọa độ maps )</td>
                                                            <td><input type="text" id="txtLocation-tabs<?= $key['tabs_lienhe']?>" value="lkashjdajksh" /></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php }?>
                                <?php $i++;}?>
                            <?php }else {?>
                                <tr id="empty-<?= $itemTabs['Id']?>"><td colspan="6"><p>Chưa có nội dung nào cả</p></td></tr>
                            <?php }?>
                        </tbody>

                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            <?php $j++; }?>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/contact/text-text">Quay lại danh sách</a></span>
        </div>
    </form>
</div>

<div id="popup-edit"  class="popup-wrapper">
    <a href="javascript:void(0);" style="margin: 0 0 5px 0;"  class="close-btn" id="close-btn">Close</a>
    <div>
        <table class="table-view" style="width:100%;">
            <thead>
                <tr>
                    <td>
                        <table style="width:936px;" class="admintable">
                            <tbody>
                                <tr>
                                   <td colspan="2">
                                        <a href="javascript:void(0);" class="linkbtn close-btn" >Đóng</a>
                                        <a href="javascript:void(0);" class="linkbtn btn-add" onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','add');" >Lưu</a>
                                   </td>
                                </tr>
                                <tr>
                                    <td style="width:150px;">Tiêu đề</td>
                                    <td><input type="text" id="txtTitle-add" style="width:200px" /></td>
                                </tr>
                                <tr>
                                    <td>Tiêu đề tiếng Anh</td>
                                    <td><input type="text" id="txtTitle_en-add" style="width:200px" /></td>
                                </tr>
                                <tr>
                                    <td>Nội dung</td>
                                    <td><textarea id="txtContent-add" > </textarea></td>
                                </tr>
                                <tr>
                                    <td>Nội dung tiếng Anh</td>
                                    <td><textarea id="txtContent_en-add" ></textarea></td>
                                </tr>
                                <tr>
                                    <td>Location ( tọa độ maps )</td>
                                    <td><input type="text" id="txtLocation-add" style="width:200px" /></td>
                                </tr>
                                <tr>
                                    <td>Hiển thị</td>
                                    <td><input type="checkbox" value="1" id="cbIsVisible-add"/></td>
                                </tr>
                                <tr>
                                    <td>Vị trí</td>
                                    <td><input type="text" id="txtOrders-add" style="width:200px" /></td>
                                </tr>
                                <tr>
                                   <td colspan="2">
                                        <a href="javascript:void(0);" class="linkbtn close-btn" >Đóng</a>
                                        <a href="javascript:void(0);" class="linkbtn btn-add" onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','add');" >Lưu</a>
                                   </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // $('#popup-wrapper').modalPopLite({ openButton: '.clicker', closeButton: '#close-btn', isModal: true });
        $('#popup-edit').modalPopLite({ openButton: '.clicker-edit', closeButton: '.close-btn', isModal: true ,
                    callBack:test
                });
    });
</script>

<script type="text/javascript">
 //<![CDATA[
    function updatePublish(id) {
        var Publish;
        if($("#cbIsVisible"+id).attr('checked')){
            Publish = 1;
        }else {
            Publish = 0;
        }
        var idReal = id.split('-');
        $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_contact_text_ajaxhandler/updatePublish",
          data: { id: idReal[1],publish: Publish},
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

    function updateOrders(id) {
        var orders = $("#txtOrders"+id).val();

        var idReal = id.split('-');
        $.ajax( {
          type: "POST",
          url: "<?= base_url()?>ajaxhandle/admin_contact_text_ajaxhandler/updateOrders",
          data: { id: idReal[1],orders: orders},
          dataType: "json",
          success: function(data) {
            if(data == 0) {
                notice('Đã có lỗi! Thực hiện lại sau.');
            }else if(data == 1) {
              notice('Đã cập thứ tự hiển thị.');
            }else {
              notice(data.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
          }
        });
    }

    function test(){
        $('#popup-edit').css('position','fixed');
    }

    function addPanel(idElement){
        $('.btn-add').removeAttr('onclick');
        $('.btn-add').attr('onclick', "showconfirm('"+idElement+"','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','add');");
        CKEDITOR.replace( 'txtContent-add',
            {
                language: 'vi',
            }
        );
        CKEDITOR.replace( 'txtContent_en-add',
            {
                language: 'vi',
            }
        );
    }

    function closePanel(idElement) {
        var idReal = idElement.split('-');
        if($('#tr-infor-tabs'+idReal[1]).length > 0) {
            $('#tr-infor-tabs'+idReal[1]).fadeOut(1000);
            $('#tr-infor-tabs'+idReal[1]).remove();
        }
    }

    function savePanel(idElement){
        var idReal = idElement.split('-');

        var Title = $('#txtTitle-tabs'+idElement).val();
        var Title_en = $('#txtTitle_en-tabs'+idElement).val();
        var Content = CKEDITOR.instances['txtContent-tabs'+idElement].getData();
        var Content_en = CKEDITOR.instances['txtContent_en-tabs'+idElement].getData();
        var Location = $('#txtLocation-tabs'+idElement).val();

        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_contact_text_ajaxhandler/update",
            data: { id: idReal[1],Title: Title,Title_en:Title_en,Content:Content,Content_en:Content_en,Location:Location},
            dataType: "json",
            success: function(data) {
                if(data == 0) {
                    notice('Đã có lỗi! Thực hiện lại sau.');
                }else if(data == 1) {
                    $('#Title'+idReal[1]).html(Title);
                    $('#Title_en'+idReal[1]).html(Title_en);
                    notice('Cập nhật dữ liệu hoàn thành!');
                }else {
                    notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function insertPannel(idElement) {
        // var idReal = idElement.split('-');

        var Title = $('#txtTitle-add').val();
        var Title_en = $('#txtTitle_en-add').val();
        var Content = CKEDITOR.instances['txtContent-add'].getData();
        var Content_en = CKEDITOR.instances['txtContent_en-add'].getData();
        var Location = $('#txtLocation-add').val();
        var Publish;
        if($("#cbIsVisible-add").attr('checked')){
            Publish = 1;
        }else {
            Publish = 0;
        }
        var orders = $("#txtOrders-add").val();

        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_contact_text_ajaxhandler/insert",
            data: {Publish:Publish,Orders:orders,Title: Title,Title_en:Title_en,Content:Content,Content_en:Content_en,Location:Location,tabs_lienhe:idElement},
            dataType: "json",
            success: function(data) {
                if(data == 0) {
                    notice('Đã có lỗi! Thực hiện lại sau.');
                }else if(data == 1) {
                    notice('insert nhật dữ liệu hoàn thành!');
                    setTimeout(function() {
                        location.reload();
                    }, 1300);
                }else {
                    notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function showEditPanel(idElement) {
        var idReal = idElement.split('-');

        if($('#tr-infor-tabs'+idReal[1]).length > 0) {
            $('#tr-infor-tabs'+idReal[1]).fadeOut(1000);
            $('#tr-infor-tabs'+idReal[1]).remove();
        }else {
            $.ajax( {
                type: "POST",
                url: "<?= base_url()?>ajaxhandle/admin_contact_text_ajaxhandler/getById",
                data: { id: idReal[1]},
                dataType: "json",
                success: function(data) {
                    if(data != 0) {
                        var html = "";

                        html += '<tr id="tr-infor-tabs'+idReal[1]+'" style="display:none;">';
                        html += '    <td colspan="6">';
                        html += '        <table style="width:100%;" class="admintable">';
                        html += '            <tbody>';
                        html += '                <tr>';
                        html += '                   <td colspan="2">';
                        html += '                       <a href="javascript:void(0);" class="linkbtn" onclick="closePanel(\''+idElement+'\')" >Đóng</a>';
                        html += '                       <a href="javascript:void(0);" class="linkbtn" onclick="showconfirm(\''+idElement+'\',\'Xác thực lưu thông tin\',\'Bạn muốn lưu lại thông tin này?\',\'save\');" >Lưu</a>';
                        html += '                   </td>';
                        html += '                </tr>';
                        html += '                <tr>';
                        html += '                    <td style="width:150px;">Tiêu đề</td>';
                        html += '                    <td><input type="text" id="txtTitle-tabs'+idElement+'" value="'+data.Title+'" style="width:200px" /></td>';
                        html += '                </tr>';
                        html += '                <tr>';
                        html += '                    <td>Tiêu đề tiếng Anh</td>';
                        html += '                    <td><input type="text" id="txtTitle_en-tabs'+idElement+'" value="'+data.Title_en+'" style="width:200px" /></td>';
                        html += '                </tr>';
                        html += '                <tr>';
                        html += '                    <td>Nội dung</td>';
                        html += '                    <td><textarea id="txtContent-tabs'+idElement+'" >'+data.Content+'</textarea></td>';
                        html += '                </tr>';
                        html += '                <tr>';
                        html += '                    <td>Nội dung tiếng Anh</td>';
                        html += '                    <td><textarea id="txtContent_en-tabs'+idElement+'">'+data.Content_en+'</textarea></td>';
                        html += '                </tr>';
                        html += '                <tr>';
                        html += '                    <td>Location ( tọa độ maps )</td>';
                        html += '                    <td><input type="text" id="txtLocation-tabs'+idElement+'" value="'+data.Location+'" style="width:200px" /></td>';
                        html += '                </tr>';
                        html += '                <tr>';
                        html += '                   <td colspan="2">';
                        html += '                       <a href="javascript:void(0);" class="linkbtn" onclick="closePanel(\''+idElement+'\')" >Đóng</a>';
                        html += '                       <a href="javascript:void(0);" class="linkbtn" onclick="showconfirm(\''+idElement+'\',\'Xác thực lưu thông tin\',\'Bạn muốn lưu lại thông tin này?\',\'save\');" >Lưu</a>';
                        html += '                   </td>';
                        html += '                </tr>';
                        html += '            </tbody>';
                        html += '        </table>';
                        html += '    </td>';
                        html += '</tr>';

                        $('#tabs'+idElement).after(html);
                        // $('#tabs'+idElement).attr('style','background:#F0F0F0;');
                        $('#tr-infor-tabs'+idReal[1]).fadeIn(1000);
                        CKEDITOR.replace( 'txtContent-tabs'+idElement,
                            {
                                language: 'vi',
                            }
                        );
                        CKEDITOR.replace( 'txtContent_en-tabs'+idElement,
                            {
                                language: 'vi',
                            }
                        );
                    }else {
                        notice(data.msg);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
                }
            });
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
                            delete_schedule(id);
                        }else if(action == 'save') {
                            savePanel(id);
                        }else if(action == 'add') {
                            insertPannel(id);
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
//]]>
</script>