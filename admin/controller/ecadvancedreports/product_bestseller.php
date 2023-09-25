<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsProductBestseller extends Ec_Report_Abstract {
	public function index() {
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/product_bestseller.tpl';
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['language'] = $this->language;

		$this->response->setOutput($this->load->view($this->template, $data));

	}

	public function initLoad($all_records = false) {
		$this->language->load('common/header');

		$this->language->load('report/customer_order');

		$this->language->load('module/ecadvancedreports');

		$this->load->model('catalog/manufacturer');
		$this->load->model("catalog/category");
		$this->load->model('ecadvancedreports/product');

		$this->setModel( $this->model_ecadvancedreports_product );
		
		$this->document->setTitle($this->language->get('heading_title_product_bestseller'));

		$this->document->addStyle('view/stylesheet/ecadvancedreports.css');
		$this->document->addScript('https://www.google.com/jsapi');
		$this->document->addStyle('view/javascript/ecadvancedreports/multilselect/multiple-select.css');
		$this->document->addScript('view/javascript/ecadvancedreports/multilselect/jquery.multiple.select.js');
		$this->document->addScript('view/javascript/ecadvancedreports/bootstrap-hover-dropdown.min.js');

		$this->_data = $this->loadMenu();

		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = 0;
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$filter_manufacturer = $this->request->get['filter_manufacturer'];
		} else {
			$filter_manufacturer = 0;
		}
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

		if (isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
		} else {
			$store_id = 0;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = 10;
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
			'text'      => $this->language->get('heading_title_product_bestseller'),
			'href'      => $this->url->link('ecadvancedreports/product_bestseller', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		

		$this->_data['reports'] = array();

		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
			'filter_category_id'	 => $filter_category_id,
			'filter_manufacturer'	 => $filter_manufacturer,
 			'filter_store_id'		 => $store_id,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end,
			'limit'	 => $limit,
			'all'		=> $all_records
		);

		$results = $this->getModel()->getBestseller($data);
		$sum_total = 0;
		$sum_qty = 0;
		$sum_cost = 0;
		$sum_profits = 0;

		if($results) {
			foreach($results as $key => $result) {
				$sum_total += (float)$result['total'];
				$sum_qty += (int)$result['quantity'];
				$cost = (float)$result['cost']*(int)$result['quantity'];
				$sum_cost += $cost;
				$profits = (float)$result['total'] - $cost;
				$sum_profits += $profits;

				$results[$key]['cost'] = $cost;
				$results[$key]['profits'] = $profits;
				$results[$key]['product_url'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], 'SSL');
				$results[$key]['total2'] = $this->currency->format($result['total'], $this->config->get('config_currency'));
				$results[$key]['cost2'] = $this->currency->format($cost, $this->config->get('config_currency'));
				$results[$key]['profits2'] = $this->currency->format($profits, $this->config->get('config_currency'));
			}
		}

		$this->_reports = $results;

		$this->_data['reports'] = $results;
		$this->_data['sum_total'] = $sum_total;
		$this->_data['sum_qty'] = $sum_qty;
		$this->_data['sum_cost'] = $sum_cost;
		$this->_data['sum_profits'] = $sum_profits;
		$this->_data['sum_total_with_currency'] = $this->currency->format($sum_total, $this->config->get('config_currency'));
		$this->_data['sum_cost_with_currency'] = $this->currency->format($sum_cost, $this->config->get('config_currency'));
		$this->_data['sum_profits_with_currency'] = $this->currency->format($sum_profits, $this->config->get('config_currency'));

		$this->_data['heading_title'] = $this->language->get('heading_title_product_bestseller');

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
		$this->_data['text_category'] = $this->language->get('text_category');
		$this->_data['text_choose_a_category'] = $this->language->get('text_choose_a_category');
		$this->_data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->_data['text_choose_a_manufacturer'] = $this->language->get('text_choose_a_manufacturer');


		$this->_data['entry_number_products'] = $this->language->get('entry_number_products');
		$this->_data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->_data['column_number'] = $this->language->get('column_number');
		$this->_data['column_percent'] = $this->language->get('column_percent');
		$this->_data['column_quantity'] = $this->language->get('column_quantity');
		$this->_data['column_total'] = $this->language->get('column_total');
		$this->_data['column_model'] = $this->language->get('column_model');
		$this->_data['column_product_name'] = $this->language->get('column_product_name');
		$this->_data['column_action'] = $this->language->get('column_action');
		$this->_data['column_cost_total'] = $this->language->get('column_cost_total');
		$this->_data['column_profits'] = $this->language->get('column_profits');


		$this->_data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->_data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->_data['entry_range'] = $this->language->get('entry_range');

		$this->_data['button_filter'] = $this->language->get('button_filter');
		$this->_data['button_export'] = $this->language->get('button_export');

		$this->_data['token'] = $this->session->data['token'];

		$this->_data['key_list'] = array("qty" => $this->language->get('column_quantity'),
										"total" => $this->language->get('column_total'),
										"cost" => $this->language->get('column_cost_total'),
										"profits" => $this->language->get('column_profits'));

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

		$this->_data['categories'] = array();
    	$this->_data['categories'] = $this->model_catalog_category->getCategories(array());
    	$this->_data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(array());
		
		$this->_data['filter_manufacturer'] = $filter_manufacturer;
		$this->_data['filter_category_id'] = $filter_category_id;
		
		$this->_data['filter_order_status_id'] = $filter_order_status_id;
		$this->_data['filter_date_start'] = $filter_date_start;
		$this->_data['filter_date_end'] = $filter_date_end;		
		$this->_data['filter_reload_key'] = $filter_reload_key;
		$this->_data['limit'] = $limit;
	}
	public function export() {
		
		$export_all = $this->config->get('ecadvancedreports_export_all');

		$this->initLoad($export_all);

		$export_type = $this->request->get["export_type"];
		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/
			$this->_data['export'] = 'html';
			$data = $this->_data;

			$this->template = 'module/ecadvancedreports/product_bestseller.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;


			$this->_export_content_html = $this->load->view($this->template, $data);
			
			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'product_bestseller';
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
				unset($val['product_url']);
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

}
?>