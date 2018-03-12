<!DOCTYPE html>
<html class="no-js" lang="<?= $lang ?>">
<head>
    <?= $this -> load -> view('guest/includes/header') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/client/social-likes_birman.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/client/jquery.bootstrap-touchspin.css" />
    <script src="<?= base_url()?>resources/js/client/social-likes.min.js"></script>
    <script src="<?= base_url()?>resources/js/client/jquery.bootstrap-touchspin.min.js"></script>

    <script type="text/javascript">
        <?= $this -> load -> view('guest/includes/documentready') ?>

        $(document).ready(function(){
            
        });
    </script>
     <style type="text/css">
        .content-product .body .h2, .other-product .h2 {
            margin: 0;
            background-color: #1f6997;
            color: #fff;
            padding: 10px;
            text-transform: uppercase;
            font-size: 16px;
            font-family: Open\ Sans\ bold;
        }
        #sidebar-left .block .h2, .dmsp .h2 {
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            font-family: Open\ Sans\ bold;
            margin: 0;
            background-color: #f66c10;
            padding: 10px;
        }
    </style>
</head>
    <body lang="<?= $lang ?>">
        <?= $this -> load -> view('guest/includes/top') ?>
        <div id="main" class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                        <div id="sidebar-left">
                            <div id="prd-cate-list" class="hidden-xs">
                                <ul class="main-page">
                                    <?= $menu_cate ?>
                                    <div class="clear"></div>
                                </ul>
                            </div>
                            <div class="spnb block">
                                <div class="h2">Sản phẩm nổi bật</div>
                                <div class="content fix">
                                    <ul>
                                        <?php if($HotProducts) { 
                                            foreach ($HotProducts as $hp) { 
                                        ?>
                                            <li>
                                                <div class="images">
                                                    <a href="<?= $hp -> Slug ?>"><img  alt="<?= $hp -> Title ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $hp -> ImageURL ?>"/></a>
                                                </div>
                                                <div class="title">
                                                    <a href="<?= $hp -> Slug ?>"><?= $hp -> Title ?></a>
                                                </div>
                                                <div class="sku">
                                                    Mã sản phẩm: <?= $hp -> SKU ?>
                                                </div>
                                                <div class="sellprice">
                                                    <?= $hp -> SellPrice ?> VNĐ
                                                </div>
                                            </li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="spnb block">
                                <div class="h2">Sản phẩm bán chạy</div>
                                <div class="content fix">
                                    <ul>
                                        <?php if($SellerProducts) { 
                                            foreach ($SellerProducts as $sp) { 
                                        ?>
                                            <li>
                                                <div class="images">
                                                    <a href="<?= $sp -> Slug ?>"><img alt="<?= $sp -> Title ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $sp -> ImageURL ?>"/></a>
                                                </div>
                                                <div class="title">
                                                    <a href="<?= $sp -> Slug ?>"><?= $sp -> Title ?></a>
                                                </div>
                                                <div class="sku">
                                                    Mã sản phẩm: <?= $sp -> SKU ?>
                                                </div>
                                                <div class="sellprice">
                                                    <?= $sp -> SellPrice ?> VNĐ
                                                </div>
                                            </li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="main-content">
                            <div class="breadcrumb">
                                <?= $breadcrumb ?>
                            </div>
                            <h1 class="page-title">
                                <?php if($product -> Title) { echo $product -> Title; } ?>
                            </h1>
                            <div class="content-product">
                                  <style type="text/css">
                                                    .social-likes__icon{
                                                        width: 34px;
                                                        height: 32px;
                                                    }
                                                    .social-likes__widget {
                                                        margin: 0px;
                                                        color: #000;
                                                        background: #fff;
                                                        border: 0px solid #ccc;
                                                        border-radius: 3px;
                                                        line-height: 19px;
                                                    }
                                                    .hover-s{
                                                        display: none;
                                                        position: absolute;
                                                        bottom: 12px;
                                                        left: calc(50% - 38px);
                                                    }
                                                    .img-review:hover .hover-s{
                                                        display: block;
                                                    }
                                                     
                                                </style>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <div class="images">
                                            <a data-toggle="modal" data-target=".bs-example-modal-lg">
                                                <div style="position: relative;" class="img-review">
                                                <img style="cursor:pointer;display:block;margin:0 auto;" alt="<?= $product -> Title ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $product -> ImageURL ?>">
                                                    <div class="social-likes hover-s" data-url="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
                                                        <a class="btn btn-social-icon btn-facebook facebook" data-href="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" data-layout="button_count"><i class="fa fa-facebook"></i></a>
                                                        <a class="btn btn-social-icon btn-twitter twitter" data-href="https://twitter.com/share"  data-url="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><i class="fa fa-twitter"></i></a>
                                                        <a class="btn btn-social-icon btn-google plusone" data-size="medium" data-href="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><i class="fa fa-google"></i></a>
                                                    </div>
                                                </div>
                                            </a>
                                              
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="mota">
                                            <div class="sku">
                                                <label>Mã sản phẩm:</label>
                                                <span class="more">
                                                    <?php if($product -> SKU) { echo $product -> SKU; } ?>
                                                </span>
                                            </div>
                                            <div class="price">
                                                <label>Giá:</label>
                                                <span class="more">
                                                    <?php if($product -> SellPrice && $product -> SellPrice > 0) { echo number_format($product -> SellPrice,0,",","."); ?>
                                                    <?php } else {echo "Liên hệ";} ?>
                                                </span>
                                            </div>
                                            <div class="order">
                                                <?php if($product -> SellPrice > 0) { 
                                                    echo form_open('addcart', 'class="addcart"');
                                                    echo form_hidden('id', $product -> ProductsID);
                                                    echo form_hidden('name', $product -> Title);
                                                    echo form_hidden('price', $product -> SellPrice);
                                                    echo form_hidden('SKU', $product -> SKU);
                                                    echo form_hidden('image', $product -> ImageURL);
                                                    echo form_hidden('slug', $product -> Slug);
                                                ?>
                                                <div>Số lượng: 
                                                    <span class='detail-spinner'>
                                                    <?php
                                                        echo form_input(array(
                                                            'name' => 'qty',
                                                            'class' => 'cart_qty',
                                                            'value' => 1
                                                        ));
                                                    ?>
                                                    </span>
                                                </div>
                                                <?php
                                                    echo form_submit('action', 'Đặt hàng','class="cart_submit"');
                                                    echo form_close();
                                                } ?>
                                            </div>
                                            <div class="social2">
                                                <label>Chia sẻ:</label>
                                              
                                                <div class="social-likes" data-url="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
                                                    <a class="btn btn-social-icon btn-facebook facebook" data-href="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" data-layout="button_count"><i class="fa fa-facebook"></i></a>
                                                    <a class="btn btn-social-icon btn-twitter twitter" data-href="https://twitter.com/share"  data-url="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><i class="fa fa-twitter"></i></a>
                                                    <a class="btn btn-social-icon btn-google plusone" data-size="medium" data-href="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><i class="fa fa-google"></i></a>
                                                </div>
                                               <!--  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <div class="social-likes" data-url="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
                                                        <div class="facebook" title="Share link on Facebook">Facebook</div>
                                                        <div class="twitter" title="Share link on Twitter">Twitter</div>
                                                        <div class="plusone" title="Share link on Google+">Google+</div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="body">
                                            <div class="h2">Chi tiết sản phẩm</div>
                                            <div class="content">
                                                <?= $product -> Body ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <?php if($relative) { ?>
                                            <div class="other-product">
                                                <div class="h2">Sản phẩm cùng danh mục</div>
                                                <div class="content">
                                                    <div class="row">
                                                        <?php foreach($relative as $rel) { ?>
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="fix1">
                                                                    <div class="images">
                                                                        <a href="<?= $rel -> Slug ?>">
                                                                            <img  alt="<?= $rel -> Title ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $rel -> ImageURL ?>" />
                                                                        </a>
                                                                    </div>
                                                                    <div class="title">
                                                                        <a href="<?= $rel -> Slug ?>"><?= $rel -> Title ?></a>
                                                                    </div>
                                                                    <div class="sellprice" style="margin-top: 5px;">
                                                                        Giá: <?= number_format($rel -> SellPrice,0,".",".") . " VNĐ" ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this -> load -> view('guest/includes/footer') ?>

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?= $product -> Title ?></h4>
                    </div>
                    <div class="modal-body">
                        <img style="display:block;margin:0 auto;" alt="<?= $product -> Title ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $product -> ImageURL ?>">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>