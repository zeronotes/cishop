<div class="grid_12">
    <form method="post"  name="form-add" id="form-add" accept-charset="utf-8">
        <div class="header-content">Thêm mới sản phẩm</div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/products">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/products/add">Thêm mới</a></span>
        </div>
        <div class="clear"></div>
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Thông tin chi tiết</a>
                </li>
                <!-- <li>
                    <a href="#tabs-1-a">Thông tin tiếng Việt</a>
                </li>
                <li>
                    <a href="#tabs-1-b">Thông tin tiếng Anh</a>
                </li>
                <li>
                    <a href="#tabs-1-c">Thông tin tiếng Pháp</a>
                </li> -->
                <!-- <li>
                    <a href="#tabs-5">Bộ lọc tìm kiếm</a>
                </li> -->
                <li>
                    <a href="#tabs-2">Ảnh sản phẩm</a>
                </li>
                <li>
                    <a href="#tabs-3">Thông tin khác</a>
                </li>
                <li>
                    <a href="#tabs-4">Cấu hình SEO</a>
                </li>
            </ul>
            <div id="tabs-1">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tên sản phẩm
                            </td>
                            <td>
                                <?php echo form_error('prdTitle'); ?>
                                <input name="prdTitle" type="text" value="" maxlength="500" id="prdTitle" class="TextInput" style="width:400px;" onchange="checkTitle(this);">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tên sản phẩm</p>
                                        <p class="tooltipmessage">Nhập tên của sản phẩm</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tên sản phẩm tiếng Anh
                            </td>
                            <td>
                                <?php echo form_error('prdTitle_en'); ?>
                                <input name="prdTitle_en" type="text" value="" maxlength="500" id="prdTitle_en" class="TextInput" style="width:400px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tên sản phẩm</p>
                                        <p class="tooltipmessage">Nhập tên của sản phẩm</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                <span class="Required">*</span>
                                &nbsp;Tên sản phẩm tiếng Pháp
                            </td>
                            <td>
                                <?php echo form_error('prdTitle_fr'); ?>
                                <input name="prdTitle_fr" type="text" value="" maxlength="500" id="prdTitle_fr" class="TextInput" style="width:400px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Tên sản phẩm</p>
                                        <p class="tooltipmessage">Nhập tên của sản phẩm</p>
                                    </span>
                                </span>
                            </td>
                        </tr> -->
                        <tr>
                            <td class="key" style="width: 150px;">
                                &nbsp;Mã sản phẩm
                            </td>
                            <td>
                                <?php echo form_error('prdSKU'); ?>
                                <input name="prdSKU" type="text" value="" maxlength="500" id="prdSKU" class="TextInput" style="width:400px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Mã sản phẩm</p>
                                        <p class="tooltipmessage">Nhập tên của sản phẩm</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                <span class="Required">*</span>
                                &nbsp;Danh mục
                            </td>
                            <td>
                                <?php echo form_error('prdCategoriesProductsID'); ?>
                                <select size="10" name="prdCategoriesProductsID" id="prdCategoriesProductsID" style="width:400px;">
                                    <?php foreach ($categories as $key) :?>
                                        <option value="<?= $key['CategoriesProductsID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Danh mục sản phẩm</p>
                                        <p class="tooltipmessage">Lựa chọn danh mục chứa sản phẩm</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Sản phẩm liên quan</td>
                            <td>
                                <select name="prdHightlight[]" multiple id="prdHightlight" class="TextInput" placeholder="Chọn các tin liên quan">
                                    <?php foreach ($hightlightproducts as $key) :?>
                                        <option value="<?= $key['ProductsID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Sản phẩm liên quan</p>
                                        <p class="tooltipmessage">Những sản phẩm liên quan</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Danh sách tag</td>
                            <td>
                                <select name="prdTags[]" multiple id="prdTags" class="TextInput" placeholder="Chọn các tag">
                                    <?php foreach ($tags as $key) :?>
                                        <option value="<?= $key['TagsID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Danh sách tag</p>
                                        <p class="tooltipmessage">Danh sách tag</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key"><span class="Required">*</span>
                                &nbsp;Ảnh chính
                                <span class="recommend-res">(Kích thước đề nghị 300 x 300 pixels)</span>
                            <td>
                                <table id="tblUpload" cellspacing="0" cellpadding="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img id="img_upload" src="">
                                                <input type="hidden" name="prdMainImage" id="prdMainImage" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" name="userfile" id="userfile" size="20" />
                                                <a onclick="showconfirm('','Xác thực Upload ảnh','Bạn muốn upload hình ảnh này?','uploadimgmain');" class="linkbtn">Upload</a>
                                                <span class="tooltip">
                                                    <span class="tooltipContent">
                                                        <p class="tooltiptitle">Ảnh chính</p>
                                                        <p class="tooltipmessage">Ảnh chính của tin tức, hiển thị cùng với tiêu đề và mô tả ngắn</p>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                &nbsp;Thẻ Title của ảnh
                            </td>
                            <td>
                                <input name="prdImageTitle" type="text" value="" maxlength="500" id="prdImageTitle" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thẻ Title của ảnh</p>
                                        <p class="tooltipmessage">Nhập thẻ Title của ảnh</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                &nbsp;Thẻ Alt của ảnh
                            </td>
                            <td>
                                <input name="prdImageAlt" type="text" value="" maxlength="500" id="prdImageAlt" class="TextInput">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thẻ Alt của ảnh</p>
                                        <p class="tooltipmessage">Nhập thẻ Alt của ảnh</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="key">Hiển thị</td>
                            <td>
                                <select name="prdPublish" id="prdPublish">
                                    <option selected="selected" value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Hiển thị sản phẩm</p>
                                        <p class="tooltipmessage">Lựa chọn để hiển thị sản phẩm ngoài website.</p>
                                    </span>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">
                                &nbsp;Thứ tự hiển thị
                            </td>
                            <td>
                                <?php echo form_error('prdOrders'); ?>
                                <input name="prdOrders" type="text" value="" id="prdOrders" style="width:120px;">
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thứ tự hiển thị sản phẩm</p>
                                        <p class="tooltipmessage">Thứ tự hiển thị của sản phẩm</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                <span class="Required">*</span>
                                &nbsp;Giá bán
                            </td>
                            <td>
                                <?php echo form_error('prdSellPrice'); ?>
                                <input name="prdSellPrice" type="text" value="" id="prdSellPrice" style="width:120px;">    
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Giá sản phẩm</p>
                                        <p class="tooltipmessage">Giá sản phẩm hiển thị trên website</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                &nbsp;Giá cũ
                            </td>
                            <td>
                                <?php echo form_error('prdListPrice'); ?>
                                <input name="prdListPrice" type="text" id="prdListPrice" style="width:80px;">    
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Giá cũ</p>
                                        <p class="tooltipmessage">Giá sản phẩm trước khi thay đổi</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="key">Mô tả ngắn</td>
                            <td>
                                <textarea name="prdDescription" class="prdDescription"></textarea>
                                <script>
                                    CKEDITOR.replace('prdDescription',{language: 'vi'});
                                    $("#prdHightlight").chosen({search_contains:true});
                                    $("#prdTags").chosen({search_contains:true});
                                </script>
                            </td>
                        </tr> -->
                        <tr>
                            <td class="key">Mô tả chi tiết</td>
                            <td>
                                <textarea name="prdBody"></textarea>
                                <script>
                                    CKEDITOR.replace('prdBody',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td class="key">Hệ thống showroom có hàng</td>
                            <td>
                                <textarea name="prdBody2"></textarea>
                                <script>
                                    CKEDITOR.replace('prdBody2',{language: 'vi',});
                                </script>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <!-- <div id="tabs-5">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key">
                                <span class="Required">*</span>
                                &nbsp;Thương hiệu
                            </td>
                            <td>
                                <?php echo form_error('prdSortingBrandID'); ?>
                                <select size="10" name="prdSortingBrandID" id="prdSortingBrandID" style="width:400px;">
                                    <?php foreach ($brand_list as $key) :?>
                                        <option value="<?= $key['SortingBrandID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Thương hiệu sản phẩm</p>
                                        <p class="tooltipmessage">Lựa chọn Thương hiệu chứa sản phẩm</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                &nbsp;Độ phân giải
                                <span class="recommend-res">(Nếu là camera)</span>
                            </td>
                            <td>
                                <?php echo form_error('prdSortingResID'); ?>
                                <select size="10" name="prdSortingResID" id="prdSortingResID" style="width:400px;">
                                    <option value="0">Không phải camera</option>
                                    <?php foreach ($res_list as $key) :?>
                                        <option value="<?= $key['SortingResID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Độ phân giải</p>
                                        <p class="tooltipmessage">Lựa chọn độ phân giải</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                &nbsp;Số kênh
                                <span class="recommend-res">(Nếu là đầu ghi)</span>
                            </td>
                            <td>
                                <?php echo form_error('prdSortingChannelID'); ?>
                                <select size="10" name="prdSortingChannelID" id="prdSortingChannelID" style="width:400px;">
                                    <option value="0">Không phải đầu ghi</option>
                                    <?php foreach ($channel_list as $key) :?>
                                        <option value="<?= $key['SortingChannelID']?>"><?= $key['Title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="tooltip">
                                    <span class="tooltipContent">
                                        <p class="tooltiptitle">Độ phân giải</p>
                                        <p class="tooltipmessage">Lựa chọn độ phân giải</p>
                                    </span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
            <!-- <div id="tabs-1-a">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả ngắn</td>
                            <td>
                                <textarea name="prdDescription" class="prdDescription">
                                    <?= "<p><span style='color:#0694f6'><span style='font-size:14px'>Ha Noi - Quang Ninh - Ha Long</span></span></p>
                                        <p><span style='font-size:14px'>Thời gian: X ngày Y đêm</span></p>" ?>
                                </textarea>
                                <script>
                                    CKEDITOR.replace('prdDescription',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả trong trang</td>
                            <td>
                                <textarea name="prdDesc" class="prdDesc"></textarea>
                                <script>
                                    CKEDITOR.replace('prdDesc',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả chi tiết</td>
                            <td>
                                <textarea name="prdBody"></textarea>
                                <script>
                                    CKEDITOR.replace('prdBody',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tabs-1-b">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả ngắn tiếng Anh</td>
                            <td>
                                <textarea name="prdDescription_en" class="prdDescription_en">
                                    <?= "<p><span style='color:#0694f6'><span style='font-size:14px'>Ha Noi - Quang Ninh - Ha Long</span></span></p>
                                        <p><span style='font-size:14px'>Duration: X days Y nights</span></p>" ?>
                                </textarea>
                                <script>
                                    CKEDITOR.replace('prdDescription_en',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả trong trang tiếng Anh</td>
                            <td>
                                <textarea name="prdDesc_en" class="prdDesc_en"></textarea>
                                <script>
                                    CKEDITOR.replace('prdDesc_en',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả chi tiết tiếng Anh</td>
                            <td>
                                <textarea name="prdBody_en"></textarea>
                                <script>
                                    CKEDITOR.replace('prdBody_en',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tabs-1-c">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả ngắn tiếng Pháp</td>
                            <td>
                                <textarea name="prdDescription_fr" class="prdDescription_fr">
                                    <?= "<p><span style='color:#0694f6'><span style='font-size:14px'>Ha Noi - Quang Ninh - Ha Long</span></span></p>
                                        <p><span style='font-size:14px'>Durée: X jours Y nuits </span></p>" ?>
                                </textarea>
                                <script>
                                    CKEDITOR.replace('prdDescription_fr',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả trong trang tiếng Pháp</td>
                            <td>
                                <textarea name="prdDesc_fr" class="prdDesc_fr"></textarea>
                                <script>
                                    CKEDITOR.replace('prdDesc_fr',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Mô tả chi tiết tiếng Pháp</td>
                            <td>
                                <textarea name="prdBody_fr"></textarea>
                                <script>
                                    CKEDITOR.replace('prdBody_fr',{language: 'vi',});
                                </script>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
            <div id="tabs-2">
                <label style="display:inline-block;width:60px;">Thẻ Title</label><input type="text" name="TitleText" id="TitleText" style="width:400px;"><br /><br />
                <label style="display:inline-block;width:60px;">Thẻ Alt</label><input type="text" name="AltText" id="AltText" style="width:400px;"><br /><br />
                <span class="recommend-res">(Kích thước đề nghị 300x300 px)</span>
                <input type="file" name="userfile2" id="userfile2" size="20" />
                <a onclick="showconfirm('','Xác thực Upload ảnh','Bạn muốn upload hình ảnh này?','uploadimg');" class="linkbtn">Upload</a>
                <div class="out-images" id="images-wraper1">
                    <table class="table-view">
                        <thead>
                            <tr>
                                <th style="width:30px;text-align:center;">#</th>
                                <th style="width:130px;text-align:center;">Ảnh</th>
                                <th>Thẻ Title</th>
                                <th>Thẻ Alt</th>
                                <th style="width:70px;text-align:center;">Thứ tự</th>
                                <th style="width:100px;text-align:center;">Ảnh chính</th>
                                <th style="width:100px;text-align:center;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
            <div id="tabs-3">
                <table class="admintable" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 5px;"></td>
                        </tr>

                        <tr>
                            <td class="key">Tùy chọn</td>
                            <td>
                                <input id="prdIsNew" type="checkbox" name="prdIsNew" >
                                <label for="prdIsNew">Mới</label>
                            </td>
                            <td>
                                <input id="prdIsHot" type="checkbox" name="prdIsHot" >
                                <label for="prdIsHot">Nổi bật</label>
                            </td>
                            <td>
                                <input id="prdIsSellers" type="checkbox" name="prdIsSellers" >
                                <label for="prdIsSellers">Bán chạy</label>
                            </td>
                            <td>
                                <input id="prdIsPromotion" type="checkbox" name="prdIsPromotion" >
                                <label for="prdIsPromotion">Khuyến mãi</label>
                            </td>
                            <td>
                                <input id="prdIsStock" type="checkbox" name="prdIsStock" checked="checked"  >
                                <label for="prdIsStock">Còn hàng</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="tabs-4" >
                <div id="Div1">
                    <table class="admintable" width="100%">
                        <tbody><tr>
                            <td style="height: 5px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="key" style="width: 150px;">
                                Tiêu đề trang
                            </td>
                            <td>
                                <input name="prdPageTitle" type="text" maxlength="500" id="txtPageTitle" style="width:400px;">
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Tiêu đề trang</p>
                                    <p class="tooltipmessage">
                                        Nội dung được hiển thị dưới dạng tiêu đề trong kết quả tìm kiếm và trên trình duyệt của người dùng.
                                    </p>
                                </span></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                Thẻ từ khóa
                            </td>
                            <td>
                                <input name="prdMetaKeywords" type="text" id="txtMetaKeywords" style="width:400px;">
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Thẻ từ khóa</p>
                                    <p class="tooltipmessage">
                                        Mô tả các từ khóa chính của website
                                    </p>
                                </span></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                Thẻ mô tả
                            </td>
                            <td>
                                <textarea name="prdMetaDesc" id="txtMetaDesc" rows="5" style="width:400px;"></textarea>
                                <span class="tooltip"><span class="tooltipContent">
                                    <p class="tooltiptitle">
                                        Thẻ mô tả</p>
                                    <p class="tooltipmessage">
                                        Cung cấp một mô tả ngắn của trang. Trong vài trường hợp, mô tả này được sử dụng như một phần của đoạn trích được hiển thị trong kết quả tìm kiếm.
                                    </p>
                                </span></span>
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="command">
            <span><a href="<?= base_url()?>administrator/products">Quay lại danh sách</a></span>
            <span><a onclick="showconfirm('','Xác thực lưu thông tin','Bạn muốn lưu lại thông tin này?','save');">Lưu</a></span>

            <span><a href="<?= base_url()?>administrator/products/add">Thêm mới</a></span>
        </div>
    </form>
</div>
<script type="text/javascript">
 //<![CDATA[
    var thutu = 0;

    function upload_images_product() {
        var TitleText = $("#TitleText").val();
        var AltText = $("#AltText").val();
        $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/products_upload_images/add?TitleText="+TitleText+"&AltText="+AltText,
            secureuri      :false,
            fileElementId  :'userfile2',
            dataType    : 'json',
            data        : {TitleText:TitleText,AltText:AltText},
            success  : function (data)
            {
                thutu++;
                if(data.url != "" && data.msg == "" && data.imgname != "" ) {
                    var html = "<tr id=\"image-item"+thutu+"\">";
                        html += "   <input type=\"hidden\" name=\"imgsinsert[]\" value=\""+data.imgname+"\">";
                        html += "   <input type=\"hidden\" name=\"imgsTitleText[]\" value=\""+data.TitleText+"\">";
                        html += "   <input type=\"hidden\" name=\"imgsAltText[]\" value=\""+data.AltText+"\">";
                        html += "   <td style=\"width:30px;text-align:center;\">";
                        html += "       "+thutu;
                        html += "   </td>";
                        html += "   <td style=\"width:130px;text-align:center;\">";
                        html += "       <img width=\"125px\" height=\"100px\" src=\""+data.url+"\" alt=\"\"/>";
                        html += "   </td>";
                        html += "   <td>";
                        html += $("#TitleText").val();
                        html += "   </td>";
                        html += "   <td>";
                        html += $("#AltText").val();
                        html += "   </td>";
                        html += "   <td style=\"width:70px;text-align:center;\">";
                        html += "       <input name=\"txtPositionNum[]\" type=\"text\" id=\"txtPositionNum\" style=\"width:60px;\">";
                        html += "   </td>";
                        html += "   <td style=\"width:100px;text-align:center;\">";
                        html += "       <input type=\"radio\" name=\"mainimage\" value=\""+data.imgname+"\"  placeholder=\"\"/>";
                        html += "   </td>";
                        html += "   <td style=\"width:100px;text-align:center;\">";
                        html += "       <a onclick=\"showconfirm("+thutu+",'Xác thực xóa ảnh','Bạn muốn xóa ảnh này?','deleteimg')\">xóa</a>";
                        html += "   </td>";
                        html += "</tr>";
                    $('#images-wraper1 table tbody').append(html);
                    $("#TitleText").val('');
                    $("#AltText").val('');
                }
                else if(data.msg != "")
                    notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
         });
   }// end upload_images_product

   function update_main_image(imageid) {
        $.ajax( {
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Update_Product_Main_Image/",
            data: { imageid: imageid},
            dataType: "json",
            success: function(data) {
                notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
   }

   function delete_image(imageid) {
        // $.ajax( {
        //     type: "POST",
        //     url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler",
        //     data: { imageid: imageid},
        //     dataType: "json",
        //     success: function(data) {
        //         notice(data.msg);
                $('#image-item'+imageid).fadeOut(400).remove();
        //     },
        //     error: function(XMLHttpRequest, textStatus, errorThrown) {
        //         notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
        //     }
        // });
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
                        if(action == 'deleteimg') {
                            delete_image(id);
                            $('body').css('overflow','auto');
                        }
                        else if(action == 'save') {
                            submitform();
                            $('body').css('overflow','auto');
                        }
                        else if(action == 'create') {
                            create_album_category_menu();
                        }else if(action == 'uploadimg') {
                            upload_images_product();
                            $('body').css('overflow','auto');
                        }else if(action == 'uploadimgmain') {
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
        $("#form-add").submit();
    }

    function upload_images() {
        $.ajaxFileUpload({
            url         :"<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Main_Image_Upload",
            secureuri      :false,
            fileElementId  :'userfile',
            dataType    : 'json',
            data        : {},
            success  : function (data)
            {
                if(data.url != "" && data.msg == "" && data.imgname != "") {
                    $('#img_upload').attr('src',data.url);
                    $('#prdMainImage').attr('value',data.imgname);
                }
                else if(data.msg != "")
                    notice(data.msg);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
         });
   }// end upload_images_product

    //$.jQuery(document).ready(function($) {
    $('#form-add').submit(function() {
        $(".error").remove();
        var idElementError = "";
        var hasError = false;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        var prdTitle = $("#prdTitle").val();
        if(prdTitle == '') {
            $("#prdTitle").before('<div class="error Required">Tên sản phẩm không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "prdTitle";
        }
        //} else if(!emailReg.test(prdTitle)) { test email regax

        if (!$("#prdCategoriesProductsID option:selected").length) {
            $("#prdCategoriesProductsID").before('<div class="error Required">Danh mục sản phẩm phải được chọn</div>');
            hasError = true;
            if (idElementError == "") idElementError = "prdCategoriesProductsID";
            //$('html, body').animate({scrollTop:$('#prdCategoriesProductsID').offset().top - 50}, 'slow');
        }

        // if (!$("#prdSortingBrandID option:selected").length) {
        //     $("#prdSortingBrandID").before('<div class="error Required">Thương hiệu sản phẩm phải được chọn</div>');
        //     hasError = true;
        //     if (idElementError == "") idElementError = "prdSortingBrandID";
        //     //$('html, body').animate({scrollTop:$('#prdSortingBrandID').offset().top - 50}, 'slow');
        // }

        var img_upload = $("#img_upload").attr("src");
        if(img_upload == '') {
            $("#img_upload").before('<div class="error Required">Ảnh chính không được trống</div>');
            hasError = true;
            if (idElementError == "") idElementError = "tblUpload";
        }

        var prdOrders = $("#prdOrders").val();
        if(isNaN(prdOrders)) {
            $("#prdOrders").before('<span class="error Required  ">Thứ tự phải là các chữ số</span>');
            hasError = true;
            if (idElementError == "") idElementError = "prdOrders";
        }

        var prdSellPrice = $("#prdSellPrice").val();
        if(isNaN(prdSellPrice)) {
            $("#prdSellPrice").before('<span class="error Required  ">Giá sản phẩm phải là các chữ số</span>');
            hasError = true;
            if (idElementError == "") idElementError = "prdSellPrice";
        }

        var prdListPrice = $("#prdListPrice").val();
        if(isNaN(prdListPrice)) {
            $("#prdListPrice").before('<span class="error Required  ">Giá sản phẩm phải là các chữ số</span>');
            hasError = true;
            if (idElementError == "") idElementError = "prdListPrice";
        }

        if(hasError == false) {
            return true;
        }

        var index = $('#tabs a[href="#tabs-1"]').parent().index(); $('#tabs').tabs('select', index);

        scrollToError(idElementError);

        return false;
    });
    //});

    function checkTitle(element) {
        var title = $("#prdTitle").val();
        $.ajax({
            type: "POST",
            url: "<?= base_url()?>ajaxhandle/admin_products_ajaxhandler/Check_Title",
            data: { title: title},
            dataType: "json",
            success: function(data) {
                if(data == 0) {
                    notice('Tiêu đề chưa tồn tại và có thể sử dụng.');
                }else if(data == 1) {
                    element.defaultValue = title;
                    notice('Tiêu đề đã tồn tại ! Vui lòng đổi lại tiêu đề khác.');
                }else {
                    notice(data.msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                notice("Error status : "+textStatus+"<br/>Error code : "+XMLHttpRequest.status+"<br/>Error thrown : "+errorThrown);
            }
        });
    }
</script>