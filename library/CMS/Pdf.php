<?php
class CMS_Pdf
{
    public function create($order){
        
        // include auto-loader class
        require_once 'fpdf.php';
        
        
        $orderDetailsModel=New Model_OrdersDetails(); //object to the order details table
	    $productModel = new Model_Products();
	
	    $details=$orderDetailsModel->getOrderDetails($order->id);
        
        $pdf=new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',20);
        //$pdf->Cell(140,10,'PrimaOro');

        $pdf->Cell(140,16,'');
        $pdf->Cell(40,16,'Sales Receipt');
        //$pdf->Image('http://images.primaoro.com/img/title.jpg',10,8,60,16);
        $pdf->Ln();

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(40,5,'321 Geneva St.',0,2);
        $pdf->Cell(40,5,'Glendale, CA 91206',0,2);
        $pdf->Cell(40,5,'818 601-2751',0,2);
        $pdf->Ln(20);
        
        $pdf->Cell(60);
        $pdf->Cell(35,5,'SHIP VIA',1);
        $pdf->Cell(18,5,'CUST. ID',1);
        $pdf->Cell(25,5,'REF. NO',1);
        $pdf->Cell(20,5,'DATE',1);
        $pdf->Cell(30,5,'ORDER ID NO.',1);
        $pdf->Ln();
        
        $pdf->Cell(60);
        $pdf->Cell(35,5,'1-7 BUSINESS DAYS',1);
        $pdf->Cell(18,5,$order->userID,1);
        $pdf->Cell(25,5,'IDCP80ke1r',1);
        $pdf->Cell(20,5,date('m/d/Y'),1);
        $pdf->Cell(30,5,'OIDN: '.$order->id,1);
        $pdf->Ln(20);
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(84,5,'Sold To',1);
        $pdf->Cell(20);
        $pdf->Cell(84,5,'Ship To',1);
        $pdf->Ln();

        $pdf->Cell(84,25,'',1);
        $pdf->Cell(20);
        $pdf->Cell(84,25,'',1);
        $pdf->Ln(0);

        $pdf->SetFont('Courier','B',12);

        $pdf->Cell(84,8,$order->bfName." ".$order->blName);
        $pdf->Cell(20);
        $pdf->Cell(84,8,$order->sfName." ".$order->slName);
        $pdf->Ln();

        $pdf->Cell(84,8,$order->bAddress);
        $pdf->Cell(20);
        $pdf->Cell(84,8,$order->sAddress);
        $pdf->Ln();

        $pdf->Cell(84,8,$order->bCity.", ".$order->bState." ".$order->bZip);
        $pdf->Cell(20);
        $pdf->Cell(84,8,$order->sCity.", ".$order->sState." ".$order->sZip);
        $pdf->Ln(20);
        
        //PRODUCTS TABLE
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(15,5,'Item#','B');
        $pdf->Cell(93,5,'Description','B',0,'C');
        $pdf->Cell(20,5,'Ordered','B');
        $pdf->Cell(20,5,'Shipped','B');
        $pdf->Cell(20,5,'Unit Price','B');
        $pdf->Cell(20,5,'Total','B');
        $pdf->Ln();

        $pdf->SetFont('Arial','',9);

        foreach($details as $detail){ 
		    $product = $productModel->find($detail->prodID)->current();	 	
					
			$pdf->Cell(15,5,$detail->prodID);
			$pdf->Cell(93,5,$product->name);
			$pdf->Cell(20,5,$detail->quantity);
			$pdf->Cell(20,5,$detail->quantity);
			$pdf->Cell(20,5,'$'.$product->price);
			$pdf->Cell(20,5,'$'.number_format ($product->price*$detail->quantity,2));
			$pdf->Ln();

		 }
		 
		 
		$pdf->Cell(188,1,'','B');
        $pdf->Ln(5);

        $pdf->SetFont('Arial','B',9);

        $pdf->Cell(140);
        $pdf->Cell(24,5,'Subtotal: ');
        $pdf->Cell(24,5,'$'.number_format ($order->subtotal,2));
        $pdf->Ln();
        $pdf->Cell(140);
        $pdf->Cell(24,5,'Shipping: ');
        $pdf->Cell(24,5,"$".number_format ($order->shipping,2));
        $pdf->Ln();

        $pdf->Cell(140);
        $pdf->Cell(24,5,'Total: ');
       $pdf->Cell(24,5,'$'.number_format ($order->total,2));
        $pdf->Ln();
        
        $pdf->Output('pdf/'. $order->id .'-'.date('d-m-Y').'.pdf','F');
        
        return 'pdf/'. $order->id .'-'.date('d-m-Y').'.pdf';
    }
    
}