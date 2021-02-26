<?php
include '../authentication/config.php';
include "session.php";
require 'PDF_Rotate.php';
$invoiceid=$_GET['invoice'];
$invoicevip=$_GET['vip'];
include 'query.php';
$invoiceC = mysqli_query($conn, "SELECT * FROM monthly_clients WHERE mc_id='$invoicevip'");
$cust_row = $invoiceC->fetch_assoc();
$invoiceData = mysqli_query($conn, "SELECT * FROM mcustomer_sales WHERE mr_id='$invoiceid' and client_id='$invoicevip'");
$readings = $invoiceData->fetch_assoc();
$dt1 = new DateTime($readings['start_date']);
$d1 = $dt1->format('D,d-M-Y');
$dt2 = new DateTime($readings['end_date']);

$d2 = $dt2->format('D,d-M-Y');
$td1 = new DateTime();
$td = $td1->format('D, d- M Y');
$dt2 = new DateTime($readings['end_date']);
$d2 = $dt2->format('D,d-M-Y');
$duedate = date('D , d M Y', strtotime(' + 5 days'));
$duedatenote = 'Current bill payable by ' . $duedate . '   to avoid disconnection.';

class Invoice extends PDF_Rotate
{

    function Header()
    {
        $strh = 'TOMAI WATER SUPPLIES';

        $this->SetFont('brandonGrotesque-Bold', 'B', 20);
        $this->Cell(30);
        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(0, 0, 0);
        $this->ClippingRoundedRect(0, 0, 150, 25, 0);

        //Rect(1, 1,145,25);
        $this->Image('../dist/assets/img/header1.png', 0, 0, 150, 25);
        $this->Cell(30, 10, $strh, 0, 1, 'L');


        //$this->Line(10, 20, 140, 20);
        //$this->Ln(10);
        $this->SetFillColor(0, 255, 0);


        $this->UnsetClipping();
    }

    function bill_to($invoiceC)
    {
        $this->SetFont('brandon-grotesque-regular', 'B', 10);
        $this->setXY(1, 30);
        $this->SetFillColor(69, 69, 69);

        $this->Cell(10, 20, '', '', 0, 'C');

        $this->MultiCell(80, 5, $invoiceC, '', 'L');
        $this->UnsetClipping();

    }

    function invoiceno($invoiceData)
    {
        $this->SetFont('brandon-grotesque-regular', 'B', 10);
        $x = $this->GetX();
        $this->setXY(60, 30);

        $this->SetDrawColor(24, 141, 170);
        $this->setTextcolor(0, 159, 159);
        $this->Line(81, 30, 81, 45);
        $this->cell(25, 0, '', '', 0, '');
        $y = $this->GetY();
        // $this->SetDrawColor(24,141,170);
        $this->ClippingRoundedRect(1, 27, 145, 20, 4, true);
        //$this->Image('../dist/assets/img/header.png', 1, 27, 145, 20);
        $this->MultiCell(70, 5, $invoiceData, '', 'J');
        //$this->Line(10, 45, 135, 45);

    }


    function populate_invoicedetails($data)
    {
        $this->SetFont('brandonGrotesque-Bold', 'B', 10);

        $this->Cell(50, 30, '', '', '1', 'C');
        $x = 20;
        $y = $this->GetY();
        $this->setXY($x, $y);
        $this->SetFillColor(24, 141, 170);
        $this->SetDrawColor(24, 141, 170);
        $this->setTextcolor(255, 255, 255);
        $this->Cell(30, 12, 'Prev. Reading', 'TLR', 0, 'L', true);
        $this->setXY($x + 25, $y);
        $this->Cell(30, 12, 'CurrentReading', 'T', 2, 'L', true);
        $this->setXY($x + 50, $y);
        $this->Cell(20, 12, 'Units', 'T', 2, 'L', true);
        $this->setXY($x + 60, $y);
        $this->Cell(20, 12, 'Rates', 'T', 2, 'L', true);
        $this->setXY($x + 80, $y);
        $this->Cell(30, 12, 'Amount', 'TR', 2, 'L', true);
        $i = 1;
        $total = 0;
        foreach ($data as $d) {
            $price = $d["rate_per_unit"] * $d["units"];
            $this->Ln(0);
            $x = 20;
            $y = $this->GetY();
            $this->setXY($x, $y);
            $this->SetFont('brandon-grotesque-regular', 'B', 10);
            $this->setTextcolor(0, 159, 159);
            $this->Cell(30, 12, $d["i_reading"], 'BL', 2, 'C');
            $this->setXY($x + 30, $y);
            $this->Cell(30, 12, $d["f_reading"], 'B', 2, 'L');
            $this->setXY($x + 50, $y);
            $this->Cell(30, 12, $d["units"], 0, 2, 'J');
            $this->setXY($x + 65, $y);
            $this->Cell(30, 12, 'ksh.' . $d["rate_per_unit"], 0, 2, 'L');
            $this->setXY($x + 80, $y);
            $this->Cell(30, 12, 'ksh.' . $price, 'RLB', 2, 'L');
            $total += $price;
            $i++;
        }
        $this->Ln(0);
        $x = 20;
        $y = $this->GetY();
        $this->setXY($x + 50, $y);
        $this->SetFont('brandonGrotesque-Bold', 'B', 10);
        $this->setTextcolor(255, 255, 255);
        $this->Cell(30, 12, 'Grand Total', 'TBL', 2, 'C', true);
        $this->setXY($x + 80, $y);
        $this->Cell(30, 12, 'ksh. ' . formatMoney($total, 2), 'RLTB', 2, 'L', true);
    }

    function headtitle($datecharge)
    {
        $this->SetFont('brandonGrotesque-Bold', 'B', 10);
        $x = $this->GetX();
        $y = $this->GetY();
        $this->setXY(15, 55);
        $this->SetFillColor(24, 141, 170);
        $this->SetTextColor(255, 255, 255);
        $this->cell(30, 5, '', '', 0);
        $this->RoundedRect(40, 55, 65, 5, 5, 13, 'F');
        $this->MultiCell(60, 5, $datecharge, 0, 'J');
        $this->Ln(2);
    }


    function Footer()
    {
        global $duedatenote;
        $this->SetY(-15);
        $this->SetTextColor(0, 159, 159);
        $this->SetFont('brandonGrotesque-Bold', 'B', 8);
        $this->Cell(0, 10, $duedatenote, 0, 0, 'C');
    }
}


ob_start();

$pdf = new Invoice('P', 'mm', 'A5');
$pdf->AddFont('brandon-grotesque-regular', 'B', 'brandon-grotesque-regular.php');
$pdf->AddFont('brandonGrotesque-Bold', 'B', 'BrandonGrotesque-Bold.php');
$pdf->AddPage();
//$pdf->Rect(5, 15, 110,100,'D');
$pdf->SetFont('brandon-grotesque-regular', 'B', 14);
$pdf->ClippingRoundedRect(0, 25, 150, 155, 0);
$pdf->Image('../dist/assets/img/bg.png', 0, 25, 150, 155);
//$pdf->Image('clips.jpg',40,100,130);
$pdf->UnsetClipping();
$pdf->invoiceno('INVOICE                :   # ' . $readings['bill_no'] . chr(10) . 'INVOICE DATE   :   ' . $td);
$pdf->bill_to('NAME            :   ' . $cust_row['fname'] . ' ' . $cust_row['lname'] . chr(10) . 'BIZNAME      :  ' . $cust_row['biz_name'] . chr(10));
$pdf->populate_invoicedetails($invoiceData);
$pdf->headtitle('Meter Reading date : ' . $d2);

//$pdf->nb('The invoice date represents the date the invoice was generated from the system.');
$fileName = $readings['bill_no'] . '-' . $cust_row['biz_name'] . '.pdf';
$pdf->SetAuthor('System Generated');

$pdf->Output('', $fileName);

ob_end_flush();