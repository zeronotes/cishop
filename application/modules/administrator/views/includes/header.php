<!DOCTYPE html>
<html>
<head>
<!-- CSS start here -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>HTSB© - CMS System</title>
<link rel="shortcut icon" href="<?= base_url()?>resources/ui_images/favi.png" type="image/x-icon">
<script src="<?= base_url()?>resources/js/jqueries/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>resources/js/ajaxfileupload.js"></script>
<script src="<?= base_url()?>resources/js/jqueries/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?= base_url()?>resources/js/jqueries/jquery.confirm.js"></script>
<script src="<?= base_url()?>resources/js/jqueries/jquery.notice.js"></script>
<script src="<?= base_url()?>ckeditor/ckeditor.js"></script>
<script src="<?= base_url()?>resources/js/common-js.js"></script>
<script src="<?= base_url()?>resources/js/jqueries/modalPopLite.min.js"></script>
<script src="<?= base_url()?>resources/js/jqueries/chosen.jquery.min.js"></script>
<script src="<?= base_url()?>resources/js/jqueries/tag-it.min.js"></script>
<script src="<?= base_url()?>resources/js/jqueries/multiselect.min.js"></script>
<script src="<?= base_url()?>resources/js/jqueries/jquery.number.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/admin/reset.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/admin/grid.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/admin/confirmdialog.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/admin/notice.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/admin/modalPopLite.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/admin/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/admin/base.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/admin/chosen.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url()?>resources/stylesheets/admin/jquery.tagit.css" />
<?php if(isset($css)) {
            echo $css;
        }
?>
<?php if(isset($js)) {
            echo $js;
        }
?>

<script type="text/javascript">
    var baseurl = "<?= base_url();?>";
</script>

<!-- CSS end here -->
</head>
<body>
<div class="wrapper">
<!-- Header start here -->
<div id="header">
    <div class="container_12">
        <div class="grid_4">
            <div id="logo">
                <a target="_blank" href="http://htsb.vn"></a>
            </div>
            <div id="seperator"></div>
            <div id="cp">
                <a href="<?= base_url();?>administrator"><?php echo str_replace(array('http://','/'),'',base_url());?></a>
            </div>
        </div>
        <div class="grid_8">
            <div id="exit">
                <a href="<?= base_url()?>administrator/logout"></a>
            </div>
            <div id="seperator_right"></div>
            <div id="help">
                <a target="_blank" href="http://htsb.com.vn/"></a>
            </div>
            <div id="seperator_right"></div>
            <div id="view">
                <a target="_blank" href="<?= base_url();?>"></a>
            </div>
        </div>
    </div>
</div>
<!-- Header end here -->

<div class="clear"></div>
<!-- Body start here -->
<div id="body">
    <div class="container_12">
        <div class="grid_12">
            <div id="menu">
                <ul>
                    <li><a href="javascript:void(0);">Đặt hàng</a>
                        <ul>
                            <li><a class="first" href="<?= base_url()?>administrator/orders">Danh sách đặt hàng</a></li>
                        </ul>
                    </li>
                    <!-- <li><a href="javascript:void(0);">T.kiếm sản phẩm</a>
                        <ul>
                            <li><a class="first" href="<?= base_url()?>administrator/sorting/price">Khung giá</a></li>
                            <li><a href="<?= base_url()?>administrator/sorting/brand">Thương hiệu</a></li>
                            <li><a href="<?= base_url()?>administrator/sorting/res">Độ phân giải (Camera)</a></li>
                            <li><a class="last" href="<?= base_url()?>administrator/sorting/channel">Số kênh (Đầu ghi)</a></li>
                        </ul>
                    </li> -->
                    <li><a href="javascript:void(0);">Sản phẩm</a>
                        <ul>
                            <li><a class="first" href="<?= base_url()?>administrator/products">Danh sách sản phẩm</a></li>
                            <li><a href="<?= base_url()?>administrator/categories/product">Danh mục sản phẩm</a></li>
                            <li><a class="last" href="<?= base_url()?>administrator/productstags">Danh sách tag sản phẩm</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);">Nội dung</a>
                        <ul>
                            <li><a class="first" href="<?= base_url()?>administrator/news">Danh sách tin tức</a></li>
                            <li><a href="<?= base_url()?>administrator/categories/news">Danh mục tin tức</a></li>
                            <!--<li><a href="<?= base_url()?>administrator/xetnghiem">Danh sách xét nghiệm</a></li>-->
                            <li><a href="<?= base_url()?>administrator/ads">Danh sách quảng cáo</a></li>
                            <li><a href="<?= base_url()?>administrator/categories/ads">Nhóm quảng cáo</a></li>
                            <li><a class="last" href="<?= base_url()?>administrator/newstags">Danh sách tag tin tức</a></li>
                            <!--<li><a href="<?= base_url()?>administrator/polls">Nhận xét, đánh giá</a></li>-->
                            <!--<li><a href="<?= base_url()?>administrator/people">Nhân sự</a></li>-->
                            <!--<li><a href="<?= base_url()?>administrator/dichvu">Dịch vụ</a></li>-->
                            <!-- <li><a href="<?= base_url()?>administrator/certificate">Chúng nhận - chứng chỉ</a></li> -->
                            <!--<li><a href="<?= base_url()?>administrator/onepages/payment-transfer">Thanh toán và vận chuyển</a></li>-->
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);">Khách hàng</a>
                        <ul>
                            <li><a class="first" href="<?= base_url()?>administrator/hotline">Hotline</a></li>
                            <li><a href="<?= base_url()?>administrator/partners">Đối tác</a></li>
                            <!-- <li><a href="<?= base_url()?>administrator/faqs">Hỏi đáp</a></li>
                            <li><a href="<?= base_url()?>administrator/callback">Yêu cầu gọi lại</a></li>
                            <li><a href="<?= base_url()?>administrator/testimonials">Ý kiến khách hàng</a></li> -->
                            <li><a class="last" href="<?= base_url()?>administrator/supportonline">Hỗ trợ trực tuyến</a></li>
                        </ul>
                    </li>
                    <!-- <li><a href="javascript:void(0);">Tuyển dụng</a>
                        <ul>
                            <li><a class="first" href="<?= base_url()?>administrator/recruitments">Tin tuyển dụng</a></li>
                        </ul>
                    </li>  -->
                    <!-- <li><a class="first" href="javascript:void(0);">Liên hệ</a>
                        <ul>
                            <li><a class="last first" href="<?= base_url()?>administrator/contact/customers">Khách hàng liên hệ</a></li>
                            <li><a class="last" href="<?= base_url()?>administrator/contact/text">Thông tin liên hệ</a></li>
                            <li><a class="last" href="<?= base_url()?>administrator/contact/text-text">Thông tin liên hệ</a></li>
                        </ul>
                    </li> -->
                    <li><a href="javascript:void(0);">Giao diện</a>
                        <ul>
                            <li><a class="first" href="<?= base_url()?>administrator/menu">Quản lý menu</a></li>
                            <!-- <li><a href="<?= base_url()?>administrator/menuhot">Quản lý menu phụ</a></li> -->
                            <!-- <li><a href="<?= base_url()?>administrator/footer">Thôn tin footer - liên hệ</a></li> -->
                            <li><a href="<?= base_url()?>administrator/favicons">Quản lý favicon</a></li>
                            <li><a href="<?= base_url()?>administrator/banners">Banner trang chủ</a></li>
                            <li><a href="<?= base_url()?>administrator/footers">Thông tin footer</a></li>
                            <li><a class="last" href="<?= base_url()?>administrator/logo">Quản lý logo</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);">Cấu hình</a>
                        <ul>
                            <li><a class="first" href="<?= base_url()?>administrator/seo">Tối ưu SEO</a></li>
							<li><a href="#" onclick="remove_cache(1)" >Xóa Cache</a></li>
							<li><a  href="#" type="submit" id="sitemap">Cập nhập Sitemap</a></li>
                            <li><a class="last" href="<?= base_url()?>administrator/adminpassword">Thay đổi mật khẩu quản trị</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
		  <script>

    function remove_cache(type){                                                
        var strUrl = '<?= base_url()?>ajaxhandle/admin_ajaxhandler/delete_cache';         
        $.ajax({
            type: "POST",
            url: strUrl,            
            data: {type:type}, 
            success: function(msg){                
              notice(msg);
             
            }
        })
    }
    $(document).ready(function(){
       $('body').on('click','#sitemap',function(){
         var strUrl = '<?= base_url()?>ajaxhandle/admin_ajaxhandler/Update_sitemap';         
         $.ajax({
            type: "POST",
            url: strUrl,            
            async: false,
            success: function(msg){                
              notice(msg);
             
            }
        })
       }) 
    })       

</script>