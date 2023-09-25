<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsSaleReport extends Ec_Report_Abstract { 

	public function index() {   
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/sale_report.tpl';
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
		$this->load->model('sale/order');

		$this->setModel( $this->model_ecadvancedreports_sale );

		$this->document->setTitle($this->language->get('heading_title_sales_report'));

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

		if (isset($this->request->get['range_date'])) {
			$range_date = $this->request->get['range_date'];
		} else {
			$range_date = "this_month";
		}


		if (isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
		} else {
			$store_id = 0;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = "";
		}

		if (isset($this->request->get['filter_customer_name'])) {
			$filter_customer_name = $this->request->get['filter_customer_name'];
		} else {
			$filter_customer_name = "";
		}

		if (isset($this->request->get['filter_customer_email'])) {
			$filter_customer_email = $this->request->get['filter_customer_email'];
		} else {
			$filter_customer_email = "";
		}

		if (isset($this->request->get['filter_customer_company'])) {
			$filter_customer_company = $this->request->get['filter_customer_company'];
		} else {
			$filter_customer_company = "";
		}

		if (isset($this->request->get['filter_country'])) {
			$filter_country = $this->request->get['filter_country'];
		} else {
			$filter_country = "";
		}

		if (isset($this->request->get['filter_region'])) {
			$filter_region = $this->request->get['filter_region'];
		} else {
			$filter_region = "";
		}

		if (isset($this->request->get['filter_city'])) {
			$filter_city = $this->request->get['filter_city'];
		} else {
			$filter_city = "";
		}

		if (isset($this->request->get['filter_zipcode'])) {
			$filter_zipcode = $this->request->get['filter_zipcode'];
		} else {
			$filter_zipcode = "";
		}

		if (isset($this->request->get['filter_product_name'])) {
			$filter_product_name = $this->request->get['filter_product_name'];
		} else {
			$filter_product_name = "";
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$filter_manufacturer = $this->request->get['filter_manufacturer'];
		} else {
			$filter_manufacturer = "";
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
			'text'      => $this->language->get('heading_title_sales_report'),
			'href'      => $this->url->link('ecadvancedreports/sale_report', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->_data['reports'] = array();
		
		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
 			'filter_store_id'		 => $store_id,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end,
			'filter_model'			 => $filter_model,
			'filter_customer_name'	 => $filter_customer_name,
			'filter_customer_email'	 => $filter_customer_email,
			'filter_customer_company'	 => $filter_customer_company,
			'filter_country'		 => $filter_country,
			'filter_region'			 => $filter_region,
			'filter_city'			 => $filter_city,
			'filter_zipcode'		 => $filter_zipcode,
			'filter_product_name'	 => $filter_product_name,
			'filter_manufacturer'	 => $filter_manufacturer
		);

		$results = $this->queryReports( $data );

		$sum_quantity = 0;
		$sum_quantity_refunded = 0;
		$sum_reward = 0;
		$sum_subtotal = 0.00;
		$sum_tax = 0.00;
		$sum_price = 0.00;
		$sum_original_price = 0.00;
		$sum_total = 0.00;
		$sum_total_include_tax = 0.00;
		$sum_refunded = 0.00;

		$tmp_results = array();

		if($results) {
			foreach($results as $key => $result) {
				if($result) {
					$sum_quantity += (int)$result['quantity'];
					$sum_reward += (int)$result['reward'];
					$sum_quantity_refunded += (int)$result['refunded_quantity'];
					$sum_subtotal += (float)$result['subtotal'];
					$sum_tax += (float)$result['tax'];
					$sum_price += (float)$result['price'];
					$sum_original_price += (float)$result['original_price'];
					$sum_total += (float)$result['total'];
					$sum_total_include_tax += (float)$result['total'] + (float)$result['tax'];
					$sum_refunded += (float)$result['refunded'];

					$tmp_subtotal = $tmp_tax = $tmp_original_price = $tmp_price = $tmp_total = $tmp_refunded = 0;
					$tmp_subtotal = isset($result['subtotal'])?$result['subtotal']:0;
					$tmp_tax = (isset($result['tax']) && $result['tax'])?$result['tax']:0;
					$tmp_original_price = isset($result['original_price'])?$result['original_price']:0;
					$tmp_price = isset($result['price'])?$result['price']:0;
					$tmp_total = isset($result['total'])?$result['total']:0;
					$tmp_total_include_tax = isset($result['total_include_tax'])?$result['total_include_tax']:0;
					$tmp_refunded = isset($result['refunded'])?$result['refunded']:0;

					$results[$key]['total2'] = $this->currency->format($tmp_total, $this->config->get('config_currency'));
					$results[$key]['total_include_tax2'] = $this->currency->format($tmp_total_include_tax, $this->config->get('config_currency'));
					$results[$key]['tax2'] = $this->currency->format($tmp_tax, $this->config->get('config_currency'));
					$results[$key]['subtotal2'] = $this->currency->format($tmp_subtotal, $this->config->get('config_currency'));
					$results[$key]['price2'] = $this->currency->format($tmp_price, $this->config->get('config_currency'));
					$results[$key]['original_price2'] = $this->currency->format($tmp_original_price, $this->config->get('config_currency'));
					$results[$key]['refunded2'] = $this->currency->format($tmp_refunded, $this->config->get('config_currency'));
					$results[$key]['product_link'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], 'SSL');
					$results[$key]['order_link'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL');

					$results[$key]['option']     = $this->model_sale_order->getOrderOptions($result['order_id'], $result['order_product_id']);

					$results[$key]['customer_link'] = $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token']."&customer_id=".$result['customer_id'], 'SSL');

					$tmp_results[] = $results[$key];
				}
				
			}
		}

		$this->_reports = $tmp_results;

		$this->_data['reports'] = $tmp_results;
		$this->_data['sum_quantity'] = $sum_quantity;
		$this->_data['sum_quantity_refunded'] = $sum_quantity_refunded;
		$this->_data['sum_tax'] = $sum_tax;
		$this->_data['sum_reward'] = $sum_reward;
		$this->_data['sum_subtotal'] = $sum_subtotal;
		$this->_data['sum_price'] = $sum_price;
		$this->_data['sum_original_price'] = $sum_original_price;
		$this->_data['sum_total'] = $sum_total;
		$this->_data['sum_refunded'] = $sum_refunded;
		$this->_data['sum_total_with_currency'] = $this->currency->format($sum_total, $this->config->get('config_currency'));
		$this->_data['sum_total_tax_with_currency'] = $this->currency->format($sum_total_include_tax, $this->config->get('config_currency'));
		$this->_data['sum_subtotal_with_currency'] = $this->currency->format($sum_subtotal, $this->config->get('config_currency'));
		$this->_data['sum_tax_with_currency'] = $this->currency->format($sum_tax, $this->config->get('config_currency'));
		$this->_data['sum_price_with_currency'] = $this->currency->format($sum_price, $this->config->get('config_currency'));
		$this->_data['sum_original_price_with_currency'] = $this->currency->format($sum_original_price, $this->config->get('config_currency'));
		$this->_data['sum_refunded_with_currency'] = $this->currency->format($sum_refunded, $this->config->get('config_currency'));

		$this->_data['heading_title'] = $this->language->get('heading_title_sales_report');

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
		$this->_data['text_view'] = $this->language->get('text_view');

		
		$this->_data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->_data['column_order_id'] = $this->language->get('column_order_id');
		$this->_data['column_order_date'] = $this->language->get('column_order_date');
		$this->_data['column_model'] = $this->language->get('column_model');
		$this->_data['column_customer_name'] = $this->language->get('column_customer_name');
		$this->_data['column_customer_email'] = $this->language->get('column_customer_email');
		$this->_data['column_customer_company'] = $this->language->get('column_customer_company');
		$this->_data['column_tax'] = $this->language->get('column_tax');
		$this->_data['column_reward'] = $this->language->get('column_reward');
		$this->_data['column_country'] = $this->language->get('column_country');
		$this->_data['column_invoice_no'] = $this->language->get('column_invoice_no');
		$this->_data['column_refunded'] = $this->language->get('column_refunded');
		$this->_data['column_total'] = $this->language->get('column_total');
		$this->_data['column_region'] = $this->language->get('column_region');
		$this->_data['column_city'] = $this->language->get('column_city');
		$this->_data['column_zipcode'] = $this->language->get('column_zipcode');
		$this->_data['column_product_name'] = $this->language->get('column_product_name');
		$this->_data['column_manufacturer'] = $this->language->get('column_manufacturer');
		$this->_data['column_qty_ordered'] = $this->language->get('column_qty_ordered');
		$this->_data['column_qty_refunded'] = $this->language->get('column_qty_refunded');
		$this->_data['column_price'] = $this->language->get('column_price');
		$this->_data['column_original_price'] = $this->language->get('column_original_price');
		$this->_data['column_subtotal'] = $this->language->get('column_subtotal');
		$this->_data['column_tax'] = $this->language->get('column_tax');
		$this->_data['column_total_include_tax'] = $this->language->get('column_total_include_tax');
		$this->_data['column_view_order'] = $this->language->get('column_view_order');
		$this->_data['column_view_product'] = $this->language->get('column_view_product');

		$this->_data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->_data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->_data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->_data['entry_range'] = $this->language->get('entry_range');
		$this->_data['entry_show_by'] = $this->language->get('entry_show_by');
		$this->_data['detail_key'] = $this->language->get('detail_key');

		$this->_data['button_filter'] = $this->language->get('button_filter');
		$this->_data['button_export'] = $this->language->get('button_export');


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
		$this->_data['filter_model'] = $filter_model;
		$this->_data['filter_customer_name'] = $filter_customer_name;
		$this->_data['filter_customer_email'] = $filter_customer_email;
		$this->_data['filter_customer_company'] = $filter_customer_company;
		$this->_data['filter_country'] = $filter_country;
		$this->_data['filter_region'] = $filter_region;
		$this->_data['filter_city'] = $filter_city;
		$this->_data['filter_zipcode'] = $filter_zipcode;
		$this->_data['filter_product_name'] = $filter_product_name;
		$this->_data['filter_manufacturer'] = $filter_manufacturer;
	}

	public function export() {
		
		$this->initLoad();

		$export_type = $this->request->get["export_type"];
		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/
			$this->_data['export'] = 'html';
			$data = $this->_data;

			$this->template = 'module/ecadvancedreports/sale_report.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;

			$this->_export_content_html = $this->load->view($this->template, $data);
			
			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'sale_report';
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
				unset($val['order_product_id']);
				unset($val['product_link']);
				unset($val['order_link']);
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
		
		return $this->getModel()->getSaleReport($data);
	}
}
?>