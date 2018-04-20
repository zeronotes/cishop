                        <div id="prd-cate-list" class="hidden-xs">
                            <ul class="main-page">
                                <?= $menu_cate ?>
                                <div class="clear"></div>
                            </ul>
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
                                                <a href="<?= $hp -> Slug ?>"><img  alt="<?=$hp -> Title?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $hp -> ImageURL ?>"/></a>
                                            </div>
                                            <div class="title">
                                                <a style="font-weight: bold; color: #1f6997" href="<?= $hp -> Slug ?>"><?= $hp -> Title ?></a>
                                            </div>
                                            <div class="sku">
                                                Mã sản phẩm: <?= $hp -> SKU ?>
                                            </div>
                                            <div class="sellprice">
                                                <?php if($hp->SellPrice != 0): ?>
                                                    <?= $hp -> SellPrice ?> VNĐ
                                                <?php endif ?>
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
                                                <a href="<?= $sp -> Slug ?>"><img alt="<?= $sp -> Title ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $sp -> ImageURL ?>"/></a>
                                            </div>
                                            <div class="title">
                                                <a style="font-weight: bold; color: #1f6997" href="<?= $sp -> Slug ?>"><?= $sp -> Title ?></a>
                                            </div>
                                            <div class="sku">
                                                Mã sản phẩm: <?= $sp -> SKU ?>
                                            </div>
                                            <div class="sellprice">
                                                <?php if($sp->SellPrice != 0): ?>
                                                    <?= $sp -> SellPrice ?> VNĐ
                                                <?php endif ?>
                                            </div>
                                        </li>
                                    <?php
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div id="adv-left">
                            <div class="content">
                                <?php if($adv_left) { 
                                    foreach ($adv_left as $advleft) { 
                                ?>
                                <div class="images"><img alt="<?= $ban['Body'] ?>" src="<?= base_url() . 'resources/uploads/images/automatic/' . $advleft -> ImageURL ?>"></div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>