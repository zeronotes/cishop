<div class="grid_12">
    <div class="header-content">Thay đổi mật khẩu quản trị</div>
    <div class="clear"></div>
    <div class="wrap-main-body">
        <form method="post" action="<?= current_url();?>/save" name="form-change-pass" id="form-change-pass" accept-charset="utf-8">
            <div id="login">
                <?php echo form_error('oldpassword'); ?>
                <input type="text" name="oldpassword" id="oldpassword" value="Mật khẩu cũ" onfocus="if(this.value=='' || this.value == 'Mật khẩu cũ') {this.value='';this.type='password'}" onblur="if(this.value == '') {this.type='text';this.value=this.defaultValue}" class="login password">
                <?php echo form_error('password'); ?>
                <input type="text" name="password" id="password" value="Mật khẩu mới" onfocus="if(this.value=='' || this.value == 'Mật khẩu mới') {this.value='';this.type='password'}" onblur="if(this.value == '') {this.type='text';this.value=this.defaultValue}" class="login password">
                <?php echo form_error('confirmpassword'); ?>
                <input type="text" name="confirmpassword" id="confirmpassword" value="Xác nhận mật khẩu mới" onfocus="if(this.value=='' || this.value == 'Xác nhận mật khẩu mới') {this.value='';this.type='password'}" onblur="if(this.value == '') {this.type='text';this.value=this.defaultValue}" class="login password">
                <div class="button"><a onclick="submitform();">Xác nhận</a></div>
            </div>

        </form>
    </div>
    <script type="text/javascript">
      var msg = "<?= $msg ?>";

      jQuery(document).ready(function($) {
          if(msg != "") {
              notice(msg);
          }
      });

      function scrollToError(yeah) {
          $('html, body').animate({scrollTop:$('#'+yeah).offset().top - 50}, 'slow');
      }

      function submitform() {
          $("#form-change-pass").submit();
      }

      $('#form-change-pass').submit(function() {
          $(".error").remove();
          var idElementError = "";
          var hasError = false;
          var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

          var oldpassword = $("#oldpassword").val();
          if(oldpassword == '' || oldpassword == "Mật khẩu cũ") { 
              $("#oldpassword").before('<div class="error Required">Bạn phải nhập mật khẩu cũ</div>');
              hasError = true;
              if (idElementError == "") idElementError = "oldpassword";
          }

          var password = $("#password").val();
          if(password == '' || password == "Mật khẩu mới" ) {
              $("#password").before('<div class="error Required">Bạn phải nhập mật khẩu mới</div>');
              hasError = true;
              if (idElementError == "") idElementError = "password";
          }

          var confirmpassword = $("#confirmpassword").val();
          if(confirmpassword == '' || confirmpassword == "Xác nhận mật khẩu") {
              $("#confirmpassword").before('<div class="error Required">Bạn phải xác nhận mật khẩu mới</div>');
              hasError = true;
              if (idElementError == "") idElementError = "confirmpassword";
          }else if(confirmpassword != password) {
              $("#confirmpassword").before('<div class="error Required">Xác nhận mật khẩu không đúng</div>');
              hasError = true;
              if (idElementError == "") idElementError = "confirmpassword";
          }

          if(hasError == false) {
              return true;
          }

          scrollToError(idElementError);
          
          return false;
      });
    </script>
</div>