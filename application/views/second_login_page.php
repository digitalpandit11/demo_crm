<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Maitry Instruments</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style type="text/css">
            body {
                color: #999;
                background: #f5f5f5;
                font-family: 'Varela Round', sans-serif;
                background-image: linear-gradient(to right, #3ab5b0 0%, #3d99be 31%, #56317a 100%);
                height: 660px;
            }
            .form-control {
                box-shadow: none;
                border-color: #ddd;
            }
            .form-control:focus {
                border-color: #4aba70;
            }
            .login-form {
                width: 350px;
                margin: 0 auto;
                padding: 30px 0;
            }
            .login-form form {
                color: #434343;
                border-radius: 1px;
                margin-bottom: 15px;
                background: #fff;
                border: 1px solid #f3f3f3;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }
            .login-form h4 {
                text-align: center;
                font-size: 22px;
                margin-bottom: 20px;
            }
            .login-form .avatar {
                color: #fff;
                margin: 0 auto 30px;
                text-align: center;
                width: 100px;
                height: 100px;
                border-radius: 50%;
                z-index: 9;
                background: #4aba70;
                padding: 15px;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
            }
            .login-form .avatar i {
                font-size: 62px;
            }
            .login-form .form-group {
                margin-bottom: 20px;
            }
            .login-form .form-control, .login-form .btn {
                min-height: 40px;
                border-radius: 2px;
                transition: all 0.5s;
            }
            .login-form .close {
                position: absolute;
                top: 15px;
                right: 15px;
            }
            .login-form .btn {
                background-image: -webkit-linear-gradient( 136deg, #8360c3
                0%,  #2ebf91  100%);
                border: none;
                line-height: normal;
            }
            .login-form .btn:hover, .login-form .btn:focus {
                background: #42ae68;
            }
            .login-form .checkbox-inline {
                float: left;
            }
            .login-form input[type="checkbox"] {
                margin-top: 2px;
            }
            .login-form .forgot-link {
                float: right;
            }
            .login-form .small {
                font-size: 13px;
            }
            .login-form a {
                color: #4aba70;
            }
        </style>
    </head>
    <body>
        <div class="login-form">
            <form action="<?php echo site_url('welcome/process_otp');?>" method="post">
                <div class="img-circular"><center><img src="<?php echo base_url().'assets/login/maitri.png'?>" style="width: 70px;height: 70px; border-radius: 50%;"></center></div><br>
                <h4 class="modal-title" style="color: #2ebf91;">Login to Your Account</h4>
                <br><br>

                <input type="hidden" id="user_id" name="user_id" value="<?php echo $entity_id;?>" required>

                <div class="form-group">
                    <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP">
                    <span class="text-danger"><?php echo form_error('otp'); ?></span>
                </div>
                <br><br>
                <!-- <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="text-danger"><?php echo form_error('password'); ?></span>
                </div> -->
                <!-- <div class="form-group small clearfix">
                    <label class="checkbox-inline"><input type="checkbox"> Remember me</label>
                    <a href="#" class="forgot-link" style="color: #8360c3;">Forgot Password?</a>
                </div> -->
                <input type="submit" class="btn btn-primary btn-block btn-lg" name="login" value="Login">
                <!-- <?php  
                    echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>';  
                ?>   -->            
            </form>
        </div>
    </body>
</html>         