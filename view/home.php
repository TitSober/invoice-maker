<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice maker</title>
    <?php include("imports.php")?>
    
</head>
<body>
    <?php
    if(isset($_SESSION["id"])){
        include("menu_user.php");
    }else{
        include("menu.php");
    }
    ?>
    <div class="d-flex justify-content-center align-items-center center-container">
        <div class="container text-center">
            <div class="jumbotron">
                <h1 class="display-4">Welcome to Online Invoice Creator</h1>
                <p class="lead">Create and manage your invoices with ease. Use the menu above to navigate through the app.</p>
               
            </div>
        </div>
    </div>
    
    <script>
      $(document).ready(function() {
    $("#audio").click(function(event) {
        event.preventDefault(); // Prevent the default action of the link
        let audioElement = document.getElementById('yippieAudio');
        audioElement.play();
    });
});
    </script>
</body>
</html>