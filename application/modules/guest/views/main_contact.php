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
                            <div class="col-xs-12">
                                <div class="article_header my-breadcrumb">
                                    <?= $breadcrumb ?>
                                </div>
                                <div class="clear"></div>
                                <div id="detail">
                                    <?= form_open(current_url(),'style="width:80%;margin:0 auto;"'); ?>
                                        <div class="form-group">
                                            <label for="fullname">Họ và tên</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ và tên">
                                            <div class="clear"></div>
                                            <?= form_error('fullname') ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Số điện thoại</label>
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại">
                                            <div class="clear"></div>
                                            <?= form_error('phone') ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Địa chỉ email">
                                            <div class="clear"></div>
                                            <?= form_error('email') ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="contactDetail">Câu hỏi và bình luận</label>
                                            <textarea class="form-control" name="contactDetail" rows="3"></textarea>
                                            <div class="clear"></div>
                                            <?= form_error('contactDetail') ?>
                                        </div>
                                      <button type="submit" name="submit_register" class="btn btn-default">Gửi liên hệ</button>
                                    <?= form_close(); ?>
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