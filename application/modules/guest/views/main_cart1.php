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
                            <div class="dmsp block">
                                <div id="prd-cate-list" class="hidden-xs">
                                    <ul class="main-page">
                                        <?= $cate_menu ?>
                                        <div class="clear"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="spnb block">
                                <h2>Sản phẩm nổi bật</h2>
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
                                <h2>Sản phẩm bán chạy</h2>
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
                            <h1 class="page-title">Giỏ hàng</h1>
                            <div class="row hidden-xs hidden-sm">
                                <div class="col-xs-12">
                                    <?= form_open('update-cart'); ?>
                                    <table id="cart">
                                        <?php if ($cart = $this -> cart -> contents()) { ?>
                                            <tr>
                                                <th></th>
                                                <th>Mã - Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Giá sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                            <?php
                                                $grand_total = 0;
                                                foreach ($cart as $item):
                                                    echo form_hidden('cart['. $item['rowid'] .'][id]', $item['id']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][rowid]', $item['rowid']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][name]', $item['name']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][price]', $item['price']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][SKU]', $item['SKU']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][slug]', $item['slug']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][image]', $item['image']);
                                            ?>
                                            <tr>
                                                <td><a title="Xóa sản phẩm" style="font-size:20px;color:#000;" href="<?= site_url() ?>removecart/<?= $item['rowid'] ?>"><i class="fa fa-trash"></i></a></td>
                                                <td><b><?php if($item['SKU']){echo $item['SKU']. " - ";} ?><?= urldecode($item['name']) ?></b></td>
                                                <td><img class="cart_img" src="<?= base_url() ?>resources/uploads/images/automatic/<?= $item['image'] ?>"></td>
                                                <td><?= number_format($item['price'],0, ".", ".") ?> VNĐ</td>
                                                <td style="width:92px;"><input class="cart_qty" type="text" name="<?= 'cart['. $item['rowid'] .'][qty]' ?>" value="<?= $item['qty'] ?>" /></td>
                                                <td><?= number_format($item['subtotal'],0, ".", ".") ?> VNĐ</td>
                                                <?php $grand_total = $grand_total + $item['subtotal']; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="5">Tổng cộng</td>
                                                <td style="color:#ff0000;font-weight:bold;"><?= number_format($grand_total,0, ".", ",") ?> VNĐ</td>
                                            </tr>
                                            <tr class="no-border">
                                                <td colspan="6">
                                                    <input class="btn1" type="button" value="Xóa giỏ hàng" onclick="clear_cart()" />
                                                    <input style="margin-left:5px;" class="btn1" type="button" value="Tiếp tục mua hàng" onclick="location.href='<?= site_url() ?>'" />
                                                    <input style="float:right;margin-left:5px" class="btn2" type="button" value="Thanh toán" onclick="location.href='<?= base_url() ?>don-hang'" />
                                                    <input style="float:right;margin:5px" class="btn3" type="submit" value="Cập nhật số lượng" />
                                                    
                                                </td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <th>Giỏ hàng trống</th>
                                            </tr>
                                        <?php } ?>
                                        </table>
                                        <?= form_close(); ?>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="row hidden-lg hidden-md">
                                <div class="col-xs-12">
                                    <div class="header">
                                        <span>Giỏ hàng</span>
                                    </div>
                                    <?= form_open('update-cart'); ?>
                                    <table id="cart">
                                        <?php if ($cart = $this -> cart -> contents()) { ?>
                                            <?php
                                                $grand_total = 0;
                                                foreach ($cart as $item):
                                                    echo form_hidden('cart['. $item['rowid'] .'][id]', $item['id']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][rowid]', $item['rowid']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][name]', $item['name']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][price]', $item['price']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][SKU]', $item['SKU']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][slug]', $item['slug']);
                                                    echo form_hidden('cart['. $item['rowid'] .'][image]', $item['image']);
                                            ?>
                                            <tr>
                                                <td colspan="2"><b><?php if($item['SKU']){echo $item['SKU']. " - ";} ?><?= urldecode($item['name']) ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><img class="cart_img" src="<?= base_url() ?>resources/uploads/images/automatic/<?= $item['image'] ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><?= number_format($item['price'],0, ".", ".") ?> VNĐ</td>
                                                <td style="width:92px;"><input class="cart_qty" maxlength="3" size="1" name="<?= 'cart['. $item['rowid'] .'][qty]' ?>" value="<?= $item['qty'] ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text_last" colspan="2"><?= number_format($item['subtotal'],0, ".", ".") ?> VNĐ</td>
                                            </tr>
                                            <?php $grand_total = $grand_total + $item['subtotal']; ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="2">Tổng cộng</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="color:#ff0000;font-weight:bold;"><?= number_format($grand_total,0, ".", ",") ?> VNĐ</td>
                                            </tr>
                                            <tr class="no-border">
                                                <td colspan="2">
                                                    <input class="btn1" type="button" value="Xóa giỏ hàng" onclick="clear_cart()" />
                                                    <input class="btn1" type="button" value="Tiếp tục mua hàng" onclick="location.href='<?= site_url() ?>'" />
                                                    <input class="btn3" type="submit" value="Cập nhật số lượng" />
                                                    <input class="btn2" type="button" value="Thanh toán" onclick="location.href='<?= base_url() ?>don-hang'" />
                                                </td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <th>Giỏ hàng trống</th>
                                            </tr>
                                        <?php } ?>
                                        </table>
                                        <?= form_close(); ?>
                                    <div class="clear"></div>
                                </div>
                            </div>
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