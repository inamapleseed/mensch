<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsProductList extends Ec_Report_Abstract {
	public function index() {
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/product_list.tpl';
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

		$this->load->model("catalog/product");
		$this->load->model("customer/customer_group");

		$this->setModel( $this->model_ecadvancedreports_product );
		
		$this->document->setTitle($this->language->get('heading_title_product_inventory'));

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

		$url = '';

		
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['store_id'])) {
			$url .= '&store_id=' . $this->request->get['store_id'];
		}
				
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->_current_url = $this->url->link('ecadvancedreports/product_list', 'token=' . $this->session->data['token'].$url, 'SSL');


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
			'text'      => $this->language->get('heading_title_product_list'),
			'href'      => $this->url->link('ecadvancedreports/product_list', 'token=' . $this->session->data['token'].$url, 'SSL'),
			'separator' => ' :: '
		);

		$this->_data['reports'] = array();

		$data = array(
 			'filter_store_id'		 => $store_id,
			'filter_category_id'	 => $filter_category_id,
			'filter_manufacturer'	 => $filter_manufacturer,
			'start'                  => ($page - 1) * $limit,
			'limit'                  => $limit,
			'all'					 => $all_records
		);

		$report_total = $this->getModel()->getTotalProductList($data);

		$results = $this->getModel()->getProductList($data);

		$number_lowstock = $this->config->get('ecadvancedreports_number_lowstock');
		$number_lowstock = $number_lowstock?$number_lowstock:10;

		if($results) {
			foreach($results as $key => $result) {
				if ($result['image'] && is_file(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 40, 40);
				} else {
					$image = $this->model_tool_image->resize('no_image.png', 40, 40);
				}
	
				$result['product_id'] = isset($result['product_id'])?$result['product_id']:0;
				$result['name'] = isset($result['name'])?$result['name']:"";

				$price = isset($result['price'])?$result['price']:0;
				//Get product special price
				$special_price = $this->model_catalog_product->getProductSpecials($result['product_id']);
				$results[$key]['special_price'] = array();
				if($special_price) {
					foreach($special_price as $sp_item) {
						$sp_item['price2'] = $this->currency->format($sp_item['price'], $this->config->get('config_currency'));

						$sp_item['customer_group'] = "";
						if($customer_group = $this->model_customer_customer_group->getCustomerGroup($sp_item['customer_group_id'])) {
							$sp_item['customer_group'] = $customer_group['name'];
						}

						$results[$key]['special_price'][] = $sp_item;
					}
				}
				//End Get product special price

				$results[$key]['image'] = $image;
				$results[$key]['price2'] = $this->currency->format($price, $this->config->get('config_currency'));
				$results[$key]['link'] = $this->url->link('catalog/product/edit', 'product_id='.$result['product_id'].'&token=' . $this->session->data['token'], 'SSL');
			}
		}

		$this->_reports = $results;
		$this->_data['reports'] = $results;

		$this->_data['heading_title'] = $this->language->get('heading_title_product_listing');

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
		$this->_data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->_data['column_image'] = $this->language->get('column_image');
		$this->_data['column_priority'] = $this->language->get('column_priority');
		$this->_data['column_price'] = $this->language->get('column_price');
		$this->_data['column_product_mpn'] = $this->language->get('column_product_mpn');
		$this->_data['column_date_start'] = $this->language->get('column_date_start');
		$this->_data['column_date_end'] = $this->language->get('column_date_end');
		$this->_data['column_total'] = $this->language->get('column_total');
		$this->_data['column_quantity'] = $this->language->get('column_quantity');
		$this->_data['column_product_model'] = $this->language->get('column_product_model');
		$this->_data['column_product_name'] = $this->language->get('column_product_name');
		$this->_data['column_product_revenue'] = $this->language->get('column_product_revenue');
		$this->_data['column_stock_status'] = $this->language->get('column_stock_status');
		$this->_data['column_qty_purchases'] = $this->language->get('column_qty_purchases');
		$this->_data['entry_show_by'] = $this->language->get('entry_show_by');
		$this->_data['column_qty_inventory'] = $this->language->get('column_qty_inventory');
		$this->_data['label_product_spcial_price'] = $this->language->get('label_product_spcial_price');

		$this->_data['text_category'] = $this->language->get('text_category');
		$this->_data['text_choose_a_category'] = $this->language->get('text_choose_a_category');

		$this->_data['button_filter'] = $this->language->get('button_filter');
		$this->_data['button_export'] = $this->language->get('button_export');

		$this->_data['token'] = $this->session->data['token'];

		$this->_data['key_list'] = array("qty" => $this->language->get('column_quantity'),
										"total" => $this->language->get('column_total'));

		$this->_data['export_types'] = $this->get_export_types();

		$this->_data['export_type'] = "";

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

		
		$url = '';

		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['store_id'])) {
			$url .= '&store_id=' . $this->request->get['store_id'];
		}


		$pagination = new Pagination();
		$pagination->total = $report_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ecadvancedreports/product_list', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
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

	
	public function export() {
		$this->language->load('common/header');

		$this->language->load('report/customer_order');

		$this->language->load('module/ecadvancedreports');

		$export_all = $this->config->get('ecadvancedreports_export_all');

		$this->initLoad($export_all);

		$limit = $this->config->get('ecadvancedreports_limit');
		$limit = $limit?(int)$limit:$this->config->get('config_admin_limit');
		
		$export_type = $this->request->get["export_type"];
		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/
			$this->_data['export'] = 'html';
			$data = $this->_data;

			$this->template = 'module/ecadvancedreports/product_list.tpl';
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['language'] = $this->language;

			$this->_export_content_html = $this->load->view($this->template, $data);
			
			/*get page html content*/
		}
		$reports = array();
		$reports['name'] = 'product_list';
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
				unset($val['special_price']);
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