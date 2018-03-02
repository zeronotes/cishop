<div id="bottom2" class="wrapper">
    <div class="container">
        <div class="row">
            <style type="text/css">
                #bottom2 .h2 {
                    margin: 0 0 10px;
                    font-size: 20px;
                    color: #f66c10;
                    font-family: Open\ Sans\ bold;
                }
            </style>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="camket2">
                    <div class="h2">Cam kết</div>
                    <div class="content">
                        <ul>
                            <li><span>Sản phẩm hàng hóa chính hãng, đa dạng, phong phú</span></li>
                            <li><span>Luôn luôn giá rẻ và khuyến mại không ngừng</span></li>
                            <li><span>Dịch vụ chăm sóc khách hàng uy tín, tận tâm</span></li>
                        </ul>
                        <div class="social">
                            <a class="btn btn-social-icon btn-facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a class="btn btn-social-icon btn-twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a class="btn btn-social-icon btn-google">
                                <i class="fa fa-google"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="kh">
                    <div class="h2">Hỗ trợ khách hàng</div>
                    <div class="content">
                        <ul>
                            <li><a href="<?= base_url() ?>tin-tuc/huong-dan-mua-hang">Hướng dẫn mua hàng</a></li>
                            <li><a href="<?= base_url() ?>tin-tuc/chinh-sach-va-quy-dinh-chung">Chính sách và quy định chung</a></li>
                            <li><a href="<?= base_url() ?>tin-tuc/thanh-toan-va-giao-hang">Thanh toán và giao hàng</a></li>
                            <li><a href="<?= base_url() ?>tin-tuc/chinh-sach-bao-mat-thong-tin">Chính sách bảo mật thông tin</a></li>
                            <li><a href="<?= base_url() ?>tin-tuc/chinh-sach-doi-tra-va-hoan-tien">Chính sách đổi trả và hoàn tiền</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="map">
                    <div class="h2">Bản đồ</div>
                    <div class="content" id="map-canvas" style="padding:0px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1862.509573357537!2d105.79249486463578!3d20.991869601452105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135acb791efde41%3A0x1e77d8baa14e19a3!2zMzQgVHJ1bmcgVsSDbiwgVOG7qyBMacOqbSwgSMOgIE7hu5lpLCBWaWV0bmFt!5e0!3m2!1sen!2s!4v1519957961499" width="100%" height="100%" allowfullscreen></iframe>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer" class="wrapper">
    <div class="container">
        <div class="row">
            <style type="text/css">
                .address .h1 {
                    margin: 0 0 20px;
                    color: #f66c10;
                    text-transform: uppercase;
                    font-family: Open\ Sans\ bold;
                    font-size: 20px;
                    text-align: center;
                }
            </style>
            <div class="address">
                <div class="h1 yl">CÔNG TY CỔ PHẦN DIỆT MỐI, MUỖI MIỀN BẮC</div>
                <?php
                    //if ($footers[0]['Body']) {
                ?>
                <div class="col-lg-12">
                    <div class="content yl">
                        <?php //echo $footers[0]['Body'] ?>
                        <p style="text-align: center;">&nbsp;</p>

                        <p style="text-align: center;">Địa chỉ&nbsp;: P1C5 TT Viện Sốt Rét- Trung Văn - Từ Liêm - Hà Nội</p>

                        <p style="text-align: center;">Điện thoại : 02422404658</p>

                        <p style="text-align: center;">Hotline :&nbsp;0975376090</p>

                        <p style="text-align: center;">Email: &nbsp;moimuoimienbac@welthyvn.net</p>

                        <p>&nbsp;</p>

                        <div id="fb-root">&nbsp;</div>

                        <p>&nbsp;</p>

                        <p><script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script></p>

                        <p>&nbsp;</p>

                        <div class="fb-like" data-action="like" data-href="http://wintechvn.com/" data-layout="standard" data-share="true" data-show-faces="true">&nbsp;</div>

                        <p>&nbsp;</p>
                    </div>
                </div>
                <?php
                    //}
                ?>
            </div>
        </div>
    </div>
</div>
<div id="copyright" class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="content"><span>Copyright © 2018 by WEALTHYVN. All rights reserved.</span></div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url()?>resources/js/client/jquery-2.1.3.min.js"></script>
<script src="<?= base_url()?>resources/js/client/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?= base_url()?>resources/js/client/bootstrap.js"></script>
<script src="<?= base_url()?>resources/js/client/scrollfix.js"></script>
<script src="<?= base_url()?>resources/js/client/equalheight.js"></script>
<script src="<?= base_url()?>resources/js/client/social-likes.min.js"></script>
<script src="<?= base_url()?>resources/bxslider/jquery.bxslider.min.js"></script>
<script src="<?= base_url()?>resources/slicknav/dist/jquery.slicknav.min.js"></script>
<script src="<?= base_url()?>resources/owl.carousel/owl-carousel/owl.carousel.min.js"></script>
<script type="text/javascript">
            function lookup(keyword) {
                var keyword = document.getElementById("searchSgg").value;
                if(keyword.length == 0) {
                    $('#autoSuggestionsList').fadeOut(400);
                } else {
                    $.post("<?= base_url()?>ajaxhandle/client_products_ajaxhandler/Ajax_Get_All_Product_Client", 
                    {keyword : keyword},
                    function(data){
                        if(data.length > 14) {
                            $('#autoSuggestionsList').fadeIn(400);
                            // var obj = jQuery.parseJSON(data);
                            var obj = JSON.parse(data);
                            var strhtml = '';
                            //$('#autoSuggestionsList').html(data['message']);
                            strhtml += '<div class="sgg-outer">';
                            for(var index in obj) {
                                //alert(obj.message[1].label);
                                //alert(obj.length());
                                for(var i=0;i<obj[index].length;i++) {
                                    //alert(obj.message[i].value);
                                    //append
                                    strhtml += '<div class="sgg-row">';
                                        strhtml += '<div class="sgg-image"><img  alt="loading" width="50" height="50" src="<?= base_url();?>resources/uploads/images/automatic/thumbs/' + obj.message[i].Image + '"/></div>';
                                        strhtml += '<div class="sgg-right">';
                                            strhtml += '<div class="sgg-title"><a href="<?= base_url();?>' + obj.message[i].Slug + '">' + obj.message[i].Title + '</a></div>';
                                            strhtml += '<div class="sgg-sellprice">' + parseFloat(obj.message[i].SellPrice).toFixed().replace(/./g, function(c, i, a) {return i && c !== "." && ((a.length - i) % 3 === 0) ? '.' + c : c;}) + ' đ</div>';
                                        strhtml += '</div>';
                                    strhtml += '</div>';
                                }
                            }
                            strhtml += '</div>';
                            $('#autoSuggestionsList').html(strhtml);
                        } else {
                            var strhtml = '';
                            strhtml += '<div class="sgg-outer">';
                                strhtml += '<div class="sgg-row">';
                                    strhtml += '<div class="sgg-title"><a>Không có sản phẩm nào tương ứng</a></div>';
                                strhtml += '</div>';
                            strhtml += '</div>';
                            $('#autoSuggestionsList').html(strhtml);
                        }
                    });
                // Ajax_Suggestion(keyword);
                }
            }
        </script>
<script>
    $(function(){
        $('#menu').slicknav();
    });


                    $(document).ready(function() {
                    var jQuerywindow = $(window);
                    var windowHeight = jQuerywindow.height();
                    if ($('#top-menu')) {
                        $(document).bind("scroll", function(){
                            if( $(window).scrollTop() >= windowHeight /8.5) {
                                $('#top-menu').addClass('topbar');
                            } else {
                                $('#top-menu').removeClass('topbar');
                            }
                        })
                    };

                    $('#main-menu').slicknav();

                });

                $('.main-menu ul > li').hover(function () {
                    $(this).children('ul').stop(true, true).delay(200).fadeIn(500);
                    }, function () {
                    $(this).children('ul').stop(true, true).fadeOut(500);
                });

                $(window).load(function() {
                    equalheight('.thumbnail.products');
                });


                $(window).resize(function(){
                    equalheight('.thumbnail.products');
                });

                $(window).load(function() {
                    equalheight('.thumbnail.products img');
                });

                $(window).load(function() {
                    equalheight('.fix1');
                });


                $(window).resize(function(){
                    equalheight('.fix1');
                });


                $(window).resize(function(){
                    equalheight('.thumbnail.products img');
                });

                $('#menu ul > li').hover(function () {
                    $(this).children('ul').stop(true, true).delay(200).fadeIn(500);
                }, function () {
                    $(this).children('ul').stop(true, true).fadeOut(500);
                });

                $('#prd-cate-list .sub-page > ul > li').hover(function () {
                    $(this).children('ul').stop(true, true).delay(200).fadeIn(500);
                }, function () {
                    $(this).children('ul').stop(true, true).fadeOut(500);
                });

                $('#prd-cate-list .sub-page > ul > li > ul > li').hover(function () {
                    $(this).children('ul').stop(true, true).delay(200).fadeIn(500);
                }, function () {
                    $(this).children('ul').stop(true, true).fadeOut(500);
                });


                $('#prd-cate-list').hover(function () {
                    $(this).children('ul.sub-page').stop(true, true).delay(200).slideDown(500);
                }, function () {
                    $(this).children('ul.sub-page').stop(true, true).slideUp(500);
                });

                $('#prd-cate-list .sub-page').hover(function () {
                    $(this).children('ul.sub-page').stop(true, true).delay(200).slideDown(500);
                }, function () {
                    $(this).children('ul.sub-page').stop(true, true).slideUp(500);
                });
                $('#prd-cate-list1 .sub-page > ul > li').hover(function () {
                    $(this).children('ul').stop(true, true).delay(200).fadeIn(500);
                }, function () {
                    $(this).children('ul').stop(true, true).fadeOut(500);
                });

                $('#prd-cate-list1').hover(function () {
                    $(this).children('ul.sub-page').stop(true, true).delay(200).slideDown(500);
                }, function () {
                    $(this).children('ul.sub-page').stop(true, true).slideUp(500);
                });

                $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
                    event.preventDefault(); 
                    event.stopPropagation(); 
                    $(this).parent().siblings().removeClass('open');
                    $(this).parent().toggleClass('open');
                });
                
                $('.scrollfix').scrollFix({fixTop:40});
</script>



 <script src="<?= base_url()?>resources/js/client/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
        <?= $this -> load -> view('guest/includes/documentready') ?>
        $(document).ready(function(){
            $('.bxslider').bxSlider({
                auto: true
            });

            $("#owl-example").owlCarousel({
                autoPlay: true,
                navigation: true,
                pagination: false,
                navigationText: ["<",">"]
            });
        });
    </script>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
        }
    </style>
    <script type="text/javascript">
        $(window).load(function() {
            $('#slider').nivoSlider({
                pauseTime: 3000,
                effect: 'boxRainGrowReverse,boxRandom,fold,sliceUpDownLeft',
            });
        });
    </script> 

<script lang="javascript">
(function() {var _h1= document.getElementsByTagName('title')[0] || false;
var product_name = ''; if(_h1){product_name= _h1.textContent || _h1.innerText;}var ga = document.createElement('script'); ga.type = 'text/javascript';
ga.src = '//live.vnpgroup.net/js/web_client_box.php?hash=d1fb8822e43a07de389c23a386ee0ef4&data=eyJzc29faWQiOjI1ODkzNTQsImhhc2giOiIzMWY4MzZmMjI2ZWI2NjMwNGQ4NGJhYTNmMjA2ODIxOSJ9&pname='+product_name;
var s = document.getElementsByTagName('script');s[0].parentNode.insertBefore(ga, s[0]);})();
    $(document).ready(function(){
        // setTimeout(function(){
        //       // $('.vgc_tt').contents().unwrap().wrap('<div class="vgc_tt" onclick="vgc_sh_chat_contact();"/>');
           
        // },1000);
      
    });
</script>
