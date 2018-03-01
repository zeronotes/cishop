<!DOCTYPE html>
<html class="no-js" lang="<?= $lang ?>">
    <head>
        <!-- CSS and Jquery start here -->
        <?= $this -> load -> view('guest/includes/header') ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/client/social-likes_birman.css" />
        <script src="<?= base_url()?>resources/js/client/social-likes.min.js"></script>
        <!-- CSS and Jquery end here -->

        <script type="text/javascript">
            <?= $this -> load -> view('guest/includes/documentready') ?>
        </script>
    </head>
    <body lang="<?= $lang ?>">
        <?= $this -> load -> view('guest/includes/top') ?>
        <div id="main" class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div id="main-content">
                            <div class="breadcrumb">
                                <?= $breadcrumb ?>
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
                                                    <img class="media-object" alt="<?= $nL -> ImageAlt ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $nL -> ImageURL ?>">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="title">
                                                <a href="<?= base_url() .'tin-tuc/'. $nL -> Slug ?>"><?= $nL -> Title ?></a>
                                            </div>
                                            <div class="date"><?= $nL -> CreatedDate ?></div>
                                            <div class="description"><?= $nL -> Description ?></div>
                                        </div>
                                    </div>
                                    <div class="thumbnail hidden-lg hidden-md">
                                        <div class="images">
                                            <a href="<?= base_url() .'tin-tuc/'. $nL -> Slug ?>">
                                                <img class="media-object" alt="<?= $nL -> ImageAlt ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $nL -> ImageURL ?>">
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
                            <?php
                                if($links) {
                            ?>
                            <div class="pagination">
                                <?= $links ?>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div id="sidebar-right">
                            <div class="hot-news">
                                <h2>Tin tức mới nhất</h2>
                                <div class="content">
                                    <?php foreach ($latest_news as $l_n) { ?>
                                        <div class="media hidden-sm hidden-xs">
                                            <div class="media-left">
                                                <div class="images">
                                                    <a href="<?= base_url() . 'tin-tuc/' . $l_n -> Slug ?>">
                                                        <img class="media-object" alt="<?= $l_n -> ImageAlt ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $l_n -> ImageURL ?>">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="title">
                                                    <a href="<?= base_url() . 'tin-tuc/' . $l_n -> Slug ?>"><?= $l_n -> Title ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumbnail hidden-lg hidden-md">
                                            <div class="images">
                                                <a href="<?= base_url() . 'tin-tuc/' . $l_n -> Slug ?>">
                                                    <img class="media-object" alt="<?= $l_n -> ImageAlt ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $l_n -> ImageURL ?>">
                                                </a>
                                            </div>
                                            <div class="caption">
                                                <div class="title">
                                                    <a href="<?= base_url() . 'tin-tuc/' . $l_n -> Slug ?>"><?= $l_n -> Title ?></a>
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
        <?=$this -> load -> view('guest/includes/footer')?>
    </body>
</html>