<?php
class ControllerXeroCustomer extends Controller {
	private $error = array();

	public function index() {
		$data = $this->load->language('xero/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('xero/customer');

		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = '';
		}

		if (isset($this->request->get['filter_xero_customer_id'])) {
			$filter_xero_customer_id = $this->request->get['filter_xero_customer_id'];
		} else {
			$filter_xero_customer_id = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
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

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . urlencode(html_entity_decode($this->request->get['filter_customer_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_xero_customer_id'])) {
			$url .= '&filter_xero_customer_id=' . urlencode(html_entity_decode($this->request->get['filter_xero_customer_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
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

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('xero/customer', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['customers'] = array();

		$filter_data = array(
			'filter_customer_id'     	 => $filter_customer_id,
			'filter_xero_customer_id'    => $filter_xero_customer_id,
			'filter_name'              => $filter_name,
			'filter_email'             => $filter_email,
			'filter_status'            => $filter_status,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$customer_total = $this->model_xero_customer->getTotalCustomers($filter_data);

		$results = $this->model_xero_customer->getCustomers($filter_data);

		foreach ($results as $result) {
			$data['customers'][] = array(
				'customer_id'    => $result['customer_id'],
				'xero_customer_id'    => $result['xero_customer_id'],
				'name'           => $result['name'],
				'email'          => $result['email'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
			);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . urlencode(html_entity_decode($this->request->get['filter_customer_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_xero_customer_id'])) {
			$url .= '&filter_xero_customer_id=' . urlencode(html_entity_decode($this->request->get['filter_xero_customer_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('xero/customer', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_email'] = $this->url->link('xero/customer', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, true);
		$data['sort_status'] = $this->url->link('xero/customer', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . urlencode(html_entity_decode($this->request->get['filter_customer_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_xero_customer_id'])) {
			$url .= '&filter_xero_customer_id=' . urlencode(html_entity_decode($this->request->get['filter_xero_customer_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
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
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('xero/customer', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($customer_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($customer_total - $this->config->get('config_limit_admin'))) ? $customer_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $customer_total, ceil($customer_total / $this->config->get('config_limit_admin')));

		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_xero_customer_id'] = $filter_xero_customer_id;
		$data['filter_name'] = $filter_name;
		$data['filter_email'] = $filter_email;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('xero/customer', $data));
	}

	public function export() {

		$this->load->language('xero/customer');

		$json = array();

		$count = 0;

		$data['start'] = 0;

		$data['limit'] = $this->config->get('module_opc_xero_slot') ? $this->config->get('module_opc_xero_slot') : 20;

		$this->registry->set('xero', new Xero($this->registry));

		if ($this->config->get('module_opc_xero_status')) {
	        //$this->session->data['xeromax_customer_id'] = 0;
			while (1) {
				$customers = $this->xero->getCustomersToSync($data);
				
				if (!$customers) {
					break;
				} else {
					$count += $this->xero->syncCustomerToXero($customers);
				}
				//$data['start'] += $data['limit'];
			}
		}

		$json['success'] = sprintf($this->language->get('text_success_customer'), $count);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function import() {

	  $this->load->language('xero/customer');

	  $json = array();

	  $count = 0;

	  if ($this->config->get('module_opc_xero_status')) {
	    $this->registry->set('xero', new Xero($this->registry));

	    $count = $this->xero->importCustomerFromXero();
	  }

	  $json['success'] = sprintf($this->language->get('text_success_import'), $count);

	  $this->response->addHeader('Content-Type: application/json');
	  $this->response->setOutput(json_encode($json));
	}

	public function auto_sync($route = '', $request = '', $response = '') {

	  $this->load->language('xero/customer');

	  $json = array();

	  $count = 0;

		$customer_id = 0;

		if ($response) {
			$customer_id = $response;
		} elseif (isset($request[0]) && $request[0]) {
			$customer_id = $request[0];
		}

		$data = array(
			'customer_id' => $customer_id,
		);

	  $this->registry->set('xero', new Xero($this->registry));

	  if ($this->config->get('module_opc_xero_status') && $this->config->get('module_opc_xero_auto_sync')) {
      $customers = $this->xero->getCustomersToSync($data);

      if ($customers) {
        $count = $this->xero->syncCustomerToXero($customers);
      }
	  }

	  $json['success'] = sprintf($this->language->get('text_success_customer'), $count);

	  $this->response->addHeader('Content-Type: application/json');
	  $this->response->setOutput(json_encode($json));
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_email'])) {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_email'])) {
				$filter_email = $this->request->get['filter_email'];
			} else {
				$filter_email = '';
			}

			$this->load->model('xero/customer');

			$filter_data = array(
				'filter_name'      => $filter_name,
				'filter_email'     => $filter_email,
				'start'            => 0,
				'limit'            => 5
			);

			$results = $this->model_xero_customer->getCustomers($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'customer_id'       => $result['customer_id'],
					'name'              => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'firstname'         => $result['firstname'],
					'lastname'          => $result['lastname'],
					'email'             => $result['email'],
					'telephone'         => $result['telephone'],
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
