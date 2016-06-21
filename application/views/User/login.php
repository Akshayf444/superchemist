<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="images/favicon.png" type="image/png">
        <?php $link = "http://www.udisha.co.in/" ?>
        <title>Superchem</title>
        <link href="<?php echo $link; ?>css/site.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $link; ?>css/style.default.css" rel="stylesheet">
        <script src="<?php echo $link; ?>js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo $link; ?>js/miniNotification.js" type="text/javascript"></script>
        <script src="<?php echo $link; ?>js/bootstrap.js" type="text/javascript"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="<?php echo $link; ?>js/html5.js"></script>
        <script src="<?php echo $link; ?>js/respond.js"></script>
        <![endif]-->
    </head>

    <body class="signin">
        <header>
        </header>
        <section>
            <div class="signinpanel">
                <div class="pull-right">Helpline No : <span class="helpline">022-65657701</span><br>From 10 am - 6 pm</div>
                <h2 class="hidden-xs" ><strong>Welcome to Superchem</strong></h2>
                <div class="row">
                    <div class="col-md-6" style="padding-top: 3em;">
                        <div class="signin-info">
                            <div class="logopanel">
                                <img src="<?php echo asset_url(); ?>images/youngdoctor.png" width="100%">
                            </div>
                        </div><!-- signin0-info -->

                    </div><!-- col-sm-7 -->
                    <div class="col-md-1"></div>
                    <div class="col-md-5">

                        <?php echo form_open('User/index'); ?>
                        <h4 class="nomargin">Sign In</h4>
                        <p class="mt5 mb20">Login to access your account.</p>

                        <input type="text" class="form-control uname" placeholder="Mobile" name="mobile"/>
                        <input type="password" class="form-control pword" placeholder="Password" name="password" />
    <!--                    <a href="#"><small>Forgot Your Password?</small></a>-->
                        <button class="btn btn-success btn-block" type="submit" name="submit" style="background: #2A5567">Sign In</button>

                        </form>
                    </div><!-- col-sm-5 -->

                </div><!-- row -->
                <hr style="margin-top: 7em">
                <div >
                    <div class="pull-left">
                        &copy; 2016. All Rights Reserved. 
                    </div>
                    <div class="pull-right">
                        Powered By: <a href="http://techvertica.com/" target="_blank">Techvertica</a>
                    </div>
                </div>

            </div><!-- signin -->

        </section>

        <script>
            $(function () {
                $('#mini-notification').miniNotification({closeButton: true, closeButtonText: 'x'});
                function blinker() {
                    $('.helpline').fadeOut(500);
                    $('.helpline').fadeIn(500);
                }

                setInterval(blinker, 1000);
            });
        </script>
    </body>
</html>
