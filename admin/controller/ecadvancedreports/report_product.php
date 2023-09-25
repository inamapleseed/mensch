<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsReportProduct extends Ec_Report_Abstract {
	var $_data = array();
	public function index() {
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/report_product.tpl';
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

		$this->load->model('ecadvancedreports/product');
		$this->load->model('ecadvancedreports/sale');

		$this->setModel( $this->model_ecadvancedreports_product );

		$this->document->setTitle($this->language->get('heading_title_report_product'));

		$this->document->addStyle('view/stylesheet/ecadvancedreports.css');
		$this->document->addScript('https://www.google.com/jsapi');
		$this->document->addStyle('view/javascript/ecadvancedreports/multilselect/multiple-select.css');
		$this->document->addScript('view/javascript/ecadvancedreports/multilselect/jquery.multiple.select.js');
		$this->document->addScript('view/javascript/ecadvancedreports/bootstrap-hover-dropdown.min.js');
		
		$this->_data = $this->loadMenu();

		$limit = $this->config->get('ecadvancedreports_limit');

		$limit = $limit?$limit:$this->config->get('config_limit_admin');

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

		if (isset($this->request->get['include_tax'])) {
			$include_tax = $this->request->get['include_tax'];
		} else {
			$include_tax = 1;
		}

		if (isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
		} else {
			$store_id = 0;
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

		$this->_current_url = $this->url->link('ecadvancedreports/report_product', 'token=' . $this->session->data['token'].$url, 'SSL');

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
			'text'      => $this->language->get('heading_title_report_product'),
			'href'      => $this->url->link('ecadvancedreports/report_product', 'token=' . $this->session->data['token'].$url, 'SSL'),
			'separator' => ' :: '
		);

		$first_order_date = $this->getModel()->getFirstOrderPlacedDate();
        
        $up_to_date_days_diff = 0;
        if($first_order_date){
            $up_to_date_days_diff = round((strtotime("now") - strtotime($first_order_date)) / (60 * 60 * 24));    
        }

		$last_day_of_previous_month = date("Y-m-d", strtotime("last day of previous month"));
		$first_day_of_previous_month = date("Y-m-d", strtotime("first day of previous month"));
		$first_day_of_past_3_months = date("Y-m-d", strtotime("-2 months", strtotime($first_day_of_previous_month)));
		$first_day_of_past_2_months = date("Y-m-d", strtotime("-1 months", strtotime($first_day_of_previous_month)));

		$this->_data['reports'] = array();
		
		$data_sales = array(
			'filter_order_status_id' => $filter_order_status_id,
 			'filter_store_id'		 => $store_id,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_reload_key' 	 => 'qty',
			'report_period'			 => 'day',
			'detail_key'			 => '1'
		);

		$sales = $this->model_ecadvancedreports_sale->getOrderReport($data_sales);

		$sum_orders = 0;
		$sum_items_ordered = 0;
		$sum_subtotal = 0.00;
		$sum_total = 0.00;

		foreach($sales as $sale){
			$sum_orders += (int)$sale['number_orders'];
			$sum_items_ordered += (int)$sale['items_ordered'];
			$sum_total += (float)$sale['total'];
		}

		$this->_data['sales_sum_orders'] = $sum_orders;
		$this->_data['sales_sum_items_ordered'] = $sum_items_ordered;
		$this->_data['sales_sum_total'] = $this->currency->format($sum_total, $this->config->get('config_currency'));

		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
 			'filter_store_id'		 => $store_id,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end,
			'include_tax'			 => $include_tax,
			'start'                  => ($page - 1) * $limit,
			'limit'                  => $limit,
			'all'		=> $all_records
		);

		$report_total = $this->getModel()->getTotalReportProduct($data);

		$results = $this->getModel()->getReportProduct( $data );

		$sum_total = 0;
		$sum_qty = 0;
		$sum_order = 0;
		$sum_reward = 0;
		$sum_tax= 0;
		$sum_predictive = 0;
		$sum_predictive2 = 0;
		$sum_predictive3 = 0;

		if($results) {
			foreach($results as $key => $result) {
				$results[$key]['predictive_qty_month1'] = 0;
				$results[$key]['predictive_qty_month2'] = 0;
				$results[$key]['predictive_qty_month3'] = 0;
				$product_view = $this->getModel()->getProductViews( $result['product_id'] );
				$product_view_per_month = ($product_view/$up_to_date_days_diff)*30;
				$product_view_ratio = $product_view_per_month*0.35;

				$filter_individual_product = array(
					'filter_order_status_id' => $filter_order_status_id,
		 			'filter_store_id'		 => $store_id,
					'filter_date_start'	     => $first_day_of_past_3_months, 
					'filter_date_end'	     => $last_day_of_previous_month,
					'include_tax'			 => $include_tax,
					'start'                  => ($page - 1) * $limit,
					'limit'                  => $limit,
					'all'					 => $all_records,
					'product_id'			 => $result['product_id'],
				);

				$individual_report = $this->getModel()->getIndividualReportProduct( $filter_individual_product );

				if(!empty($individual_report['quantity'])){
					$individual_product_ratio = ($individual_report['quantity']/3)*0.65;
				}

				if(!empty($product_view_ratio) && !empty($individual_product_ratio)){
					$results[$key]['predictive_qty_month1'] = (int)($product_view_ratio + $individual_product_ratio);
				}

				$sum_predictive += $results[$key]['predictive_qty_month1'];

				$filter_individual_product = array(
					'filter_order_status_id' => $filter_order_status_id,
		 			'filter_store_id'		 => $store_id,
					'filter_date_start'	     => $first_day_of_past_2_months, 
					'filter_date_end'	     => $last_day_of_previous_month,
					'include_tax'			 => $include_tax,
					'start'                  => ($page - 1) * $limit,
					'limit'                  => $limit,
					'all'					 => $all_records,
					'product_id'			 => $result['product_id'],
				);

				$individual_report2 = $this->getModel()->getIndividualReportProduct( $filter_individual_product );
				
				if(!empty($individual_report2['quantity'])){
					$individual_product_ratio2 = (($individual_report2['quantity']+$results[$key]['predictive_qty_month1'])/3)*0.65;
				}

				if(!empty($product_view_ratio) && !empty($individual_product_ratio2)){
					$results[$key]['predictive_qty_month2'] = (int)($product_view_ratio + $individual_product_ratio2);
				}

				$sum_predictive2 += $results[$key]['predictive_qty_month2'];

				$filter_individual_product = array(
					'filter_order_status_id' => $filter_order_status_id,
		 			'filter_store_id'		 => $store_id,
					'filter_date_start'	     => $first_day_of_previous_month, 
					'filter_date_end'	     => $last_day_of_previous_month,
					'include_tax'			 => $include_tax,
					'start'                  => ($page - 1) * $limit,
					'limit'                  => $limit,
					'all'					 => $all_records,
					'product_id'			 => $result['product_id'],
				);

				$individual_report3 = $this->getModel()->getIndividualReportProduct( $filter_individual_product );
				
				if(!empty($individual_report3['quantity'])){
					$individual_product_ratio3 = (($individual_report3['quantity']+$results[$key]['predictive_qty_month1']+$results[$key]['predictive_qty_month2'])/3)*0.65;
				}

				if(!empty($product_view_ratio) && !empty($individual_product_ratio3)){
					$results[$key]['predictive_qty_month3'] = (int)($product_view_ratio + $individual_product_ratio3);
				}

				$sum_predictive3 += $results[$key]['predictive_qty_month3'];
				
				if($result) {
					$sum_total += (float)$result['product_revenue'];
					$sum_qty += (int)$result['quantity'];
					$sum_order += (int)$result['unique_purchases'];
					$sum_reward += (int)$result['reward'];
					$sum_tax += (float)$result['tax'];
				} else {
					$results[$key]['product_revenue'] = 0;
					$results[$key]['quantity'] = 0;
					$results[$key]['unique_purchases'] = 0;
					$results[$key]['reward'] = 0;
					$results[$key]['tax'] = 0;

				}
				$result['product_id'] = isset($result['product_id'])?$result['product_id']:0;
				$result['name'] = isset($result['name'])?$result['name']:"";
				$product_name = $this->encodeURI($result['name']);

				$tax = isset($result['tax'])?$result['tax']:0;
				$product_revenue = isset($result['product_revenue'])?$result['product_revenue']:0;
				$price_avg = isset($result['price_avg'])?$result['price_avg']:0;

				$results[$key]['tax2'] = $this->currency->format($tax, $this->config->get('config_currency'));
				$results[$key]['product_revenue2'] = $this->currency->format($product_revenue, $this->config->get('config_currency'));
				$results[$key]['price_avg2'] = $this->currency->format($price_avg, $this->config->get('config_currency'));
				$results[$key]['link'] = $this->url->link('ecadvancedreports/product', 'product_id='.$result['product_id'].'&product_name='.$product_name.'&token=' . $this->session->data['token'], 'SSL');
			}
		}

		$this->_reports = $results;
		$this->_data['reports'] = $results;

		$this->_data['sum_total'] = $sum_total;
		$this->_data['sum_qty'] = $sum_qty;
		$this->_data['sum_order'] = $sum_order;
		$this->_data['sum_tax'] = $sum_tax;
		$this->_data['sum_reward'] = $sum_reward;
		$this->_data['sum_predictive'] = $sum_predictive;
		$this->_data['sum_predictive2'] = $sum_predictive2;
		$this->_data['sum_predictive3'] = $sum_predictive3;
		$this->_data['sum_tax_with_currency'] = $this->currency->format($sum_tax, $this->config->get('config_currency'));
		$this->_data['sum_total_with_currency'] = $this->currency->format($sum_total, $this->config->get('config_currency'));

		$this->_data['heading_title'] = $this->language->get('heading_title_report_product');

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
		$this->_data['text_no_purchases'] = $this->language->get('text_no_purchases');


		
		$this->_data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->_data['column_percent'] = $this->language->get('column_percent');
		$this->_data['column_quantity'] = $this->language->get('column_quantity');
		$this->_data['column_quantity_sold'] = $this->language->get('column_quantity_sold');
		$this->_data['column_total'] = $this->language->get('column_total');
		$this->_data['column_cost'] = $this->language->get('column_cost');
		$this->_data['column_unique_purchases'] = $this->language->get('column_unique_purchases');
		$this->_data['column_product_model'] = $this->language->get('column_product_model');
		$this->_data['column_product_name'] = $this->language->get('column_product_name');
		$this->_data['column_product_revenue'] = $this->language->get('column_product_revenue');
		$this->_data['column_reward'] = $this->language->get('column_reward');
		$this->_data['column_tax'] = $this->language->get('column_tax');
		$this->_data['column_avg_qty'] = $this->language->get('column_avg_qty');
		$this->_data['column_avg_price'] = $this->language->get('column_avg_price');
		$this->_data['column_optimal_price'] = $this->language->get('column_optimal_price');
		$this->_data['column_avg_reward'] = $this->language->get('column_avg_reward');

		$first_day_date = date("Y-m-01");
		$this->_data['column_next_month'] = 'Forecasted Demand on '.date('m/Y', strtotime('+1 month' , strtotime ($first_day_date)));
		$this->_data['column_next_2month'] = 'Forecasted Demand on '.date('m/Y', strtotime('+2 month' , strtotime ($first_day_date)));
		$this->_data['column_next_3month'] = 'Forecasted Demand on '.date('m/Y', strtotime('+3 month' , strtotime ($first_day_date)));

		$this->_data['entry_include_tax'] = $this->language->get('entry_include_tax');
		$this->_data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->_data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->_data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->_data['entry_range'] = $this->language->get('entry_range');
		$this->_data['entry_show_by'] = $this->language->get('entry_show_by');
		$this->_data['detail_key'] = $this->language->get('detail_key');

		$this->_data['button_filter'] = $this->language->get('button_filter');
		$this->_data['button_export'] = $this->language->get('button_export');

		$this->_data['token'] = $this->session->data['token'];


		$this->_data['include_taxs'] = array("1" => $this->language->get('text_included'),
											"0" => $this->language->get('text_excluded')
										);


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

		$pagination = new Pagination();
		$pagination->total = $report_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ecadvancedreports/report_product', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->_data['pagination'] = $pagination->render();

		$this->load->model('setting/store');

		$this->_data['stores'] = $this->model_setting_store->getStores();

		$this->load->model('localisation/order_status');
		
		$this->_data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$this->_data['filter_order_status_id'] = $filter_order_status_id;
		$this->_data['filter_date_start'] = $filter_date_start;
		$this->_data['filter_date_end'] = $filter_date_end;		
		$this->_data['include_tax'] = $include_tax;
		$this->_data['page'] = $page;
	}
	public function export() {
		
		$export_all = $this->config->get('ecadvancedreports_export_all');

		$this->initLoad($export_all);
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$export_type = $this->request->get["export_type"];
		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/

			$this->_data['export'] = 'html';
			$data = $this->_data;

			$this->template = 'module/ecadvancedreports/report_product.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;

			$this->_export_content_html = $this->load->view($this->template, $data);

			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'report_product_page_'.$page;
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
				unset($val['link']);
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