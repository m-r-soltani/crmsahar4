<?php defined('__ROOT__') or exit('No direct script access allowed'); ?>
<html>
<script src="https://www.google.com/recaptcha/api.js?hl=fa" async defer>
</script>

<head>
    <title>User Authentication</title>
    <!-- Global stylesheets -->
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/icons/icomoon/styles.css' ?>" />
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/bootstrap.min.css' ?>" />
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/bootstrap_limitless.min.css' ?>" />
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/layout.min.css' ?>" />
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/components.min.css' ?>" />
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/colors.min.css' ?>" />
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/persian-datepicker.min.css' ?>" />
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/dataTables.bootstrap4.min.css' ?>" />
    <link rel="stylesheet" href="<?php echo __ROOT__ . '/public/css/loginnew.css' ?>" />
    <!-- /global stylesheets -->

</head>



<body>
    <div class="container-fluid">
        <div class="card">
            <div id="header" class="col-sx-12">
                <div id="headerlogo1">
                    <a href="" onclick="window.location.reload(true);">
                        <img class="" src="../public/images/logo_48_48.jpg">
                    </a>
                </div>
                <div id="headertitles">
                    <div id="pcheadertitle1">
                        سامانه مدیریت اینترنت و تلفن بین الملل مشتریان سحر ارتباط
                    </div>
                    <div id="mobileheadertitle1">
                        شرکت سحر ارتباط
                    </div>
                    <div id="pcheadertitle2">
                        دارای مجوز به شماره ۱۰۰/۹۵/۳۹ از سازمان تنظیم مقررات و ارتباطات رادیویی
                    </div>
                    <div id="mobileheadertitle2">
                        سامانه مدیریت مشتریان
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row formandslideshow">
                <!-- Login Form -->
                <div class="col-md-4 formsection">
                    <div class="card-body">
                        <p class="login-card-description" id="entringtext">ورود به سامانه</p>
                        <hr>
                        <form action="">
                            <div class="form-group">
                                <label for="Username" class="sr-only">نام کاربری</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="کد ملی">
                            </div>
                            <div class="form-group mb-4">
                                <label for="password" class="sr-only">رمز عبور</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                            </div>
                            <div class="form-group mb-4" id="googlecaptcha">
                                <div class="g-recaptcha" data-theme="light" data-sitekey="6LfBEcIZAAAAAIlZqRE9xZZYb2v3n2bqL2--XBC0" ></div>
                            </div>
                            <input name="login" id="login" class="btn btn-block login-btn mb-4" type="button" value="ورود به سامانه">
                        </form>
                        <a href="" class="forgot-password-link forgotpassword" id = "forgotpassword">رمز خود را فراموش کرده ام</a>
                    </div>


                </div>
                <!-- Slider -->
                <!-- d-none d-md-block -->
                <div class="col-md-8 slidersection d-none d-md-block" style="">
                    <div class="card-body">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox" style="width:100% !important; height: 500px !important;">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="../public/images/headerwebsite.jpg" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="../public/images/login1.png" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="../public/images/login-4.png" alt="Third slide">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card">
            <div id="footer" class="col-sx-12">
                <span class="footercopyrighttext">
                    کلیه حقوق این سامانه متعلق به
                </span>
                <span class="footercopyrighttext linkedbadge" >
                    <a href="http://www.saharertebat.net" target="_blank" style="color:#fff;">
                        شرکت سحر ارتباط
                    </a>
                </span>
                <span class="footercopyrighttext">
                    میباشد
                </span>
            </div>
        </div>
    </div>
    <div id="modal_forgotpassword" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">فراموشی رمز عبور</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <form action="#" name="form_forgotpassword" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label">موبایل</label>
                                        <select class="form-control" name="mobile" id="mobile_forgotpassword" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <div class="text-right">
                                <button type="submit" name="send_forgotpassword" id="send_forgotpassword"
                                        class="btn btn-primary">ایجاد رمز جدید
                                    <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </div>
                    </form>

                </div>
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
<script src="<?php echo __ROOT__ . '/public/js/plugins/forms/selects/select2.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/extensions/select.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/plugins/tables/datatables/extensions/buttons.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/app.js' ?>"></script>


<script src="<?php echo __ROOT__ . '/public/js/demo_pages/form_inputs.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/persian-date.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/persian-datepicker.min.js' ?>"></script>
<script src="<?php echo __ROOT__ . '/public/js/functions.js' ?>"></script>


</script>