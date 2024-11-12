<?php
include_once(BASE_URL."/controllers/DataController.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an invoice</title>
    <?php include("imports.php");?>
   
    <style>
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
        .preserve-whitespace {
            white-space: pre-wrap; /* CSS property to preserve whitespace and new lines */
        }
        .form-card {
            margin-bottom: 20px;
        }
        .container-centered {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    
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
        <div class="container row" id="global-row">
            <div class="container col">
                <div class="row container">
                    <div class="col container"id="firstCompany">
                        <div class="form-group form-card card shadow-sm p-4 mb-4">
                            <h2>Select your company</h2>
                            <option selected>Choose your company</option>
                            <select id="firstCompanySelect" class="form-select">
                            <?php
                                $arr = DataController::returnUserCompanyNames();
                                foreach ($arr as $el){
                                    echo "<option value='".$el."'>" . $el . "</option>";
                                }
                                
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col container" id="secondCompany">
                        <div class="form-group form-card card shadow-sm p-4 mb-4">
                            <h2>Select the company to invoice</h2>
                            <select id="secondCompanySelect" class="form-select">
                            
                            <?php
                                $arr = DataController::returnUserCompanyNames();
                                foreach ($arr as $el){
                                    echo "<option value='".$el."'>" . $el . "</option>";
                                }
                                
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col container"id="footer">
                        <div class="form-group form-card card shadow-sm p-4 mb-4">
                            <h2>Select your Footer</h2>
                            
                            <select id="footerSelect" class="form-select">
                            <?php
                                $arr = DataController::returnUserFooterID();
                                foreach ($arr as $el){
                                    echo "<option value='".$el."'>" . $el . "</option>";
                                    echo $el;
                                }
                                
                            ?>
                            </select>
                            
                        </div>
                    </div>
                    

                </div>
                    <div class="row container">
                    <div class="col container form-card card shadow-sm p-4 mb-4">
                <h2>Add services</h2>
                <div class="form-group" id="service-area">
                    <button id="addService" class="btn-primary btn ">Add Service</button>
                    <button id="convertToPdf" class="btn btn-success">Download invoice</button>
                </div>    
              
                    
                </div>
                    </div>
                </div>
                <div class="container col">
                <div class="row container">
                    <div class="col container p-2" id="output">
                    <div class="row container">
                    <div class="col-md-12 text-center">
                    <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th id="nameOfFirstCompany"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="company1table">
                        
                    
                    </tbody >
                    </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th id="nameOfSecondCompany"></th>
                            <th></th>
                        </tr>
                    </thead>
 
                    <tbody id="company2table">
                    </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                <table class="table">
 
                    <tbody id="dateTable">
                        <tr>
                        
                        
                        <td>Date of invoice <input type="date" class="form-control" placeholder="Enter the date of the invoice"/></td>
                        </tr>
                        <tr>
                        
                        
                        <td>Due date <input type="date"class="form-control" placeholder="Enter the due date"/></td>
                        </tr>
                        
                    
                    </tbody>
                    </table>
                    </div>
                </div>
                <div class="row">
                <table class="table table-bordered">
                        <thead>
                            <th scope="col">Name of service</th>
                            <th scope="col">Price of service</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Total</th>
                        </thead>
                        <tbody id="tableData">
                            <!-- Service rows will be appended here -->
                            <tr id="Total">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="totalPrice">0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12 text-begin">
                        <p id="footerText" class="preserve-whitespace">This is the footer text.</p>
                    </div>
                </div>
                        
                    </div>
                </div>
                </div>
                
        </div>
    </div>
    <script>
        $(document).ready(function(){
            function updateTotal() {
            let total = 0;
            $("#tableData tr:not(#Total)").each(function() {
                let rowTotal = parseFloat($(this).find("td:last").text()) || 0;
                total += rowTotal;
            });
            $("#totalPrice").text(total.toFixed(2));
        }

            $('#firstCompanySelect').change( function (e) {
                $("#company1table").html("");
                $("#nameOfFirstCompany").html("");
                let cname = $(this).val();
                //console.log(name);
                //console.log("asd");
                
               

                $.post("<?=BASE_URL."apiCompanyData"?>",
                {name:cname},
                function(data){
                    if(data["status"] == "success"){
                        let tableDiv = $("#company1table");
                        
                        

                        companyName = data["name"];
                        kvPairs = data["data"];
                        //console.log(companyName);
                        $("#nameOfFirstCompany").html(companyName);
                        kvPairs.forEach(element => {
                            let row = $("<tr>");
                            let key = $("<td>");
                            let val = $("<td>");
                            key.html(element["key"]);
                            val.html(element["value"]);
                            
                            row.append(key);
                            row.append("<td></td>");
                            row.append(val);
                            //console.log(row.val());
                            tableDiv.append(row);
                        });
                    }
                },'json'
            );

                
               
            });
            $('#secondCompanySelect').change( function (e) {
                $("#company2table").html("");
                $("#nameOfSecondCompany").html("");
                let cname = $(this).val();
                


                $.post("<?=BASE_URL."apiCompanyData"?>",
                {name:cname},
                function(data){
                    if(data["status"] == "success"){
                        let tableDiv = $("#company2table");
                        
                        

                        companyName = data["name"];
                        kvPairs = data["data"];
                        //console.log(companyName);
                        $("#nameOfSecondCompany").html(companyName);
                        kvPairs.forEach(element => {
                            let row = $("<tr>");
                            let key = $("<td>");
                            let val = $("<td>");
                            key.html(element["key"]);
                            val.html(element["value"]);
                            
                            row.append(key);
                            row.append("<td></td>");
                            row.append(val);
                            //console.log(row.val());
                            tableDiv.append(row);
                        });
                    }
                },'json'
            );
                
            });


            $('#footerSelect').change(function () {
            let id = $(this).val();
            
            $.post("<?=BASE_URL . "apiFooterData"?>",
                { fid: id},

                function (data){
                    console.log(data);
                    console.log("asd");
                    if(data["status"] == "success"){
                        let color = data["color"];
                        let text = data["text"];
                        $("#footerText").text(text);
                        $('#footerText').css('color', color);

                    }else{
                        console.log(data);
                    }
                },'json'
            );
        });


        $("#addService").click(function() {
        let tableData = $("#tableData");
        let tableRow = $("<tr>");
        let serviceName = $("<td>");
        let servicePrice = $("<td>");
        let serviceAmount = $("<td>");
        let serviceTotal = $("<td>");

        let serviceRow = $("<div>", { class: " mt-1 service-row" });
        let amountValDiv = $("<div>",{class: "container d-flex"});
        let serviceInput = $("<input>", {
            type: "text",
            class: "form-control m-1",
            placeholder: "Enter the service"
        });

        let priceInput = $("<input>", {
            type: "number",
            class: "form-control m-1",
            placeholder: "Price"
        });

        let amountInput = $("<input>", {
            type: "number",
            class: "form-control m-1",
            placeholder: "Amount"
        });

        let calculatedPriceInput = $("<input>", {
            type: "text",
            class: "form-control m-1",
            placeholder: "Calculated price",
            readonly: true
        });
        
        let deleteButton = $("<button>", {
            class: "btn-danger btn m-1 delete-service"
        }).html("<i class='fa fa-trash' aria-hidden='true'></i>");

        amountValDiv.append(priceInput)
                    .append(amountInput);
        // Append all inputs to the service row
        serviceRow.append(serviceInput)
                  .append(amountValDiv)
                  .append(calculatedPriceInput)
                  .append(deleteButton);
        tableRow.append(serviceName)
                .append(servicePrice)
                .append(serviceAmount)
                .append(serviceTotal);
        tableData.prepend(tableRow);
        // Append the service row to the service area
        $("#service-area").append(serviceRow);

        // Event handler to remove a service row
        deleteButton.click(function(event) {
            event.stopPropagation();
            event.stopImmediatePropagation();
            serviceRow.remove();
            tableRow.remove();
            updateTotal();
        });
        serviceInput.keyup(function(){
            serviceName.html($(this).val());
        });
        // Event handler to calculate the price
        priceInput.add(amountInput).on('input', function() {
            let price = parseFloat(priceInput.val()) || 0;
            let amount = parseFloat(amountInput.val()) || 0;
            let total = price * amount;
            calculatedPriceInput.val(total.toFixed(2));
            serviceAmount.html(amount);
            servicePrice.html(price);
            serviceTotal.html(calculatedPriceInput.val());
            updateTotal();
        });
    });
    document.getElementById('convertToPdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;

    html2canvas(document.getElementById('output')).then((canvas) => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF();
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        const pdfBlob = pdf.output('blob');

        // Create a FormData object
        const formData = new FormData();
        formData.append('pdfFile', pdfBlob, 'invoice.pdf');

        // Send the PDF to the server using XMLHttpRequest
        $.ajax({
            url: '<?=BASE_URL . "uploadInvoice"?>',
            type: 'POST',
            data: formData,
            processData: false, // Important! Prevents jQuery from automatically transforming the data into a query string
            contentType: false, // Important! Tells jQuery not to set the content type header
            success: function(response) {
                console.log('File uploaded successfully:', response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('File upload error:', textStatus, errorThrown);
            }
        });
    });
});
});

        

    </script>
    
</body>
</html>