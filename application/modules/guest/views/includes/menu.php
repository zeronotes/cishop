            <div class="container-fluid hidden-xs hidden-md menu_bg">
                <div class="row menu_bg">
                    <div class="col-xs-12 col-xs-offset-0 col-md-10 col-md-offset-1 menu_bg">
                        <div class="row">
                            <div class="col-md-3 full-right hidden-xs hidden-sm">
                                <div id="prd-cate-list">
                                    <div class="prd-cate-header">
                                        <span>Danh mục sản phẩm<i class="fa fa-chevron-circle-down"></i></span>
                                    </div>
                                    <ul class="sub-page">
                                        <?= $menu_cate ?>
                                        <li><a href="<?= base_url() . 'khuyen-mai' ?>">
                                            <span class="mc_title">Sản phẩm khuyến mãi</span>
                                            <span class="mc_desc hidden-md hidden-sm hidden-xs">Giảm giá nhiều sản phẩm cực sốc</span>
                                        </a></li>
                                        <li><a href="<?= base_url() . 'moi' ?>">
                                            <span class="mc_title">Sản phẩm mới khác</span>
                                            <span class="mc_desc hidden-md hidden-sm hidden-xs">Danh sách các sản phẩm mới</span>
                                        </a></li>
                                        <li><a href="<?= base_url() . 'noi-bat' ?>">
                                            <span class="mc_title">Sản phẩm nổi bật</span>
                                            <span class="mc_desc hidden-md hidden-sm hidden-xs">Các sản phẩm cực hot tại hệ thống</span>
                                        </a></li>
                                        <div class="clear"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 full-right">
                                <div id="searchform">
                                    <?= form_open(base_url().'tim-kiem', array('method' => 'get')); ?>
                                        <img  alt="loading" style="display: none;" class="loader" src="<?= base_url() ?>resources/ui_images/client/background/loader.gif"/>
                                        <?= form_input(array('name' => 't', 'id' => 'searchSgg', 'class' => 'searchfield', 'onkeyup' => 'lookup()', 'autocomplete' => 'off', 'placeholder' => 'Tìm kiếm sản phẩm ...')); ?>
                                        <?= form_submit('submit_search', 'Tìm kiếm', 'id="search_btn" class="searchbutton"'); ?>
                                        <div class="clear"></div>
                                        <div class="autoSuggestionsList_l" id="autoSuggestionsList">
                                        </div>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <button type="button" class="btn btn-danger button-support" data-toggle="modal" data-target="#supportonlineModal">Hỗ trợ trực tuyến</button>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
		