<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsEarnings extends Ec_Report_Abstract {

	var $_data = array();
	public function index() {

		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/earnings.tpl';
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['language'] = $this->language;

		$this->response->setOutput($this->load->view($this->template, $data));
	}

	public function initLoad() {
		$this->language->load('common/header');

		$this->language->load('report/customer_order');

		$this->language->load('module/ecadvancedreports');

		$this->load->model('ecadvancedreports/sale');

		$this->setModel( $this->model_ecadvancedreports_sale );

		$this->document->setTitle($this->language->get('heading_title_earnings'));

		$this->document->addStyle('view/stylesheet/ecadvancedreports.css');
		$this->document->addScript('https://www.google.com/jsapi');

		$this->document->addStyle('view/javascript/ecadvancedreports/multilselect/multiple-select.css');
		$this->document->addScript('view/javascript/ecadvancedreports/multilselect/jquery.multiple.select.js');
		$this->document->addScript('view/javascript/ecadvancedreports/bootstrap-hover-dropdown.min.js');

		$this->_data = $this->loadMenu();

		$filter_year = $filter_month = $filter_day = "";
		$filter_query = "";

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 5;
		}

		if (isset($this->request->get['filter_year'])) {
			$filter_year = $this->request->get['filter_year'];
			$filter_query = "&filter_year=".$filter_year;
		}

		if (isset($this->request->get['filter_month'])) {
			$filter_month = $this->request->get['filter_month'];
			$filter_query .= "&filter_month=".$filter_month;
		}

		if (isset($this->request->get['filter_day'])) {
			$filter_day = $this->request->get['filter_day'];
			$filter_query .= "&filter_day=".$filter_day;
		}

		if (isset($this->request->get['filter_reload_key'])) {
			$filter_reload_key = $this->request->get['filter_reload_key'];
		} else {
			$filter_reload_key = "total";
		}

		$is_current = 0;

		if(isset($this->request->get['current']) && $this->request->get['current']) {
			$filter_year = date("Y");
			$filter_month = date("m");
			$filter_date = "";
			$is_current = $this->request->get['current'];
		}

		if (isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
		} else {
			$store_id = 0;
		}

		$url_supfix = "";

		if($filter_order_status_id) {
			$url_supfix .= "&filter_order_status_id=".$filter_order_status_id;
			$filter_query .= "&filter_order_status_id=".$filter_order_status_id;
		}

		if($store_id) {
			$url_supfix .= "&store_id=".$store_id;
			$filter_query .= "&store_id=".$store_id;
		}
		$this->_data['breadcrumbs'] = array();

		$this->_data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->_data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/ecadvancedreports', 'token=' . $this->session->data['token'] , 'SSL'),
			'separator' => ' :: '
		);

		$this->_data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title_earnings'),
			'href'      => $this->url->link('ecadvancedreports/earnings', 'token=' . $this->session->data['token'].$filter_query, 'SSL'),
			'separator' => ' :: '
		);

		$this->_data['filter_breadcrumbs'] = array();

		$this->_data['filter_breadcrumbs'][] = array(
				'text'      => '<strong>'.$this->language->get('text_sales_reports').'</strong>',
				'separator' => false
			);

		if($filter_year) {
			$this->_data['filter_breadcrumbs'][] = array(
				'text'      => $this->language->get('text_alltime'),
				'href'      => $this->url->link('ecadvancedreports/earnings', 'token=' . $this->session->data['token'].$url_supfix, 'SSL'),
				'separator' => ' / '
			);
		}

		if($filter_month) {
			$this->_data['filter_breadcrumbs'][] = array(
				'text'      => $filter_year,
				'href'      => $this->url->link('ecadvancedreports/earnings', 'token=' . $this->session->data['token'].'&filter_year='.$filter_year.$url_supfix, 'SSL'),
				'separator' => ' / '
			);
		}


		if($filter_day) {
			$this->_data['filter_breadcrumbs'][] = array(
				'text'      => date('F', mktime(0, 0, 0, $filter_month, 10)),
				'href'      => $this->url->link('ecadvancedreports/earnings', 'token=' . $this->session->data['token'].'&filter_year='.$filter_year.'&filter_month='.$filter_month.$url_supfix, 'SSL'),
				'separator' => ' / '
			);
		}


		if(!$filter_year) {
			$this->_data['filter_breadcrumbs'][] = array(
				'text'      => '<strong>'.$this->language->get('text_alltime').'</strong>',
				'separator' => ' / '
			);
		} elseif($filter_year && !$filter_month) {
			$this->_data['filter_breadcrumbs'][] = array(
				'text'      => '<strong>'.$filter_year.'</strong>',
				'separator' => ' / '
			);
		} elseif($filter_year && $filter_month && !$filter_day) {
			$this->_data['filter_breadcrumbs'][] = array(
				'text'      => '<strong>'.date('F', mktime(0, 0, 0, $filter_month, 10)).'</strong>',
				'separator' => ' / '
			);
		} elseif($filter_year && $filter_month && $filter_day) {
			$week_day_name = $this->_getWeekDay($filter_day, $filter_month, $filter_year);
			$this->_data['filter_breadcrumbs'][] = array(
				'text'      => '<strong>'.$week_day_name.", ".date('F', mktime(0, 0, 0, $filter_month, 10))." ".$filter_day.'</strong>',
				'separator' => ' / '
			);
		}

		$this->_data['reports'] = array();
		$this->_data['current_reports'] = $this->getModel()->getCurrentMonthReport($store_id, $filter_order_status_id);
		$this->_data['total_sales'] = $this->getModel()->getTotalSales($store_id, $filter_order_status_id);
		$this->_data['total_earnings_currency'] = "";
		$this->_data['total_earnings_orders'] = "0";

		if($this->_data['current_reports']) {
			$this->_data['total_earnings_currency'] = $this->currency->format($this->_data['current_reports']['subtotal'], $this->config->get('config_currency'));
			$this->_data['total_earnings_orders'] = $this->_data['current_reports']['number_orders'];
		}
		$this->_data['total_sales_currency'] = $this->currency->format((float)$this->_data['total_sales'], $this->config->get('config_currency'));
		
		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
 			'filter_store_id'		 => $store_id,
			'filter_year'	     	 => $filter_year, 
			'filter_month'	     	 => $filter_month,
			'filter_day'	     	 => $filter_day,
			'filter_reload_key' 	 => $filter_reload_key
		);

		$results = $this->getModel()->getEarningsReport($data);

		$sum_orders = 0;
		$sum_items_ordered = 0;
		$sum_subtotal = 0.00;

		if($results) {
			foreach($results as $key => $result) {
				if($result) {
					$sum_orders += (int)$result['number_orders'];
					$sum_items_ordered += (int)$result['items_ordered'];
					$sum_subtotal += (float)$result['subtotal'];
				
					$tmp_subtotal = 0;
					$tmp_subtotal = isset($result['subtotal'])?$result['subtotal']:0;

					$results[$key]['subtotal2'] = $this->currency->format($tmp_subtotal, $this->config->get('config_currency'));
					$results[$key]['datefield'] = $key;
					$results[$key]['action'] = "";
					$results[$key]['date'] = $key;

					if(!$filter_year) {
						$results[$key]['action'] = $this->url->link('ecadvancedreports/earnings', 'token=' . $this->session->data['token'].'&filter_year='.$key.$url_supfix, 'SSL');
					} elseif($filter_year && !$filter_month) {
						$results[$key]['action'] = $this->url->link('ecadvancedreports/earnings', 'token=' . $this->session->data['token'].'&filter_year='.$filter_year.'&filter_month='.$key.$url_supfix, 'SSL');
						$results[$key]['datefield'] = date('F', mktime(0, 0, 0, $key, 10));
					} elseif($filter_year && $filter_month && !$filter_day) {
						$results[$key]['action'] = $this->url->link('ecadvancedreports/earnings', 'token=' . $this->session->data['token'].'&filter_year='.$filter_year.'&filter_month='.$filter_month.'&filter_day='.$key.$url_supfix, 'SSL');

						$results[$key]['datefield'] = date('F', mktime(0, 0, 0, $filter_month, 10)).", ".$key;
					} elseif($filter_year && $filter_month && $filter_day) {
						$start_time = $this->_lz((int)$key-1).":00";
						$end_time = $this->_lz((int)$key+1).":00";
						$results[$key]['datefield'] = $start_time." - ".$end_time;
					}
				}
			}

		}

		$this->_reports = $results;
		$current_month = date("m");
		$this->_data['current_month'] = date('F', mktime(0, 0, 0, $current_month , 10));
		$this->_data['current'] = $is_current;
		$this->_data['filter_year'] = $filter_year;
		$this->_data['filter_month'] = $filter_month;		
		$this->_data['filter_day'] = $filter_day;
		$this->_data['filter_order_status_id'] = $filter_order_status_id;

		$this->_data['chart_width'] = $this->config->get('ecadvancedreports_chart_width');
		$this->_data['chart_width'] = $this->_data['chart_width']?$this->_data['chart_width']:300;
		$this->_data['chart_height'] = $this->config->get('ecadvancedreports_chart_height');
		$this->_data['chart_height'] = $this->_data['chart_height']?$this->_data['chart_height']:300;
		$this->_data['chart_color'] = $this->config->get('ecadvancedreports_chart_color');
		$this->_data['chart_color'] = $this->_data['chart_color']?$this->_data['chart_color']:"f39c12";

		$this->_data['reports'] = $this->getReportData();
		$this->_data['sum_items_ordered'] = $sum_items_ordered;
		$this->_data['sum_orders'] = $sum_orders;
		$this->_data['sum_subtotal_with_currency'] = $this->currency->format($sum_subtotal, $this->config->get('config_currency'));

		$this->_data['heading_title'] = $this->language->get('heading_title_earnings');

		$this->_data['text_no_results'] = $this->language->get('text_no_results');
		$this->_data['text_default'] = $this->language->get('text_default');
		$this->_data['text_range'] = $this->language->get('text_range');
		$this->_data['text_export_to'] = $this->language->get('text_export_to');
		$this->_data['text_filter_store'] = $this->language->get('text_filter_store');
		$this->_data['text_show_report_for'] = $this->language->get('text_show_report_for');
		$this->_data['text_select_one'] = $this->language->get('text_select_one');
		$this->_data['text_order_total'] = $this->language->get('text_order_total');
		$this->_data['text_order_qty'] = $this->language->get('text_order_qty');
		$this->_data['text_total'] = $this->language->get('text_total');
		$this->_data['text_quantity'] = $this->language->get('text_quantity');
		$this->_data['text_no_found_on_period'] = $this->language->get('text_no_found_on_period');
		$this->_data['text_all_status'] = $this->language->get('text_all_status');
		$this->_data['text_sales_earning_this_month'] = $this->language->get('text_sales_earning_this_month');
		$this->_data['text_total_earnings'] = $this->language->get('text_total_earnings');
		$this->_data['text_your_balance'] = $this->language->get('text_your_balance');
		$this->_data['text_total_value_of_item_sales'] = $this->language->get('text_total_value_of_item_sales');
		$this->_data['text_base_on_each_item'] = $this->language->get('text_base_on_each_item');
		$this->_data['text_date'] = $this->language->get("text_date");
		$this->_data['text_sale_earnings'] = $this->language->get("text_sale_earnings");
  
		
		$this->_data['column_date'] = $this->language->get('column_date');
		$this->_data['column_sales_count'] = $this->language->get('column_sales_count');
		$this->_data['column_products_ordered'] = $this->language->get('column_products_ordered');
		$this->_data['column_earnings'] = $this->language->get('column_earnings');
		$this->_data['column_tax'] = $this->language->get('column_tax');
		$this->_data['column_shipping'] = $this->language->get('column_shipping');
		$this->_data['column_discounts'] = $this->language->get('column_discounts');
		$this->_data['column_refunded'] = $this->language->get('column_refunded');
		$this->_data['column_total'] = $this->language->get('column_total');
		$this->_data['column_period'] = $this->language->get('column_period');


		$this->_data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->_data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->_data['entry_range'] = $this->language->get('entry_range');
		$this->_data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->_data['entry_show_by'] = $this->language->get('entry_show_by');
		$this->_data['detail_key'] = $this->language->get('detail_key');

		/*Menu*/
		$this->_data['text_sales_by_customer_group'] = $this->language->get("text_sales_by_customer_group");
		$this->_data['text_report_sale_order'] = $this->language->get("text_report_sale_order");
		$this->_data['text_sales_by_product'] = $this->language->get("text_sales_by_product");
		$this->_data['text_advanced'] = $this->language->get("text_advanced");
		$this->_data['text_report_sale_tax'] = $this->language->get("text_report_sale_tax");
		$this->_data['text_report_sale_shipping'] = $this->language->get("text_report_sale_shipping");
		$this->_data['text_report_sale_return'] = $this->language->get("text_report_sale_return");
		$this->_data['text_report_sale_coupon'] = $this->language->get("text_report_sale_coupon");
		$this->_data['text_product'] = $this->language->get("text_product");
		$this->_data['text_report_product_viewed'] = $this->language->get("text_report_product_viewed");
		$this->_data['text_report_product_purchased'] = $this->language->get("text_report_product_purchased");
		$this->_data['text_customer'] = $this->language->get("text_customer");
		$this->_data['text_report_customer_online'] = $this->language->get("text_report_customer_online");
		$this->_data['text_report_customer_order'] = $this->language->get("text_report_customer_order");
		$this->_data['text_report_customer_reward'] = $this->language->get("text_report_customer_reward");
		$this->_data['text_report_customer_credit'] = $this->language->get("text_report_customer_credit");
		$this->_data['text_report_affiliate_commission'] = $this->language->get("text_report_affiliate_commission");
		$this->_data['text_affiliate'] = $this->language->get("text_affiliate");
		$this->_data['text_report_sale_by_country'] = $this->language->get("text_report_sale_by_country");
		$this->_data['text_report_sale_by_hour'] = $this->language->get("text_report_sale_by_hour");
		$this->_data['text_report_sale_by_day_of_week'] = $this->language->get("text_report_sale_by_day_of_week");
		$this->_data['text_report_sale_by_product'] = $this->language->get("text_report_sale_by_product");
		$this->_data['text_report_sale_by_manufacturer'] = $this->language->get("text_report_sale_by_manufacturer");
		$this->_data['text_report_sale_statistic'] = $this->language->get("text_report_sale_statistic");
		$this->_data['text_report_sale_by_coupon_code'] = $this->language->get("text_report_sale_by_coupon_code");
		$this->_data['text_report_sale_by_payment_type'] = $this->language->get("text_report_sale_by_payment_type");
		$this->_data['text_report_sale_by_zip_code'] = $this->language->get("text_report_sale_by_zip_code");
		$this->_data['text_report_sale_report'] = $this->language->get("text_report_sale_report");
		$this->_data['text_report_product_bestseller'] = $this->language->get("text_report_product_bestseller");

		$this->_data['button_filter'] = $this->language->get('button_filter');
		$this->_data['button_export'] = $this->language->get('button_export');

		switch ($filter_reload_key) {
			case 'total':
				$this->_data['text_subtitle_chart'] = $this->language->get("text_report_type_total");
				$this->_data['text_verticle_title'] = $this->language->get("column_total");
				break;
			case 'subtotal':
				$this->_data['text_subtitle_chart'] = $this->language->get("text_report_type_subtotal");
				$this->_data['text_verticle_title'] = $this->language->get("column_subtotal");
				break;
			case 'qty':
				$this->_data['text_subtitle_chart'] = $this->language->get("text_report_type_number_orders");
				$this->_data['text_verticle_title'] = $this->language->get("column_number_orders");
				break;
			case 'qty_item':
				$this->_data['text_subtitle_chart'] = $this->language->get("text_report_items_ordered");
				$this->_data['text_verticle_title'] = $this->language->get("column_items_ordered");
				break;
		}
		$this->_data['token'] = $this->session->data['token'];

		$this->_data['key_list'] = array("total" => $this->language->get('column_total'),
										"subtotal" => $this->language->get('column_subtotal'),
										"qty" => $this->language->get('column_number_orders'),
										"qty_item" => $this->language->get('column_items_ordered'));

		$this->_data['export_types'] = $this->get_export_types();

		$this->_data['store_id'] = $store_id;


		$this->load->model('setting/store');

		$this->_data['stores'] = $this->model_setting_store->getStores();

		$this->load->model('localisation/order_status');
		
		$this->_data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

	}

	public function export() {
		
		$this->initLoad();

		$export_type = $this->request->get["export_type"];

		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/

			$this->_data['export'] = 'html';
			$data = $this->_data;

			$this->template = 'module/ecadvancedreports/earnings.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;

			$this->_export_content_html = $this->load->view($this->template, $data);

			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'earnings';
		$reports['data'] = array();
		$reports['data'] = $this->getReportData();

		if (isset($this->request->get['report_period'])) {
			$report_period = $this->request->get['report_period'];
		} else {
			$report_period = "month_";
		}

		if($reports['data']) {
			$tmp = array();
			$i = 1;
			foreach($reports['data'] as $key=>$val) {
				unset($val['action']);
				$tmp[$report_period.$i] = $val;
				$i++;
			}
			$reports['data'] = array();
			if($export_type == "xml") {
				$reports['data']['items'] = $tmp;
			} else {
				$reports['data'] = $tmp;
			}
		}
		$this->exportReport( $reports, array(), $export_type );
	}

	protected function queryReports( $data ){
		
		return $this->getModel()->getOrderReport($data);
	}

	protected function _lz($num)
	{
	    return (strlen($num) < 2) ? "0{$num}" : $num;
	}
	protected function _getWeekDay($day,$month,$year){
		return date("l",strtotime($year.'-'.$month.'-'.$day));
	}
}
?>