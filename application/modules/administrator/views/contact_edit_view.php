<div class="grid_12">
    <form method="post" action="<?= current_url();?>" name="form-edit" id="form-edit" accept-charset="utf-8">
        <div class="header-content">Thông tin chi tiết khách hàng liên hệ</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/contact/customers">Quay lại danh sách</a></span>
        </div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin contact</a>
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
                                &nbsp;Tên
                            </td>
                            <td>
                                <input name="contactTitle" type="text" value="<?= $contact['Name']?>" id="contactTitle" style="width:400px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                &nbsp;Số điện thoại
                            </td>
                            <td>
                                <input name="contactPhone" type="text" value="<?= $contact['Phone']?>" id="contactPhone" style="width:400px;">
                            </td>
                        </tr>

                        <tr>
                            <td class="key">
                                &nbsp;Email
                            </td>
                            <td>
                                <input name="contactPhone" type="text" value="<?= $contact['Email']?>" id="contactPhone" style="width:400px;">
                            </td>
                        </tr>

                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Địa chỉ
                            </td>
                            <td>
                                <textarea name="newsDescription" rows="2" cols="20" id="newsDescription" class="TextInput" style="height:96px;width:400px;"><?= $contact['Address']?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class="key" valign="top">
                                &nbsp;Nội dung liên hệ
                            </td>
                            <td>
                                <textarea name="newsDescription" rows="2" cols="20" id="newsDescription" class="TextInput" style="height:96px;width:400px;"><?= $contact['Content']?></textarea>
                            </td>
                        </tr>
                        
                    </tbody></table>
                </div>
            </div>
        </div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/contact/customers">Quay lại danh sách</a></span>
        </div>
    </form>
</div>