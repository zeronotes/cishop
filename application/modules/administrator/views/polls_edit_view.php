<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thay đổi thông tin Poll</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/polls">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin Poll</a>
                </li>
                <li>
                    <a href="#tabs-2">Danh sách lựa chọn theo Poll</a>
                </li>
                <li>
                    <a href="#tabs-3">Biểu đồ theo dõi</a>
                </li>
            </ul>
            <div id="tabs-1" >
                <div id="Div1">
                    <table class="admintable" width="100%">
                        <tbody><tr>
                            <td style="height: 5px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Tiêu đề
                            </td>
                            <td>
                                <?php echo form_error('Title'); ?>
                                <input name="Title" type="text" value="<?= $poll['Title']?>" id="Title" style="width:400px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Tiêu đề tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('Title_en'); ?>
                                <input name="Title_en" type="text" value="<?= $poll['Title_en']?>" id="Title_en" style="width:400px;">
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Kết thúc</td>
                            <td>
                                <select name="Finished" id="pollPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option <?php if($poll['Finished'] != 1) echo 'selected="selected"';?> value="0">Không</option>
                                </select>
                            </td>
                        </tr>

                    </tbody></table>
                </div>
            </div>

            <div id="tabs-2">
                <div id="small-tool-bar">
                    <ul>
                        <li><a href="javascript:void(0);" onclick="showconfirm('','Xác thực xóa toàn bộ','Bạn có chắc chắn muốn xóa toàn bộ lịch sử đặt lệnh của tài khoản này?','delete_all_lenh');" class="small-btn skull">Xóa toàn bộ</a></li>
                        <li><a href="javascript:void(0);" id="clicker" class="small-btn add clicker">Thêm mới</a></li>
                    </ul>
                </div>
                <table class="table-view tb-no-float">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tiêu đề</th>
                            <th>Tiêu đề tiếng Anh</th>
                            <th>Votes</th>
                            <th>Ngày khỏi tạo</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(!empty($answersList)) {?>
                        <?php $i = 1; foreach ($answersList as $key) {?>
                            <tr id="answer_poll<?= $key['IdAns'];?>">
                                <td align="center" style="width:20px;text-align:center;"><?= $i?></td>
                                <td id="title-answer<?= $key['IdAns']?>" style=""><?= $key['Title']?></td>
                                <td id="title-en-answer<?= $key['IdAns']?>" align="center"><?= $key['Title_en']?></td>
                                <td align="center" style="width:90px;text-align:center;color:green;"><?= $key['Votes']?></td>
                                <td align="center" style="width:120px;text-align:center;"><?= $key['CreatedDate']?></td><td align="center" style="width:100px;text-align:center;">
                                    <a href="javascript:void(0);" class="clicker-edit" onclick="getAnswer('<?= $key['IdAns']?>')">Chi tiết</a>|
                                    <a href="javascript:void(0);" onclick="showconfirm(<?= $key['IdAns']?>,'Xác thực xóa','Bạn có chắc muốn xóa yêu cầu này?','delete_answer_poll');">Xóa</a>
                                </td>
                            </tr>
                        <?php $i++; }?>
                        <?php }else {?>
                            <td colspan="5">Chưa có lựa chọn poll nào</td>
                        <?php }?>
                    </tbody>

                    <tfoot>

                    </tfoot>
                </table>
            </div>

            <div id="tabs-3">

                <?= $summeryChart?>

            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/polls">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
        </div>
    </form>
</div>

<div id="popup-wrapper" class="popup-wrapper">
  <a href="javascript:void(0);" style="margin: 0 0 5px 0;"  id="close-btn">Close</a>
  <div>
    <table class="table-view">
      <thead>
        <tr>
          <td>
            <table style="width:100%;">
              <tr>
                <td style="width:70px;"><span class="Required">*</span>&nbsp;Tiêu đề</td>
                <td><input style="width:200px;" type="text" name="Title_ajax" id="Title_ajax" /></td>
                <td style="width:100px;"><span class="Required">*</span>&nbsp;Tiêu đề tiếng Anh</td>
                <td><input style="width:200px;" type="text" name="Title_ajax_en" id="Title_ajax_en" /></td>
                <td><a href="javascript:void(0);" onclick="addAnswer('<?= $poll['Id']?>');" id="addbtn" class="linkbtn" title="Thêm mới lựa chọn cho poll">add</a></td>
              </tr>

            </table>
          </td>
        </tr>
      </thead>

      <!-- <tbody>
        <tr>
          <td>
            <table id="table-loai-phong">
              <tr id="anchor_add"></tr>
            </table>
          </td>
        </tr>
      </tbody> -->
    </table>
  </div>
</div>

<div id="popup-edit" class="popup-wrapper">
  <a href="javascript:void(0);" style="margin: 0 0 5px 0;"  id="close-btn">Close</a>
  <div>
    <table class="table-view">
      <thead>
        <tr>
          <td>
            <table style="width:100%;">
              <tr>
                <td style="width:70px;"><span class="Required">*</span>&nbsp;Tiêu đề</td>
                <td><input style="width:200px;" type="text" name="Title_ajax_edit" id="Title_ajax_edit" /></td>
                <td style="width:100px;"><span class="Required">*</span>&nbsp;Tiêu đề tiếng Anh</td>
                <td><input style="width:200px;" type="text" name="Title_ajax_en_edit" id="Title_ajax_en_edit" /></td>
                <td><a href="javascript:void(0);" onclick="saveAnswer('<?= $poll['Id']?>');" id="savebtn" class="linkbtn" title="Lưu lại thông tin của lựa chọn cho poll">save</a></td>
              </tr>

            </table>
          </td>
        </tr>
      </thead>
    </table>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#popup-wrapper').modalPopLite({ openButton: '.clicker', closeButton: '#close-btn', isModal: true });
        $('#popup-edit').modalPopLite({ openButton: '.clicker-edit', closeButton: '#close-btn', isModal: true });
    });
</script>
<script type="text/javascript">
    var index = <?php if(isset($i)) echo $i; else echo '0';?>;
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
                        }else if(action == 'delete_answer_poll'){
                            Delete_answer(id);
                        }
                        $('body').css('overflow','auto');
                    }
                },
                'No'    : {
                    'class' : 'gray',
                    'action': function(){
                        // if(action == 'delete' || action == 'update' || action == 'uploadimg') {
                        //     $('body').css('overflow','auto');
                        // }
                        $('body').css('overflow','auto');
                    }
                }
            }
        });
    }

    function getAnswer(id){
        $('#Title_ajax_edit').val('');
        $('#Title_ajax_en_edit').val('');
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_polls_ajaxhandler/getAnswer",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data.correct == 0){
                    notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data.correct == 1) {
                    $('#savebtn').attr('onclick', 'saveAnswer("'+id+'","<?= $poll['Id']?>")');
                    $('#Title_ajax_edit').val(data.Title);
                    $('#Title_ajax_en_edit').val(data.Title_en);
                }else {
                    notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function saveAnswer(id,idPoll) {
        var Title = $('#Title_ajax_edit').val();
        var Title_en = $('#Title_ajax_en_edit').val();
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_polls_ajaxhandler/updateAnswer",
            data: { id: id,idPoll:idPoll,Title:Title,Title_en:Title_en},
            dataType: "json",
            success: function(data) {
                if(data.correct == 0){
                    notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data.correct == 1) {
                    $('#title-answer'+id).html(Title);
                    $('#title-en-answer'+id).html(Title_en);
                    $('div#tabs-3').html(data.pollChart);
                    notice('Cập nhật thành công');
                }else {
                    notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }

    function addAnswer(id) {
        var Title = $('#Title_ajax').val();
        var Title_en = $('#Title_ajax_en').val();
        var hasError = false;

        if(Title == '') {
            notice('Tiêu đề lựa chọn poll không được trống');
            hasError = true;
            $('#Title_ajax').focus();
        }else if(Title_en == '') {
            notice('Tiêu đề lựa chọn tiếng Anh của poll không được trống');
            hasError = true;
            $('#Title_ajax_en').focus();
        }

        if(!hasError) {

            $.ajax( {
                type: "POST",
                url: "<?= base_url()?>ajaxhandle/admin_polls_ajaxhandler/addAnswer",
                data: { id: id,Title:Title,Title_en:Title_en},
                dataType: "json",
                success: function(data) {
                    if(data.correct == 0){
                        notice('Có lỗi, vui lòng thử lại sau!');
                    }else if(data.correct == 1) {
                        var html = '';
                            html += '<tr id="answer_poll'+data.answerObj.IdAns+'">';
                            html += '   <td align="center" style="width:20px;text-align:center;">'+index+'</td>';
                            html += '   <td style="">'+data.answerObj.Title+'</td>';
                            html += '   <td align="center">'+data.answerObj.Title_en+'</td>';
                            html += '   <td align="center" style="width:90px;text-align:center;color:green;">'+data.answerObj.Votes+'</td>';
                            html += '   <td align="center" style="width:120px;text-align:center;">'+data.answerObj.CreatedDate+'</td><td align="center" style="width:100px;text-align:center;">';
                            html += '      <a href="javascript:void(0);" onclick="showconfirm('+data.answerObj.IdAns+',"Xác thực xóa","Bạn có chắc muốn xóa yêu cầu này?","delete_answer_poll");">Xóa</a>';
                            html += '   </td>';
                            html += '</tr>';
                        $('table.tb-no-float tbody').append(html);
                        $('div#tabs-3').html(data.pollChart);
                        $('#Title_ajax').val('');
                        $('#Title_ajax_en').val('');
                        index++;
                        notice('Thêm mới thành công');
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

    function Delete_answer(id) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_polls_ajaxhandler/Delete_answer",
            data: { id: id},
            dataType: "json",
            success: function(data) {
                if(data == 0){
                  notice('Có lỗi, vui lòng thử lại sau!');
                }else if(data == 1) {
                  notice('Xóa thành công!');
                  $('#answer_poll'+id).fadeOut(400);
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

    $('form').submit(function() {
        $(".error").remove();
        var idElementError = "";
        var hasError = false;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        var Title = $("#Title").val();
        if(Title == '') {
            $("#Title").before('<div class="error Required">Tiêu đề poll không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "Title";
        }

        var Title_en = $("#Title_en").val();
        if(Title_en == '') {
            $("#Title_en").before('<div class="error Required">Tiêu đề poll tiếng Anh không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "Title_en";
        }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
</script>