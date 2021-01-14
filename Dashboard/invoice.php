<?php
include '../authentication/config.php';
include "session.php";
require 'PDF_Rotate.php';
$invoiceid=$_GET['invoice'];
$invoicevip=$_GET['vip'];
include 'query.php';
$invoiceC = mysqli_query($conn, "SELECT * FROM monthly_clients WHERE mc_id='$invoicevip'");
$cust_row = $invoiceC->fetch_assoc();
$invoiceData= mysqli_query($conn, "SELECT * FROM mcustomer_sales WHERE mr_id='$invoiceid' and client_id='$invoicevip'");
$readings= $invoiceData->fetch_assoc();
$dt1 = new DateTime($readings['start_date']);
$d1=$dt1->format('D,d-M-Y');
$dt2 = new DateTime($readings['end_date']);

$d2=$dt2->format('D,d-M-Y');
class Invoice extends PDF_Rotate {

    function Header(){
                            $this->SetFont('times','B',24);
        $this->Cell(60);
        $this->SetFillColor(210, 225, 225);
        $this->SetDrawColor(22,200,224);
        $this->Cell(60,10,'INVOICE',0,1,'C',true);

        $this->Rect(5, 5, 200, 287, 'D');


        $this->Ln(10);


//Put the watermark
        $this->SetFont('times','B',50);
        $this->SetTextColor(255,192,203);
       $this->RotatedText(90,190,'',65);
    }

    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }
    function add_from($invoiceC){
        $this->SetFont('times','',10);
        $this->setXY(10,50);
        $this->SetFillColor(210, 225, 225);
        $this->Cell(25,6,'BILLED TO:',0,2,'L',true);
        $this->Cell(60,6,'','','2','L');
        $this->MultiCell(70,5,$invoiceC,'','L');
        $this->Ln(10);
    }

    function add_to($str){
        $this->SetFont('times','',10);
        $x = $this->GetX();
        $this->setXY($x+135,25);
        $this->Cell(60,7,'',0,2,'L',false);
        $y = $this->GetY();
        $this->MultiCell(60,8,$str,'',1);
        $this->Ln(10);
    }
    function datebill($invoiceData){
        $this->SetFont('times','B',10);
        $x = $this->GetX();
        $this->setXY($x+50,100);
        $this->SetFillColor(210, 225, 225);
        $this->Cell(100,10,'Bill Charge date:',1,2,'C','true');
        $y = $this->GetY();
        $this->MultiCell(100,8,$invoiceData,'LRB','C');
        $this->Ln(10);
    }
    function add_order_detail($invoiceData){
        $this->Cell(50,'10','','','1','C');
        $x=$this->GetX();
        $y=$this->GetY();
        $this->setXY($x,$y);
        $this->Cell(50,7,'Initial Reading',1,2,'C',false);

        $this->setXY($x+50,$y);
        $this->Cell(50,7,'Final Reading',1,2,'C',false);

        $this->setXY($x+100,$y);
        $this->Cell(40,7,'Dates Recorded',1,2,'C',false);
        $this->MultiCell(60,8,$invoiceData,'LRB',1);
        $this->Ln(10);


    }
function addtitle($invoiceData){
    $this->SetFont('times','',11);
    $this->SetFillColor(210, 225, 225);
    $x=$this->GetX();
    $y=$this->GetY();
    $this->setXY($x+50,$y+15);
    $this->Cell(100,8,'BILL SUMMARY:',1,2,'C',true);
    $this->Cell(60,'6','','','2','C');
    $this->MultiCell(100,6,$invoiceData,'1','C',false);





}
    function populate_table($data){
        $this->SetFont('times','B',10);
        $this->Cell(50,'10','','','1','C');
        $x=$this->GetX();
        $y=$this->GetY();
        $this->setXY($x,$y);
        $this->Cell(20,10,'Bill No.',0,2,'C',true);
        $this->setXY($x+20,$y);
        $this->Cell(50,10,'Previous Reading',0,2,'C',true);
        $this->setXY($x+70,$y);
        $this->Cell(30,10,'CurrentReading',0,2,'L',true);
        $this->setXY($x+100,$y);
        $this->Cell(20,10,'Units',0,2,'L',true);
        $this->setXY($x+120,$y);
        $this->Cell(30,10,'Rates',0,2,'L',true);
        $this->setXY($x+150,$y);
        $this->Cell(30,10,'Amount',0,2,'L',true);
        $i=1;
        $total=0;
        foreach($data as $d){
            $price = $d["rate_per_unit"]*$d["units"];
            $this->Ln(0);
            $x=$this->GetX();
            $y=$this->GetY();
            $this->setXY($x,$y);
            $this->Cell(20,10,$d['bill_no'],0,2,'L');
            $this->setXY($x+20,$y);
            $this->Cell(50,10,$d["i_reading"],0,2,'C');
            $this->setXY($x+70,$y);
            $this->Cell(30,10,$d["f_reading"],0,2,'C');
            $this->setXY($x+100,$y);
            $this->Cell(20,10,$d["units"],0,2,'L');
            $this->setXY($x+120,$y);
            $this->Cell(30,10,'ksh.'.$d["rate_per_unit"].' /unit',0,2,'L');
            $this->setXY($x+150,$y);
            $this->Cell(30,10,'ksh.'.$price,0,2,'L');
            $total += $price;
            $i++;
        }
        $this->Ln(0);
        $x=$this->GetX();
        $y=$this->GetY();
        $this->setXY($x+120,$y);
        $this->Cell(30,7,'Grand Total',0,2,'C',true);
        $this->setXY($x+150,$y);
        $this->Cell(30,7,'ksh. '.formatMoney($total,2),0,2,'L');
    }

//    function populate_table($invoiceData)
//    {
//        $this->SetFont('times','',10);
//        $x=$this->GetX();
//        $y=$this->GetY();
//        $this->setXY($x+30,$y+5);
//        $this->Cell(25,8,'',0,2,'L',false);
//        $this->MultiCell(70,5,$invoiceData,'',1);
//        $this->MultiCell(60,8,$invoiceData,'LRB',1);
//        $this->Ln(10);
//    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('times','I',8);
        $this->Cell(0,10,'Copyright  Tomai water supplies. All Rights Reserved.',0,0,'C');
    }
}


ob_start();

$pdf = new Invoice();
$pdf->AddPage();
$pdf->SetFont('times','B',16);


$pdf->add_from('NAME            :      '.$cust_row['fname'].' '.$cust_row['lname'].chr(10).'BIZ NAME     :    '.$cust_row['biz_name'].chr(10).'ADDRESS      :    MAKUTANO, KYUMBI'.chr(10).'EMAIL           :      '.$cust_row['email']);
$pdf->add_to("TOMAI WATER SUPPLIES\n+254723778932\nTomaiwaterservices@gmail.com");
$pdf->datebill($d1.'     :        '.$d2);
//$pdf->addtitle('Bill No:                    '.$readings['bill_no'].chr(10).chr(10).'Initial Reading:        '.$readings['i_reading'].chr(10).chr(10).'Final Reading:          '.$readings['f_reading'].chr(10).chr(10).'Units:                        '.$readings['units'].chr(10).chr(10).'Rate:                        '.'Ksh.'.$readings['rate_per_unit'].chr(10).chr(10).'Amount:                   '.'ksh.'.$readings['Amount']);
$pdf->populate_table($invoiceData);
$pdf->Output();
ob_end_flush();