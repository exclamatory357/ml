<?php
session_start();
require_once '../../config/db.php';

if (isset($_GET['sale_id'])) {
    $sale_id = intval($_GET['sale_id']);

    // Fetch all receipt records for the specified sale_id
    $stmt_receipt = $con->prepare("SELECT * FROM receipt_records WHERE sale_id = ?");
    $stmt_receipt->bind_param("i", $sale_id);
    $stmt_receipt->execute();
    $result = $stmt_receipt->get_result();
    $receipts = $result->fetch_all(MYSQLI_ASSOC);
    $stmt_receipt->close();

    if ($receipts) {
        // Calculate the overall total
        $overall_total = 0;
        foreach ($receipts as $receipt) {
            $overall_total += $receipt['total_amount'];
        }

        // Get the amount from the query or set a default
        $amount = isset($_GET['amount']) ? floatval($_GET['amount']) : 0;
        $change = max(0, $amount - $overall_total); // Ensure change is not negative
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Print Receipt</title>
            <style>
                /* Print styling */
                * {
                    background: transparent !important;
                    background-color: white !important;
                    color-adjust: exact !important;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                    box-shadow: none !important;
                }

                body, html {
                    background: white !important;
                    margin: 0;
                    padding: 0;
                }

                @media print {
                    @page {
                        size: A4;
                        margin: 10mm;
                    }
                    body * {
                        visibility: hidden;
                    }
                    .print-area, .print-area * {
                        visibility: visible;
                    }
                    .print-area {
                        position: absolute;
                        left: 0;
                        top: 0;
                        width: 100%;
                        font-family: Arial, sans-serif;
                        text-align: center;
                        background: none !important;
                    }

                    .header-logo {
                        position: absolute;
                        top: 10px;
                        right: 10px;
                        width: 100px;
                        height: auto;
                    }

                    h1 {
                        font-size: 22px;
                        font-weight: bold;
                        margin-top: 0;
                    }
                    .content-info {
                        font-size: 14px;
                        margin: 10px 0;
                    }
                    table {
                        width: 80%;
                        margin: 20px auto;
                        border-collapse: collapse;
                        font-size: 14px;
                    }
                    table, th, td {
                        border: 1px solid black;
                    }
                    th, td {
                        padding: 8px;
                        text-align: center;
                    }
                    .footer {
                        width: 80%;
                        margin: 40px auto 0;
                        display: flex;
                        justify-content: flex-end;
                        align-items: center;
                    }
                    .signature {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        margin-top: 50px;
                        font-size: 14px;
                    }
                    .signature-line {
                        width: 200px;
                        border-top: 1px solid black;
                        margin-bottom: 5px;
                    }
                    .signature-label {
                        font-weight: bold;
                        text-align: center;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-area">
                <!-- Logo only in print area -->
                <img src="../function/uploads/icon.png" alt="Logo" class="header-logo">
                <h1>Danrose Fishing Agency Management System</h1>
                <h2>Address: Sitio Kabay-ot, Hilantagaan, Santa Fe, Cebu</h2>
                <h2>Contact Number: 09123456789</h2>
                <h2>Gmail: danrosefishing30@gmail.com</h2>

                <div class="content-info">
                    <p>Date: <?php echo htmlspecialchars($receipts[0]['payment_date']); ?></p>
                    <p>Buyer Name: <?php echo htmlspecialchars($receipts[0]['buyer_name']); ?></p>
                    <p>Address: <?php echo htmlspecialchars($receipts[0]['address']); ?></p>
                    <p>Phone Number: <?php echo htmlspecialchars($receipts[0]['phone_number']); ?></p>
                    <p>Payment Method: <?php echo htmlspecialchars($receipts[0]['payment_method']); ?></p>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Receipt Number</th>
                            <th>Remarks</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($receipts as $receipt) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($receipt['receipt_number']); ?></td>
                                <td><?php echo htmlspecialchars($receipt['remarks']); ?></td>
                                <td>&#8369;<?php echo number_format($receipt['total_amount'], 2); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2" style="text-align: right; font-weight: bold;">Overall Total:</td>
                            <td style="font-weight: bold;">&#8369;<?php echo number_format($overall_total, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right; font-weight: bold;">Amount Given:</td>
                            <td style="font-weight: bold;">&#8369;<?php echo number_format($amount, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right; font-weight: bold;">Change:</td>
                            <td style="font-weight: bold;">&#8369;<?php echo number_format($change, 2); ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="footer">
                    <div class="signature">
                        <span class="signature-line"></span>
                        <span class="signature-label">Signature</span>
                    </div>
                </div>
            </div>
            <script>
                window.onload = function() {
                    window.print();
                    window.onafterprint = function() {
                        window.location.href = '../?page=manage_sell_product';
                    };
                };
            </script>
        </body>
        </html>
        <?php
    } else {
        echo "<p>No receipt found for Sale ID: $sale_id</p>";
    }
} else {
    echo "<p>Missing Sale ID parameter.</p>";
}
?>
