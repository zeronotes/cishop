<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thêm mới quảng cáo</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/ads">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/ads/add">Thêm mới</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
                </li>
            </ul>
            <div id="tabs-1">
                <table class="admintable"  width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                &nbsp;Tiêu đề
                            </td>
                            <td>
                                <?php echo form_error('Title'); ?>
                                <input name="Title" type="text" value="" maxlength="500" id="adsTitle" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tiêu đề</p>
                                        <p class="tooltipmessage">Nhập tiêu đề của quảng cáo</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Link
                            </td>
                            <td>
                                <?php echo form_error('Link'); ?>
                                <input name="Link" type="text" value="" maxlength="500" id="adsTitle" class="TextInput">
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Ảnh</td>
                                <!-- <span class="recommend-res">(Kích thước quảng cáo đề nghị 259 x 215 pixels)</span> -->
                            <td>

                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img id="img_upload" src="">
                                                <input type="hidden" name="ImageURL" id="ImageURL" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="userfile" id="userfile" size="20" />
                                                <a onclick="showconfirm('','Xác thực Upload ảnh','Bạn muốn upload hình ảnh này?','uploadimg');" class="linkbtn">Upload</a>
                                                <span class="tooltip">
                                                    <span class="tooltipContent">
                                                        <p class="tooltiptitle">Ảnh</p>
                                                        <p class="tooltipmessage">Ảnh sẽ hiển thị ngoài website</p>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" valign="top">
                                Mô tả
                            </td>
                            <td>
                                <?php echo form_error('Description'); ?>
                                <textarea name="Description" rows="2" cols="20" id="adsDescription" style="height:96px;width:400px;"></textarea>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Mô tả</p>
                                        <p class="tooltipmessage">
                                            Mô tả quảng cáo
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" valign="top"><span class="Required">*</span>
                                &nbsp;Nhóm quảng cáo
                            </td>
                            <td>
                                <select size="10" name="AdsGroupsID" id="AdsGroupsID" style="width:400px;">
                                  <?php foreach ($adsgroups_list as $key) :?>
                                      <option value="<?= $key['AdsGroupsID']?>" ><?= $key['Title']?></option>
                                  <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Nhóm quảng cáo</p>
                                        <p class="tooltipmessage">
                                            Nhóm quảng cáo của mỗi quảng cáo
                                        </p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <!-- <tr>
                            <td class="key">
                                &nbsp;Chiều cao</td>
                            <td>
                                <?php echo form_error('Height'); ?>
                                <input name="Height" type="text" value="" id="adsHeight" style="width:70px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Chiều cao</p>
                                        <p class="tooltipmessage">
                                            Chiều cao hiển thị của quảng cáo
                                        </p>
                                    </span>
                                </span>

                            </td>
                        </tr>

                        <tr>
                            <td class="key">
                                &nbsp;Chiều dài</td>
                            <td>
                                <?php echo form_error('Width'); ?>
                                <input name="Width" type="text" value="" id="adsWidth" style="width:70px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Chiều dài</p>
                                        <p class="tooltipmessage">
                                            Chiều dài hiển thị của quảng cáo
                                        </p>
                                    </span>
                                </span>

                            </td>
                        </tr> -->

                        <tr>
                            <td class="key">Thứ tự</td>
                            <td>
                                <?php echo form_error('Orders'); ?>
                                <input name="Orders" type="text" value="" id="adsOrders" style="width:70px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thứ tự</p>
                                        <p class="tooltipmessage">
                                            Thứ tự hiển thị quảng cáo ngoài website
                                        </p>
                                    </span>
                                </span>

                            </td>
                        </tr>

                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="Publish" id="adsPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị Quảng cáo</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị quảng cáp ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/ads">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>
            <span><a href="<?= base_url()?>administrator/ads/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[

    function upload_images() {
         $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_ajaxhandler/Ads_uploas_image",
            secureuri      :false,
            fileElementId  :'userfile',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.msg == "" && data.imgname != "") {
                    $('#img_upload').attr('src',data.url);
                    $('#ImageURL').attr('value',data.imgname);
                }
                else if(data.msg != "")
                    notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
         });
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
                        if(action == 'save') {
                            submitform();
                            $('body').css('overflow','auto');
                        }else if(action == 'uploadimg') {
                            upload_images();
                            $('body').css('overflow','auto');
                        }
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

//]]>
</script>
<script type="text/javascript">
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

        var Title = $("#adsTitle").val();
        if(Title == '') {
            $("#adsTitle").before('<div class="error Required">Tiêu đề không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "adsTitle";
        }

        var img_upload = $("#img_upload").attr("src");
        if(img_upload == '') {
            $("#img_upload").before('<div class="error Required">Ảnh quảng cáo không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "img_upload";
        }

        if (!$("#AdsGroupsID option:selected").length) {
            $("#AdsGroupsID").before('<div class="error Required">Nhóm quảng cáo phải được chọn</div>');
            hasError = true;
            if (idElementError == "") idElementError = "AdsGroupsID";
        }


        // var adsHeight = $("#adsHeight").val();
        // if(isNaN(adsHeight) || adsHeight < 0) {
        //     $("#adsHeight").before('<span class="error Required  ">Chiều cao phải là các chữ số và lớn hơn 0</span>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "adsHeight";
        // }

        // var adsWidth = $("#adsWidth").val();
        // if(isNaN(adsWidth) || adsWidth < 0) {
        //     $("#adsWidth").before('<span class="error Required  ">Chiều dài phải là các chữ số và lớn hơn 0</span>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "adsWidth";
        // }

        var adsOrders = $("#adsOrders").val();
        if(isNaN(adsOrders) || adsOrders < 0) {
            $("#adsOrders").before('<span class="error Required  ">Thứ tự phải là các chữ số và lớn hơn 0</span>');
            hasError = true;
            if (idElementError == "") idElementError = "adsOrders";
        }


        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
</script>