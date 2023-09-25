<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsSaleZipcode extends Ec_Report_Abstract { 
	public function index() {   
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/sale_zipcode.tpl';
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

		$this->load->model('ecadvancedreports/sale');

		$this->setModel( $this->model_ecadvancedreports_sale );

		$this->document->setTitle($this->language->get('heading_title_sales_zipcode'));

		$this->document->addStyle('view/stylesheet/ecadvancedreports.css');
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
			'text'      => $this->language->get('heading_title_sales_zipcode'),
			'href'      => $this->url->link('ecadvancedreports/sale_zipcode', 'token=' . $this->session->data['token'].$url, 'SSL'),
			'separator' => ' :: '
		);

		$this->_data['reports'] = array();
		
		$data_zipcode = array(
			'filter_order_status_id' => $filter_order_status_id,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end,
			'filter_postal_code'	 => '01,02,03,04,05',
		);

		$district['01'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['01']['total2'] = $this->currency->format($district['01']['total'], $this->config->get('config_currency'));
		$district['01']['postal_sector'] = '01, 02, 03, 04, 05, 06';
		$district['01']['general_location'] = 'Raffles Place, Cecil, Marina, People’s Park';
		$district['01']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '07,08';
		$district['02'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['02']['total2'] = $this->currency->format($district['02']['total'], $this->config->get('config_currency'));
		$district['02']['postal_sector'] = '07, 08';
		$district['02']['general_location'] = 'Anson, Tanjong Pagar';
		$district['02']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '14,15,16';
		$district['03'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['03']['total2'] = $this->currency->format($district['03']['total'], $this->config->get('config_currency'));
		$district['03']['postal_sector'] = '14, 15, 16';
		$district['03']['general_location'] = 'Queenstown, Tiong Bahru';
		$district['03']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '09,10';
		$district['04'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['04']['total2'] = $this->currency->format($district['04']['total'], $this->config->get('config_currency'));
		$district['04']['postal_sector'] = '09, 10';
		$district['04']['general_location'] = 'Telok Blangah, Harbourfront';
		$district['04']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '11,12,13';
		$district['05'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['05']['total2'] = $this->currency->format($district['05']['total'], $this->config->get('config_currency'));
		$district['05']['postal_sector'] = '11, 12, 13';
		$district['05']['general_location'] = 'Pasir Panjang, Hong Leong Garden, Clementi New Town';
		$district['05']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '17';
		$district['06'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['06']['total2'] = $this->currency->format($district['06']['total'], $this->config->get('config_currency'));
		$district['06']['postal_sector'] = '17';
		$district['06']['general_location'] = 'High Street, Beach Road (part)';
		$district['06']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '18,19';
		$district['07'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['07']['total2'] = $this->currency->format($district['07']['total'], $this->config->get('config_currency'));
		$district['07']['postal_sector'] = '18,19';
		$district['07']['general_location'] = 'Middle Road, Golden Mile';
		$district['07']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '20,21';
		$district['08'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['08']['total2'] = $this->currency->format($district['08']['total'], $this->config->get('config_currency'));
		$district['08']['postal_sector'] = '20,21';
		$district['08']['general_location'] = 'Little India';
		$district['08']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '22,23';
		$district['09'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['09']['total2'] = $this->currency->format($district['09']['total'], $this->config->get('config_currency'));
		$district['09']['postal_sector'] = '22, 23';
		$district['09']['general_location'] = 'Orchard, Cairnhill, River Valley';
		$district['09']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '24,25,26,27';
		$district['10'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['10']['total2'] = $this->currency->format($district['10']['total'], $this->config->get('config_currency'));
		$district['10']['postal_sector'] = '24, 25, 26, 27';
		$district['10']['general_location'] = 'Ardmore, Bukit Timah, Holland Road, Tanglin';
		$district['10']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '28,29,30';
		$district['11'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['11']['total2'] = $this->currency->format($district['11']['total'], $this->config->get('config_currency'));
		$district['11']['postal_sector'] = '28, 29, 30';
		$district['11']['general_location'] = 'Watten Estate, Novena, Thomson';
		$district['11']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '31,32,33';
		$district['12'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['12']['total2'] = $this->currency->format($district['12']['total'], $this->config->get('config_currency'));
		$district['12']['postal_sector'] = '31, 32, 33';
		$district['12']['general_location'] = 'Balestier, Toa Payoh, Serangoon';
		$district['12']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '34,35,36,37';
		$district['13'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['13']['total2'] = $this->currency->format($district['13']['total'], $this->config->get('config_currency'));
		$district['13']['postal_sector'] = '34, 35, 36, 37';
		$district['13']['general_location'] = 'Macpherson, Braddell';
		$district['13']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '38,39,40,41';
		$district['14'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['14']['total2'] = $this->currency->format($district['14']['total'], $this->config->get('config_currency'));
		$district['14']['postal_sector'] = '38, 39, 40, 41';
		$district['14']['general_location'] = 'Geylang, Eunos';
		$district['14']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '42,43,44,45';
		$district['15'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['15']['total2'] = $this->currency->format($district['15']['total'], $this->config->get('config_currency'));
		$district['15']['postal_sector'] = '42, 43, 44, 45';
		$district['15']['general_location'] = 'Katong, Joo Chiat, Amber Road';
		$district['15']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '46,47,48';
		$district['16'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['16']['total2'] = $this->currency->format($district['16']['total'], $this->config->get('config_currency'));
		$district['16']['postal_sector'] = '46, 47, 48';
		$district['16']['general_location'] = 'Bedok, Upper East Coast, Eastwood, Kew Drive';
		$district['16']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '49,50,81';
		$district['17'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['17']['total2'] = $this->currency->format($district['17']['total'], $this->config->get('config_currency'));
		$district['17']['postal_sector'] = '49, 50, 81';
		$district['17']['general_location'] = 'Loyang, Changi';
		$district['17']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '51,52';
		$district['18'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['18']['total2'] = $this->currency->format($district['18']['total'], $this->config->get('config_currency'));
		$district['18']['postal_sector'] = '51, 52';
		$district['18']['general_location'] = 'Tampines, Pasir Ris';
		$district['18']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '53,54,55,82';
		$district['19'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['19']['total2'] = $this->currency->format($district['19']['total'], $this->config->get('config_currency'));
		$district['19']['postal_sector'] = '53, 54, 55, 82';
		$district['19']['general_location'] = 'Serangoon Garden, Hougang, Ponggol';
		$district['19']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '56,57';
		$district['20'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['20']['total2'] = $this->currency->format($district['20']['total'], $this->config->get('config_currency'));
		$district['20']['postal_sector'] = '56, 57';
		$district['20']['general_location'] = 'Bishan, Ang Mo Kio';
		$district['20']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '58,59';
		$district['21'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['21']['total2'] = $this->currency->format($district['21']['total'], $this->config->get('config_currency'));
		$district['21']['postal_sector'] = '58, 59';
		$district['21']['general_location'] = 'Upper Bukit Timah, Clementi Park, Ulu Pandan';
		$district['21']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '60,61,62,63,64';
		$district['22'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['22']['total2'] = $this->currency->format($district['22']['total'], $this->config->get('config_currency'));
		$district['22']['postal_sector'] = '60, 61, 62, 63, 64';
		$district['22']['general_location'] = 'Jurong';
		$district['22']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '65,66,67,68';
		$district['23'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['23']['total2'] = $this->currency->format($district['23']['total'], $this->config->get('config_currency'));
		$district['23']['postal_sector'] = '65, 66, 67, 68';
		$district['23']['general_location'] = 'Hillview, Dairy Farm, Bukit Panjang, Choa Chu Kang';
		$district['23']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '69,70,71';
		$district['24'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['24']['total2'] = $this->currency->format($district['24']['total'], $this->config->get('config_currency'));
		$district['24']['postal_sector'] = '69, 70, 71';
		$district['24']['general_location'] = 'Lim Chu Kang, Tengah';
		$district['24']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '72,73';
		$district['25'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['25']['total2'] = $this->currency->format($district['25']['total'], $this->config->get('config_currency'));
		$district['25']['postal_sector'] = '72, 73';
		$district['25']['general_location'] = 'Kranji, Woodgrove, Woodlands';
		$district['25']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '77,78';
		$district['26'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['26']['total2'] = $this->currency->format($district['26']['total'], $this->config->get('config_currency'));
		$district['26']['postal_sector'] = '77, 78';
		$district['26']['general_location'] = 'Upper Thomson, Springleaf';
		$district['26']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '75,76';
		$district['27'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['27']['total2'] = $this->currency->format($district['27']['total'], $this->config->get('config_currency'));
		$district['27']['postal_sector'] = '75, 76';
		$district['27']['general_location'] = 'Yishun, Sembawang';
		$district['27']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );

		$data_zipcode['filter_postal_code'] = '79,80';
		$district['28'] = $this->getModel()->getSaleByZipcodeArea( $data_zipcode );
		$district['28']['total2'] = $this->currency->format($district['28']['total'], $this->config->get('config_currency'));
		$district['28']['postal_sector'] = '79, 80';
		$district['28']['general_location'] = 'Seletar';
		$district['28']['man_power'] = $this->getModel()->getSaleByZipcodeAreaManpower( $data_zipcode );
		
		$this->_data['districts'] = $district;

		$district_sum_order = 0;
		$district_sum_item_ordered = 0;
		$district_sum_total = 0.00;
		foreach($district as $dist){
			$district_sum_order += $dist['number_orders']; 
			$district_sum_item_ordered += $dist['items_ordered'];
			$district_sum_total += $dist['total'];
		}

		$this->_data['district_sum_order'] = $district_sum_order;
		$this->_data['district_sum_item_ordered'] = $district_sum_item_ordered;
		$this->_data['district_sum_total'] = $this->currency->format($district_sum_total, $this->config->get('config_currency'));

		// debug($district);

		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
 			'filter_store_id'		 => $store_id,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end,
			'start'                  => ($page - 1) * $limit,
			'limit'                  => $limit,
			'all'		=> $all_records
		);

		$report_total = $this->getModel()->getTotalSaleZipcode($data);

		$results = $this->queryReports( $data );

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

					$results[$key]['total2'] = $this->currency->format($tmp_total, $this->config->get('config_currency'));
					$results[$key]['tax2'] = $this->currency->format($tmp_tax, $this->config->get('config_currency'));
					$results[$key]['subtotal2'] = $this->currency->format($tmp_subtotal, $this->config->get('config_currency'));
					$results[$key]['shipping2'] = $this->currency->format($tmp_shipping, $this->config->get('config_currency'));
					if((float)$tmp_discount < 0) {
						$results[$key]['discount2'] = "-".$this->currency->format(-$tmp_discount, $this->config->get('config_currency'));
					} else {
						$results[$key]['discount2'] = $this->currency->format($tmp_discount, $this->config->get('config_currency'));	
					}
					
					$results[$key]['refunded2'] = $this->currency->format($tmp_refunded, $this->config->get('config_currency'));
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

		$this->_data['heading_title'] = $this->language->get('heading_title_sales_zipcode');

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
		$this->_data['column_zipcode'] = $this->language->get('column_zipcode');
		$this->_data['column_district'] = $this->language->get('column_district');
		$this->_data['column_postal_sector'] = $this->language->get('column_postal_sector');
		$this->_data['column_general_location'] = $this->language->get('column_general_location');
		$first_day_date = date("Y-m-01");
		$this->_data['column_next_month'] = 'Forecasted Manpower on '.date('m/Y', strtotime('+1 month' , strtotime ($first_day_date)));
		$this->_data['column_next_2month'] = 'Forecasted Manpower on '.date('m/Y', strtotime('+2 month' , strtotime ($first_day_date)));
		$this->_data['column_next_3month'] = 'Forecasted Manpower on '.date('m/Y', strtotime('+3 month' , strtotime ($first_day_date)));

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
		$pagination->url = $this->url->link('ecadvancedreports/sale_zipcode', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->_data['pagination'] = $pagination->render();


		$this->load->model('setting/store');

		$this->_data['stores'] = $this->model_setting_store->getStores();
		
		$this->load->model('localisation/order_status');
		
		$this->_data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->_data['filter_order_status_id'] = $filter_order_status_id;
		$this->_data['filter_date_start'] = $filter_date_start;
		$this->_data['filter_date_end'] = $filter_date_end;
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

			$this->template = 'module/ecadvancedreports/sale_zipcode.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;

			$this->_export_content_html = $this->load->view($this->template, $data);

			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'report_sale_zipcode_page_'.$page;
		$reports['data'] = array();
		$reports['data'] = array();
		$reports['data'] = $this->getReportData();
		
		$this->initLoad();
		foreach ($this->_data['districts'] as $key => $district) { 
		    $data_jason['District'] = $key;    
		    $data_jason['Postal Sector'] = $district['postal_sector'];   
		    $data_jason['General Location'] = $district['general_location'];   
		    $data_jason['Number Orders'] = $district['number_orders'];   
		    $data_jason['Items Ordered'] = $district['items_ordered'];   
		    $data_jason['Total'] = $district['total2'];  
		    $data_jason_jasonp[] = $data_jason;
		}
		$reports['data'] = $data_jason_jasonp;
// 		echo "<pre>";
// var_dump($this->_data['districts']);die;

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
		
		return $this->getModel()->getSaleByZipcode($data);
	}
}
?>