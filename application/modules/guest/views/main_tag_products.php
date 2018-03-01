<!DOCTYPE html>
<html class="no-js" lang="<?= $lang ?>">
    <head>
        <!-- CSS and Jquery start here -->
        <?= $this -> load -> view('guest/includes/header') ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/client/flexslider.css" />
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/client/social-likes_birman.css" />
        <script src="<?= base_url()?>resources/js/client/jquery.flexslider-min.js"></script>
        <script src="<?= base_url()?>resources/js/client/social-likes.min.js"></script>
        <!-- CSS and Jquery end here -->
    </head>
    <body lang="<?= $lang ?>">
        <div id="wrapper">
            <!-- Top start here -->
            <div id="top">
                <?= $this -> load -> view('guest/includes/top') ?>
                <?= $this -> load -> view('guest/includes/menu') ?>
                <div class="clear"></div>
            </div>
            <!-- Top end here -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-xs-offset-0 col-md-10 col-md-offset-1 bg pad-btm">
                        <div class="row">
                            <div class="col-xs-12 col-md-9">
                                <div class="article_header my-breadcrumb">
                                    <?= $breadcrumb ?>
                                </div>
                                <div class="clear"></div>
                                <div class="product_list">
                                    <div class="row">
                                    <?php if($productsList){ foreach($productsList as $pL) { ?>
                                        <div class="col-xs-6 col-sm-4 col-lg-3">
                                            <div class="thumbnail products">
                                                <a href="<?= base_url() . $pL -> Slug ?>"><img alt="<?= $pL -> ImageAlt ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $pL -> ImageURL ?>"></a>
                                                <div class="caption">
                                                    <a href="<?= base_url() . $pL -> Slug ?>"><h3><?= $pL -> Title ?></h3></a>
                                                    <div class="clear"></div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 right-0"><span class="old-price"><?php if ($pL -> ListPrice > 0) echo number_format($pL -> ListPrice,0,".",".") . " đ"; ?></span></div>
                                                        <?php if ($pL -> SellPrice > 0) { ?>
                                                            <div class="col-xs-12 col-sm-6 left-0"><span class="new-price"><?= number_format($pL -> SellPrice,0,".",".") . " đ" ?></span></div>
                                                        <?php } else { ?>
                                                            <div class="col-xs-12 col-sm-6 left-0"><span class="new-price">Liên hệ</span></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }} ?>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="pagination">
                                    <?= $links ?>
                                </div>
                            </div>
                            <div class="col-md-3 hidden-xs hidden-sm">
                                <div class="header" style="margin-top:0;">
                                    <span>Tin tức mới</span>
                                </div>
                                <?php foreach ($latest_news as $l_n) { ?>
                                    <div class="media news longer">
                                        <div class="media-left">
                                        <a href="<?= base_url() . 'tin-tuc/' . $l_n -> Slug ?>">
                                            <img class="media-object" alt="<?= $l_n -> ImageAlt ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $l_n -> ImageURL ?>">
                                        </a>
                                        </div>
                                        <div class="media-body">
                                            <a href="<?= base_url() . 'tin-tuc/' . $l_n -> Slug ?>">
                                                <h4 class="media-heading longer"><i class="fa fa-angle-right hidden-lg hidden-md">&nbsp;</i><?= $l_n -> Title ?></h4>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="clear"></div>
                                <div class="scrollfix">
                                    <div class="header">
                                        <span>Sản phẩm bán chạy</span>
                                    </div>
                                    <?php if($SellerProducts){ foreach($SellerProducts as $SP) { ?>
                                    <div class="media products">
                                        <div class="media-left">
                                            <a href="<?= base_url() . $SP -> Slug ?>">
                                                <img class="media-object" alt="<?= $SP -> ImageAlt ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $SP -> ImageURL ?>">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <a href="<?= base_url() . $SP -> Slug ?>">
                                                <h4 class="media-heading"><?= $SP -> Title ?></h4>
                                            </a>
                                            <?php if ($SP -> SellPrice > 0) { ?>
                                                <span class="media-price"><?= number_format($SP -> SellPrice,0,".",".") ?> đ</span>
                                            <?php } else { ?>
                                                <span class="media-price">Liên hệ</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php }} ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom end here -->
            <div id="bottom">
                <?= $this -> load -> view('guest/includes/footer') ?>
                <div class="clear"></div>
            </div>
            <!-- Bottom end here -->

        </div>
        <?= $this -> load -> view('guest/includes/sticky') ?>
        <script type="text/javascript" charset="utf-8">
            <?= $this -> load -> view('guest/includes/documentready') ?>
        </script>
    </body>
</html>