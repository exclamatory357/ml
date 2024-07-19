<?php

require('../../plugins/fpdf/fpdf.php');
include "../../config/db.php";

$from = $_POST["from"];
$to = $_POST["to"];
$category = $_POST["category"]; // Correctly retrieve category

$sumOfCottage = 0;
$sumOfchild = 0;
$sumOfadult = 0;

$fill = true;

$pdf = new FPDF('L', 'mm', 'LETTER');
$pdf->SetTitle('Monthly Report', true);
$pdf->AddPage();

// Add background image
$background_image = 'uploads/danrose_house.jpg'; // Set the path to your background image
$pdf->Image($background_image, 0, 0, 279.4, 215.9); // Adjust the width and height according to your page size

// Title header
$pdf->SetFont('Arial', 'B', 25);
$pdf->SetX(90);
$pdf->Cell(90, 10, 'DanRose Fishing', '', 0, 'C');
$pdf->Ln();
$pdf->SetX(90); 
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(90, 10, 'Generate Report', '', 0, 'C');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(90);
$pdf->Cell(85, 0, 'FROM: ' . date("M d, Y", strtotime($from)) . '  ' . 'TO: ' . date("M d, Y", strtotime($to)), '', 0, 'C');
$pdf->Ln();

$pdf->SetY(40);
$pdf->SetLeftMargin(20);

$pdf->SetFillColor(217, 217, 217);
$pdf->SetDrawColor(0);
$pdf->SetLineWidth(0);

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
        $pdf->Cell(33, 5, 'Remaining Amount', 1, 0, 'L', $fill);
        $pdf->Cell(25, 5, 'Status', 1, 0, 'L', $fill);
        $pdf->Ln();

        while ($row = $query->fetch_assoc()) {
            $sumOfCottage += $row["amount"];
            $sumOfchild += $row["original_amount"];
            $sumOfadult += $row["remaining_amount"];

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

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(43, 5, '', 1, 0, 'L');
        $pdf->Cell(30, 5, '', 1, 0, 'L');
        $pdf->Cell(40, 5, '', 1, 0, 'L');
        $pdf->Cell(33, 5, 'Total', 1, 0, 'R');
        $pdf->Cell(33, 5, number_format($sumOfCottage, 2), 1, 0, 'R');
        $pdf->Cell(33, 5, number_format($sumOfchild, 2), 1, 0, 'R');
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

$pdf->Output();
?>
