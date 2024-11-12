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
    
            <!-- Registration Form -->
            <div class="container text-center">
            <div id="alert" class="alert alert-success" role="alert" style="display: none;">
                <h4 class="alert-heading">Registered user</h4>
                <button class="btn btn-primary" id="close">Close</button>
            </div>
            
            <div id="register" class="form-card card shadow-sm p-4 mb-4" >
                <h2 class="card-title">Register</h2>
                
                    
                    <div class="form-group pb-2 pt-2">
                        <label for="registerEmail">Email address</label>
                        <input type="email" class="form-control" id="registerEmail" placeholder="Enter email" data-toggle="popover" data-content="Username already exists!">
                    </div>
                    <div class="form-group pb-2 pt-2">
                        <label for="registerPassword">Password</label>
                        <input type="password" class="form-control" id="registerPassword" placeholder="Password">
                    </div>
                    <div class="form-group pb-2 pt-2">
                        <label for="registerConfirmPassword">Confirm Password</label>
                        <!--<input type="password" class="form-control" id="registerConfirmPassword" placeholder="Confirm Password">-->
                        <input type="password" class="form-control" placeholder="Retype password" id="registerConfirmPassword" name="registerConfirmPassword" data-toggle="popover" data-content="Passwords do not match!">
                    </div>
                    <button type="submit" id="registerBtn" class="btn btn-primary btn-block">Register</button>
                
            </div>
            </div>
        </div>
    </div>
    
</body>
    
    <script>
        $(document).ready(function(){
        $('#registerConfirmPassword').popover({
            trigger: 'manual',
            placement: 'bottom'
        });

        $('#registerConfirmPassword').on('focus', function() {
            $(this).popover('show');
        });

        $('#registerConfirmPassword').on('blur', function() {
            $(this).popover('hide');
        });

        $('#registerEmail').popover({
            trigger: 'manual',
            placement: 'bottom'
        });

        $('#registerEmail').on('focus', function() {
            $(this).popover('hide');
        });

        $('#registerEmail').on('blur', function() {
            $(this).popover('hide');
        });
        $("#close").click(function(){
            $("#alert").hide("slow");
        });

        $('#registerConfirmPassword').on('input', function() {
            var password = $("#registerPassword").val();
            var registerConfirmPassword = $(this).val();
            if (password !== registerConfirmPassword) {
                $(this).attr('data-content', 'Passwords do not match!').popover('show');
                //console.log(password);
                //console.log($(this).val());
            } else {
                $(this).popover('hide');
                
            }
        });

        $("#registerBtn").click(function(){
            var registerPassword = $("#registerPassword").val();
            var registerConfirmPassword = $("#registerConfirmPassword").val();
            if(registerPassword == registerConfirmPassword){
                $.post("<?= BASE_URL . "registerUser" ?>",
                { username: $("#registerEmail").val(), password: registerPassword },
                function(response) {
                        if(response.status == "success"){
                            $("#alert").show("slow");
                        }else{
                            $("#registerEmail").attr('data-content', "Username already exists!").popover('show');
                            
                        }
                    },
                    'json' // Specify the response type as JSON
                ).fail(function(xhr, status, error) {
                    // Handle errors
                    console.error('AJAX Error: ' + status + error);
                }
                );

            }else{
                $("#registerConfirmPassword").attr('data-content', 'Passwords do not match!').popover('show');
            }
        });
        
});
        
        
    </script>
</html>

