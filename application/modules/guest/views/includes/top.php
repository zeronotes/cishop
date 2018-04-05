<div id="header" class="wrapper hidden-sm hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-10">
                <div class="menu-top">
                    <div class="content fix">
                        <?php echo $menu ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2">
                <div class="support">
                    <button type="button" class="btn btn-danger button-support" data-toggle="modal" data-target="#supportonlineModal">Hỗ trợ trực tuyến</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display: none">
    		<div class="vcard">
			    <div class="fn org">Wealthyvn</div>
			    <div class="adr">
			        <div class="street-address">Trung Văn</div>
			        <div> <span class="locality">Hà Nội</span>, <abbr class="region" title="California">CA</abbr> 
			        <span class="postal-code">100000</span></div>
			        <div class="country-name">Việt Nam</div>
			    </div>
			    <div>Phone: <span class="tel">024 2240 4658 - 097 5376 090</span></div>
			    <div>Email: <span class="email">moimuoimienbac@wealthyvn.net</span></div>
			    <div class="tel">
			        <span class="type">Phone</span>:
			        <span class="value">>098 1231 002</span>
			    </div>
			</div>
    		
    	</div>

<div id="site-menu" class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="logo">
                    <a href="<?= base_url(); ?>">
                        <img  alt="Trang chủ" title="<?= $logo['Title'] ?>" src="<?=base_url() . 'resources/uploads/images/automatic/' . $logo['ImageURL']  ?>"/>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 hidden-sm hidden-xs">
                <div id="camket">
                    <div class="content fix">
                        <ul>
                            <li class="first">
                                <div class="one">Cam kết</div>
                                <div class="two">Chất lượng tốt nhất</div>
                            </li>
                            <li class="second">
                                 <div class="one">Dịch vụ</div>
                                <div class="two">Uy tín nhất</div> 
                            </li>
                            <li class="third last">
                                <div class="one">Giao hàng</div>
                                <div class="two">Toàn quốc</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="hotline">
                    <?php 
                        if($hotline){
                            foreach ($hotline as $key) {
                               echo "<a style='text-decoration: none;' href='tel: ".$key['Phone']."'><div class='number'>" . $key['Phone'] . "</div></a>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="top" class="wrapper hidden-sm hidden-xs">
    <div class="container">
        <div class="row">
        <style type="text/css">
            .dmsp .h2{
                color: #fff;
                font-size: 16px;
                text-transform: uppercase;
                font-family: Open\ Sans\ bold;
                margin: 0;
                background-color: #f66c10;
                padding: 10px;
            }
            .dmsp .h2 i {
                float: right;
                font-size: 24px;
                line-height: 16px;
            }
        </style>
            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                <div class="dmsp">

                    <div class="h2">Danh mục sản phẩm<i class="fa fa-chevron-circle-down"></i></div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6 hidden-sm hidden-xs">
                <div class="search">
                    <?= form_open(base_url().'tim-kiem', array('method' => 'get')); ?>
                        <?= form_input(array('name' => 't', 'id' => 'searchSgg', 'class' => 'searchfield', 'onkeyup' => 'lookup()', 'autocomplete' => 'off', 'placeholder' => 'Tìm kiếm sản phẩm ...')); ?>
                        <?= form_submit('submit_search', 'Tìm kiếm', 'id="search_btn" class="searchbutton"'); ?>
                        <div class="clear"></div>
                        <div class="autoSuggestionsList_l" id="autoSuggestionsList">
                        </div>
                    <?= form_close(); ?>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 hidden-sm hidden-xs">
                <a class="name_cart" href="<?= base_url() ?>gio-hang">Giỏ hàng (<b><?= $cart_counter ?></b> sản phẩm)</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="supportonlineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Hỗ trợ trực tuyến</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="modal_hotline_list">
                        <?php foreach ($support_online as $so) { ?>
                            <div class="col-xs-12">
                                <div class="hotline2">
                                    <p class="title"><?= $so['Title'] ?></p>
                                    <?php if ($so['FullName']) {echo '<p>'. $so['FullName'] .'</p>';} ?>
                                    <p>Sđt:   <?= $so['Phone'] ?></p>
                                    <p>Email: <?= $so['Email'] ?></p>
                                    <?php if ($so['Yahoo']) {echo '
                                        <a href="ymsgr:SendIM?'. $so['Yahoo'] .'">
                                            <img style="height:25px;" alt="liên hệ yahoo" border="0" align="absmiddle" src="http://opi.yahoo.com/online?u='. $so['Yahoo'] .'&amp;m=g&amp;t=1&amp;l=us">
                                       </a>
                                    ';} ?>
                                    <?php if ($so['Skype']) {echo '
                                        <a href="skype:'. $so['Skype'] .'?chat" class="icons skype"><i style="font-size:25px;margin-left:10px;" class="fa fa-skype"></i></a>
                                    ';} ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>