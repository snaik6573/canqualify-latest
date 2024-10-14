<?php
namespace App\Controller\Component;
require_once(ROOT."/vendor/aws/aws-autoloader.php"); 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
/**
 * Export component
 */
class ExportComponent extends Component
{
  
    public function exportToExcel($report=array(),$year=array())
    {    
    $spreadsheet = new Spreadsheet();
    $spreadsheet->createSheet(0);
       
    $i=67;
    if($i <= 70)
    {
      foreach ($year as $key => $value) {     
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1','Contractor Name')
                    ->setCellValue('B1','Category'); 
        $azRange = range('C', 'F');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'1',$value);   
        $i++; 
      }
    } 
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $col = 2;
    foreach ($report as $rep) {
      $row = 1;
        foreach ($rep as $key => $value) {
           $spreadsheet->getActiveSheet(0)->setCellValueByColumnAndRow($row, $col, $value);     
           $row++;
        }
        $col++;
    }
    $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];    
    $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);
    $spreadsheet->getActiveSheet()->setTitle('Report Result'); 
    $sheet = $spreadsheet->getActiveSheet();
    $spreadsheet->setActiveSheetIndex(1);
    $spreadsheet->getActiveSheet(1)->setTitle('Chart');
    $drawing = new Drawing();
    $drawing->setName('chart');
    $drawing->setDescription('chart');
    $filename = EXPORT_IMG.'image.png';
    if (file_exists($filename)) {          
        $drawing->setPath($filename); // put your path and image here
       // unlink($filename);     
        $drawing->setCoordinates('A4');
        $drawing->setOffsetX(25);                       //setOffsetX works properly
        $drawing->setOffsetY(10);                //setOffsetY works properly
        $drawing->setWidth(300);                 //set width, height
        $drawing->setHeight(300); 
        $drawing->getShadow()->setVisible(true);
        $drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet(1));
        $writer = new Xlsx($spreadsheet);
        $writer->save(EXPORT_IMG.'Report.xlsx');      
        ob_end_clean();
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
        header("Content-Disposition: attachment; filename=".$filename);
        header("Cache-Control: max-age=0");
        header('Cache-Control: no-cache');
        $writer->save('php://output'); 
        exit();     
    }
   } 
    public function exportToPdf($report=array(),$year=array())
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet(0)->setTitle('Table');
        $i=67;
         if($i <= 70)
         {
         foreach ($year as $key => $value) {     
            $spreadsheet->setActiveSheetIndex(0)
              ->setCellValue('A1','Contractor Name')
              ->setCellValue('B1','Category'); 
              $azRange = range('C', 'F');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'1',$value);
            $i++;  
        }
        }   
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);     
       $col = 2;
       foreach ($report as $rep) {
        $row = 1;
            foreach ($rep as $key => $value) {
                $spreadsheet->getActiveSheet(0)->setCellValueByColumnAndRow($row, $col, $value);       
                $row++;
          }
         $col++;
        }
        $spreadsheet->createSheet();
        $drawing = new Drawing();
        $drawing->setName('chart');
        $drawing->setDescription('chart');
        $filename = EXPORT_IMG.'image.png';
        if (file_exists($filename)) {          
        $drawing->setPath($filename); // put your path and image here
        $drawing->setCoordinates('A4');
        $drawing->setOffsetX(110);
        $drawing->setRotation(25);
        $drawing->getShadow()->setVisible(true);
        $drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->setActiveSheetIndex(1));
        $spreadsheet->getActiveSheet(1)->setTitle('chart');
        //$spreadsheet->getActiveSheet(1)->getSheetView()->setZoomScale(75);
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('A1:F12')->applyFromArray($styleArray);
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
        $writer->setPreCalculateFormulas(false);
        $writer->writeAllSheets();
        $writer->save(EXPORT_IMG."Report.pdf");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Report.pdf"');
        $writer->save("php://output");
        return false;
      } 
    }
    public function exportToCsv($report=array(),$year=array()){       
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
         $i=67;
         if($i <= 70)
         {
           foreach ($year as $key => $value) {          
            $spreadsheet->setActiveSheetIndex(0)
              ->setCellValue('A1','Contractor Name')
              ->setCellValue('B1','Category'); 
                $azRange = range('C', 'F');      
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'1',$value);
               $i++;  
        }
        }
        $col = 2;
        foreach ($report as $rep) {
          $row = 1;
            foreach ($rep as $key => $value) {
                $spreadsheet->getActiveSheet(0)->setCellValueByColumnAndRow($row, $col, $value);      
                $row++;
            }
           $col++;
        }
        $spreadsheet->getActiveSheet(0)->setTitle('Table');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setSheetIndex(0);
        $writer->setPreCalculateFormulas(false);
        $writer->setUseBOM(true);
        $writer->save(EXPORT_IMG.'Report.csv');
        header('Content-Type: text/csv');    
        header('Content-Disposition: attachment;filename="Report.csv"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->save('php://output');
        return false;
    }

    public function XportToExcel($data =array(),$headT=array(),$company_logo = null)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A5:H5');
        $spreadsheet->getActiveSheet()->mergeCells('B2:B4');
        /*add logo*/
        if($company_logo != null ){
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath($company_logo); /* put your path and image here */
        $drawing->setWidthAndHeight(300,150);
        $drawing->setResizeProportional(true);
        $drawing->setCoordinates('B2');
        $drawing->getShadow()->setVisible(true);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        }
        $spreadsheet->getActiveSheet()->getStyle('A6:H6')->applyFromArray(
           array(
            'fill' => array(
              'type' => Fill::FILL_SOLID,
              'color' => array('rgb' => 'E5E4E2' )
            ),
            'font'  => array(
              'bold'  =>  true
            )
           )
         );
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $dateC = date("d-M-Y");
        $spreadsheet->getActiveSheet()->getStyle('A6:H6')->applyFromArray($styleArray);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
        if($headT[5] == "Waiting On"){
          $sheet->setCellValue('A2', 'Client Name:- '.$headT[8]);
        }else{
          $sheet->setCellValue('A2', 'Client Name:- '.$headT[9]);
        }        
        $sheet->setCellValue('A3', 'Total Contractors:- '.count($data));
        $sheet->setCellValue('A4', 'Date Downloaded:- '.$dateC);
        if($headT[5] == "Waiting On"){
          $sheet->setCellValue('A5', $headT[8]);
        }else{
          $sheet->setCellValue('A5', $headT[9]);
        }
        $spreadsheet->getActiveSheet()->setAutoFilter('B6:E6');
        if($headT[5] == "Waiting On"){
        $i=65;      
        if($i <= 72)
        {
         foreach ($headT as $key => $value) {  
            $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'6',$value);
            $i++; 
          if(chr($i) == 'I') break;
         }
        }
        }else{
            $i=65;      
        if($i <= 72)
        {
         foreach ($headT as $key => $value) {  
            $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'6',$value);
            $i++; 
          if(chr($i) == 'J') break;
         }
        }
        } 
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A7'); 
        $writer = new Xlsx($spreadsheet); 
        if($headT[5] == "Waiting On"){
          $title = str_replace(" ","_",mb_strimwidth($headT[8],0, 13));
        }else{
          $title = str_replace(" ","_",mb_strimwidth($headT[9],0, 13));
        } 
        $filename = $title.'_'.$dateC.'.xlsx';
        $spreadsheet->getActiveSheet()->setTitle($filename);
        $file_url = DOWNLOAD_PQF.$filename;
        //$writer->save(DOWNLOAD_PQF.$headT[7].' '.$dateC.'.xlsx');
        ob_end_clean();
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
        header("Content-Disposition: attachment; filename=".$filename);
        // header("Cache-Control: max-age=0");
        // header('Cache-Control: no-cache');
        $writer->save('php://output');        
    }
    public function XportToCSV($data =array(),$headT=array())
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        if($headT[5] == 'Waiting On'){
           $sheet->setCellValue('A1', $headT[8]);
           $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                //if(chr($i) == 'I') {break;}
             }
            } 
        }else{
        if($headT[7] != "Status"){
        $sheet->setCellValue('A1', $headT[8]);
           $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                //if(chr($i) == 'J') {break;}
             }
            } 
        }else{
            $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                //if(chr($i) == 'K') {break;}
             }
            } 
        }
      }
       
      
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A3');    
        $sheet->getStyle('A:K')->getAlignment()->setHorizontal('left');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setSheetIndex(0);
        $writer->setPreCalculateFormulas(false);
        //$writer->save(EXPORT_IMG.'ContractorList.csv');
        if($headT['5'] == "Waiting On"){
          $filename = $headT[8].'.csv';
        }else{
          $filename = $headT[9].'.csv';
        }
        
        header('Content-Type: text/csv');
        if($headT[5] = "Waiting On"){
             header("Content-Disposition: attachment; filename=".$filename);             
        }else{
          if($headT[7] == 'Status'){
           header('Content-Disposition: attachment;filename="ContractorList.csv"');
          }else{
           header("Content-Disposition: attachment; filename=".$filename);
          }      
        }
        
       
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->save('php://output');
        exit();
    }
	public function XportToCSVLead($data =array(),$headT=array())
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $dateC = date("d-M-Y");

        if($headT[5] == 'Waiting On'){
           $sheet->setCellValue('A1', $headT[7]);
           $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                if(chr($i) == 'H') {break;}
             }
            } 
        }else{
        if($headT[7] != "Status"){
        $sheet->setCellValue('A1', $headT[8]);
           $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                if(chr($i) == 'I') {break;}
             }
            } 
        }else{
            $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                if(chr($i) == 'J') {break;}
             }
            } 
        }
      }
       
      
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A3');    
        $sheet->getStyle('A:K')->getAlignment()->setHorizontal('left');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setSheetIndex(0);
        $writer->setPreCalculateFormulas(false);
        //$writer->save(EXPORT_IMG.'ContractorList.csv');
       /* if($headT['5'] == "Waiting On"){
          $filename = $headT[7].'.csv';
        }else{
          $filename = $headT[8].'.csv';
        }*/
        $filename = $dateC.'.csv';
        header('Content-Type: text/csv');
        if($headT[5] = "Waiting On"){
             header("Content-Disposition: attachment; filename=".$filename);             
        }else{
          if($headT[7] == 'Status'){
           header('Content-Disposition: attachment;filename="ContractorList.csv"');
          }else{
           header("Content-Disposition: attachment; filename=".$filename);
          }      
        }
        
       
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->save('php://output');
        exit();
    }

    public function XportToPDF($data=array(), $image=null, $contractor_id=null, $path=null)
    {
       $spreadsheet = new Spreadsheet();
       $spreadsheet->setActiveSheetIndex(0);
       $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(60);
	   

       $sheet = $spreadsheet->getActiveSheet(0);
       $spreadsheet->getActiveSheet()->mergeCells('A1:C1');	          
	   $spreadsheet->getActiveSheet()->mergeCells('A2:C2');	          
	   
	   $sheet->getPageMargins()
			->setLeft(0.75)
			->setRight(0.75)
			->setTop(1)
			->setBottom(1)
			->setHeader(0);
	
	
	   $clm =count($data)+1;	   
	   $sheet->getStyle('B2:C'.$clm)->getAlignment()->setHorizontal('center');


       if($image!=null && file_exists($image))
       {
	       $drawing = new Drawing();
	       $drawing->setPath($image); // put your path and image here
		   
		   $drawing->setOffsetX(25);                       //setOffsetX works properly
		   $drawing->setOffsetY(10);                //setOffsetY works properly
		   $drawing->setWidth(150);                 //set width, height		   
		   $drawing->setWorksheet($spreadsheet->setActiveSheetIndex(0));	       
       }
		//$col = 1;	
       
		$spreadsheet->getActiveSheet()
		   ->fromArray(
			   $data,  // The data to set
			   NULL,        // Array values with this value will not be set
			   'A2'         // Top left coordinate of the worksheet range where
							//    we want to set these values (default is A1)
		   );

		$styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],					
                ],
            ],
        ];	
		$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getStyle('A2:C'.$clm)->applyFromArray($styleArray);	
		
       ///$spreadsheet->getActiveSheet()->setTitle('Table');
	   $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);        
       $writer->setPreCalculateFormulas(false);
	   $writer->writeAllSheets();
	   if($path!=null)
	   {
       $writer->save($path.'ContractorInvoice_'.$contractor_id.'.pdf');
	   return $path.'ContractorInvoice_'.$contractor_id.'.pdf';
	   }
		else
		{
		   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		   header('Content-Disposition: attachment; filename="Report.pdf"');
		   $writer->save("php://output");
		   return false;
		}
 
   }
   public function XportToPQF($data = array(), $cnt = 0, $format_array = array(), $file_name = null)
    {
        if($file_name == null || empty($file_name)){
            $file_name = 'PQF.pdf';
        }
       $spreadsheet = new Spreadsheet();
       $spreadsheet->setActiveSheetIndex(0);
       $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(100);

       $sheet = $spreadsheet->getActiveSheet(0);
       /*align all cells content to left*/
       $sheet->getStyle('A1:A'.$cnt)->getAlignment()->setHorizontal('left');
       //$sheet->getStyle('A2')->getAlignment()->setHorizontal('right');
        if(!empty($format_array['pull_right']) && count($format_array['pull_right']) > 0){
            foreach ($format_array['pull_right'] as $pull_right_row){
                $sheet->getStyle('A'.$pull_right_row)->getAlignment()->setHorizontal('right');
                $spreadsheet->getActiveSheet()->getStyle('A'.$pull_right_row)->applyFromArray(array('font' => array('size' => 14)));

            }
        }

        if(!empty($format_array['bold_cells']) && count($format_array['bold_cells']) > 0){
            foreach ($format_array['bold_cells'] as $row){
                $spreadsheet->getActiveSheet()->getStyle('A'.$row)->applyFromArray(array('font' => array('bold'  =>  true)));
            }
        }

        if(!empty($format_array['service_cells']) && count($format_array['service_cells']) > 0){
            foreach ($format_array['service_cells'] as $service_row){
                $spreadsheet->getActiveSheet()->getStyle('A'.$service_row)->applyFromArray(array('font' => array('color'  =>  array('rgb' => '66CC01'), 'size' => 16)));
            }
        }

        if(!empty($format_array['category_cells']) && count($format_array['category_cells']) > 0){
            foreach ($format_array['category_cells'] as $category_row){
                $spreadsheet->getActiveSheet()->getStyle('A'.$category_row)->applyFromArray(array('font' => array('color'  =>  array('rgb' => '0065CE'), 'size' => 13)));
            }
        }


       /*if($image!=null && file_exists($image))
       {
	       $drawing = new Drawing();
	       $drawing->setPath($image); // put your path and image here
	       $drawing->setWorksheet($spreadsheet->setActiveSheetIndex(0));	       
       }*/
       $col = 1;
       foreach ($data as $res)
       {
           $row =1;
           $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($row, $col, $res);
           $row++;
           $col++;
       }

       $spreadsheet->getActiveSheet()->setTitle('Table');
       $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
       //$writer->setPreCalculateFormulas(false);
       $writer->writeAllSheets();

       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment; filename="'.$file_name.'"');
       $writer->save("php://output");

       return false;
   }
    public function htmlToPDF($output=array(), $path=null, $contractor_id=null)
    {
      if($path!=null)
	   {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($output);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
        $writer->save($path.'ContractorInvoice_'.$contractor_id.'.pdf');
	    return $path.'ContractorInvoice_'.$contractor_id.'.pdf';
	   }
		else
		{
		   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		   header('Content-Disposition: attachment; filename="Report.pdf"');
		   $writer->save("php://output");
		   return false;
		}



    }
    public function XportToExcelData($data =array(),$headT=array(),$title)
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        if(count($headT) == 6){
        $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
        }else{
         $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
        }
        $spreadsheet->getActiveSheet()->getStyle('A3:F3')->applyFromArray(
           array(
            'fill' => array(
              'type' => Fill::FILL_SOLID,
              'color' => array('rgb' => 'E5E4E2' )
            ),
            'font'  => array(
              'bold'  =>  true
            )
           )
         );
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $dateC = date("d-M-Y");
        if(count($headT) == 6){
          $spreadsheet->getActiveSheet()->getStyle('A3:F3')->applyFromArray($styleArray);
        }else{
          $spreadsheet->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleArray);
        }
        $sheet->getStyle('C')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');        
        $sheet->setCellValue('A2', $title);        
       
        $i=65;      
        if($i <= 75)
        {
         foreach ($headT as $key => $value) {  
            $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'3',$value);
            $i++; 
          if(chr($i) == 'K') break;
         }
        } 
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A5'); 
        $writer = new Xlsx($spreadsheet); 

       // $title = str_replace(" ","_",mb_strimwidth($headT[7],0, 13)); 
         
        $filename = $title.'_'.$dateC.'.xlsx';

        $spreadsheet->getActiveSheet()->setTitle($filename);
        // $file_url = DOWNLOAD_PQF.'ContractorList.xlsx';
        //$writer->save($file_url.'_'.$dateC.'.xlsx');
        ob_end_clean();
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
        header("Content-Disposition: attachment; filename=".$filename);
        header("Cache-Control: max-age=0");
        header('Cache-Control: no-cache');
        $writer->save('php://output');        
      }
      public function XportToCSVData($data =array(),$headT=array(),$title)
      {        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);        
        // $sheet->setCellValue('A1', $headT[7]);        
        $i=65;      
        if($i <= 72)
        {
         foreach ($headT as $key => $value) {  
            $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'1',$value);
            $i++; 
          if(chr($i) == 'K') break;
         }
        }        
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A2');    
        $sheet->getStyle('A:K')->getAlignment()->setHorizontal('left');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setSheetIndex(0);
        $writer->setPreCalculateFormulas(false);
        $dateC = date("d-M-Y");       
        $filename = $title.'_'.$dateC.'.csv';
        header('Content-Type: text/csv');  
        //$file_url = 'ContractorList.csv';  
        header("Content-Disposition: attachment;filename=".$filename);
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->save('php://output');
        exit();
    }
    public function XportLeadExcel($data =array(),$headT=array())
    {
      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A5:H5');
        $spreadsheet->getActiveSheet()->getStyle('A6:H6')->applyFromArray(
           array(
            'fill' => array(
              'type' => Fill::FILL_SOLID,
              'color' => array('rgb' => 'E5E4E2' )
            ),
            'font'  => array(
              'bold'  =>  true
            )
           )
         );
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $dateC = date("d-M-Y");
        $spreadsheet->getActiveSheet()->getStyle('A6:H6')->applyFromArray($styleArray);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
        // $sheet->setCellValue('A2', 'Client Name:- '.$headT[8]);
        $sheet->setCellValue('A3', 'Total Contractors:- '.count($data));
        $sheet->setCellValue('A4', 'Date Downloaded:- '.$dateC);
        // $sheet->setCellValue('A5', $headT[8]);
        $spreadsheet->getActiveSheet()->setAutoFilter('B6:E6');
       
        $i=65;      
        if($i <= 72)
        {
         foreach ($headT as $key => $value) {  
            $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'6',$value);
            $i++; 
          if(chr($i) == 'I') break;
         }
        } 
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A7'); 
        $writer = new Xlsx($spreadsheet); 

        $title = str_replace(" ","_",mb_strimwidth($headT[7],0, 13)); 
         
        $filename = $dateC.'.xlsx';

        $spreadsheet->getActiveSheet()->setTitle($filename);
        $file_url = DOWNLOAD_PQF.$filename;
        //$writer->save(DOWNLOAD_PQF.$headT[7].' '.$dateC.'.xlsx');
        ob_end_clean();
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
        header("Content-Disposition: attachment; filename=".$filename);
        header("Cache-Control: max-age=0");
        header('Cache-Control: no-cache');
        $writer->save('php://output');    
    }
    public function XportToExcel2($data =array(),$headT=array())
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A5:H5');
        $spreadsheet->getActiveSheet()->getStyle('A6:H6')->applyFromArray(
           array(
            'fill' => array(
              'type' => Fill::FILL_SOLID,
              'color' => array('rgb' => 'E5E4E2' )
            ),
            'font'  => array(
              'bold'  =>  true
            )
           )
         );
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $dateC = date("d-M-Y");
        $spreadsheet->getActiveSheet()->getStyle('A6:H6')->applyFromArray($styleArray);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
        if($headT[5] == "Waiting On"){
          $sheet->setCellValue('A2', 'Client Name:- '.$headT[8]);
        }else{
          $sheet->setCellValue('A2', 'Client Name:- '.$headT[9]);
        }        
        $sheet->setCellValue('A3', 'Total Contractors:- '.count($data));
        $sheet->setCellValue('A4', 'Date Downloaded:- '.$dateC);
        if($headT[5] == "Waiting On"){
          $sheet->setCellValue('A5', $headT[7]);
        }else{
          $sheet->setCellValue('A5', $headT[8]);
        }
        $spreadsheet->getActiveSheet()->setAutoFilter('B6:E6');
        if($headT[5] == "Waiting On"){
        $i=65;      
        if($i <= 72)
        {
         foreach ($headT as $key => $value) {  
            $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'6',$value);
            $i++; 
          if(chr($i) == 'I') break;
         }
        }
        }else{
            $i=65;      
        if($i <= 72)
        {
         foreach ($headT as $key => $value) {  
            $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'6',$value);
            $i++; 
          if(chr($i) == 'J') break;
         }
        }
        } 
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A7'); 
        $writer = new Xlsx($spreadsheet); 
        if($headT[5] == "Waiting On"){
          $title = str_replace(" ","_",mb_strimwidth($headT[7],0, 13)); 
        }else{
          $title = str_replace(" ","_",mb_strimwidth($headT[8],0, 13)); 
        } 
        $filename = $title.'_'.$dateC.'.xlsx';
        $spreadsheet->getActiveSheet()->setTitle($filename);
        $file_url = DOWNLOAD_PQF.$filename;
        //$writer->save(DOWNLOAD_PQF.$headT[7].' '.$dateC.'.xlsx');
        ob_end_clean();
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
        header("Content-Disposition: attachment; filename=".$filename);
        // header("Cache-Control: max-age=0");
        // header('Cache-Control: no-cache');
        $writer->save('php://output');        
    }
    public function XportToCSV2($data =array(),$headT=array())
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        if($headT[5] == 'Waiting On'){
           $sheet->setCellValue('A1', $headT[8]);
           $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                if(chr($i) == 'I') {break;}
             }
            } 
        }else{
        if($headT[7] != "Status"){
        $sheet->setCellValue('A1', $headT[7]);
           $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                if(chr($i) == 'J') {break;}
             }
            } 
        }else{
            $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                if(chr($i) == 'K') {break;}
             }
            } 
        }
      }
       
      
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A3');    
        $sheet->getStyle('A:K')->getAlignment()->setHorizontal('left');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setSheetIndex(0);
        $writer->setPreCalculateFormulas(false);
        //$writer->save(EXPORT_IMG.'ContractorList.csv');
        if($headT['5'] == "Waiting On"){
          $filename = $headT[8].'.csv';
        }else{
          $filename = $headT[9].'.csv';
        }
        
        header('Content-Type: text/csv');
        if($headT[5] = "Waiting On"){
             header("Content-Disposition: attachment; filename=".$filename);             
        }else{
          if($headT[7] == 'Status'){
           header('Content-Disposition: attachment;filename="ContractorList.csv"');
          }else{
           header("Content-Disposition: attachment; filename=".$filename);
          }      
        }
        
       
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->save('php://output');
        exit();
    }
    public function XportToExcel3($data =array(),$headT=array(),$isEmail = false)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A3:D3');
        $spreadsheet->getActiveSheet()->getStyle('A4:D4')->applyFromArray(
           array(
            'fill' => array(
              'type' => Fill::FILL_SOLID,
              'color' => array('rgb' => 'E5E4E2' )
            ),
            'font'  => array(
              'bold'  =>  true
            )
           )
         );
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $dateC = date("d-M-Y");
        $spreadsheet->getActiveSheet()->getStyle('A4:D4')->applyFromArray($styleArray);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        
        $sheet->setCellValue('A1', 'Client Name:- '.$headT[4]);       
      
        $sheet->setCellValue('A2', 'Date Downloaded:- '.$dateC);
         $sheet->setCellValue('A3', 'Employees Orientation Status');
        $spreadsheet->getActiveSheet()->setAutoFilter('A4:D4');
        
        $i=65;      
        if($i <= 72)
        {
         foreach ($headT as $key => $value) {  
            $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'4',$value);
            $i++; 
          if(chr($i) == 'E') break;
         }
        }       
        
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A6'); 
        $writer = new Xlsx($spreadsheet); 
       
        $title = str_replace(" ","_",mb_strimwidth($headT[4],0, 13)); 
        
        $filename = $title.'_'.$dateC.'.xlsx';
        $spreadsheet->getActiveSheet()->setTitle($filename);
        //$file_url = DOWNLOAD_PQF.$filename;
        //$writer->save(DOWNLOAD_PQF.$headT[7].' '.$dateC.'.xlsx');
        ob_end_clean();
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
        header("Content-Disposition: attachment; filename=".$filename);
        // header("Cache-Control: max-age=0");
        // header('Cache-Control: no-cache');
        $writer->save('php://output'); 
        if($isEmail == true){ 
         $filename1 = 'Oriantation_Status_Report_'.$dateC.'.xlsx';             
         $writer->save(REPORT.$filename1);
        }elseif($isEmail == false) {
          exit();
        }
      
    }
    public function XportToCSV3($data =array(),$headT=array())
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);     

        $sheet->setCellValue('A1', $headT[4]);
        $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                $i++; 
                if(chr($i) == 'E') {break;}
             }
            }

        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A3');    
        $sheet->getStyle('A:E')->getAlignment()->setHorizontal('left');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setSheetIndex(0);
        $writer->setPreCalculateFormulas(false);
        //$writer->save(EXPORT_IMG.'ContractorList.csv');
       
        $filename = $headT[4].'.csv';         
        
        header('Content-Type: text/csv');
        
        header("Content-Disposition: attachment; filename=".$filename);             
      
       
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->save('php://output');
        exit();
    }
    public function XportIconReportExcel($data =array(),$headT=array(),$title = null,$totalCount=null)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A4:F4');
        $spreadsheet->getActiveSheet()->getStyle('A5:F5')->applyFromArray(
           array(
            'fill' => array(
              'type' => Fill::FILL_SOLID,
              'color' => array('rgb' => 'E5E4E2' )
            ),
            'font'  => array(
              'bold'  =>  true
            )
           )
         );
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $dateC = date("d-M-Y");
        $spreadsheet->getActiveSheet()->getStyle('A5:F5')->applyFromArray($styleArray);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
        
        $sheet->setCellValue('A1', $title);       
      
        $sheet->setCellValue('A2', 'Exported On:- '.$dateC);
        $sheet->setCellValue('A3', 'No. of Records Exported:- '.$totalCount);
        $sheet->setCellValue('A4', 'Icon Change Report ');
        $spreadsheet->getActiveSheet()->setAutoFilter('C5:E5');
        
        $i=65;      
        if($i <= 72)
        {
         foreach ($headT as $key => $value) {  
            $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'5',$value);
            $i++; 
          if(chr($i) == 'G') break;
         }
        }       
        
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A6'); 
        $writer = new Xlsx($spreadsheet); 
       
        $title = str_replace(" ","_",mb_strimwidth($title,0, 13)); 
        
        $filename = $title.'_Icon_Change.xlsx';
        $spreadsheet->getActiveSheet()->setTitle($filename);
        //$file_url = DOWNLOAD_PQF.$filename;
        //$writer->save(DOWNLOAD_PQF.$headT[7].' '.$dateC.'.xlsx');
        ob_end_clean();
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
        header("Content-Disposition: attachment; filename=".$filename);
        // header("Cache-Control: max-age=0");
        // header('Cache-Control: no-cache');
        $writer->save('php://output'); 
       
        exit();
        
      
    }
    public function XportIconReportCSV($data =array(),$headT=array(),$title=null,$totalCount=null)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);     
        $dateC = date("d-M-Y");
        $sheet->setCellValue('A1', 'Client Name:- '.$title);      
        $sheet->setCellValue('A2', 'Exported On:- '.$dateC);
        $sheet->setCellValue('A3', 'No. of Records Exported:- '.$totalCount);
        $i=65;      
            if($i <= 75)
            {
             foreach ($headT as $key => $value) {  
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'4',$value);
                $i++; 
                if(chr($i) == 'G') {break;}
             }
            }

        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A6');    
        $sheet->getStyle('A:F')->getAlignment()->setHorizontal('left');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setSheetIndex(0);
        $writer->setPreCalculateFormulas(false);
        //$writer->save(EXPORT_IMG.'ContractorList.csv');
        $title = str_replace(" ","_",mb_strimwidth($title,0, 13));
        $filename = $title.'_Icon_Change.csv';       
        
        header('Content-Type: text/csv');
        
        header("Content-Disposition: attachment; filename=".$filename);             
      
       
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->save('php://output');
        exit();
    }

/*Generic function to export to excel*/
    public function XportAsExcel($data =array(),$headT=array(),$extras = null)
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /*$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);

        $spreadsheet->getActiveSheet()->getStyle('G6:G8')
            ->getAlignment()->setWrapText(true);*/

        /*add logo*/
        if(!empty($extras['client_logo']) && file_exists($this->webroot.'img/client-logos/'.$extras['client_logo'])){
            $spreadsheet->getActiveSheet()->mergeCells('B2:B4');
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setPath($this->webroot.'img/client-logos/'.$extras['client_logo']); /* put your path and image here */
            $drawing->setWidthAndHeight(300,150);
            $drawing->setResizeProportional(true);
            $drawing->setCoordinates('B2');
            $drawing->getShadow()->setVisible(true);
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
        }
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
                'fill' => [
                    'type' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E5E4E2' )
                ],
                'font'  => [
                    'bold'  =>  true
                ]
            ],
        ];
        $lastColumn = (65 + count($headT)) - 1;
        $spreadsheet->getActiveSheet()->getStyle('A6:'.chr($lastColumn).'6')->applyFromArray($styleArray);

        $sheet->setCellValue('A2', 'Client Name:- '.$extras['client_name']);
        $sheet->setCellValue('A3', 'Total Records:- '.count($data));
        $dateC = date("M-d-Y");
        $sheet->setCellValue('A4', 'Date Downloaded:- '.$dateC);

        $spreadsheet->getActiveSheet()->setAutoFilter('A6:'.chr($lastColumn).'6');
        $i=65;
            foreach ($headT as $key => $value) {
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'6',$value);
                $i++;
            }
        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A7');
        $writer = new Xlsx($spreadsheet);

        if(!empty($extras['file_name'])){
            $filename = $extras['file_name'].'.xlsx';
        }else{
            $filename = 'export'.'.xlsx';
        }

        $title = (isset($extras['title'])) ? $extras['title'] : 'Downloaded';
        $spreadsheet->getActiveSheet()->setTitle($title);

        ob_end_clean();
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
        header("Content-Disposition: attachment; filename=".$filename);
        $writer->save('php://output');
        exit();
    }

    public function XportAsCSV($data =array(),$headT=array(), $extras = array())
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);

            $i=65;

                foreach ($headT as $key => $value) {
                    $spreadsheet->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue(chr($i).'2',$value);
                    $i++;
                }


        $spreadsheet->getActiveSheet()->fromArray($data,NULL,'A3');
        $sheet->getStyle('A:K')->getAlignment()->setHorizontal('left');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->setSheetIndex(0);
        $writer->setPreCalculateFormulas(false);
        //$writer->save(EXPORT_IMG.'ContractorList.csv');
        if(!empty($extras['file_name'])){
            $filename = $extras['file_name'].'.csv';
        }else{
            $filename = 'export'.'.csv';
        }

        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=".$filename);

        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->save('php://output');
        exit();
    }

}
?>

