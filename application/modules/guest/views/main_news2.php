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
                            <?= $this -> load -> view('guest/includes/sidebar2') ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="main-content">
                            <div class="breadcrumb">
                                <?= $breadcrumb ?>
                            </div>
                            <div class="h1 page-title">
                                <?php if($parent -> Title == 'Trang'): ?>
                                    <?php if($SEOTitle !== false) echo $SEOTitle;?>
                                <?php else: ?>
                                <?= $parent -> Title ?>
                                <?php endif ?>
                            </div>
                            <div class="news-content">
                                <div class="widget row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <?= $news -> CreatedDate ?> - Lượt xem: <?= $news -> View ?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="social-likes" data-url="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
                                            <div class="facebook" title="Share link on Facebook">Facebook</div>
                                            <div class="twitter" title="Share link on Twitter">Twitter</div>
                                            <div class="plusone" title="Share link on Google+">Google+</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="news-desc"><?= $news -> Description ?></div>
                                    <div class="news-body"><?= $news -> Body ?></div>
                                    <!--
                                    <?php if ($news_tag) { ?>
                                        <div id="tags">
                                            <span><i class="fa fa-tags"></i>Tags</span>
                                            <?php foreach($news_tag as $nt) { ?>
                                                <a href="<?= base_url() . 'tag-tin-tuc/' . $nt -> Slug ?>"><?= $nt -> Title ?></a>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this -> load -> view('guest/includes/footer') ?>
    </body>
</html>