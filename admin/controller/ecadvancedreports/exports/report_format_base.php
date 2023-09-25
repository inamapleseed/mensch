<?php

abstract class ReportFormatBase {
	public static function display($report, $requests=array()) {

	}
	
	public static function prepareReport($report, $requests=array()) {
		//$report = new Report($report,$macros,$environment);

		return $report;
	}

	public static function getPageHtml( $url = "", $export_type = "html" ) {
		// Open the file using the HTTP headers set above
		$file = file_get_contents($url."&export=".$export_type);
		return $file;
	}
}