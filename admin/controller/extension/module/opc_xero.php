<?php
class ControllerExtensionModuleOpcXero extends Controller {
	private $error = array();

	public function install() {
		$this->load->model('xero/opc_xero');

		$this->load->model('extension/event');

		$this->model_xero_opc_xero->createTable();

		$this->model_extension_event->addEvent('opc_xero', 'admin/model/customer/customer/addCustomer/after', 'xero/customer/auto_sync');

		$this->model_extension_event->addEvent('opc_xero', 'admin/model/customer/customer/editCustomer/after', 'xero/customer/auto_sync');

		$this->model_extension_event->addEvent('opc_xero', 'catalog/model/account/customer/addCustomer/after', 'xero/customer/auto_sync');

		$this->model_extension_event->addEvent('opc_xero', 'catalog/model/account/customer/editCustomer/after', 'xero/customer/auto_sync');

		$this->model_extension_event->addEvent('opc_xero', 'admin/model/catalog/product/addProduct/after', 'xero/product/auto_sync');

		$this->model_extension_event->addEvent('opc_xero', 'admin/model/catalog/product/editProduct/after', 'xero/product/auto_sync');

		$this->model_extension_event->addEvent('opc_xero', 'catalog/model/checkout/order/addOrderHistory/after', 'xero/order/auto_sync');
	}

	public function uninstall() {
		$this->load->model('xero/opc_xero');

		$this->load->model('extension/event');

		$this->model_xero_opc_xero->dropTable();

		$this->model_extension_event->deleteEvent('opc_xero');
	}

	public function menu(){
		$this->load->language('extension/module/opc_xero');

		$menus = array();

		$xero = array();

		if ($this->config->get('module_opc_xero_status')) {
			if ($this->user->hasPermission('access', 'extension/module/opc_xero')) {
				$xero[] = array(
					'name'	   => $this->language->get('text_configuration'),
					'href'     => $this->url->link('extension/module/opc_xero', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'xero/customer')) {
				$xero[] = array(
					'name'	   => $this->language->get('text_customer_xero'),
					'href'     => $this->url->link('xero/customer', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'xero/product')) {
				$xero[] = array(
					'name'	   => $this->language->get('text_product_xero'),
					'href'     => $this->url->link('xero/product', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'xero/order')) {
				$xero[] = array(
					'name'	   => $this->language->get('text_order_xero'),
					'href'     => $this->url->link('xero/order', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($xero) {
				$menus = array(
					'id'       => 'menu-xero',
					'icon'	   => 'fa-exchange',
					'name'	   => $this->language->get('text_xero'),
					'href'     => '',
					'children' => $xero
				);
			}
		}

		return $menus;
	}

	public function index() {
		$data = $this->load->language('extension/module/opc_xero');

		if ($this->request->post) {
			function clean(&$value) {
			    $value = trim($value);
			}

			array_walk_recursive($this->request->post, 'clean');
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('module_opc_xero', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$opc_error = array(
			'warning',
			'client_id',
			'client_secret',
			'slot',
		);

		foreach ($opc_error as $key => $value) {
			if (isset($this->error[$value])) {
				$data['error_'.$value] = $this->error[$value];
			} else {
				$data['error_'.$value] = '';
			}
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/opc_xero', 'token=' . $this->session->data['token'], true)
		);

		$data['user_guide'] = $this->url->link('extension/module/opc_xero/user_guide', 'token=' . $this->session->data['token'], true);

		$data['action'] = $this->url->link('extension/module/opc_xero', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        $opc_module_config = array(
    			'status',
    			'slot',
    			'client_id',
    			'client_secret',
    			'access_token',
    			'refresh_token',
    			'product_code',
    			'invoice_status',
    			'account',
    			'auto_sync',
    			'order_status',
    			'payment_account',
    			'guest_id'
    		);
    
        foreach ($opc_module_config as $key => $value) {
          if (isset($this->request->post['module_opc_xero_'.$value])) {
      			$data['module_opc_xero_'.$value] = $this->request->post['module_opc_xero_'.$value];
    			} elseif (isset($this->session->data['module_opc_xero_'.$value])) {
    				$data['module_opc_xero_'.$value] = $this->session->data['module_opc_xero_'.$value];
      		} else {
      			$data['module_opc_xero_'.$value] = $this->config->get('module_opc_xero_'.$value);
      		}
        }

		$data['connect_button'] = 0;

		if ($this->config->get('module_opc_xero_client_id') && $this->config->get('module_opc_xero_client_secret')) {
		  $data['connect_button'] = 1;

		  if ($this->request->server['HTTPS']) {
		    $redirect_uri = HTTPS_CATALOG . 'index.php?route=account/xero';
		  } else {
		    $redirect_uri = HTTP_CATALOG . 'index.php?route=account/xero';
		  }

		  $data['authorizationRequestUrl'] = 'https://login.xero.com/identity/connect/authorize?response_type=code&client_id=' . $this->config->get('module_opc_xero_client_id') . '&scope=offline_access accounting.settings accounting.contacts accounting.transactions&redirect_uri=' . $redirect_uri;
		}

		$this->registry->set('xero', new Xero($this->registry));

		$data['accounts'] = $this->xero->getAccounts();

        $data['payment_methods'] = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'payment'")->rows;
		$data['payment_accounts'] = $this->xero->getPaymentAccounts();

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if(isset($this->session->data['xero_error'])) {
			if($this->session->data['xero_error'] != ""){
				$data['xero_error'] = $this->session->data['xero_error'];
			}else{
				$data['xero_error'] = ""; 
			}
		}
		

		$this->response->setOutput($this->load->view('extension/module/opc_xero', $data));
	}

	public function user_guide() {
	  $this->document->setTitle('Opencart Xero Integration User Guide');

	  $data['cancel'] = $this->url->link('extension/module/opc_xero', 'token=' . $this->session->data['token'], true);

	  $data['token'] = $this->session->data['token'];

	  $data['header'] = $this->load->controller('common/header');

	  $data['column_left'] = $this->load->controller('common/column_left');

	  $data['footer'] = $this->load->controller('common/footer');

	  $this->response->setOutput($this->load->view('extension/module/opc_xero_user_guide', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/opc_xero')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['module_opc_xero_status']) {

			if (!isset($this->request->post['module_opc_xero_slot']) || $this->request->post['module_opc_xero_slot'] < 5 || $this->request->post['module_opc_xero_slot'] > 50) {
				$this->error['slot'] = $this->language->get('error_slot');
			}

			$opc_error = array(
				'client_id',
				'client_secret',
			);

			foreach ($opc_error as $key => $value) {
				if (!isset($this->request->post['module_opc_xero_'.$value]) || !$this->request->post['module_opc_xero_'.$value]) {
					$this->error[$value] = $this->language->get('error_'.$value);
				}
			}
		}

		return !$this->error;
	}
}
