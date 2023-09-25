<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsProductNotSold extends Ec_Report_Abstract {
	public function index() {
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/product_notsold.tpl';
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

		$this->load->model('catalog/manufacturer');

		$this->load->model('tool/image');

		$this->load->model("catalog/category");

		$this->setModel( $this->model_ecadvancedreports_product );
		
		$this->document->setTitle($this->language->get('heading_title_product_notsold'));

		$this->document->addStyle('view/stylesheet/ecadvancedreports.css');
		$this->document->addStyle('view/javascript/ecadvancedreports/multilselect/multiple-select.css');
		$this->document->addScript('view/javascript/ecadvancedreports/multilselect/jquery.multiple.select.js');
		$this->document->addScript('view/javascript/ecadvancedreports/bootstrap-hover-dropdown.min.js');

		$this->_data = $this->loadMenu();

		$limit = $this->config->get('ecadvancedreports_limit');

		$limit = $limit?$limit:$this->config->get('config_limit_admin');

		$number_lowstock = $this->config->get('ecadvancedreports_number_lowstock');
		$number_lowstock = $number_lowstock?$number_lowstock:10;

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

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}

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

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = trim($this->request->get['filter_quantity']);
		} else {
			$filter_quantity = "";
		}

		$filter_quantity = ($filter_quantity != "")?$filter_quantity: -1;

		if (isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
		} else {
			$store_id = 0;
		}

		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		if (isset($this->request->get['product_name'])) {
			$product_name = $this->request->get['product_name'];
		} else {
			$product_name = "";
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['range_date'])) {
			$range_date = $this->request->get['range_date'];
		} else {
			$range_date = "this_month";
		}

		$url = '';

		
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['store_id'])) {
			$url .= '&store_id=' . $this->request->get['store_id'];
		}

		if (isset($this->request->get['product_name'])) {
			$url .= '&product_name=' . $this->encodeURI($this->request->get['product_name']);
		}

		if (isset($this->request->get['product_id'])) {
			$url .= '&product_id=' . $this->request->get['product_id'];
		}
								
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->_current_url = $this->url->link('ecadvancedreports/product_notsold', 'token=' . $this->session->data['token'].$url, 'SSL');


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
			'text'      => $this->language->get('heading_title_product_notsold'),
			'href'      => $this->url->link('ecadvancedreports/product_notsold', 'token=' . $this->session->data['token'].$url, 'SSL'),
			'separator' => ' :: '
		);

		$text_low_stock = $this->language->get("text_low_stock");
		$text_out_stock = $this->language->get("text_out_stock");
		$text_available_stock = $this->language->get("text_available_stock");

		$this->_data['reports'] = array();

		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
 			'filter_store_id'		 => $store_id,
			'filter_category_id'	 => $filter_category_id,
			'filter_manufacturer'	 => $filter_manufacturer,
			'filter_quantity'		 => $filter_quantity,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_product_id'		 => $product_id,
			'start'                  => ($page - 1) * $limit,
			'limit'                  => $limit,
			'all'					 => $all_records
		);

		$report_total = $this->getModel()->getTotalNotSoldReport($data);

		$results = $this->getModel()->getNotSoldReport($data);

		$sum_total_price = 0;
		$sum_total_value = 0;
		$sum_total_cost = 0;
		$sum_total_total_cost = 0;
		$sum_qty = 0;
		$sum_purchases_qty = 0;
		$sum_total_purchases = 0;

		if($results) {
			foreach($results as $key => $result) {
				if($result) {
					$sum_total_price += (float)$result['price'];
					$sum_total_cost += (float)$result['cost'];
					$sum_total_total_cost += (float)$result['total_cost'];
					$sum_total_value += (float)$result['product_value'];
					$sum_qty += (int)$result['quantity'];
					$sum_purchases_qty += isset($result['purchases_quantity'])?(int)$result['purchases_quantity']:0;
					$sum_total_purchases += isset($result['purchases_value'])?(float)$result['purchases_value']:0;
				} else {
					$results[$key]['price'] = 0;
					$results[$key]['cost'] = 0;
					$results[$key]['total_cost'] = 0;
					$results[$key]['quantity'] = 0;
					$results[$key]['product_value'] = 0;
					$results[$key]['purchases_quantity'] = 0;
					$results[$key]['purchases_value'] = 0;
				}
				if($results[$key]['quantity'] < $number_lowstock && $results[$key]['quantity'] > 0) {
					$results[$key]['stock_status'] = $text_low_stock;
					$results[$key]['stock_class'] = "low_stock";
				} else if($results[$key]['quantity'] <= 0 ) {
					$results[$key]['stock_status'] = $text_out_stock;
					$results[$key]['stock_class'] = "out_stock";
				} else {
					$results[$key]['stock_status'] = $text_available_stock;
					$results[$key]['stock_class'] = "available";
				}


				if ($result['image'] && is_file(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 40, 40);
				} else {
					$image = $this->model_tool_image->resize('no_image.png', 40, 40);
				}
	
				$result['product_id'] = isset($result['product_id'])?$result['product_id']:0;
				$result['name'] = isset($result['name'])?$result['name']:"";

				$price = isset($result['price'])?$result['price']:0;
				$cost = isset($result['cost'])?(float)$result['cost']:0;
				$total_cost = isset($result['total_cost'])?(float)$result['total_cost']:0;
				$product_value = isset($result['product_value'])?(float)$result['product_value']:0;
				$product_value = $product_value<0?0:$product_value;
				$purchases_value = isset($result['purchases_value'])?$result['purchases_value']:0;

				$results[$key]['options'] = $this->getProductOptions($result['product_id']);
				$results[$key]['image'] = $image;
				$results[$key]['price2'] = $this->currency->format($price, $this->config->get('config_currency'));
				$results[$key]['product_value2'] = $this->currency->format($product_value, $this->config->get('config_currency'));
				$results[$key]['purchases_value2'] = $this->currency->format($purchases_value, $this->config->get('config_currency'));
				$results[$key]['cost2'] = $this->currency->format($cost, $this->config->get('config_currency'));
				$results[$key]['total_cost2'] = $this->currency->format($total_cost, $this->config->get('config_currency'));
				$results[$key]['link'] = $this->url->link('catalog/product/edit', 'product_id='.$result['product_id'].'&token=' . $this->session->data['token'], 'SSL');
			}
		}

		$this->_reports = $results;

		$this->_data['filter_date_start'] = $filter_date_start;
		$this->_data['filter_date_end'] = $filter_date_end;		
		$this->_data['text_available_stock'] = $text_available_stock;
		$this->_data['text_out_stock'] = $text_out_stock;
		$this->_data['text_low_stock'] = $text_low_stock;
		$this->_data['number_lowstock'] = $number_lowstock;
		$this->_data['reports'] = $results;
		$this->_data['sum_total_price'] = $sum_total_price;
		$this->_data['sum_total_cost'] = $sum_total_cost;
		$this->_data['sum_total_total_cost'] = $sum_total_total_cost;
		$this->_data['sum_qty'] = $sum_qty;
		$this->_data['sum_total_value'] = $sum_total_value;
		$this->_data['sum_purchases_qty'] = $sum_purchases_qty;
		$this->_data['sum_total_purchases'] = $sum_purchases_qty;
		$this->_data['sum_total_price_with_currency'] = $this->currency->format($sum_total_price, $this->config->get('config_currency'));
		$this->_data['sum_total_value_with_currency'] = $this->currency->format($sum_total_value, $this->config->get('config_currency'));
		$this->_data['sum_total_cost_with_currency'] = $this->currency->format($sum_total_cost, $this->config->get('config_currency'));
		$this->_data['sum_total_total_cost_with_currency'] = $this->currency->format($sum_total_total_cost, $this->config->get('config_currency'));

		$this->_data['sum_total_purchases_with_currency'] = $this->currency->format($sum_total_purchases, $this->config->get('config_currency'));

		$this->_data['heading_title'] = $this->language->get('heading_title_product_notsold');

		$this->_data['text_option_value_name'] = $this->language->get('text_option_value_name');
		$this->_data['text_filter_product'] = $this->language->get('text_filter_product');
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
		$this->_data['text_filter_quantity'] = $this->language->get('text_filter_quantity');
		$this->_data['text_no_purchases'] = $this->language->get('text_no_purchases');
		$this->_data['text_or'] = $this->language->get('text_or');
		$this->_data['text_type'] = $this->language->get('text_type');
		$this->_data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->_data['text_choose_a_manufacturer'] = $this->language->get('text_choose_a_manufacturer');
		$this->_data['text_expand_options'] = $this->language->get('text_expand_options');

		$this->_data['column_product_sku'] = $this->language->get('column_product_sku');
		$this->_data['column_cost'] = $this->language->get('column_cost');
		$this->_data['column_total_cost'] = $this->language->get('column_total_cost');
		$this->_data['column_image'] = $this->language->get('column_image');
		$this->_data['column_quantity'] = $this->language->get('column_quantity');
		$this->_data['column_price'] = $this->language->get('column_price');
		$this->_data['column_value'] = $this->language->get('column_value');
		$this->_data['column_purchases_value'] = $this->language->get('column_purchases_value');
		$this->_data['column_purchases_quantity'] = $this->language->get('column_purchases_quantity');
		$this->_data['column_total'] = $this->language->get('column_total');
		$this->_data['column_quantity'] = $this->language->get('column_quantity');
		$this->_data['column_product_model'] = $this->language->get('column_product_model');
		$this->_data['column_product_name'] = $this->language->get('column_product_name');
		$this->_data['column_product_revenue'] = $this->language->get('column_product_revenue');
		$this->_data['column_stock_status'] = $this->language->get('column_stock_status');
		$this->_data['column_qty_purchases'] = $this->language->get('column_qty_purchases');
		$this->_data['entry_show_by'] = $this->language->get('entry_show_by');
		$this->_data['column_qty_inventory'] = $this->language->get('column_qty_inventory');

		$this->_data['text_category'] = $this->language->get('text_category');
		$this->_data['text_choose_a_category'] = $this->language->get('text_choose_a_category');

		$this->_data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->_data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->_data['entry_range'] = $this->language->get('entry_range');
		$this->_data['button_filter'] = $this->language->get('button_filter');
		$this->_data['button_export'] = $this->language->get('button_export');

		$this->_data['token'] = $this->session->data['token'];

		$this->_data['key_list'] = array("qty" => $this->language->get('column_quantity'),
										"total" => $this->language->get('column_total'));

		$this->_data['export_types'] = $this->get_export_types();

		$this->_data['export_type'] = "";

		$this->_data['range_list'] = array(
											"all" => $this->language->get('text_all_time'),
											"today" => $this->language->get('text_today'),
											"yesterday" => $this->language->get('text_yesterday'),
											"last_7_days" => $this->language->get('text_last_seven_days'),
											"last_week" => $this->language->get('text_last_week'),
											"last_business_week" => $this->language->get('text_last_business_week'),
											"this_month" => $this->language->get('text_this_month'),
											"last_month" => $this->language->get('text_last_month'),
											"custom" => $this->language->get('text_custom_range')
										);

		
		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['store_id'])) {
			$url .= '&store_id=' . $this->request->get['store_id'];
		}

		if (isset($this->request->get['product_name'])) {
			$url .= '&product_name=' . $this->encodeURI($this->request->get['product_name']);
		}

		if (isset($this->request->get['product_id'])) {
			$url .= '&product_id=' . $this->request->get['product_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $report_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ecadvancedreports/product_notsold', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		$this->_data['range_date'] = $range_date;
		
		$this->_data['pagination'] = $pagination->render();

		$this->load->model('setting/store');

		$this->_data['stores'] = $this->model_setting_store->getStores();

		$this->_data['categories'] = array();
    	
    	$this->_data['categories'] = $this->model_catalog_category->getCategories(array('sort'=>'name'));

    	$this->_data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(array());

		$this->_data['store_id'] = $store_id;
		$this->_data['filter_order_status_id'] = $filter_order_status_id;
		$this->_data['filter_manufacturer'] = $filter_manufacturer;
		$this->_data['filter_category_id'] = $filter_category_id;
		$this->_data['filter_quantity'] = (int)$filter_quantity>=0?$filter_quantity:"";
		$this->_data['product_id'] = $product_id;
		$this->_data['product_name'] = $product_name;
		$this->_data['page'] = $page;
		$this->_data['number_lowstock'] = $number_lowstock;
	}

	public function getProductOptions($product_id) {
		$this->load->model('catalog/product');
		// Options
		$this->load->model('catalog/option');

		$tmp_product_options = $this->model_catalog_product->getProductOptions($product_id);			

		$product_options = array();

		foreach ($tmp_product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();

				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price2' 				  => $this->currency->format($product_option_value['price'], $this->config->get('config_currency')),
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],						
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']	
					);
				}

				$product_options[] = array(
					'product_option_id'    => $product_option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $product_option['option_id'],
					'name'                 => $product_option['name'],
					'type'                 => $product_option['type'],
					'required'             => $product_option['required']
				);				
			} else {
				$product_options[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => isset($product_option['option_value'])?$product_option['option_value']:'',
					'required'          => $product_option['required']
				);
			}
		}
	/*Get option values*/
		foreach ($product_options as $key => $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$option_values = $this->model_catalog_option->getOptionValues($product_option['option_id']);
				$tmp = array();
				foreach($option_values as $item) {
					$tmp[$item['option_value_id']] = $item;
				}
				$product_option['option_values'] = $tmp;

				$product_options[$key] = $product_option;
			} else {
				unset($product_options[$key]);
			}
		}

		return $product_options;
	}
	public function export() {
		$this->language->load('common/header');

		$this->language->load('report/customer_order');

		$this->language->load('module/ecadvancedreports');

		$export_all = $this->config->get('ecadvancedreports_export_all');

		$this->initLoad($export_all);

		$config = $this->config->get('ecadvancedreports_general');

		$limit = $this->config->get('ecadvancedreports_limit');
		$limit = $limit?(int)$limit:$this->config->get('config_admin_limit');
		$number_lowstock = $this->config->get('ecadvancedreports_number_lowstock');
		$number_lowstock = $number_lowstock?(int)$number_lowstock:10;
		$text_low_stock = $this->language->get("text_low_stock");
		$text_out_stock = $this->language->get("text_out_stock");
		$text_available_stock = $this->language->get("text_available_stock");

		$export_type = $this->request->get["export_type"];
		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/
			$this->_data['export'] = 'html';
			$data = $this->_data;

			$this->template = 'module/ecadvancedreports/product_notsold.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;

			$this->_export_content_html = $this->load->view($this->template, $data);
			
			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'product_notsold';
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
				unset($val['image']);
				$options = $val['options'];
				unset($val['options']);
				$tmp[$report_period.$i] = $val;
				$i++;
				if($options) {
					foreach($options as $option) {
						if(isset($option['product_option_value']) && $option['product_option_value']) {
							$option_values = isset($option['option_values'])?$option['option_values']:array();
							foreach($option['product_option_value'] as $option_value) {
								$tmp2 = $val;

								if($option_value['quantity'] < $number_lowstock && $option_value['quantity'] > 0) {
		                          $option_value['stock_status'] = $text_low_stock;
		                          $option_value['stock_class'] = "low_stock";
		                          $style_color = "color:#FFA500";
		                        } else if($option_value['quantity'] <= 0 ) {
		                          $option_value['stock_status'] = $text_out_stock;
		                          $option_value['stock_class'] = "out_stock";
		                          $style_color = "color:#FF0000";
		                        } else {
		                          $option_value['stock_status'] = $text_available_stock;
		                          $option_value['stock_class'] = "available";
		                        }

								$option_value_name = isset($option_values[$option_value['option_value_id']])?$option_values[$option_value['option_value_id']]['name']:'';

								$tmp2['name'] = $tmp2['name']." - ".$option['name']." - ".$option_value_name;
								$tmp2['quantity'] = $option_value['quantity'];
								$tmp2['price'] = $option_value['price_prefix'].(isset($option_value["price"])?$option_value['price']:"0.00");
								$tmp2['price2'] = $option_value['price_prefix'].(isset($option_value["price2"])?$option_value['price2']:"0.00");
								$tmp2['product_value2'] = $tmp2['purchases_value2'] =  $tmp2['cost2'] = $tmp2['total_cost2'] = $tmp2['cost'] = $tmp2['total_cost'] =$tmp2['product_value'] = "";

								$tmp[$report_period.$i] = $tmp2;
								$i++;
							}
						}
					}
					
				}
				
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