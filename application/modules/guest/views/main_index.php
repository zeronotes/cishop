<!DOCTYPE html>
<html class="no-js" lang="<?= $lang ?>">
<head>
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous"> -->
    <?= $this -> load -> view('guest/includes/header') ?>
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/client/nivo-slider.css" /> -->
   <!--  <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'> -->
   
</head>
<body lang="<?= $lang ?>">
    <?= $this -> load -> view('guest/includes/top') ?>
    <div id="main" class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div id="sidebar-left">
                        <?= $this -> load -> view('guest/includes/sidebar') ?>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="main-content">
                        <div id="banner" class="slider-wrapper theme-default">
                            <div id="slider" class="nivoSlider">
							 <?php $i=0;?>
                                <?php foreach ($banners as $ban) { 
                                 $i++;
                                if(empty($ban['Link'])) {
                            ?>
                                <a href="#">
                                    <img alt="Ảnh banner <?=$i?>" src=" <?= base_url() ?>resources/uploads/images/automatic/<?= $ban['ImageURL'] ?>" />
                                    <div class="clear"></div>
                                </a>
                            <?php } else { ?>
                                <a target="_blank" href="<?= $ban['Link'] ?>">
                                    <img alt="<?= $ban['Body'] ?>" src="<?= base_url() ?>resources/uploads/images/automatic/<?= $ban['ImageURL'] ?>" />
                                    <div class="clear"></div>
                                </a>
                            <?php }} ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <?php foreach ($hot_cate_products as $hcp) { ?>
                        <ul class="nav nav-tabs custom-tabs" role="tablist">
                            <li role="presentation" class="active"><a style="line-height:22px;" href="<?= base_url() . $hcp -> Slug ?>"><?= $hcp -> Title ?></a></li>
                            <li class="ok-background hidden-xs" style="border: none; margin-top: 0;"></li>
                            <?php if($hcp -> childCate) { foreach ($hcp -> childCate as $childCate) { if (($childCate -> IsTop)==1) { ?>
                                <li class="hidden-xs hidden-sm" role="presentation"><a href="<?= base_url() . $childCate -> Slug ?>"><?= $childCate -> Title ?></a></li>
                            <?php }}} ?>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="dmsp-<?= $hcp -> Slug ?>">
                                <div class="row">
                                    <div class="col-xs-12 col-lg-12">
                                        <div class="row">
                                            <?php if($hcp -> products){ $hcp_counter = 0; foreach($hcp -> products as $hcpp) { $hcp_counter++; if($hcpp -> IsNew ==1){?>
                                                <div class="col-xs-6 col-sm-4 col-lg-3 <?php if($hcp_counter >= 5) {echo "hidden-xs ";} if($hcp_counter >= 7) {echo "hidden-sm hidden-md";} ?>">
                                                    <div class="thumbnail products test">
                                                        <a href="<?= base_url() . $hcpp -> Slug ?>"><img alt="<?= $hcpp -> Title ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $hcpp -> ImageURL ?>" style="max-height: 180px"></a>
                                                        <div class="title">
                                                            <a href="<?= base_url() . $hcpp -> Slug ?>"><?= $hcpp -> Title ?></a>
                                                        </div>
                                                        <div class="caption">
                                                            <div class="clear"></div>
                                                            <div class="sku">
                                                                Mã sản phẩm: <?= $hcpp -> SKU ?>
                                                            </div>
                                                            <?php if ($hcpp -> SellPrice > 0) { ?>
                                                                <span class="new-price">Giá: <?= $hcpp -> SellPrice ?> đ</span>
                                                            <?php } else { ?>
                                                                <span class="new-price">Giá: Liên hệ</span>
                                                            <?php } ?>
                                                            <span class="old-price"><?php if ($hcpp -> ListPrice > 0) echo number_format($hcpp -> ListPrice,0,".",".") . " đ"; ?></span>
                                                            <span class="sale-price hidden-xs hidden-sm"><?php if ($hcpp -> ListPrice > 0 && $hcpp -> SellPrice > 0) echo "Khuyến mãi giá trị lên đến <br /><b>" . number_format($hcpp -> ListPrice - $hcpp -> SellPrice,0,".",".") . " đ</b>"; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }}} ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
                
            </div>
        </div>
    </div>
    <div id="bottom" class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="front-news">
                        <h2><span>Tin tức - sự kiện</span></h2>
                        <div class="content" style="border:0px !important;">
                            <div class="row" style="background:#fbf9f9;padding-top: 10px;">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-bottom: 15px;">
                                    <?php
                                        if($child_news_1) {
                                            foreach ($child_news_1 as $cn1) {
                                    ?>
                                    <div class="big-news">
                                        <div class="images" style="border:0px !important;">
                                            <a href="<?= base_url(). 'tin-tuc/' .$cn1 -> Slug ?>">
                                                <img alt="<?= $cn1 -> Title ?>" src="<?=base_url() . 'resources/uploads/images/automatic/' . $cn1 -> ImageURL ?>">
                                            </a>
                                        </div>
                                        <div class="title">
                                            <a href="<?= base_url(). 'tin-tuc/' .$cn1 -> Slug ?>"><?= $cn1 -> Title ?></a>
                                        </div>
                                        <div class="description" style="font-size: 14px;">
                                            <span><?= $cn1 -> Description ?></span>
                                        </div>
                                    </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-bottom: 20px;">
                                    <div class="small-news">
                                        <ul>
                                            <?php
                                                if($child_news_2) {
                                                    foreach ($child_news_2 as $cn2) {
                                            ?>
                                                <li>
                                                    <div class="images">
                                                        <a href="<?= base_url(). 'tin-tuc/' .$cn2 -> Slug ?>">
                                                            <img alt="<?= $cn2 -> Title ?>" src="<?=base_url() . 'resources/uploads/images/automatic/' . $cn2 -> ImageURL ?>">
                                                        </a>
                                                    </div>
                                                    <div class="title">
                                                        <a href="<?= base_url(). 'tin-tuc/' .$cn2 -> Slug ?>"><?= $cn2 -> Title ?></a>
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
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="background:#fbf9f9;">
                    <div class="gioithieu">
                        <h2><span>Giới thiệu</span></h2>
                        <div class="content" style="border:0px !important;">
                            <?php
                                if($gioithieu) {
                            ?>
                                    <img style="padding-bottom:15px;padding-top: 10px;" alt="Giới thiệu" src="<?=base_url() . 'resources/uploads/images/automatic/' . $gioithieu -> ImageURL ?>">
                                    <?= $gioithieu -> Description ?>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="doitac">
                        <h2><span>Đối tác</span></h2>
                        <div id="owl-example" class="owl-carousel">
                            <?php
                                if($partner){
                                    foreach ($partner as $pa) {
                            ?>
                            <div class="content">
                                <a target="_blank" href="<?= $pa['Url'] ?>">
                                    <img  alt="Đối tác" src="<?=base_url() . 'resources/uploads/images/automatic/' . $pa['ImageUrl'] ?>"/>
                                </a>
                            </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <?=$this -> load -> view('guest/includes/footer')?>

    <?php if ($message) { ?>
        <div class="modal" id="alert-dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Thông báo</h4>
                    </div>
                    <div class="modal-body">
                        <?php echo $message; ?>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" type="button" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(function() {
            $('#alert-dialog').modal('show').on('hidden.bs.modal');
        });
        </script>
    <?php } ?>
</body>
</html>