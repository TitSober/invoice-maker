<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer create</title>
    <?php include("imports.php");?>
    <style>
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
        .preserve-whitespace {
            white-space: pre-wrap; /* CSS property to preserve whitespace and new lines */
        }
    </style>
</head>
<body>
<?php
    if(isset($_SESSION["id"])){
        include("menu_user.php");
    }else{
        include("menu.php");
        header("Location: ". BASE_URL);
        exit();
    }
    ?>
<div class="container mt-5">
    <div id="alert" class="alert alert-success" role="alert" style="display: none;">
        <h4 class="alert-heading">Footer added</h4>
        <button class="btn btn-primary" id="close">Close</button>
    </div>
    <h2>Footer editor</h2>
   
        <div class="form-group">
            <label for="textInput">Text Input:</label>
            <textarea class="form-control" id="textInput" rows="5" placeholder="Enter the text for the footer and choose the color"></textarea>
        </div>
        <div class="form-group">
            <label for="colorPicker">Select Color:</label>
            <input type="color" class="form-control form-control-color" id="colorPicker">
        </div>
 
    
    <button class="btn btn-success" id="save-to-database">Save the footer</button>
</div>

<div class="footer text-center mt-5" id="footer">
    <p id="footerText" class="preserve-whitespace">This is the footer text. It will be updated based on your input.</p>
</div>

<script>
    $(document).ready(function(){
        $("#textInput").on("input",function(){
            //var text = $(this).val().replace(/\n/g, '<br>');
            var text = $(this).val();
            console.log(text);
            var color = $('#colorPicker').val();
            console.log(color);
            $('#footerText').html(text);
            $('#footerText').css('color', color);
            console.log("asd");

        });
        $("#save-to-database").click(function(){
            let text = $("#textInput").val();
            if(text != ""){
                $.post("<?= BASE_URL . "saveFooter"?>",
                {id: <?= $_SESSION["id"]?>, footer: $("#textInput").val(),color: $("#colorPicker").val()},
                function(data){
                    $("#alert").show();
                }
            );
            }

        });
        $("#close").click(function(){
            $("#alert").hide("slow");
        });


       
    });
    function updateFooter() {
        var text = $('#textInput').val().replace(/\n/g, '<br>');
        var color = $('#colorPicker').val();
        $('#footerText').text(text).css('color', color);
    }
    
</script>
    
</body>
</html>