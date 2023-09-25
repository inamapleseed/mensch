<?php
class ControllerContactEnquiryContactEnquiry extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('contact_enquiry/contact_enquiry');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('contact_enquiry/contact_enquiry');

		$this->getList();
	}

	public function changeStatus() {
                $contact_status = $this->request->get['contact_status'];
                $contact_id = $this->request->get['contact_id'];
                $this->db->query("UPDATE ".DB_PREFIX."contact SET contact_status = '" . $contact_status. "' WHERE contact_id = '" . $contact_id . "'");
                
                $this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode(array("status"=>1)));
	}
        
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_contact_name']) || isset($this->request->get['filter_contact_phone']) || isset($this->request->get['filter_contact_email'])) {
			if (isset($this->request->get['filter_contact_name'])) {
				$filter_contact_name = $this->request->get['filter_contact_name'];
			} else {
				$filter_contact_name = '';
			}

			if (isset($this->request->get['filter_contact_phone'])) {
				$filter_contact_phone = $this->request->get['filter_contact_phone'];
			} else {
				$filter_contact_phone = '';
			}
                        
			if (isset($this->request->get['filter_contact_email'])) {
				$filter_contact_email = $this->request->get['filter_contact_email'];
			} else {
				$filter_contact_email = '';
			}
            
			if (isset($this->request->get['filter_contact_message'])) {
				$filter_contact_message = $this->request->get['filter_contact_message'];
			} else {
				$filter_contact_message = '';
			}

			$this->load->model('contact_enquiry/contact_enquiry');

			$filter_data = array(
				'filter_contact_name'  => $filter_contact_name,
				'filter_contact_phone' => $filter_contact_phone,
				'filter_contact_email' => $filter_contact_email,
				'filter_contact_message' => $filter_contact_message,
				'start'                 => 0,
				'limit'                 => 5
			);
                        
			$results = $this->model_contact_enquiry_contact_enquiry->getContacts($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'contact_id'    => $result['contact_id'],
					'name'          => strip_tags(html_entity_decode($result['contact_name'], ENT_QUOTES, 'UTF-8')),
					'email'         => $result['contact_email'],
					'phone'         => $result['contact_phone']
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
        
	protected function getList() {
		if (isset($this->request->get['filter_contact_name'])) {
			$filter_contact_name = $this->request->get['filter_contact_name'];
		} else {
			$filter_contact_name = null;
		}
                
        if (isset($this->request->get['filter_contact_phone'])) {
			$filter_contact_phone = $this->request->get['filter_contact_phone'];
		} else {
			$filter_contact_phone = null;
		}
                
        if (isset($this->request->get['filter_contact_email'])) {
			$filter_contact_email = $this->request->get['filter_contact_email'];
		} else {
			$filter_contact_email = null;
		}
                
        if (isset($this->request->get['filter_contact_message'])) {
			$filter_contact_message = $this->request->get['filter_contact_message'];
		} else {
			$filter_contact_message = null;
		}
                
        if (isset($this->request->get['filter_contact_date'])) {
			$filter_contact_date = $this->request->get['filter_contact_date'];
		} else {
			$filter_contact_date = null;
		}
                
        if (isset($this->request->get['filter_contact_status'])) {
			$filter_contact_status = $this->request->get['filter_contact_status'];
		} else {
			$filter_contact_status = null;
		}
                
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'contact_date';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_contact_name'])) {
			$url .= '&filter_contact_name=' . urlencode(html_entity_decode($this->request->get['filter_contact_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_contact_phone'])) {
			$url .= '&filter_contact_phone=' . urlencode(html_entity_decode($this->request->get['filter_contact_phone'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_contact_email'])) {
			$url .= '&filter_contact_email=' . urlencode(html_entity_decode($this->request->get['filter_contact_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_contact_message'])) {
			$url .= '&filter_contact_message=' . urlencode(html_entity_decode($this->request->get['filter_contact_message'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_contact_date'])) {
			$url .= '&filter_contact_date=' . urlencode(html_entity_decode($this->request->get['filter_contact_date'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_contact_status'])) {
			$url .= '&filter_contact_status=' . urlencode(html_entity_decode($this->request->get['filter_contact_status'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['searchs'] = array();

		$filter_data = array(
			'filter_contact_name'      => $filter_contact_name,
			'filter_contact_phone'     => $filter_contact_phone,
			'filter_contact_email'     => $filter_contact_email,
			'filter_contact_message'   => $filter_contact_message,
			'filter_contact_date'      => $filter_contact_date,
			'filter_contact_status'    => $filter_contact_status,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$search_total = $this->model_contact_enquiry_contact_enquiry->getTotalContacts($filter_data);
                
		$results = $this->model_contact_enquiry_contact_enquiry->getContacts($filter_data);

        $data['enquirys'] = array();
		foreach ($results as $result) {

            $data['enquirys'][] = array(
                'contact_id'        => $result['contact_id'],
                'contact_name'      => $result['contact_name'],
                'contact_phone'     => $result['contact_phone'],
                'contact_email'     => $result['contact_email'],
                'contact_email_send_to' => $result['contact_email_send_to'],
                'contact_subject'   => $result['contact_subject'],
                'contact_message'   => $result['contact_message'],
                'contact_date'      => $result['contact_date'],
                'contact_time'      => $result['contact_time'],
                'contact_status'    => $result['contact_status']
            );
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_customer_group'] = $this->language->get('column_customer_group');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_approved'] = $this->language->get('column_approved');
		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_reward'] = $this->language->get('column_reward');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_approved'] = $this->language->get('entry_approved');
		$data['entry_ip'] = $this->language->get('entry_ip');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_login'] = $this->language->get('button_login');
		$data['button_unlock'] = $this->language->get('button_unlock');

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

		if (isset($this->request->get['filter_contact_name'])) {
			$url .= '&filter_contact_name=' . urlencode(html_entity_decode($this->request->get['filter_contact_name'], ENT_QUOTES, 'UTF-8'));
		}
                
		if (isset($this->request->get['filter_contact_phone'])) {
			$url .= '&filter_contact_phone=' . urlencode(html_entity_decode($this->request->get['filter_contact_phone'], ENT_QUOTES, 'UTF-8'));
		}
                
		if (isset($this->request->get['filter_contact_email'])) {
			$url .= '&filter_contact_email=' . urlencode(html_entity_decode($this->request->get['filter_contact_email'], ENT_QUOTES, 'UTF-8'));
		}
                
		if (isset($this->request->get['filter_contact_message'])) {
			$url .= '&filter_contact_message=' . urlencode(html_entity_decode($this->request->get['filter_contact_message'], ENT_QUOTES, 'UTF-8'));
		}
                
		if (isset($this->request->get['filter_contact_date'])) {
			$url .= '&filter_contact_date=' . urlencode(html_entity_decode($this->request->get['filter_contact_date'], ENT_QUOTES, 'UTF-8'));
		}
                
		if (isset($this->request->get['filter_contact_status'])) {
			$url .= '&filter_contact_status=' . urlencode(html_entity_decode($this->request->get['filter_contact_status'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_contact_name']      = $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'] . '&sort=contact_name' . $url, true);
		$data['sort_contact_phone']     = $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'] . '&sort=contact_phone' . $url, true);
		$data['sort_contact_email']     = $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'] . '&sort=contact_email' . $url, true);
		$data['sort_contact_email_sendto'] = $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'] . '&sort=contact_email_send_to' . $url, true);
		$data['sort_contact_message']   = $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'] . '&sort=contact_message' . $url, true);
		$data['sort_contact_date']      = $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'] . '&sort=contact_date' . $url, true);
		$data['sort_contact_status']    = $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'] . '&sort=contact_status' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_contact_name'])) {
			$url .= '&filter_contact_name=' . urlencode(html_entity_decode($this->request->get['filter_contact_name'], ENT_QUOTES, 'UTF-8'));
		}
                
		if (isset($this->request->get['filter_contact_phone'])) {
			$url .= '&filter_contact_phone=' . urlencode(html_entity_decode($this->request->get['filter_contact_phone'], ENT_QUOTES, 'UTF-8'));
		}
                
		if (isset($this->request->get['filter_contact_email'])) {
			$url .= '&filter_contact_email=' . urlencode(html_entity_decode($this->request->get['filter_contact_email'], ENT_QUOTES, 'UTF-8'));
		}
                
		if (isset($this->request->get['filter_contact_message'])) {
			$url .= '&filter_contact_message=' . urlencode(html_entity_decode($this->request->get['filter_contact_message'], ENT_QUOTES, 'UTF-8'));
		}
                
		if (isset($this->request->get['filter_contact_date'])) {
			$url .= '&filter_contact_date=' . urlencode(html_entity_decode($this->request->get['filter_contact_date'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_contact_status'])) {
			$url .= '&filter_contact_status=' . $this->request->get['filter_contact_status'];
		}
                
		$pagination = new Pagination();
		$pagination->total = $search_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('contact_enquiry/contact_enquiry', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($search_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($search_total - $this->config->get('config_limit_admin'))) ? $search_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $search_total, ceil($search_total / $this->config->get('config_limit_admin')));

		$data['filter_contact_name']    = $filter_contact_name;
		$data['filter_contact_phone']   = $filter_contact_phone;
		$data['filter_contact_email']   = $filter_contact_email;
		$data['filter_contact_message']    = $filter_contact_message;
		$data['filter_contact_date']    = $filter_contact_date;
		$data['filter_contact_status']  = $filter_contact_status;
                
		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
                
		$this->response->setOutput($this->load->view('contact_enquiry/contact_enquiry', $data));
	}
}
