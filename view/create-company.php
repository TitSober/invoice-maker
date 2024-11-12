<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create company</title>
    <?php include("imports.php");?>
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
    <div id="company" class="form-card card shadow-sm p-4 mb-4">
        <div class="form-group">
            <h2 class="card-title">Create a company</h2>
        </div>
        <div class="form-group d-flex m-1">
            <input type="text" id="companyName" name="company" class="form-control" placeholder="Enter the name of the company">
           <!-- <button class="btn btn-primary ml-2"></button>-->
        </div>
    
    <div id="attribute-area" class="container mt-5" style="display:block;">
        <div class="form-group  d-flex">
            <input type="text" class="form-control m-1 key" placeholder="Enter name of information">
            <input type="text" class="form-control m-1 value" placeholder="Enter value of information">
            <button class="btn-danger btn delete">Delete</button>


        </div>
        
    </div>
    <div class="form-group p-5 d-flex">
            <button id="addKVPair" class="btn-primary btn me-3">Add more attributes</button>
            <button class="btn-success btn" id="save">Save company to profile</button>

        </div>

    </div>
   

</div>
<script>
    $(document).ready(function(){

        $("#close").click(function(){
            $("#alert").hide("slow");
        });
        
        $("#addKVPair").click(function(){
            let area = $("#attribute-area");
            let div = "<div class='form-group  d-flex mt-1'><input type='text' class='form-control m-1 key' placeholder='Enter name of information'><input type='text' class='form-control m-1 value' placeholder='Enter value of information'><button class='btn-danger btn delete'>Delete</button></div>";
            area.append(div);
            $(".delete").click(function () {
            event.stopPropagation();
            event.stopImmediatePropagation();
            $(this).closest('div').remove();
        });
        });

        $("#save").click(function() {
          
            let data = [];
            $('#attribute-area .form-group').each(function() {
                let key = $(this).find('.key').val();
                let value = $(this).find('.value').val();
                if (key && value) {
                    data.push({ "key": key, "value": value });
                }
            });
            //console.log({id: , name: $("#companyName").val(),data: JSON.stringify(data) });
            $.post("<?= BASE_URL."saveCompany"?>",
            {id: <?=$_SESSION["id"]?>, name: $("#companyName").val(),data: JSON.stringify(data) },
            function(response){
                if(response.status == "success"){
                    console.log(response.message);
                    $("#message").text(response.message);
                    $("#alert").show("slow");}
                },'json'
            );
          
        });
    });



</script>
    
</body>
