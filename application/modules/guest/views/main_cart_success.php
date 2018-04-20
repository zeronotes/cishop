<!DOCTYPE html>
<html class="no-js" lang="<?= $lang ?>">
<head>
    <?= $this -> load -> view('guest/includes/header') ?>

    <script type="text/javascript">
        <?= $this -> load -> view('guest/includes/documentready') ?>

        $(document).ready(function(){
            
        });
    </script>
</head>
    <body lang="<?= $lang ?>">
        <?= $this -> load -> view('guest/includes/top') ?>
        <div id="main" class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
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
                                Giỏ hàng
                            </h1>
                            <div class="row">
                                <div class="col-xs-12">
                                    <img style="display:block;margin:20px auto;" src="<?= base_url() ?>resources/ui_images/client/background/error_404.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this -> load -> view('guest/includes/sticky') ?>
    </body>
</html>