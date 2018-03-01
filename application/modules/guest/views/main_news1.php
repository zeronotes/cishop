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
        #sidebar-left .block .h2, .dmsp .h2 {
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            font-family: Open\ Sans\ bold;
            margin: 0;
            background-color: #f66c10;
            padding: 10px;
        }

        .h1.page-title {
            border-left: 10px solid red;
            padding: 10px;
            font-size: 16px;
        }
        .h1.page-title {
            color: #fff;
            font-family: Open\ Sans\ bold;
            text-transform: uppercase;
        }

        .h1.page-title {
            margin: 0 0 10px;
        }
        .h1.page-title {
            background-color: #1f6997;
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
                            <div class="dmsp block">
                                <div class="content fix">
                                    <?= $cate_menu ?>
                                </div>
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
                                                    <a href="<?= $hp -> Slug ?>"><img src="<?= base_url() . 'resources/uploads/images/automatic/' . $hp -> ImageURL ?>"/></a>
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
                                                    <a href="<?= $sp -> Slug ?>"><img src="<?= base_url() . 'resources/uploads/images/automatic/' . $sp -> ImageURL ?>"/></a>
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
                            <div class="h1 page-title">
                                <?= $parent -> Title ?>
                            </div>
                            <div class="list-news">
                                <?php 
                                    if ($newsList==false) {
                                ?>
                                <div class="empty-content alert alert-info">
                                    Nội dung đang được cập nhật...
                                </div>
                                <?php
                                    }
                                    else {
                                        foreach ($newsList as $nL) {
                                ?>
                                    <div class="media hidden-sm hidden-xs">
                                        <div class="media-left">
                                            <div class="images">
                                                <a href="<?= base_url() .'tin-tuc/'. $nL -> Slug ?>">
                                                    <img class="media-object" alt="<?= $nL -> Title ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $nL -> ImageURL ?>">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="title">
                                                <a href="<?= base_url() .'tin-tuc/'. $nL -> Slug ?>"><?= $nL -> Title ?></a>
                                            </div>
                                            <div class="date"><?= $nL -> CreatedDate ?> - Lượt xem: <?= $nL -> View ?></div>
                                            <div class="description"><?= $nL -> Description ?></div>
                                        </div>
                                    </div>
                                    <div class="thumbnail hidden-lg hidden-md">
                                        <div class="images">
                                            <a href="<?= base_url() .'tin-tuc/'. $nL -> Slug ?>">
                                                <img class="media-object" alt="<?= $nL -> Title ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $nL -> ImageURL ?>">
                                            </a>
                                        </div>
                                        <div class="caption">
                                            <div class="title">
                                                <a href="<?= base_url() .'tin-tuc/'. $nL -> Slug ?>"><?= $nL -> Title ?></a>
                                            </div>
                                            <div class="date"><?= $nL -> CreatedDate ?> - Lượt xem: <?= $nL -> View ?></div>
                                            <div class="description"><?= $nL -> Description ?></div>
                                        </div>
                                    </div>
                                <?php
                                        }
                                    }
                                ?>
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