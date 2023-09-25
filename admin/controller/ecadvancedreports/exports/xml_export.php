<?php


require_once(DIR_APPLICATION."controller/ecadvancedreports/exports/report_format_base.php");

class XmlExport extends ReportFormatBase {
	public static function display($report, $requests=array()) {

		$file_name = preg_replace(array('/[\s]+/','/[^0-9a-zA-Z\-_\.]/'),array('_',''),$report['name']);
		
		$now = gmdate("D, d M Y H:i:s");
	    header("Pragma: no-cache");
		header("Expires: 0");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download  
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");
	    header("Content-type: application/xml");

	    // disposition / encoding on response body
	    header("Content-Disposition: attachment;filename={$file_name}.xml");
	    header("Content-Transfer-Encoding: binary");

		$data = "";
		if(isset($report['data']) && $report['data']) {
			$data = self::array2xml( $report['data'] );
			
		}
		
		if(trim($data)) echo $data;
	}

	public static function array2xml($array, $node_name="root") {
	    $dom = new DOMDocument('1.0', 'UTF-8');
	    $dom->formatOutput = true;
	    $root = $dom->createElement($node_name);
	    $dom->appendChild($root);

	    $array2xml = function ($node, $array) use ($dom, &$array2xml) {
	        foreach($array as $key => $value){
	            if ( is_array($value) ) {
	            	if(strpos($key, "item_") === 0){
	            		$key = "item";
	            	}
	            	if(strpos($key, "month_") === 0){
	            		$key = "month";
	            	}
	                $n = $dom->createElement($key);
	                $node->appendChild($n);
	                $array2xml($n, $value);
	            }else{
	                $attr = $dom->createAttribute($key);
	                $attr->value = $value;
	                $node->appendChild($attr);
	            }
	        }
	    };

	    $array2xml($root, $array);

	    return $dom->saveXML();
	}
}
