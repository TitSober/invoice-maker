<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Invoice Creator - Login/Register</title>
    <?php include("imports.php");?>
    
    <style>
        body, html {
            height: 100%;
        }
        .center-container {
            height: 100vh;
        }
        .form-card {
            max-width: 400px;
            margin: auto;
        }
    </style>
</head>
<body>
<?php
    if(isset($_SESSION["id"])){
        include("menu_user.php");
    }else{
        include("menu.php");
    }
    ?>

        <div class="container text-center">
        <div id="alert" class="alert alert-success" role="alert" style="display: none;">
                <h4 class="alert-heading" id="message"></h4>
                <button class="btn btn-primary" id="close">Close</button>
            </div>
            <!-- Login Form -->
            <div id="login" class="form-card card shadow-sm p-4 mb-4">
                <h2 class="card-title">Login</h2>
                
                    <div class="form-group pb-2 pt-2">
                        <label for="username">Email address</label>
                        <input  class="form-control" id="username" name="username" placeholder="Enter email" data-content="Username does not exist!">
                    </div>
                    <div class="form-group pb-2 pt-2">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name = "password" placeholder="Password" data-content="Wrong password">
                    </div>
                    <input type="submit" id="loginBtn" class="btn btn-primary btn-block" value="Login"/>
                    
                
            </div>
    <script>
        $(document).ready(function(){
        $('#username').popover({
            trigger: 'manual',
            placement: 'bottom'
        });

        $('#username').on('focus', function() {
            $(this).popover('hide');
        });

        $('#username').on('blur', function() {
            $(this).popover('hide');
        });

        $('#password').popover({
            trigger: 'manual',
            placement: 'bottom'
        });

        $('#password').on('focus', function() {
            $(this).popover('hide');
        });

        $('#password').on('blur', function() {
            $(this).popover('hide');
        });
        $("#close").click(function(){
            $("#alert").hide("slow");
        });

        $("#loginBtn").click(function(){
            console.log("asd");
            
            $.post("<?= BASE_URL . "loginUser" ?>",
            
            { username: $("#username").val(), password: $("#password").val()},
                
            
            
            function(response) {
                    
                    
                    if(response.status == "success"){
                        console.log(response.message);
                        $("#message").text(response.message);
                        //$("#alert").show();
                        window.location.replace("<?=BASE_URL?>");
                    }else{
                        if(response.message == "1"){
                            $("#username").attr('data-content', "Username doesn't exist").popover('show');
                        }else{
                            $("#password").attr('data-content','Wrong password').popover('show');
                        }
                        
                    }
                },
                'json' // Specify the response type as JSON
            );

        }
    );


        });
        

    </script>
           
</body>
</html>
