<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsSaleStatistics extends Ec_Report_Abstract {
	public function index() {   
		
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/sale_statistics.tpl';
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

		$this->document->setTitle($this->language->get('heading_title_sales_statistics'));

		$this->document->addStyle('view/stylesheet/ecadvancedreports.css');
		$this->document->addScript('https://www.google.com/jsapi');
		$this->document->addStyle('view/javascript/ecadvancedreports/multilselect/multiple-select.css');
		$this->document->addScript('view/javascript/ecadvancedreports/multilselect/jquery.multiple.select.js');
		$this->document->addScript('view/javascript/ecadvancedreports/bootstrap-hover-dropdown.min.js');
		
		$this->_data = $this->loadMenu();

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date("Y-m-d");
		}

		if (isset($this->request->get['filter_reload_key'])) {
			$filter_reload_key = $this->request->get['filter_reload_key'];
		} else {
			$filter_reload_key = "qty";
		}

		if (isset($this->request->get['range_date'])) {
			$range_date = $this->request->get['range_date'];
		} else {
			$range_date = "this_month";
		}

		if (isset($this->request->get['report_period'])) {
			$report_period = $this->request->get['report_period'];
		} else {
			$report_period = "month";
		}

		if (isset($this->request->get['detail_key'])) {
			$detail_key = $this->request->get['detail_key'];
		} else {
			$detail_key = "1";
		}

		if (isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
		} else {
			$store_id = 0;
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
			'text'      => $this->language->get('heading_title_sales_statistics'),
			'href'      => $this->url->link('ecadvancedreports/sale_statistics', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->_data['reports'] = array();
		
		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
 			'filter_store_id'		 => $store_id,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_reload_key' 	 => $filter_reload_key,
			'report_period'			 => $report_period,
			'detail_key'			 => $detail_key
		);

		$results = $this->getReports2( $data, $report_period);

		$sum_orders = 0;
		$sum_items_ordered = 0;
		$sum_subtotal = 0.00;
		$sum_tax = 0.00;
		$sum_shipping = 0.00;
		$sum_discount = 0.00;
		$sum_total = 0.00;
		$sum_refunded = 0.00;
		
		if($results) {
			foreach($results as $key => $result) {
				if($result) {
					$sum_orders += (int)$result['number_orders'];
					$sum_items_ordered += (int)$result['items_ordered'];
					$sum_subtotal += (float)$result['subtotal'];
					$sum_tax += (float)$result['tax'];
					$sum_shipping += (float)$result['shipping'];
					$sum_discount += (float)$result['discount'];
					$sum_total += (float)$result['total'];
					$sum_refunded += (float)$result['refunded'];
					$tmp_subtotal = $tmp_tax = $tmp_shipping = $tmp_discount = $tmp_total = $tmp_refunded = 0;
					$tmp_subtotal = isset($result['subtotal'])?$result['subtotal']:0;
					$tmp_tax = (isset($result['tax']) && $result['tax'])?$result['tax']:0;
					$tmp_shipping = isset($result['shipping'])?$result['shipping']:0;
					$tmp_discount = isset($result['discount'])?$result['discount']:0;
					$tmp_total = isset($result['total'])?$result['total']:0;
					$tmp_refunded = isset($result['refunded'])?$result['refunded']:0;
					$total_avg = isset($result['total_avg'])?$result['total_avg']:0;
					$product_total_avg = isset($result['product_total_avg'])?$result['product_total_avg']:0;

					$results[$key]['datefield'] = $key;
					$results[$key]['total_avg'] = $total_avg;
					$results[$key]['tax'] = $tmp_tax;
					$results[$key]['total2'] = $this->currency->format($tmp_total, $this->config->get('config_currency'));
					$results[$key]['total_avg2'] = $this->currency->format($total_avg, $this->config->get('config_currency'));
					$results[$key]['product_total_avg2'] = $this->currency->format($product_total_avg, $this->config->get('config_currency'));
					$results[$key]['tax2'] = $this->currency->format($tmp_tax, $this->config->get('config_currency'));
					$results[$key]['subtotal2'] = $this->currency->format($tmp_subtotal, $this->config->get('config_currency'));
					$results[$key]['shipping2'] = $this->currency->format($tmp_shipping, $this->config->get('config_currency'));
					if((float)$tmp_discount < 0) {
						$results[$key]['discount2'] = "-".$this->currency->format(-$tmp_discount, $this->config->get('config_currency'));
					} else {
						$results[$key]['discount2'] = $this->currency->format($tmp_discount, $this->config->get('config_currency'));	
					}
					
					$results[$key]['refunded2'] = $this->currency->format($tmp_refunded, $this->config->get('config_currency'));
				} else {
					unset($results[$key]);
				}

			}
		}

		$this->_reports = $results;

		$this->_data['reports'] = $results;
		$this->_data['sum_items_ordered'] = $sum_items_ordered;
		$this->_data['sum_orders'] = $sum_orders;
		$this->_data['sum_tax'] = $sum_tax;
		$this->_data['sum_shipping'] = $sum_shipping;
		$this->_data['sum_subtotal'] = $sum_subtotal;
		$this->_data['sum_discount'] = $sum_discount;
		$this->_data['sum_total'] = $sum_total;
		$this->_data['sum_refunded'] = $sum_refunded;
		$this->_data['sum_total_with_currency'] = $this->currency->format($sum_total, $this->config->get('config_currency'));
		$this->_data['sum_subtotal_with_currency'] = $this->currency->format($sum_subtotal, $this->config->get('config_currency'));
		$this->_data['sum_tax_with_currency'] = $this->currency->format($sum_tax, $this->config->get('config_currency'));
		$this->_data['sum_shipping_with_currency'] = $this->currency->format($sum_shipping, $this->config->get('config_currency'));
		if((float)$sum_discount < 0) {
			$this->_data['sum_discount_with_currency'] = "-".$this->currency->format(-$sum_discount, $this->config->get('config_currency'));
		} else {
			$this->_data['sum_discount_with_currency'] = $this->currency->format($sum_discount, $this->config->get('config_currency'));
		}
		$this->_data['sum_refunded_with_currency'] = $this->currency->format($sum_refunded, $this->config->get('config_currency'));

		$this->_data['heading_title'] = $this->language->get('heading_title_sales_statistics');

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

		
		$this->_data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->_data['column_percent'] = $this->language->get('column_percent');
		$this->_data['column_number_orders'] = $this->language->get('column_number_orders');
		$this->_data['column_items_ordered'] = $this->language->get('column_items_ordered');
		$this->_data['column_subtotal'] = $this->language->get('column_subtotal');
		$this->_data['column_tax'] = $this->language->get('column_tax');
		$this->_data['column_shipping'] = $this->language->get('column_shipping');
		$this->_data['column_discounts'] = $this->language->get('column_discounts');
		$this->_data['column_refunded'] = $this->language->get('column_refunded');
		$this->_data['column_total'] = $this->language->get('column_total');
		$this->_data['column_period'] = $this->language->get('column_period');
		$this->_data['column_order_amount_avg'] = $this->language->get('column_order_amount_avg');
		$this->_data['column_item_final_price_avg'] = $this->language->get('column_item_final_price_avg');

		$this->_data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->_data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->_data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->_data['entry_range'] = $this->language->get('entry_range');
		$this->_data['entry_show_by'] = $this->language->get('entry_show_by');
		$this->_data['detail_key'] = $this->language->get('detail_key');

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

		$this->_data['detail_key_list'] = array("0" => $this->language->get('text_grouped'),
										"1" => $this->language->get('text_detailed'));

		$this->_data['period_list'] = array("day" => $this->language->get('text_day'),
										"week" => $this->language->get('text_week'),
										"month" => $this->language->get('text_month'),
										"quarter" => $this->language->get('text_quarter'),
										"year" => $this->language->get('text_year'));

		$this->_data['export_types'] = $this->get_export_types();

		$this->_data['range_list'] = array(
											"today" => $this->language->get('text_today'),
											"yesterday" => $this->language->get('text_yesterday'),
											"last_7_days" => $this->language->get('text_last_seven_days'),
											"last_week" => $this->language->get('text_last_week'),
											"last_business_week" => $this->language->get('text_last_business_week'),
											"this_month" => $this->language->get('text_this_month'),
											"last_month" => $this->language->get('text_last_month'),
											"custom" => $this->language->get('text_custom_range')
										);

		$this->_data['store_id'] = $store_id;

		$this->_data['range_date'] = $range_date;

		$this->_data['chart_width'] = $this->config->get('ecadvancedreports_chart_width');
		$this->_data['chart_width'] = $this->_data['chart_width']?$this->_data['chart_width']:300;
		$this->_data['chart_height'] = $this->config->get('ecadvancedreports_chart_height');
		$this->_data['chart_height'] = $this->_data['chart_height']?$this->_data['chart_height']:300;
		$this->_data['chart_color'] = $this->config->get('ecadvancedreports_chart_color');
		$this->_data['chart_color'] = $this->_data['chart_color']?$this->_data['chart_color']:"f39c12";

		$this->load->model('setting/store');

		$this->_data['stores'] = $this->model_setting_store->getStores();

		$this->load->model('localisation/order_status');
		
		$this->_data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$this->_data['filter_order_status_id'] = $filter_order_status_id;
		$this->_data['filter_date_start'] = $filter_date_start;
		$this->_data['filter_date_end'] = $filter_date_end;		
		$this->_data['filter_reload_key'] = $filter_reload_key;
		$this->_data['report_period'] = $report_period;
		$this->_data['detail_key'] = $detail_key;

	}


	public function export() {
		
		$this->initLoad();

		$export_type = $this->request->get["export_type"];
		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/
			$this->_data['export'] = 'html';
			$data = $this->_data;

			$this->template = 'module/ecadvancedreports/sale_statistics.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;

			$this->_export_content_html = $this->load->view($this->template, $data);
			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'sale_statistics';
		$reports['data'] = array();
		$reports['data'] = $this->getReportData();

		if (isset($this->request->get['report_period'])) {
			$report_period = $this->request->get['report_period'];
		} else {
			$report_period = "item_";
		}

		if($reports['data']) {
			$tmp = array();
			$i = 1;
			foreach($reports['data'] as $key=>$val) {
				$tmp[$report_period.$i] = $val;
				$tmp[$report_period.$i]['datefield'] = $key;
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
		
		return $this->getModel()->getSaleStatistics($data);
	}
}
?>