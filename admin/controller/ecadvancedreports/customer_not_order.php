<?php

require_once(DIR_APPLICATION."/controller/ecadvancedreports/abstract.php");

class ControllerEcadvancedreportsCustomerNotOrder extends Ec_Report_Abstract {
	public function index() {
		$this->initLoad();
		$data = $this->_data;
		$data['export'] = '';

		$this->template = 'module/ecadvancedreports/customer_notorder_report.tpl';
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['language'] = $this->language;

		$this->response->setOutput($this->load->view($this->template, $data));
	}

	public function initLoad($all_records = false) {
		$this->language->load('common/header');

		$this->language->load('report/customer_order');

		$this->load->language('sale/customer');

		$this->language->load('module/ecadvancedreports');

		$this->load->model('ecadvancedreports/customer');

		$this->setModel( $this->model_ecadvancedreports_customer );
		
		$this->document->setTitle($this->language->get('heading_title_customer_notorder_report'));

		$this->document->addStyle('view/stylesheet/ecadvancedreports.css');
		$this->document->addStyle('view/javascript/ecadvancedreports/multilselect/multiple-select.css');
		$this->document->addScript('view/javascript/ecadvancedreports/multilselect/jquery.multiple.select.js');
		$this->document->addScript('view/javascript/ecadvancedreports/bootstrap-hover-dropdown.min.js');

		$this->_data = $this->loadMenu();

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = null;
		}

		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			'text'      => $this->language->get('heading_title_customer_notorder_report'),
			'href'      => $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'].$url, 'SSL'),
			'separator' => ' :: '
		);

		$this->_data['reports'] = array();

		$filter_data = array(
			'filter_name'              => $filter_name,
			'filter_email'             => $filter_email,
			'filter_customer_group_id' => $filter_customer_group_id,
			'filter_status'            => $filter_status,
			'filter_approved'          => $filter_approved,
			'filter_date_added'        => $filter_date_added,
			'filter_ip'                => $filter_ip,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin'),
			'all'					   => $all_records
		);

		$report_total = $this->getModel()->getTotalCustomersNotOrder($filter_data);

		$results = $this->getModel()->getCustomersNotOrder($filter_data);

		foreach ($results as $key => $result) {
			
			$this->_data['reports'][] = array(
				'customer_id'    => $result['customer_id'],
				'name'           => $result['name'],
				'email'          => $result['email'],
				'customer_group' => $result['customer_group'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'ip'             => $result['ip'],
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'           => $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
			);
		}

		$this->_reports = $this->_data['reports'];

		$this->_data['heading_title'] = $this->language->get('heading_title_customer_notorder_report');

		$this->_data['text_list'] = $this->language->get('text_list');
		$this->_data['text_enabled'] = $this->language->get('text_enabled');
		$this->_data['text_disabled'] = $this->language->get('text_disabled');
		$this->_data['text_yes'] = $this->language->get('text_yes');
		$this->_data['text_no'] = $this->language->get('text_no');
		$this->_data['text_default'] = $this->language->get('text_default');
		$this->_data['text_no_results'] = $this->language->get('text_no_results');
		$this->_data['text_confirm'] = $this->language->get('text_confirm');

		$this->_data['column_name'] = $this->language->get('column_name');
		$this->_data['column_email'] = $this->language->get('column_email');
		$this->_data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->_data['column_status'] = $this->language->get('column_status');
		$this->_data['column_approved'] = $this->language->get('column_approved');
		$this->_data['column_ip'] = $this->language->get('column_ip');
		$this->_data['column_date_added'] = $this->language->get('column_date_added');
		$this->_data['column_action'] = $this->language->get('column_action');

		$this->_data['entry_name'] = $this->language->get('entry_name');
		$this->_data['entry_email'] = $this->language->get('entry_email');
		$this->_data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->_data['entry_status'] = $this->language->get('entry_status');
		$this->_data['entry_approved'] = $this->language->get('entry_approved');
		$this->_data['entry_ip'] = $this->language->get('entry_ip');
		$this->_data['entry_date_added'] = $this->language->get('entry_date_added');

		$this->_data['button_approve'] = $this->language->get('button_approve');
		$this->_data['button_add'] = $this->language->get('button_add');
		$this->_data['button_edit'] = $this->language->get('button_edit');
		$this->_data['button_delete'] = $this->language->get('button_delete');
		$this->_data['button_filter'] = $this->language->get('button_filter');
		$this->_data['button_login'] = $this->language->get('button_login');
		$this->_data['button_unlock'] = $this->language->get('button_unlock');

		$this->_data['token'] = $this->session->data['token'];

		$this->_data['text_export_to'] = $this->language->get('text_export_to');
		$this->_data['button_export'] = $this->language->get('button_export');

		$this->_data['export_types'] = $this->get_export_types();

		if (isset($this->error['warning'])) {
			$this->_data['error_warning'] = $this->error['warning'];
		} else {
			$this->_data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->_data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->_data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$this->_data['selected'] = (array)$this->request->post['selected'];
		} else {
			$this->_data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->_data['sort_name'] = $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->_data['sort_email'] = $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
		$this->_data['sort_customer_group'] = $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
		$this->_data['sort_status'] = $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
		$this->_data['sort_ip'] = $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'] . '&sort=c.ip' . $url, 'SSL');
		$this->_data['sort_date_added'] = $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('ecadvancedreports/customer_not_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->_data['pagination'] = $pagination->render();

		$this->_data['results'] = sprintf($this->language->get('text_pagination'), ($report_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($report_total - $this->config->get('config_limit_admin'))) ? $report_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $report_total, ceil($report_total / $this->config->get('config_limit_admin')));

		$this->_data['filter_name'] = $filter_name;
		$this->_data['filter_email'] = $filter_email;
		$this->_data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->_data['filter_status'] = $filter_status;
		$this->_data['filter_approved'] = $filter_approved;
		$this->_data['filter_ip'] = $filter_ip;
		$this->_data['filter_date_added'] = $filter_date_added;

	//	$this->load->model('sale/customer_group');
	    $this->load->model('customer/customer_group');

	//	$this->_data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
        $this->_data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		$this->load->model('setting/store');

		$this->_data['stores'] = $this->model_setting_store->getStores();

		$this->_data['sort'] = $sort;
		$this->_data['order'] = $order;

		$this->_data['header'] = $this->load->controller('common/header');
		$this->_data['column_left'] = $this->load->controller('common/column_left');
		$this->_data['footer'] = $this->load->controller('common/footer');
	}

	public function export() {
		
		$export_all = $this->config->get('ecadvancedreports_export_all');

		$this->initLoad($export_all);

		$export_type = $this->request->get["export_type"];
		if($export_type == "pdf" || $export_type == "html") {
			/*Get page html content*/
			$this->_data['export'] = 'html';
			$data = $this->_data;
			
			$this->template = 'module/ecadvancedreports/customer_notorder_report.tpl';
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
				unset($val['edit']);
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