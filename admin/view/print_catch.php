<?php
session_start();

if (isset($_SESSION["print_ready_team"]) && isset($_SESSION["added_ids"])) {
    $team = htmlspecialchars($_SESSION["print_ready_team"]);
    $added_ids = $_SESSION["added_ids"];

    unset($_SESSION["print_ready_team"], $_SESSION["added_ids"]);

    // Include database connection
    require_once '../../config/db.php';

    // Fetch the boat type for the selected team
    $boat_type = '';
    $stmt_pumpboat = $con->prepare("SELECT type FROM pumpboats WHERE team = ?");
    $stmt_pumpboat->bind_param("s", $team);
    $stmt_pumpboat->execute();
    $stmt_pumpboat->bind_result($boat_type);
    $stmt_pumpboat->fetch();
    $stmt_pumpboat->close();

    // Prepare IDs for SQL query
    $ids_string = implode(",", array_map('intval', $added_ids));
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print Catch Records</title>
        <style>
            /* Comprehensive reset for all backgrounds and images */
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

            /* Print styling */
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
            <h5>Address: Sitio Kabay-ot, Hilantagaan, Santa Fe, Cebu</h5>
                <h5>Contact Number: 09123456789</h5>
                <h5>Gmail: danrosefishing30@gmail.com</h5>
            <div class="content-info">
                <p>Date: <?php echo date('Y-m-d'); ?></p>
                <p>Team: <?php echo $team; ?></p>
                <p>Type: <?php echo htmlspecialchars($boat_type); ?></p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Catch Items</th>
                        <th>Catch Amount</th>
                        <th>Kilo</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
<?php
// Initialize the overall total
$overall_total = 0;

// Fetch and display data for printing
$catch_sql = "SELECT * FROM catch_records WHERE id IN ($ids_string)";
$catch_result = mysqli_query($con, $catch_sql);
if (mysqli_num_rows($catch_result) > 0) {
    while ($catch_row = mysqli_fetch_assoc($catch_result)) {
        $total = $catch_row['catch_amount'] * $catch_row['catch_kilo'];
        $overall_total += $total; // Add to overall total
        ?>
        <tr>
            <td><?php echo htmlspecialchars($catch_row['catch_item']); ?></td>
            <td>&#8369;<?php echo number_format($catch_row['catch_amount'], 2); ?></td>
            <td><?php echo htmlspecialchars($catch_row['catch_kilo']); ?> kg</td>
            <td>&#8369;<?php echo number_format($total, 2); ?></td>
        </tr>
    <?php }
} else { ?>
    <tr>
        <td colspan="4">No data found</td>
    </tr>
<?php } ?>
</tbody>
<tfoot>
    <tr>
        <td colspan="3" style="text-align: right;"><strong>Overall Total:</strong></td>
        <td><strong>&#8369;<?php echo number_format($overall_total, 2); ?></strong></td>
    </tr>
</tfoot>

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
                    window.location.href = '../?manage_catch_by_team';
                };
            };
        </script>
    </body>
    </html>
    <?php
} else {
    echo "No print data available.";
}
