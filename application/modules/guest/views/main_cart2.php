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
                    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                        <div id="sidebar-left">
                            <?= $this -> load -> view('guest/includes/sidebar2') ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="main-content">
                            <h1 class="page-title">
                                Giỏ hàng
                            </h1>
                            <table id="cart">
                                <tr>
                                    <td>
                                        <span style="color: #333;">Xin vui lòng điền thông tin dưới đây để chúng tôi thực hiện giao hàng tới cho bạn</span>
                                        <?= form_open() ?>
                                        <div class="form_label_input">
                                            <label for="fullname">Họ tên<span class="required"> * </span></label>
                                            <input type="text" name="fullname" id="fullname" value="<?php if (isset($cart_guest['fullname'])) echo $cart_guest['fullname']; ?>" >
                                            <?php echo form_error('fullname'); ?>
                                        </div>
                                        <div class="form_label_input">
                                            <label for="phone">Điện thoại<span class="required"> * </span></label>
                                            <input type="text" name="phone" id="phone" value="<?php if (isset($cart_guest['phone'])) echo $cart_guest['phone']; ?>" >
                                            <?php echo form_error('phone'); ?>
                                        </div>
                                        <div class="form_label_input">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" id="email" value="<?php if (isset($cart_guest['email'])) echo $cart_guest['email']; ?>" >
                                            <?php echo form_error('email'); ?>
                                        </div>
                                        <div class="form_label_input">
                                            <label for="address">Địa chỉ<span class="required"> * </span></label>
                                            <textarea style="width:100%;height:100px" name="address" id="address"><?php if (isset($cart_guest['address'])) echo $cart_guest['address']; ?></textarea>
                                            <?php echo form_error('address'); ?>
                                        </div>
                                        <input name="submit_guest" class="form_label_submit btn3" type="submit" value="Bước tiếp theo" >
                                        <?= form_close() ?>
                                    </td>
                                </tr>
                                <tr class="no-border">
                                    <td colspan="7">
                                        <input class="btn2" type="button" value="Trở về giỏ hàng" onclick="location.href='<?= site_url() ?>gio-hang'" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" charset="utf-8">
            <?= $this -> load -> view('guest/includes/documentready') ?>

            $(".cart_qty").TouchSpin({
                verticalbuttons: true,
                verticalupclass: 'glyphicon glyphicon-plus',
                verticaldownclass: 'glyphicon glyphicon-minus'
            });

            function clear_cart() {
                var result = confirm('Bạn muốn hủy giỏ hàng ?');
                if(result) {
                    window.location = "<?php echo base_url(); ?>removecart/all";
                }else{
                    return false; // cancel button
                }
            }
        </script>
    </body>
</html>