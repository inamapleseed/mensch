<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsCustomer extends Ec_Report_Abstract {
	public function index() {
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/customer_report.tpl';
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

		$this->load->model('ecadvancedreports/customer');

		$this->setModel( $this->model_ecadvancedreports_customer );
		
		$this->document->setTitle($this->language->get('heading_title_customer_report'));

		$this->document->addStyle('view/stylesheet/ecadvancedreports.css');
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

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = 20;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
						
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}		

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['range_date'])) {
			$url .= '&range_date=' . $this->request->get['range_date'];
		}

		if (isset($this->request->get['store_id'])) {
			$url .= '&store_id=' . $this->request->get['store_id'];
		}
								
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
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
			'text'      => $this->language->get('heading_title_customer_report'),
			'href'      => $this->url->link('ecadvancedreports/customer', 'token=' . $this->session->data['token'].$url, 'SSL'),
			'separator' => ' :: '
		);

		

		$this->_data['reports'] = array();

		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
 			'filter_store_id'		 => $store_id,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end,
			'limit'	 			     => $limit,
			'all'					 => $all_records
		);

		$report_total = $this->getModel()->getTotalCustomerReport($data);

		$results = $this->getModel()->getCustomerReport($data);
		
		$sum_subtotal = 0;
		$sum_orders = 0;
		$sum_tax = 0.00;
		$sum_shipping = 0.00;
		$sum_total = 0.00;
		$sum_discount = 0.00;

		if($results) {
			foreach($results as $key => $result) {
				$sum_subtotal += (float)$result['subtotal'];
				$sum_orders += (int)$result['number_order'];
				$sum_tax += (float)$result['tax'];
				$sum_shipping += (float)$result['shipping'];
				$sum_total += (float)$result['total'];
				$sum_discount += (float)$result['discount'];

				$tmp_tax = (isset($result['tax']) && $result['tax'])?$result['tax']:0;
				$tmp_shipping = isset($result['shipping'])?$result['shipping']:0;
				$tmp_discount = isset($result['discount'])?$result['discount']:0;

				$results[$key]['customer_url'] = $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'], 'SSL');
				$results[$key]['subtotal2'] = $this->currency->format($result['subtotal'], $this->config->get('config_currency'));
				$results[$key]['total2'] = $this->currency->format($result['total'], $this->config->get('config_currency'));
				$results[$key]['tax2'] = $this->currency->format($tmp_tax, $this->config->get('config_currency'));
				$results[$key]['shipping2'] = $this->currency->format($tmp_shipping, $this->config->get('config_currency'));
				$results[$key]['discount2'] = $this->currency->format($tmp_discount, $this->config->get('config_currency'));
			}
		}

		$this->_reports = $results;

		$this->_data['reports'] = $results;
		$this->_data['sum_orders'] = $sum_orders;
		$this->_data['sum_subtotal'] = $sum_subtotal;
		$this->_data['sum_tax'] = $sum_tax;
		$this->_data['sum_total'] = $sum_total;
		$this->_data['sum_shipping'] = $sum_shipping;
		$this->_data['sum_discount'] = $sum_discount;

		$this->_data['sum_total_with_currency'] = $this->currency->format($sum_total, $this->config->get('config_currency'));
		$this->_data['sum_subtotal_with_currency'] = $this->currency->format($sum_subtotal, $this->config->get('config_currency'));
		$this->_data['sum_tax_with_currency'] = $this->currency->format($sum_tax, $this->config->get('config_currency'));
		$this->_data['sum_shipping_with_currency'] = $this->currency->format($sum_shipping, $this->config->get('config_currency'));
		$this->_data['sum_discount_with_currency'] = $this->currency->format($sum_discount, $this->config->get('config_currency'));
		
		$this->_data['heading_title'] = $this->language->get('heading_title_customer_report');

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


		$this->_data['entry_number_items'] = $this->language->get('entry_number_items');
		$this->_data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->_data['column_number'] = $this->language->get('column_number');
		$this->_data['column_company'] = $this->language->get('column_customer_company');
		$this->_data['column_percent'] = $this->language->get('column_percent');
		$this->_data['column_quantity'] = $this->language->get('column_quantity');
		$this->_data['column_total'] = $this->language->get('column_total');
		$this->_data['column_email'] = $this->language->get('column_email');
		$this->_data['column_discounts'] = $this->language->get('column_discounts');
		$this->_data['column_number_orders'] = $this->language->get('column_number_orders');
		$this->_data['column_total_orders'] = $this->language->get('column_total_orders');
		$this->_data['column_subtotal'] = $this->language->get('column_subtotal');
		$this->_data['column_customer_name'] = $this->language->get('column_customer_name');
		$this->_data['column_customer_firstname'] = $this->language->get('column_customer_firstname');
		$this->_data['column_customer_lastname'] = $this->language->get('column_customer_lastname');
		$this->_data['column_shipping'] = $this->language->get('column_shipping');
		$this->_data['column_tax_amount'] = $this->language->get('column_tax_amount');
		$this->_data['column_shipping_city'] = $this->language->get('column_shipping_city');
		$this->_data['column_shipping_postcode'] = $this->language->get('column_shipping_postcode');
		$this->_data['column_action'] = $this->language->get('column_action');


		$this->_data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->_data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->_data['entry_range'] = $this->language->get('entry_range');

		$this->_data['button_filter'] = $this->language->get('button_filter');
		$this->_data['button_export'] = $this->language->get('button_export');

		$this->_data['token'] = $this->session->data['token'];

		$this->_data['key_list'] = array("number_orders" => $this->language->get('column_total_orders'),
										"subtotal" => $this->language->get('column_subtotal'));

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

		$url = '';

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}		

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['range_date'])) {
			$url .= '&range_date=' . $this->request->get['range_date'];
		}

		if (isset($this->request->get['store_id'])) {
			$url .= '&store_id=' . $this->request->get['store_id'];
		}
								
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$pagination = new Pagination();
		$pagination->total = $report_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ecadvancedreports/customer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->_data['pagination'] = $pagination->render();

		$this->load->model('setting/store');

		$this->_data['stores'] = $this->model_setting_store->getStores();

		$this->load->model('localisation/order_status');
		
		$this->_data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$this->_data['filter_order_status_id'] = $filter_order_status_id;
		$this->_data['filter_date_start'] = $filter_date_start;
		$this->_data['filter_date_end'] = $filter_date_end;
		$this->_data['limit'] = $limit;
		$this->_data['page'] = $page;
	}
	public function export() {
		
		$export_all = $this->config->get('ecadvancedreports_export_all');

		$this->initLoad($export_all);

		$export_type = $this->request->get["export_type"];
		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/
			$this->_data['export'] = 'html';
			$data = $this->_data;
			
			$this->template = 'module/ecadvancedreports/customer_report.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;


			$this->_export_content_html = $this->load->view($this->template, $data);
			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'customer_report';
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
				unset($val['customer_url']);
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