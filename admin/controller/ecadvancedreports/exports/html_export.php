<?php

require_once(DIR_APPLICATION."controller/ecadvancedreports/exports/report_format_base.php");

class HtmlExport extends ReportFormatBase {
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
	    header("Content-Disposition: attachment;filename={$file_name}.html");
	    header("Content-Transfer-Encoding: binary");
		
		$content_html = isset($requests['content_html'])?$requests['content_html']:"";
		echo $content_html;die();
	}
}
