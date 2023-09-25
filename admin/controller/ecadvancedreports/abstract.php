<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog Product Abstract Block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
abstract class Ec_Report_Abstract extends Controller
{
    /**
     * Price block array
     *
     * @var array
     */
    protected $_model = null;
    protected $_reports = null;
    protected $_export_content_html = null;
    var $_data = array();

    public function getBaseUrl() {
    	if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
	        $base = HTTPS_SERVER;
	    } else {
	        $base = HTTP_SERVER;
	    }
	    return $base;
    }
    public function getReportData() {
    	return $this->_reports;
    }

    public function setModel($_model = null) {
    	$this->_model = $_model;
    }
    public function getModel() {
    	return $this->_model;
    }
    public function exportReport( $report = array(), $requests = array(), $type = "csv") {
    	$method = "export".ucfirst($type);

		if( method_exists( $this, $method ) ){
			return $this->{$method}( $report, $requests );
		}
    }
    public function exportCsv( $report = array(), $requests = array() ) {
    	require_once(DIR_APPLICATION."controller/ecadvancedreports/exports/csv_export.php");
    	$requests['content_html'] = $this->_export_content_html;
    	CsvExport::display( $report, $requests );
	}

	public function exportXml( $report = array(), $requests = array() ) {
		require_once(DIR_APPLICATION."controller/ecadvancedreports/exports/xml_export.php");
		$requests['content_html'] = $this->_export_content_html;
		XmlExport::display( $report, $requests );
	}

	public function exportPdf( $report = array(), $requests = array() ) {
		$setting = $this->config->get('ecadvancedreports_general');
		$report['paper'] = isset($setting['paper'])?$setting['paper']:'letter';
		$report['orientation'] = isset($setting['orientation'])?$setting['orientation']:'p';/*p:portrait, l: lancapse*/

		$requests['memory_limit'] = isset($setting['memory_limit'])?$setting['memory_limit']:'64';
		$requests['content_html'] = $this->_export_content_html;
		require_once(DIR_APPLICATION."controller/ecadvancedreports/exports/pdf_export.php");
		PdfExport::display( $report, $requests );
	}

	public function exportHtml( $report = array(), $requests = array() ) {
		require_once(DIR_APPLICATION."controller/ecadvancedreports/exports/html_export.php");
		$requests['content_html'] = $this->_export_content_html;
		HtmlExport::display( $report, $requests );
	}

	protected function initLoad() {
		
	}

	protected function queryReports( $data ){
		
		return $this->getModel()->getReport($data);
	}
	protected function getReports2($data = array(), $report_period = "month") {
		$results = array();
		switch ($report_period) {
			case 'day':
				$data['filter_date_start'] = isset($data['filter_date_start'])?$data['filter_date_start']:date('Y-01-01');
				$data['filter_date_end'] = isset($data['filter_date_end'])?$data['filter_date_end']:date('Y-12-31');

				$days = $this->get_day_in_range($data['filter_date_start'], $data['filter_date_end']);

				$reports = $this->queryReports($data);

				foreach($days as $key=>$val) {
						$data['filter_date_start'] = $val['start'];
						$data['filter_date_end'] = $val['end'];
						$results[$key] = array();
				}

				if($reports) {
					foreach($reports as $key=>$val) {
						if(isset($val['datefield'])) {
							$date_time = strtotime($val['datefield']);
							$tmp_day = date('M d, Y', $date_time);

							if(isset($results[$tmp_day])) {
								$results[$tmp_day] = $val;
							}
						}
						
					}
				}

				break;
			case 'month':
				$data['filter_date_start'] = isset($data['filter_date_start'])?$data['filter_date_start']:date('Y-01-01');
				$data['filter_date_end'] = isset($data['filter_date_end'])?$data['filter_date_end']:date('Y-12-31');

				$months = $this->get_months_in_range($data['filter_date_start'], $data['filter_date_end']);

				$reports = $this->queryReports($data);
				
				foreach($months as $key=>$val) {
						$data['filter_date_start'] = $val['start'];
						$data['filter_date_end'] = $val['end'];
						$results[$key] = array();
				}

				if($reports) {
					foreach($reports as $key=>$val) {

						if(isset($results[$val['datefield']])) {
							$results[$val['datefield']] = $val;
						} else if (isset($results["0".$val['datefield']])) {
							$results["0".$val['datefield']] = $val;
						}
						
					}
				}

				break;
			case 'week':
				$data['filter_date_start'] = isset($data['filter_date_start'])?$data['filter_date_start']:date('Y-01-01');
				$data['filter_date_end'] = isset($data['filter_date_end'])?$data['filter_date_end']:date('Y-12-31');

				$weeks = $this->get_week_in_range($data['filter_date_start'], $data['filter_date_end']);

				$reports = $this->queryReports($data);

				foreach($weeks as $key=>$val) {
					$tmp_k = date('M d, Y', strtotime($val['start'])) ." - ".date('M d, Y', strtotime($val['end']));
					$results[$tmp_k] = array();
				}

				if($reports) {
					foreach($reports as $key=>$val) {
						$val['datefield'] = (int)$val['datefield'] + 1;
						$date_range = $this->getWeekRange( $val['datefield'] );
						if(count($date_range) == 2) {
							if(strtotime($date_range[0]) < strtotime($data['filter_date_start'])) {
								$date_range[0] = date("Y-m-d", strtotime($data['filter_date_start']));
							}

							if(strtotime($date_range[1]) > strtotime($data['filter_date_end'])) {
								$date_range[1] = date("Y-m-d", strtotime($data['filter_date_end']));
							}
							$tmp_k = date('M d, Y', strtotime($date_range[0])) ." - ".date('M d, Y', strtotime($date_range[1]));
							if(isset($results[$tmp_k])) {
								$results[$tmp_k] = $val;
							}
						}
					}
				}

				break;
			case 'quarter':
				$data['filter_date_start'] = isset($data['filter_date_start'])?$data['filter_date_start']:date('Y-01-01');
				$data['filter_date_end'] = isset($data['filter_date_end'])?$data['filter_date_end']:date('Y-12-31');

				$months = $this->get_quarter_in_range($data['filter_date_start'], $data['filter_date_end']);

				$reports = $this->queryReports($data);
				
				foreach($months as $key=>$val) {
						$data['filter_date_start'] = $val['start'];
						$data['filter_date_end'] = $val['end'];
						$results[$key] = array();
				}

				if($reports) {
					foreach($reports as $key=>$val) {
						if(isset($results["Q".$val['datefield']])) {
							$results["Q".$val['datefield']] = $val;
						}
						
					}
				}

				break;
			case 'year':
				$data['filter_date_start'] = isset($data['filter_date_start'])?$data['filter_date_start']:date('Y-01-01');
				$data['filter_date_end'] = isset($data['filter_date_end'])?$data['filter_date_end']:date('Y-12-31');

				$months = $this->get_year_in_range($data['filter_date_start'], $data['filter_date_end']);

				$reports = $this->queryReports($data);
				
				foreach($months as $key=>$val) {
						$data['filter_date_start'] = $val['start'];
						$data['filter_date_end'] = $val['end'];
						$results[$key] = array();
				}

				if($reports) {
					foreach($reports as $key=>$val) {
						if(isset($results[$val['datefield']])) {
							$results[$val['datefield']] = $val;
						}
						
					}
				}

				break;
		}
		return $results;
	}

	protected function getWeekRange($week, $dateFormat= "Y-m-d")
	{
		$year = substr($week,0,4);
	    $week = substr($week,4,2);

	   	if((int)$week < 10) {
	   		$week = "0".(int)$week;
	   	}
	   	if($week == "01") {
	   		$previous_year = (int)$year - 1;
	   		
	   	}
	    $from = date($dateFormat, strtotime("{$year}-W{$week}-0")); //Returns the date of monday in week
	    $to = date($dateFormat, strtotime("{$year}-W{$week}-6"));   //Returns the date of sunday in week
	 
	    return array($from, $to);
	}

	protected function get_months_in_range($start, $end) {
		$start = $month = strtotime($start);
		$end = strtotime($end);
		$result = array();
		while($month <= $end)
		{
			 $tmp = array();
			 $tmp_date = date('m/Y', $month);
			 $tmp_date_array = explode("/", $tmp_date);
			 $tmp["start"] = date('Y-m-d', mktime(0, 0, 0, $tmp_date_array[0], 1, $tmp_date_array[1]));
			 $tmp["end"] = date('Y-m-t', mktime(0, 0, 0, $tmp_date_array[0], 1, $tmp_date_array[1]));

			 $end_time = strtotime($tmp['end']);
			
			 if($end_time > $end) {
			 	$tmp["end"] = date('Y-m-d', $end);
			 }
		     $result[ $tmp_date ] = $tmp;
		     $month = strtotime("+1 month", $month);
		}

		return $result;
	}

	protected function get_week_in_range($start, $end) {
		$start_year = date("Y", strtotime($start));
		$end_year = date("Y", strtotime($end));

		$start_week_number = date("W", strtotime($start));
		$end_week_number = date("W", strtotime($end));
		$start_week_number = $start_week_number;
		$end_week_number = $end_week_number;

		$result = array();

		$tmp = array();
		$first_week = $this->getWeekRange($start_year.$start_week_number);

		$tmp['start'] = date('Y-m-d', strtotime( $start ) );
		$tmp['end'] = date('Y-m-d', strtotime($first_week[1]) );

		$result[ $tmp["start"]." - ".$tmp["end"] ] = $tmp ;
		if((int)$end_year > (int)$start_year) {

			for($k = (int)$start_year; $k <= (int)$end_year; $k++) {

				if($k == (int)$end_year) {
					$tmp_week_number = (int)$end_week_number;
				} else {
					$tmp_week_number = date("W", mktime(0,0,0,12,28,$k));
				}
				if($start_week_number == 53 ) {
					$start_week_number = 1;
				} elseif( $start_week_number == 52 && $tmp_week_number < 52) {
					$start_week_number = 1;
					$first_week = $this->getWeekRange($k.$start_week_number);
					$tmp = array();
					$tmp['start'] = date('Y-m-d', strtotime($first_week[0]) );
					$tmp['end'] = date('Y-m-d', strtotime($first_week[1]) );
					$result[ $tmp["start"]." - ".$tmp["end"] ] = $tmp ;
				}

				for($j = $start_week_number + 1; $j <= (int)$tmp_week_number; $j ++) {
					$tmp = array();
					$first_week = $this->getWeekRange($k.$j);
					$tmp['start'] = date('Y-m-d', strtotime($first_week[0]) );
					$tmp['end'] = date('Y-m-d', strtotime($first_week[1]) );

					$result[ $tmp["start"]." - ".$tmp["end"] ] = $tmp ;
				}

				$start_week_number = date("W", mktime(0,0,0,12,29,$k));
				
				
			}
		} else {
			for($i = (int)$start_week_number + 1; $i <= (int)$end_week_number ; $i++ ) {

				$first_week = $this->getWeekRange($end_year.$i);
				$tmp['start'] = date('Y-m-d', strtotime($first_week[0]) );

				if($i == $end_week_number) { 
					if(strtotime($end) > strtotime($first_week[1])) {
						$tmp['end'] = date('Y-m-d', strtotime($first_week[1]) );
					} else {
						$tmp['end'] = date('Y-m-d', strtotime($end) );
					}
				} else {
					$tmp['end'] = date('Y-m-d', strtotime($first_week[1]) );
				}
				$result[ $tmp["start"]." - ".$tmp["end"] ] = $tmp ;
			}
		}

		$tmp = array();
		$end_week_number = (int)$end_week_number + 1;
		$end_week = $this->getWeekRange($end_year.$end_week_number);
		if(strtotime($end_week[0]) <= strtotime($end)) {
			$tmp['start'] = date('Y-m-d', strtotime($end_week[0]) );
			$tmp['end'] = date('Y-m-d', strtotime($end) );
			$result[ $tmp["start"]." - ".$tmp["end"] ] = $tmp ;
		}
		

		return $result;
	}
	
	protected function get_quarter_in_range($start, $end) {
		$start = $month = strtotime($start);
		$end = strtotime($end);

		$result = array();
		
		while($month <= $end)
		{
			 $tmp = array();
			 $tmp_month = date('n', $month);
			 $tmp_year = date('Y', $month);

			 $quarter = $this->date_quarter( $tmp_month );
			
			 switch ($quarter) {
			 	case '1':
			 		$tmp["start"] = date('Y-m-d', mktime(0, 0, 0, 1, 1, $tmp_year));
			 		$tmp["end"] = date('Y-m-t', mktime(0, 0, 0, 3, 1, $tmp_year));
			 		break;
			 	
			 	case '2':
			 		$tmp["start"] = date('Y-m-d', mktime(0, 0, 0, 4, 1, $tmp_year));
			 		$tmp["end"] = date('Y-m-t', mktime(0, 0, 0, 6, 1, $tmp_year));
			 		break;
			 	case '3':
			 		$tmp["start"] = date('Y-m-d', mktime(0, 0, 0, 7, 1, $tmp_year));
			 		$tmp["end"] = date('Y-m-t', mktime(0, 0, 0, 9, 1, $tmp_year));
			 		break;
			 	case '4':
			 		$tmp["start"] = date('Y-m-d', mktime(0, 0, 0, 10, 1, $tmp_year));
			 		$tmp["end"] = date('Y-m-t', mktime(0, 0, 0, 12, 1, $tmp_year));
			 		break;
			 }

			 $end_time = strtotime($tmp['end']);
			 $start_time = strtotime($tmp['start']);
			 
			 if($start_time < $start) {
			 	$tmp["start"] = date('Y-m-d', $start);
			 }

			 if($end_time > $end) {
			 	$tmp["end"] = date('Y-m-d', $end);
			 }

			 $text_key_name = $this->language->get("text_quarter_name");
			 $text_key_name = sprintf($text_key_name, $quarter)."/".$tmp_year;
		     $result[ $text_key_name ] = $tmp;

		     $month = strtotime("+1 month", $month);
		}

		return $result;
	}
	protected function get_export_types(){

		return array("csv" => $this->language->get('text_csv'),
										"xml" => $this->language->get('text_xml'),
										"html" => $this->language->get('text_html'),
										"pdf" => $this->language->get('text_pdf')
										);

	}
	protected function get_day_in_range($start, $end) {
		$start = $day = strtotime($start);
		$end = strtotime($end);
		$result = array();
		while($day <= $end)
		{
			 $tmp = array();
			 $tmp['start'] = date('Y-m-d', $day )." 00:00:00";
			 $tmp['end'] = date('Y-m-d', $day )." 23:59:59";

			 $end_time = strtotime($tmp['end']);
			 $start_time = strtotime($tmp['start']);
			 
			 if($start_time < $start) {
			 	$tmp["start"] = date('Y-m-d H:i:s', $start);
			 }

			 if($end_time > $end) {
			 	$tmp["end"] = date('Y-m-d H:i:s', $end);
			 }
			 $key = date('M d, Y', $day);

		     $result[ $key ] = $tmp;
		     $day = strtotime("+1 day", $day);
		}

		return $result;
	}

	protected function get_year_in_range($start, $end) {
		$start = $day = strtotime($start);
		$end = strtotime($end);
		$result = array();
		$year1 = date('Y', $start);
		$year2 = date('Y', $end);
		$years = range($year1, $year2);
		foreach($years as $year)
		{
			$tmp = array();
			$tmp['start'] = date('Y-m-d', mktime(0,0,0,1,1,$year) );
			$tmp['end'] = date('Y-m-d', mktime(0,0,0,1,0,$year+1) );

			$end_time = strtotime($tmp['end']);
			$start_time = strtotime($tmp['start']);
			 
			 if($start_time < $start) {
			 	$tmp["start"] = date('Y-m-d', $start);
			 }

			 if($end_time > $end) {
			 	$tmp["end"] = date('Y-m-d', $end);
			 }

			$result[ $year ] = $tmp;
		}
		

		return $result;
	}

	protected function date_quarter( $month )
	{
	    if ($month <= 3) return 1;
	    if ($month <= 6) return 2;
	    if ($month <= 9) return 3;

	    return 4;
	}

	protected function encodeURI($url) {
	    // http://php.net/manual/en/function.rawurlencode.php
	    // https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/encodeURI
	    $unescaped = array(
	        '%2D'=>'-','%5F'=>'_','%2E'=>'.','%21'=>'!', '%7E'=>'~',
	        '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'
	    );
	    $reserved = array(
	        '%3B'=>';','%2C'=>',','%2F'=>'/','%3F'=>'?','%3A'=>':',
	        '%40'=>'@','%26'=>'&','%3D'=>'=','%2B'=>'+','%24'=>'$'
	    );
	    $score = array(
	        '%23'=>'#'
	    );
	    return strtr(rawurlencode($url), array_merge($reserved,$unescaped,$score));

	}
	protected function loadMenu(){
		/*Menu*/
		$data = array();
		$data['base_url'] = $this->getBaseUrl();
		$data['text_sales_by_customer_company'] = $this->language->get("text_sales_by_customer_company");
		$data['text_sales_by_customer_group'] = $this->language->get("text_sales_by_customer_group");
		$data['text_report_sale_order'] = $this->language->get("text_report_sale_order");
		$data['text_sales_by_product'] = $this->language->get("text_sales_by_product");
		$data['text_advanced'] = $this->language->get("text_advanced");
		$data['text_report_sale_tax'] = $this->language->get("text_report_sale_tax");
		$data['text_report_sale_shipping'] = $this->language->get("text_report_sale_shipping");
		$data['text_report_sale_return'] = $this->language->get("text_report_sale_return");
		$data['text_report_sale_coupon'] = $this->language->get("text_report_sale_coupon");
		$data['text_product'] = $this->language->get("text_product");
		$data['text_report_product_viewed'] = $this->language->get("text_report_product_viewed");
		$data['text_report_product_purchased'] = $this->language->get("text_report_product_purchased");
		$data['text_customer'] = $this->language->get("text_customer");
		$data['text_report_customer_online'] = $this->language->get("text_report_customer_online");
		$data['text_report_customer_order'] = $this->language->get("text_report_customer_order");
		$data['text_report_customer_reward'] = $this->language->get("text_report_customer_reward");
		$data['text_report_customer_credit'] = $this->language->get("text_report_customer_credit");
		$data['text_report_affiliate_commission'] = $this->language->get("text_report_affiliate_commission");
		$data['text_affiliate'] = $this->language->get("text_affiliate");
		$data['text_report_sale_product_per_country'] = $this->language->get("text_report_sale_product_per_country");
		$data['text_report_sale_by_country'] = $this->language->get("text_report_sale_by_country");
		$data['text_report_customer_by_city'] = $this->language->get("heading_title_customer_city");
		$data['text_report_customer_by_country'] = $this->language->get("heading_title_customer_country");
		$data['text_report_sale_by_hour'] = $this->language->get("text_report_sale_by_hour");
		$data['text_report_sale_by_day_of_week'] = $this->language->get("text_report_sale_by_day_of_week");
		$data['text_report_sale_by_product'] = $this->language->get("text_report_sale_by_product");
		$data['text_report_sale_by_manufacturer'] = $this->language->get("text_report_sale_by_manufacturer");
		$data['text_report_sale_statistic'] = $this->language->get("text_report_sale_statistic");
		$data['text_report_sale_by_coupon_code'] = $this->language->get("text_report_sale_by_coupon_code");
		$data['text_report_sale_by_payment_type'] = $this->language->get("text_report_sale_by_payment_type");
		$data['text_report_sale_by_zip_code'] = $this->language->get("text_report_sale_by_zip_code");
		$data['text_report_sale_by_state'] = $this->language->get("text_report_sale_by_state");
		$data['text_report_sale_report'] = $this->language->get("text_report_sale_report");
		$data['text_report_product_bestseller'] = $this->language->get("text_report_product_bestseller");
		$data['text_report_sale_category'] = $this->language->get("text_report_sale_category");
		$data['text_report_sale_by_profit'] = $this->language->get("text_report_sale_by_profit");
		$data['text_report_product_profit'] = $this->language->get("text_report_product_profit");
		$data['text_report_user_activity'] = $this->language->get("text_report_user_activity");
		$data['text_report_customer_purchase'] = $this->language->get("text_report_customer_purchase");
		$data['text_report_product'] = $this->language->get("text_report_product");
		$data['text_report_top_customer'] = $this->language->get("text_report_top_customer");
		$data['text_report_product_inventory'] = $this->language->get("text_report_product_inventory");
		$data['text_report_product_notsold'] = $this->language->get("text_report_product_notsold");
		$data['text_report_customer'] = $this->language->get("text_report_customer");
		$data['text_report_customer_notorder'] = $this->language->get("text_report_customer_notorder");
		$data['text_earnings'] = $this->language->get("text_earnings");
		$data['text_product_list'] = $this->language->get("text_product_list");
		$data['text_order'] = $this->language->get("text_order");
		$data['text_report_order'] = $this->language->get("text_report_order");

		$data['link_to_module'] = $this->url->link('module/ecadvancedreports', 'token=' . $this->session->data['token'], 'SSL');

		/*Links to report pages*/
		$data['link_to_sales_by_customer_company'] = $this->url->link('ecadvancedreports/customer_company', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_to_sales_by_customer_group'] = $this->url->link('ecadvancedreports/customer_group', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_to_sales_by_product'] = $this->url->link('ecadvancedreports/product', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_bestseller'] = $this->url->link('ecadvancedreports/product_bestseller', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_by_country'] = $this->url->link('ecadvancedreports/sale_country', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_product_per_country'] = $this->url->link('ecadvancedreports/sale_product_country', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_coupon'] = $this->url->link('ecadvancedreports/sale_coupon', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_statistic'] = $this->url->link('ecadvancedreports/sale_statistics', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_zip_code'] = $this->url->link('ecadvancedreports/sale_zipcode', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_state'] = $this->url->link('ecadvancedreports/sale_state', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_payment_type'] = $this->url->link('ecadvancedreports/sale_payment', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_customer_by_city'] = $this->url->link('ecadvancedreports/customer_city', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_customer_by_country'] = $this->url->link('ecadvancedreports/customer_country', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_order'] = $this->url->link('ecadvancedreports/sale_order', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_earnings'] = $this->url->link('ecadvancedreports/earnings', 'current=1&token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_by_manufacturer'] = $this->url->link('ecadvancedreports/sale_manufacturer', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_by_category'] = $this->url->link('ecadvancedreports/category', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_by_hour'] = $this->url->link('ecadvancedreports/sale_hour', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_by_day_week'] = $this->url->link('ecadvancedreports/sale_day_week', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_to_sales_by_profit'] = $this->url->link('ecadvancedreports/sale_profit', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_customer_purchase'] = $this->url->link('ecadvancedreports/customer_purchase', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_sale_report'] = $this->url->link('ecadvancedreports/sale_report', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_user_activity'] = $this->url->link('ecadvancedreports/user_activity', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_product'] = $this->url->link('ecadvancedreports/report_product', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_top_customer'] = $this->url->link('ecadvancedreports/top_customer', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_customer'] = $this->url->link('ecadvancedreports/customer', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_customer_notorder'] = $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_product_inventory'] = $this->url->link('ecadvancedreports/product_inventory', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_product_notsold'] = $this->url->link('ecadvancedreports/product_notsold', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_product_list'] = $this->url->link('ecadvancedreports/product_list', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_report_order'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'], 'SSL');

		/*Links to report pages*/
		return $data;
	}
}

