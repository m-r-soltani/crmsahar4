<?php defined('__ROOT__') or exit('No direct script access allowed');?>
<html>
<script src="https://www.google.com/recaptcha/api.js?hl=fa"
    async defer>
</script>
<head>
    <title>User Authentication</title>
    <!-- Global stylesheets -->
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/icons/icomoon/styles.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/bootstrap.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/bootstrap_limitless.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/layout.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/components.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/colors.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/persian-datepicker.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/dataTables.bootstrap4.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/login.css' ?>"/>
    <!-- /global stylesheets -->
    
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="logo1 col-md-12">
                    <img class="logo1img" src="<?php echo __ROOT__ . 'public/images/logo1.jpg' ?>" alt="IMG">
                </div>
                <br>
                <div class="login100-pic js-tilt " data-tilt>
                    <a href="<?php echo __ROOT__ . 'public/images/logo1.jpg' ?>">
                        <img src="<?php echo __ROOT__ . '/public/images/login-4.png' ?>" alt="IMG" style="margin-top: -30px;">
                    </a>
                </div>

                <form class="login100-form validate-form" name="login_form" method="post" action="">
					<span class="login100-form-title font-weight-bold loginformlable">
						User Login
					</span>
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="username" placeholder="username" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LfBEcIZAAAAAIlZqRE9xZZYb2v3n2bqL2--XBC0"></div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn font-weight-bold" 
                            name="send_login" 
                            id="send_login">
                            Login
                        </button>
                    </div>
                    <!-- <span class="login50-form-title font-weight-bold loginformlable" style="
    margin-top: 10px;
"><a href="forgotpassword" target="_blank">فراموشی رمز عبور</a></span> -->


                </form>

            </div>
        </div>

        <div class="navbar-collapse login_footer_texts" id="navbar-footer">
                    <span class="login_description_text" style="display: block">
(شبکه فناوری اطلاعات سحر ارتباط (دارای پروانه ارایه خدمات ارتباطی ثابت - پروانه سروکو: 39-95-100
					</span>
            <span class="login_description_text" style="display: block;direction: rtl">
                <span class=" login_description_text" style="">
                    تلفن:
                </span>
                5-02122376081
                 5-02191033501
					</span>
            <span class="login_copy_text">
                        &copy;2019 - <?php echo date("Y"); ?>
					</span>
        </div>
    </div>

</body>
</html>

<!-- Core JS files -->

<script src="<?php echo __ROOT__ . '/public/js/main/jquery.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/main/bootstrap.bundle.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/plugins/loaders/blockui.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/datatables.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/extensions/responsive.min.js' ?>"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script src="<?php echo __ROOT__ . '/public/js/plugins/forms/styling/uniform.min.js' ?>"></script>
<!--<script src="<?php /*echo __ROOT__ . '/public/js/plugins/forms/styling/switchery.min.js' */?>"></script>
<script src="<?php /*echo __ROOT__ . '/public/js/js/plugins/forms/styling/switch.min.js' */?>"></script>-->
<script src="<?php echo __ROOT__ . '/public/js/plugins/forms/selects/select2.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/extensions/select.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/extensions/buttons.min.js' ?>"></script>
<!--<script src="<?php /*echo __ROOT__ . '/public/js/plugins/editors/datatable/dataTables.altEditor.js' */?>"></script>-->
<script src="<?php echo __ROOT__ . '/public/js/app.js' ?>"></script>


<!--<script src="<?php /*echo __ROOT__ . '/public/js/demo_pages/form_checkboxes_radios.js' */?>"></script>-->
<script src="<?php echo __ROOT__ . '/public/js/demo_pages/form_inputs.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/persian-date.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/persian-datepicker.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/functions.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/login.js' ?>"></script>
<!-- <script>
        var onloadCallback = function () {
        $("button.g-recaptcha").each(function () {
            var el = $(this);
            console.log(el);
            var SITE_KEY="6LfBEcIZAAAAAIlZqRE9xZZYb2v3n2bqL2--XBC0";
            grecaptcha.render($(el).attr("id"), {
                "sitekey": SITE_KEY,  
                "size": "normal",
                "badge": "inline",
                "callback": function (token) {
                    alert('sdfsdf');
                    alert(token);
                    $(el).parent().find(".g-recaptcha-response").val(token);
                    $(el).closest("form").submit();
                }
            }, true);
        });
    
        $("button.g-recaptcha").click(function(event) {
            event.preventDefault();
            grecaptcha.execute();
        });
    };
</script> -->
<script type="text/javascript">
  var onloadCallback = function() {
    console.log("grecaptcha is ready!");
  };
</script>

</script>