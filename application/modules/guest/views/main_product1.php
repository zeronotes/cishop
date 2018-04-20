<!DOCTYPE html>
<html class="no-js" lang="<?= $lang ?>">
<head>
    <?= $this -> load -> view('guest/includes/header') ?>

    <script type="text/javascript">
        <?= $this -> load -> view('guest/includes/documentready') ?>

        $(document).ready(function(){
            
        });
    </script>
    <style type="text/css">
        .other-product .h2 {
            margin: 0;
            background-color: #1f6997;
            color: #fff;
            padding: 10px;
            text-transform: uppercase;
            font-size: 16px;
            font-family: Open\ Sans\ bold;
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
                            <?= $this -> load -> view('guest/includes/sidebar2') ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="main-content">
                            <div class="breadcrumb">
                                <?= $breadcrumb ?>
                            </div>
                            <h1 class="page-title">
                                <?= $parent -> Title ?>
                            </h1>
                            <div class="list-products">
                                <div class="row">
                                    <?php if(isset($productsList[0] -> ProductsID)){ foreach($productsList as $pL) { ?>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="fix1" style="margin-bottom: 15px;">
                                            <div class="images">
                                                <a href="<?= $pL -> Slug ?>">
                                                    <img alt="<?= $pL -> ImageAlt ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $pL -> ImageURL ?>" />
                                                </a>
                                            </div>
                                            <div class="title">
                                                <a href="<?= $pL -> Slug ?>"><?= $pL -> Title ?></a>
                                            </div>
                                            <div class="sellprice" style="margin-top: 5px;">
                                                Giá: <?= number_format($pL -> SellPrice,0,".",".") . " VNĐ" ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }} else { ?>
                                    <div class="col-xs-12">
                                        <div class="alert alert-info" role="alert"><b>Rất tiếc!</b> Không có sản phẩm nào phù hợp yêu cầu của bạn.</div>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                            <div class="pagination">
                                <?= $links ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this -> load -> view('guest/includes/footer') ?>
    </body>
</html>