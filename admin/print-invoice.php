<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
}
else {
    $bid = intval($_GET['bid']);
    $bookingid = $_GET['bookingid'];
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>CWMS | Invoice</title>
    <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style type="text/css" media="all">
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            color: #333;
        }
        
        .invoice-box {
            max-width: 900px;
            margin: 30px auto;
            margin-top:30px;
            padding: 40px;
            border: none;
            box-shadow: 0 0 20px rgba(0, 0, 0, .1);
            font-size: 14px;
            line-height: 24px;
            background: #fff;
            border-radius: 10px;
        }
        
        .invoice-header {
            background: #2c3e50;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .invoice-header h2 {
            margin-left: 170px;
            margin-bottom:30px;
            font-size: 24px;
            font-weight: 600;
        }
        
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .customer-details, .washing-point-details {
            flex: 1;
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .service-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .service-table th {
            background: #34495e;
            color: #fff;
            padding: 12px;
            text-align: left;
            border-radius: 5px 5px 0 0;
        }
        
        .service-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .amount-column {
            text-align: right;
            font-weight: 500;
            color: #2c3e50;
        }
        
        .booking-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        /* thank-you {
            text-align: center;
            margin-top: 40px;
            padding: 30px;
            background: #2c3e50;
            color: #fff;
            border-radius: 8px;
        } */
        
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #2c3e50;
            color: #fff;
            border: none;
        }
        
        .btn-primary:hover {
            background: #34495e;
        }
        
        .btn-default {
            background: #6c757d;
            color: #fff;
            border: none;
            margin-left: 10px;
        }
        
        .btn-default:hover {
            background: #5a6268;
        }
        
        @media print {
            .no-print {
                display: none;
            }
            .invoice-box {
                box-shadow: none;
                margin: 0;
                padding: 20px;
            }
            body {
                background: #fff;
            }
        }
        
        .payment-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2c3e50;
        }
        
        .payment-details table tr:last-child td {
            padding-top: 15px;
            border-top: 1px dashed #dee2e6;
        }
        
        .payment-details table td {
            padding: 8px 0;
            color: #444;
        }
        
        .payment-details .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        
        .payment-details .section-title:before {
            content: '';
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #2c3e50;
            margin-right: 10px;
            border-radius: 50%;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .thank-you-section {
            transition: all 0.3s ease;
        }
        
        .thank-you-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        @media print {
            .thank-you-section {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .footer-note {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        @media print {
            .signature-section {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .signature-section img {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <?php 
    $sql = "SELECT b.*, w.washingPointName, w.washingPointAddress, 
            b.paymentMode as transactionType, b.txnNumber as transactionId 
            FROM tblcarwashbooking b 
            JOIN tblwashingpoints w ON w.id=b.carWashPoint 
            WHERE b.id=:bid AND b.bookingId=:bookingid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bid', $bid, PDO::PARAM_STR);
    $query->bindParam(':bookingid', $bookingid, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    if($query->rowCount() > 0) {
    ?>
    <br><br>
    <div class="invoice-box">
        <div class="invoice-header">
            <h2>Car Wash Management System</h2>
            <div style="margin-top: 10px; font-size: 14px; display: flex; justify-content: space-between; align-items: center;">
                <span>Invoice #: <?php echo htmlentities($result->bookingId);?></span>
                <span style="margin-left: 20px;">Date: <?php echo date('d/m/Y');?></span>
            </div>
        </div>
        <br>
        <div class="invoice-details">
            <div class="customer-details">
                <div class="section-title">Customer Details</div>
                <strong><?php echo htmlentities($result->fullName);?></strong><br>
                <span style="color: #666;">
                    Mobile: <?php echo htmlentities($result->mobileNumber);?>
                </span>
            </div>
            
            <div class="washing-point-details">
                <div class="section-title">Washing Point</div>
                <strong><?php echo htmlentities($result->washingPointName);?></strong><br>
                <span style="color: #666;">
                    <?php echo htmlentities($result->washingPointAddress);?>
                </span>
            </div>
        </div>
        <br>

        <table class="service-table">
            <tr>
                <th>Service Details</th>
                <th style="text-align: right;">Amount</th>
            </tr>
            <tr>
                <td>
                    Package Type: 
                    <?php 
                    $ptype=$result->packageType;
                    if($ptype==1) echo "BASIC CLEANING";
                    else if($ptype==2) echo "PREMIUM CLEANING";
                    else if($ptype==3) echo "COMPLEX CLEANING";
                    ?>
                </td>
                <td class="amount-column">
                    <?php 
                    if($ptype==1) echo "₹200";
                    else if($ptype==2) echo "₹350";
                    else if($ptype==3) echo "₹400";
                    ?>
                </td>
            </tr>
        </table>
        <br><br>

        <div class="payment-details" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <div class="section-title">Payment Details</div>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px 0;">Transaction Type:</td>
                    <td style="text-align: right; font-weight: 500;">
                        <?php 
                        $transType = htmlentities($result->transactionType);
                        echo !empty($transType) ? $transType : 'Cash Payment';
                        ?>
                    </td>
                </tr>
                <?php if(!empty($result->transactionId)): ?>
                <tr>
                    <td style="padding: 8px 0;">Transaction ID:</td>
                    <td style="text-align: right; font-weight: 500; color: #2c3e50;">
                        <?php echo htmlentities($result->transactionId); ?>
                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td style="padding: 8px 0;">Payment Status:</td>
                    <td style="text-align: right;">
                        <span style="color: #28a745; font-weight: 500;">Paid</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">Total Amount:</td>
                    <td style="text-align: right; font-weight: 600; color: #2c3e50;">
                        <?php 
                        if($ptype==1) echo "₹200";
                        else if($ptype==2) echo "₹350";
                        else if($ptype==3) echo "₹400";
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <br><br>
<br><br><br>
        <div class="booking-details">
            <div class="section-title">Booking Details</div>
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 8px 0;">Washing Date/Time:</td>
                    <td style="text-align: right;"><?php echo htmlentities($result->washDate."/".$result->washTime);?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">Booking Date:</td>
                    <td style="text-align: right;"><?php echo htmlentities($result->postingDate);?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">Status:</td>
                    <td style="text-align: right;"><span style="color: #28a745;"><?php echo htmlentities($result->status);?></span></td>
                </tr>
            </table>
        </div>


        <div class="thank-you-section" style="text-align: center; margin: 30px 0 20px 0; padding: 20px; background: linear-gradient(135deg, #2c3e50, #3498db); border-radius: 8px; color: white; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMTgiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIiBzdHJva2Utd2lkdGg9IjIiLz48L3N2Zz4=') repeat; opacity: 0.1;"></div>
            <div style="position: relative; z-index: 1;">
                <i class="fa fa-heart" style="font-size: 24px; margin-bottom: 10px; color: #e74c3c;"></i>
                <h3 style="margin: 0 0 10px 0; font-size: 20px; font-weight: 600;">Thank You!</h3>
                <p style="margin: 0; font-size: 14px; opacity: 0.9;">We appreciate your business and look forward to serving you again.</p>
            </div>
        </div>

        <div class="footer-note" style="text-align: center; font-size: 12px; color: #666; margin-top: 15px; border-top: 1px dashed #dee2e6; padding-top: 15px;">
            <p style="margin: 0;">For any queries, please contact us.</p>
        </div>
        <br><br>
        <div style="width: 100%; margin: 40px 0;">
            <div style="float: right; text-align: center;">
                <div style="border-bottom: 1px solid #2c3e50; width: 200px; margin-bottom: 10px;">
                    <!-- You can add an image here if you have a signature image -->
                    <!-- <img src="signature.png" alt="Manager Signature" style="max-width: 150px; height: auto; margin-bottom: 5px;"> -->
                </div>
                <div style="font-size: 14px; color: #2c3e50;">
                    <strong>Manager Signature</strong><br>
                    Car Wash Management System
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div class="no-print" style="text-align: center; margin-top: 30px;">
            <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
            <button onclick="window.close()" class="btn btn-default">Close</button>
        </div>
    </div>
    <?php } ?>
</body>
</html>
<?php } ?> 