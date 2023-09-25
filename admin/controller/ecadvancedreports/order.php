<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsOrder extends Ec_Report_Abstract { 

	public function index() {   
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/order.tpl';
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

		$this->document->setTitle($this->language->get('heading_title_order'));

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

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('ecadvancedreports_limit');
			$limit = $limit?$limit:$this->config->get('config_limit_admin');

		}

		$limit = !empty($limit)?$limit: 100;

		$url = '';

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . urlencode(html_entity_decode($this->request->get['filter_order_status_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . urlencode(html_entity_decode($this->request->get['filter_date_start'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['range_date'])) {
			$url .= '&range_date=' . $this->request->get['range_date'];
		}

		if (isset($this->request->get['store_id'])) {
			$url .= '&store_id=' . $this->request->get['store_id'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
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
			'text'      => $this->language->get('heading_title_order'),
			'href'      => $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'].$url, 'SSL'),
			'separator' => ' :: '
		);

		$margin_profit = $this->config->get('ecadvancedreports_margin_profit');
		$margin_profit = $margin_profit?(int)$margin_profit:0;

		$this->_data['reports'] = array();
		
		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
 			'filter_store_id'		 => $store_id,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end,
			'margin_profit'			 => $margin_profit,
			'sort'	 				 => $sort,
			'order'	 				 => $order,
			'start'           		 => ($page - 1) * $limit,
			'limit'	 				 => $limit
		);

		$report_total = $this->getModel()->getTotalOrderSummaryReport($data);
		$results = $this->queryReports( $data );

		$sum_quantity = 0;
		$sum_discount = 0;
		$sum_tax = 0.00;
		$sum_total = 0.00;
		$sum_cost = 0.00;
		$sum_grossprofit = $sum_netprofit = 0.00;
		$tmp_results = array();
		if($results) {
			foreach($results as $key => $result) {
				if($result) {
					$sum_quantity += (int)$result['quantity'];
					$sum_tax += (float)$result['tax'];
					$sum_cost += (float)$result['total_cost'];
					$sum_total += (float)$result['total'];
					$sum_grossprofit += (float)$result['gross_profits'];
					$sum_netprofit += (float)$result['net_profits'];
					$sum_discount += (float)$result['discount'];

					$tmp_netprofit = $tmp_tax = $tmp_grossprofit = $tmp_cost = $tmp_total = $tmp_discount =  0;

					$tmp_netprofit = isset($result['net_profits'])?$result['net_profits']:0;
					$tmp_tax = (isset($result['tax']) && $result['tax'])?$result['tax']:0;
					$sum_grossprofit = isset($result['gross_profits'])?$result['gross_profits']:0;
					$tmp_cost = isset($result['total_cost'])?$result['total_cost']:0;
					$tmp_total = isset($result['total'])?$result['total']:0;
					$tmp_discount = isset($result['discount'])?$result['discount']:0;

					$results[$key]['total2'] = $this->currency->format($tmp_total, $this->config->get('config_currency'));
					$results[$key]['total_net_profits2'] = $this->currency->format($tmp_netprofit, $this->config->get('config_currency'));
					$results[$key]['tax2'] = $this->currency->format($tmp_tax, $this->config->get('config_currency'));
					$results[$key]['gross_profits2'] = $this->currency->format($sum_grossprofit, $this->config->get('config_currency'));
					$results[$key]['total_cost2'] = $this->currency->format($tmp_cost, $this->config->get('config_currency'));
					$results[$key]['discount2'] = $this->currency->format($tmp_discount, $this->config->get('config_currency'));

					$results[$key]['order_link'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL');
					$tmp_results[] = $results[$key];
				}
				
			}
		}

		$this->_reports = $tmp_results;

		$this->_data['reports'] = $tmp_results;
		$this->_data['sum_quantity'] = $sum_quantity;
		$this->_data['sum_tax'] = $sum_tax;
		$this->_data['sum_total'] = $sum_total;
		$this->_data['sum_discount'] = $sum_discount;
		$this->_data['sum_cost'] = $sum_cost;
		$this->_data['sum_grossprofit'] = $sum_grossprofit;
		$this->_data['sum_netprofit'] = $sum_netprofit;

		$this->_data['sum_total_with_currency'] = $this->currency->format($sum_total, $this->config->get('config_currency'));
		$this->_data['sum_cost_with_currency'] = $this->currency->format($sum_cost, $this->config->get('config_currency'));
		$this->_data['sum_tax_with_currency'] = $this->currency->format($sum_tax, $this->config->get('config_currency'));
		$this->_data['sum_discount_with_currency'] = $this->currency->format($sum_discount, $this->config->get('config_currency'));
		$this->_data['sum_grossprofit_with_currency'] = $this->currency->format($sum_grossprofit, $this->config->get('config_currency'));
		$this->_data['sum_netprofit_with_currency'] = $this->currency->format($sum_netprofit, $this->config->get('config_currency'));


		$url = '';

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . urlencode(html_entity_decode($this->request->get['filter_order_status_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . urlencode(html_entity_decode($this->request->get['filter_date_start'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['range_date'])) {
			$url .= '&range_date=' . $this->request->get['range_date'];
		}

		if (isset($this->request->get['store_id'])) {
			$url .= '&store_id=' . $this->request->get['store_id'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->_data['sort_order_id'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$this->_data['sort_date_added'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$this->_data['sort_quantity'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=quantity' . $url, 'SSL');
		$this->_data['sort_total'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$this->_data['sort_status'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=o.status' . $url, 'SSL');
		$this->_data['sort_tax'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=tax' . $url, 'SSL');
		$this->_data['sort_discount'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=discount' . $url, 'SSL');
		$this->_data['sort_cost'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=total_cost' . $url, 'SSL');
		$this->_data['sort_gross_profits'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=gross_profits' . $url, 'SSL');
		$this->_data['sort_net_profits'] = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . '&sort=net_profits' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $report_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('ecadvancedreports/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->_data['pagination'] = $pagination->render();

		$this->_data['results'] = sprintf($this->language->get('text_pagination'), ($report_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($report_total - $limit)) ? $report_total : ((($page - 1) * $limit) + $limit), $report_total, ceil($report_total / $limit));

		$this->_data['heading_title'] = $this->language->get('heading_title_order');

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

		
		$this->_data['column_order_status'] = $this->language->get('column_order_status');
		$this->_data['column_order_id'] = $this->language->get('column_order_id');
		$this->_data['column_order_date'] = $this->language->get('column_order_date');
		$this->_data['column_tax'] = $this->language->get('column_tax');
		$this->_data['column_discount'] = $this->language->get('column_discount');
		$this->_data['column_country'] = $this->language->get('column_country');
		$this->_data['column_invoice_no'] = $this->language->get('column_invoice_no');
		$this->_data['column_refunded'] = $this->language->get('column_refunded');
		$this->_data['column_total'] = $this->language->get('column_total');
		$this->_data['column_total_cost'] = $this->language->get('column_total_cost');
		$this->_data['column_total_gross_profit'] = $this->language->get('column_total_gross_profit');
		$this->_data['column_total_net_profit'] = $this->language->get('column_total_net_profit');
		$this->_data['column_qty_ordered'] = $this->language->get('column_qty_ordered');
		$this->_data['column_qty_refunded'] = $this->language->get('column_qty_refunded');
		$this->_data['column_subtotal'] = $this->language->get('column_subtotal');
		$this->_data['column_tax'] = $this->language->get('column_tax');
		$this->_data['column_view_order'] = $this->language->get('column_view_order');

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

		$this->_data['sort'] = $sort;
		$this->_data['order'] = $order;
	}

	public function export() {
		
		$this->initLoad();

		$export_type = $this->request->get["export_type"];
		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/
			$this->_data['export'] = 'html';
			$data = $this->_data;

			$this->template = 'module/ecadvancedreports/order.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;

			$this->_export_content_html = $this->load->view($this->template, $data);
			
			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'order';
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
		
		return $this->getModel()->getOrderSummaryReport($data);
	}
}
?>