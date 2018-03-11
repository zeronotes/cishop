<div class="clear"></div>


    </div>
</div>
<!-- Body end here -->

<div class="clear"></div>

<!-- Footer start here -->
    <div id="footer">
        <div class="container_12">
            <div class="grid_12">

                <div id="develop">
                    Phát triển bởi CI SYSTEM / 2017
                </div>
            </div>
        </div>
    </div>
    <!-- Footer end here -->
</div>

<div id="lightbox"></div>

<div id="loading">
    <img src="<?= base_url()?>resources/ui_images/loading_transparent.gif"/>
</div>

<div id="go_top"></div>

<!--[if lt IE 9]>
<script
    src="<?= base_url()?>resources/js/jqueries/html5shiv.js">
</script>
<![endif]-->
<script type="text/javascript" charset="utf-8">
    $(function () {
        $("#loading").ajaxStart(function () {
            $(this).fadeIn(200);
            $("#lightbox").fadeIn(200);

        });

        $("#loading").ajaxStop(function () {
            $(this).fadeOut(200);
            $("#lightbox").fadeOut(200);
        });

        $("#loading").ajaxError (function () {
            $(this).fadeOut(200);
            $("#lightbox").fadeOut(200);
        });

        var sT = $(window).scrollTop();
        if ($(window).scrollTop() != "0")
            $("#go_top").fadeIn("slow");
        var scrollDiv = $("#go_top");
        $(window).scroll(function () {
            if ($(window).scrollTop() == "0")
                $(scrollDiv).fadeOut("slow")
            else
                $(scrollDiv).fadeIn("slow")
        });
        $("#go_top").click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, "slow")
        });

        anchorForm('loading');
    });

    function anchorForm(idform) {
        $("#"+idform).css('margin-top', ($("#lightbox").height() - $("#"+idform).height()) / 2);
        $("#"+idform).css('margin-left', ($("#lightbox").width() - $("#"+idform).width()) / 2);
    }

    function ConvertPrice(numberText, culture) {
        if(numberText == "") return 0;
        var number = 0;
        if(culture == "vi-VN") {
            number = numberText.replace(/\./g, "");
            return Number(number);
        }
        else {
            var s = numberText.length - 2;
            var c = numberText.substring(s - 1, s);
            if(c == ".") {
                number = numberText.replace(/\,/g, "");
                return Number(number);
            }
            if(c == ",") {
                number = numberText.replace(/\./g, "");
                number = number.replace(/\,/g, ".");
                return Number(number);
            }
        }
        return Number(numberText);
    }
</script>
<!-- Scripts end here -->
</body>
</html>