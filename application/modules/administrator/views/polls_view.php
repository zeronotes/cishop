<div class="grid_12">
    <div class="header-content">Danh sách Poll</div>
    <div class="clear"></div>
    <div class="command">
        <span>
            <span><a href="<?= base_url()?>administrator/polls/add">Thêm mới</a></span>
        </span>
    </div>
    <div class="wrap-main-body">

        <div class="wrap-page-link">
            <div class="page-link">
                <?= $link?></div>
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
                                    <!-- <li><a href="javascript:void(0);" onclick="showconfirm('','Xác thực xóa tạm','Thông tin này sẽ được lưu trong bộ nhớ tạm!','trashChk')">Xóa tạm</a></li> -->
                                    <li><a href="javascript:void(0);" onclick="showconfirm('','Xác thực xóa vĩnh viễn','Bạn có chắc muốn xóa vĩnh viễn?','deleteChk')">Xóa vĩnh viễn</a></li>
                                </ul>
                            </div>
                        </th>
                        <th>Tiêu đề poll</th>
                        <th>Kết thúc</th>
                        <th>Ngày khởi tạo</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(!empty($polls_list)) {?>
                        <?php $i = 1; foreach ($polls_list as $key) :?>
                        <tr id="poll<?= $key['Id']?>" class="poll">
                            <td align="center" style="width:20px;text-align:center;"><input type="checkbox" class="selectedId" name="Chk[]" value="<?= $key['Id']?>" id="chkTick<?= $key['Id']?>" onclick="ChkTick(<?= $key['Id']?>);"/></td>
                            <td><b><?= $key['Title']?></b></td>
                            <td align="center" style="width:120px;text-align:center;">
                                <input type="checkbox" value="1" id="cbIsVisible<?= $key['Id']?>" <?php if($key['Finished'] == 1) echo 'checked="checked"'?> onclick="UpdateFinished(<?= $key['Id']?>);"/>
                            </td>
                            <td align="center" style="width:120px;text-align:center;"><?= $key['CreatedDate']?></td>
                            <td align="center" style="width:120px;text-align:center;">
                                <a href="<?= base_url()?>administrator/polls/edit/<?= $key['Id']?>">Chi tiết</a>|
                                <a href="javascript:void(0);" onclick="showconfirm(<?= $key['Id']?>,'Xác thực xóa','Bạn có chắc muốn xóa thông tin này?','delete')">xóa</a>
                            </td>
                        </tr>
                        <?php $i++; endforeach;?>
                    <?php }else {?>
                        <tr>
                            <td colspan="6">Chưa có poll nào cả</td>
                        </tr>
                    <?php }?></tbody>

                <tfoot></tfoot>
            </table>
        </form>
        </div>
        <div class="wrap-page-link">
            <div class="page-link">
                <?= $link?></div>
        </div>
    </div>
    <div class="command">
        <span>
            <span><a href="<?= base_url()?>administrator/polls/add">Thêm mới</a></span>
        </span>
    </div>
</div>

<script type="text/javascript">

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
                        if(action == 'save') {
                            submitform();
                        }else if(action == 'delete') {
                            Delete_poll(id);
                        }else if(action == 'deleteChk') {
                            DeleteChk();
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

    function Delete_poll(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_polls_ajaxhandler/Delete_poll",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa thành công!');
                  $('#poll'+id).fadeOut(400);
                }else {
                    notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function UpdateFinished(id) {
        var Finished;
        if($("#cbIsVisible"+id).attr('checked')){
            Finished = 1;
        }else {
            Finished = 0;
        }
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_polls_ajaxhandler/updateFinished",
            data: { id: id,Finished: Finished},
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

    function scrollToError(yeah) {
        $('html, body').animate({scrollTop:$('#'+yeah).offset().top - 50}, 'slow');
    }

    function submitform() {
        $("#form-edit").submit();
    }

    $('form#form-edit').submit(function() {
        return true;
    });
</script>

<script type="text/javascript">

    function CheckAll() {
        $(".selectedId").attr('checked', $("#chkTickAll").is(":checked"));
        if($('.selectedId').filter(":checked").length > 0 ) {
            $("#menu-trigger").attr('onclick','ShowActinMenu();');
            $("table.table-view tbody tr.poll td").css('background-color','#F0F0F0');
        }else {
            $("#menu-trigger").removeAttr('onclick');
            $(".action-menu").hide();
            $("table.table-view tbody tr.poll td").css('background-color','');
        }

    }

    function ChkTick(id) {

        if($('.selectedId').filter(":checked").length > 0 && $("#chkTick"+id).is(":checked")) {
            $("#menu-trigger").attr('onclick','ShowActinMenu();');
            $("table.table-view tbody tr#poll"+id+" td").css('background-color','#F0F0F0');
        }else if($('.selectedId').filter(":checked").length == 0 && !$("#chkTick"+id).is(":checked")){
            $("#menu-trigger").removeAttr('onclick');
            $(".action-menu").hide();
            $("table.table-view tbody tr#poll"+id+" td").css('background-color','');
        }else {
            $(".action-menu").hide();
            $("table.table-view tbody tr#poll"+id+" td").css('background-color','');
        }

        var check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
        $('#chkTickAll').prop("checked", check);
    }

    function ShowActinMenu() {
        if ($(".action-menu").is(":visible"))
        {
            $(".action-menu").slideUp(100);
            $("#menu-trigger").removeClass("open");
        }else
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
        funcName = "Delete_poll_chk";
        $("#formPost").submit();
    }

    function TrashChk() {
        $('#chkTickAll').prop("checked", false);
        $("#menu-trigger").removeClass("open");
        $("#menu-trigger").removeAttr('onclick');
        $(".action-menu").hide();
        funcName = "Trash_poll_chk";
        $("#formPost").submit();
    }

    function temp() {
        var form = document.formPost;

        var dataString = $(form).serialize();

        $.ajax({
            type:'POST',
            url:'<?= base_url()?>ajaxhandle/admin_polls_ajaxhandler/'+funcName,
            data: dataString,
            dataType: 'json',
            success: function(data){
                $.each(data.array, function(i, item) {
                    $("#poll"+item).remove();
                });

                notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function submitFormPost(){
        $("#formPost").submit();
    }

    $('form#formPost').submit(function(){
        temp();
        return true;
    });

</script>