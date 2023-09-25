<?php

require_once(DIR_APPLICATION."controller/ecadvancedreports/exports/report_format_base.php");
require_once(DIR_APPLICATION."controller/ecadvancedreports/exports/html_export.php");


class PdfExport extends ReportFormatBase {
	public static function display($report, $requests=array()) {
		//always use cache for CSV reports
		
		$file_name = preg_replace(array('/[\s]+/','/[^0-9a-zA-Z\-_\.]/'),array('_',''),$report['name']);

		$data = "";
		$content_html = isset($requests['content_html'])?$requests['content_html']:"";
		$memory_limit = isset($requests['memory_limit'])?$requests['memory_limit']:"16";
		
		if(isset($report['data']) && $report['data'] && $content_html ) {
			/*Remove empty data item*/
			$tmp = array();
			foreach($report['data'] as $key=>$item) {
				if(!empty($item)) {
					$tmp[] = $item;
				}
			}
			$report['data'] = $tmp;
			/*Remove empty data item*/
			$old_limit = @ini_set("memory_limit", $memory_limit."M");
			if ( get_magic_quotes_gpc() )
		    	$content_html = stripslashes($content_html);
		    
			require_once(DIR_SYSTEM."ecadvancedreports/tcpdf/tcpdf.php"); //include dompdf config
			// create new PDF document
			$pdf = new TCPDF($report["orientation"], "mm", $report["paper"], true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator("Ecomteck");
			$pdf->SetAuthor('Hieptq');
			$pdf->SetTitle('Ecomteck Advanced Reports');
			$pdf->SetSubject('Ecomteck Advanced Reports');
			$pdf->SetKeywords('Ecomteck, Advanced Reports, Opencart' );

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont("courier");

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 25);

			// set image scale factor
			$pdf->setImageScale(1.25);

			// set some language-dependent strings (optional)
			if (@file_exists(DIR_SYSTEM."ecadvancedreports/tcpdf/lang/eng.php")) {
			    require_once(DIR_SYSTEM."ecadvancedreports/tcpdf/lang/eng.php");
			    $pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// add a page
			$pdf->AddPage();

			// print a block of text using Write()
			$pdf->writeHTML($content_html, true, false, true, false, '');

			// reset pointer to the last page
			$pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$pdf->Output($file_name.".pdf", 'D');

		}

		exit(0);
	}
}
