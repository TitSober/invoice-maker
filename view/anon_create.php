<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create company</title>
    <?php include("imports.php"); ?>
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
if (isset($_SESSION["id"])) {
    include("menu_user.php");
} else {
    include("menu.php");
}
?>
<div class="container-centered">
    <div class="row container" id="global-row">
        <div class="col container form-card card shadow-sm p-4 mb-4" id="left">
            <div class="row">
                <div class="col">
                    <div id="company" class="form-card card shadow-sm p-4 mb-4">
                        <div class="form-group">
                            <h2 class="card-title">Your company</h2>
                        </div>
                        <div class="form-group d-flex m-1">
                            <input type="text" id="companyName" name="company" class="form-control" placeholder="Enter the name of the company">
                        </div>
                        <div id="attribute-area" class="container mt-5" style="display:block;">
                            
                        </div>
                        <div class="form-group p-5 d-flex">
                            <button id="addKVPair" class="btn-primary btn me-3"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col container form-card card shadow-sm p-4 mb-4">
                    <div class="form-group">
                        <h2 class="card-title">Other company</h2>
                    </div>
                    <div class="form-group d-flex m-1">
                        <input type="text" id="otherCompanyName" name="company" class="form-control" placeholder="Enter the name of the company">
                    </div>
                    <div id="attribute-area-other" class="container mt-5" style="display:block;">
                       
                        
                    </div>
                    <div class="form-group p-5">
                            <button id="addKVPairOther" class="btn-primary btn me-3"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                </div>
            </div>
            <div class="row container">
                <div class="col container form-card card shadow-sm p-4 mb-4">
                <h2>Services</h2>
                <div class="form-group" id="service-area">
                   
                        <!-- This is where new service rows will be added -->
                        
                    
                    <button id="addService" class="btn-primary btn mt-3"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>    
              
                    
                </div>
                <div class="col container form-card card shadow-sm p-4 mb-4">
                    <h2>Footer</h2>
                    <div class="form-group">
                        <label for="textInput">Text Input:</label>
                        <textarea class="form-control" id="textInput" rows="5" placeholder="Enter the text for the footer and choose the color"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="colorPicker">Select Color:</label>
                        <input type="color" class="form-control form-control-color" id="colorPicker">
                        <button id="convertToPdf" class="btn btn-success">Download invoice</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="col container form-card card shadow-sm p-4 mb-4" id="right">
            <div class="container col p-2" id="output">
                <div class="row container">
                    <div class="col-md-12 text-center">
                    <table class="table">
 
                    <tbody id="company1table">
                        <tr>
                        <th scope="row"></th>
                        <td></td>
                        <td id="nameOfFirstCompany"></td>
                        <td></td>
                        </tr>
                    
                    </tbody >
                    </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <table class="table">
 
                    <tbody id="company2table">
                        <tr>
                        <th scope="row"></th>
                        <td id="nameOfSecondCompany"></td>
                        <td></td>
                        </tr>
                    
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
                            <th scope="col">
                                Name of service 
                            </th>
                            <th scope="col">
                                Price of service 
                            </th>
                            <th scope="col">
                                Amount
                            </th>
                            <th scope="col">
                                Total 
                            </th>
                        </thead>
                        <tbody id="tableData">
                            

                            </div>
                            <tr id="Total">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="totalPrice"></td>
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

<script>
    $(document).ready(function() {
        function updateTotal() {
            let total = 0;
            $("#tableData tr:not(#Total)").each(function() {
                let rowTotal = parseFloat($(this).find("td:last").text()) || 0;
                total += rowTotal;
            });
            $("#totalPrice").text(total.toFixed(2));
        }


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




        //connect the company data with the invoice
        $("#companyName").keyup(function(){
            $("#nameOfFirstCompany").text($(this).val());
        });

        $("#otherCompanyName").keyup(function(){
            $("#nameOfSecondCompany").text($(this).val());   
        });

        $("#textInput").on("input", function() {
            var text = $(this).val();
            var color = $('#colorPicker').val();
            $('#footerText').html(text);
            $('#footerText').css('color', color);
        });

        $("#addKVPair").click(function() {
            let area = $("#attribute-area");
            let tableDiv = $("#company1table");
            let row = $("<tr>");
            let key = $("<td>");
            let val = $("<td>");
            
            let div = $("<div>", { class: "form-group d-flex mt-1" });

            let inputName = $("<input>", {
                type: "text",
                class: "form-control m-1 key",
                placeholder: "Enter name of information"
            });

            let inputValue = $("<input>", {
                type: "text",
                class: "form-control m-1 value",
                placeholder: "Enter value of information"
            });

            let deleteButton = $("<button>", {
                class: "btn-danger btn delete"
            }).html("<i class='fa fa-trash' aria-hidden='true'></i>");

            // Add listeners to change invoice on input
            inputName.keyup(function(){
                key.html($(this).val());
            });
            inputValue.keyup(function(){
                val.html($(this).val());
            });

            // Append the row to the table
            tableDiv.append(row);
            row.append(key);
            row.append("<td></td>");
            row.append(val);

            // Append the elements to the div
            div.append(inputName)
               .append(inputValue)
               .append(deleteButton);

            area.append(div);

            // Attach event listener to the delete button
            deleteButton.click(function(event) {
                event.stopPropagation();
                event.stopImmediatePropagation();
                row.remove(); // Remove the corresponding row in the table
                div.remove(); // Remove the div containing the input fields
            });
        });

        $("#addKVPairOther").click(function() {
            let area = $("#attribute-area-other");
            let tableDiv = $("#company2table");
            let row = $("<tr>");
            let key = $("<td>");
            let val = $("<td>");
            
            let div = $("<div>", { class: "form-group d-flex mt-1" });

            let inputName = $("<input>", {
                type: "text",
                class: "form-control m-1 key",
                placeholder: "Enter name of information"
            });

            let inputValue = $("<input>", {
                type: "text",
                class: "form-control m-1 value",
                placeholder: "Enter value of information"
            });

            let deleteButton = $("<button>", {
                class: "btn-danger btn delete"
            }).html("<i class='fa fa-trash' aria-hidden='true'></i>");

            // Add listeners to change invoice on input
            inputName.keyup(function(){
                key.html($(this).val());
            });
            inputValue.keyup(function(){
                val.html($(this).val());
            });

            // Append the row to the table
            tableDiv.append(row);
            row.append(key);
            row.append("<td></td>");
            row.append(val);

            // Append the elements to the div
            div.append(inputName)
               .append(inputValue)
               .append(deleteButton);

            area.append(div);

            // Attach event listener to the delete button
            deleteButton.click(function(event) {
                event.stopPropagation();
                event.stopImmediatePropagation();
                row.remove(); // Remove the corresponding row in the table
                div.remove(); // Remove the div containing the input fields
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

            pdf.addImage(imgData, 'pdf', 0, 0, pdfWidth, pdfHeight);
            pdf.save('invoice.pdf');
        });
});



    });
</script>
</body>
</html>
