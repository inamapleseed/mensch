<?php

require_once(DIR_APPLICATION."controller/ecadvancedreports/exports/report_format_base.php");

class CsvExport extends ReportFormatBase {
	public static function display($report, $requests=array()) {
		//always use cache for CSV reports
		
		$file_name = preg_replace(array('/[\s]+/','/[^0-9a-zA-Z\-_\.]/'),array('_',''),$report['name']);

		// disable caching
	    $now = gmdate("D, d M Y H:i:s");
	    header("Pragma: no-cache");
		header("Expires: 0");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download  
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");

	    // disposition / encoding on response body
	    header("Content-Disposition: attachment;filename={$file_name}.csv");
	    header("Content-Transfer-Encoding: binary");
		
		$data = "";
		if(isset($report['data']) && $report['data']) {
			$tmp = array();
			foreach($report['data'] as $key=>$item) {
				if(!empty($item)) {
					$tmp[] = $item;
				}
			}
			$report['data'] = $tmp;
			$data = self::array2csv( $report['data'] );
		}
		
		if(trim($data)) echo $data;
	}

	public static function array2csv(array &$array)
	{
	   if (count($array) == 0) {
	     return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   fputcsv($df, array_keys(reset($array)));
	   foreach ($array as $row) {
	      if(count($row)) {
	   			fputcsv($df, $row);
	   		}
	   }
	   fclose($df);
	   return ob_get_clean();
	}
}
