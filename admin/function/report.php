<?php

require('../../plugins/fpdf/fpdf.php');
include "../../config/db.php";

$from = $_POST["from"];
$to = $_POST["to"];
$category = $_POST["category"]; // Correctly retrieve category

$sumOfCottage = 0;
$fill = true;

$pdf = new FPDF('L', 'mm', 'LETTER');
$pdf->SetTitle('Monthly Report', true);
$pdf->AddPage();

// Add Logo in the top-right corner
$pdf->Image('uploads/icon.png', 240, 10, 30); // Adjust the path and position as needed

// Title header
$pdf->SetFont('Arial', 'B', 25);
$pdf->SetX(90);
$pdf->Cell(90, 10, 'DanRose Fishing Agency Management System', '', 0, 'C');
$pdf->Ln(10);  // Break line with 10mm space

$pdf->SetFont('Arial', 'B', 16);
$pdf->SetX(90);
$pdf->Cell(90, 10, 'Generate Report C/A', '', 0, 'C');
$pdf->Ln(7);  // Break line with 10mm space

$pdf->SetX(90);
$pdf->Cell(88, 10, 'Address: Sitio Kabay-ot, Hilantagaan, Santa Fe, Cebu', '', 0, 'C');
$pdf->Ln(7);  // Break line with 10mm space

$pdf->SetX(90);
$pdf->Cell(87, 10, 'Contact Number: 09123456789', '', 0, 'C');
$pdf->Ln(7);  // Break line with 10mm space

$pdf->SetX(90);
$pdf->Cell(86, 10, 'Gmail: danrosefishing30@gmail.com', '', 0, 'C');
$pdf->Ln(10);  // Break line with 10mm space

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(90);
$pdf->Cell(85, 0, 'FROM: ' . date("M d, Y", strtotime($from)) . '  ' . 'TO: ' . date("M d, Y", strtotime($to)), '', 0, 'C');
$pdf->Ln(15);  // Break line with 10mm space

// Reset Y and Left margin settings
$pdf->SetY(60);
$pdf->SetLeftMargin(20);

// Set colors for the table headers
$pdf->SetFillColor(100, 100, 255); // Light blue
$pdf->SetTextColor(0, 0, 0); // Black text
$pdf->SetDrawColor(0, 0, 0); // Black border
$pdf->SetLineWidth(0.5); // Line width

if (isset($_POST["btnReport"])) {
    // Ensure the date format is correct
    $from = date("Y-m-d", strtotime($from));
    $to = date("Y-m-d", strtotime($to));

    $sql = "SELECT
        invoices.invoice_id,
        invoices.user_id,
        invoices.date_issued,
        invoices.amount,
        invoices.original_amount,
        invoices.remaining_amount,
        invoices.status,
        user.fname,
        user.lname
        FROM
        invoices
        INNER JOIN user ON user.user_id = invoices.user_id
        WHERE invoices.status = '$category' AND invoices.date_issued BETWEEN '$from' AND '$to'";

    $query = $con->query($sql);

    if ($query->num_rows > 0) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(43, 5, 'Agent Name', 1, 0, 'L', $fill);
        $pdf->Cell(30, 5, 'Invoice ID', 1, 0, 'L', $fill);
        $pdf->Cell(40, 5, 'Date Issued', 1, 0, 'L', $fill);
        $pdf->Cell(33, 5, 'Amount Pay', 1, 0, 'L', $fill);
        $pdf->Cell(33, 5, 'Original Amount', 1, 0, 'L', $fill);
        $pdf->Cell(33, 5, 'Balance', 1, 0, 'L', $fill);
        $pdf->Cell(25, 5, 'Status', 1, 0, 'L', $fill);
        $pdf->Ln();

        while ($row = $query->fetch_assoc()) {
            $sumOfCottage += $row["amount"];

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(43, 5, ucfirst($row['fname']) . ' ' . ucfirst($row['lname']), 1, 0, 'L');
            $pdf->Cell(30, 5, $row['invoice_id'], 1, 0, 'L');
            $pdf->Cell(40, 5, $row['date_issued'], 1, 0, 'L');
            $pdf->Cell(33, 5, number_format($row['amount'], 2), 1, 0, 'R');
            $pdf->Cell(33, 5, number_format($row['original_amount'], 2), 1, 0, 'R');
            $pdf->Cell(33, 5, number_format($row['remaining_amount'], 2), 1, 0, 'R');
            $pdf->Cell(25, 5, $row['status'], 1, 0, 'L');
            $pdf->Ln();
        }

        // Add a row for the total, excluding the original amount and balance
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(113, 5, 'Total: ', 1, 0, 'R', $fill);
        $pdf->Cell(33, 5, number_format($sumOfCottage, 2), 1, 0, 'R');
        $pdf->Cell(33, 5, '', 1, 0, 'R'); // Empty cell for the Original Amount
        $pdf->Cell(33, 5, '', 1, 0, 'R'); // Empty cell for the Balance
        $pdf->Cell(25, 5, '', 1, 0, 'L');
        $pdf->Ln();
    } else {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(43, 5, '', 0, 0, 'L');
        $pdf->Cell(40, 5, '', 0, 0, 'L');
        $pdf->Cell(30, 5, '', 0, 0, 'L');
        $pdf->Cell(25, 5, 'No Data', 0, 0, 'L');
        $pdf->Cell(25, 5, '', 0, 0, 'L');
        $pdf->Cell(50, 5, '', 0, 0, 'L');
        $pdf->Ln();
    }
}

// Signature section
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetXY(180, 250); // Adjust the Y value based on your page layout
$pdf->Cell(30, 5, 'Signature', 0, 0, 'C');

// Draw the underline for the signature
$pdf->Line(180, 255, 270, 255); // Adjust the starting and ending X positions to set the length of the underline

// Optional: Add another label below if needed, such as "Authorized Signatory"
$pdf->SetXY(180, 260); // Adjust the position for the second line of text
$pdf->Cell(30, 5, 'Authorized Signatory', 0, 0, 'C');
$pdf->Output();

?>
