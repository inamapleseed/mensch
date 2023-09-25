<?php
class ControllerCatalogAppointment extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/appointment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/appointment');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/appointment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/appointment');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_appointment->addAppointment($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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

			$this->response->redirect($this->url->link('catalog/appointment', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/appointment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/appointment');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_appointment->editAppointment($this->request->get['appointment_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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

			$this->response->redirect($this->url->link('catalog/appointment', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/appointment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/appointment');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $appointment_id) {
				$this->model_catalog_appointment->deleteAppointment($appointment_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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

			$this->response->redirect($this->url->link('catalog/appointment', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
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
			'href' => $this->url->link('catalog/appointment', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['insert'] = $this->url->link('catalog/appointment/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/appointment/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['appointments'] = array();

		$filter_data = array(
			'filter_name'    => $filter_name,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$appointment_total = $this->model_catalog_appointment->getTotalAppointment($filter_data);

		$results = $this->model_catalog_appointment->getAppointments($filter_data);

		foreach ($results as $result) {
			$calendar_events = $this->model_catalog_appointment->getCalendarEvent($result['event_id']);

			$data['appointments'][] = array(
				'appointment_id' => $result['appointment_id'],
				'event'     => $calendar_events['name'],
				'name'      => $result['name'],
				'contact'   => $result['contact'],
				'date'      => date('d M Y', strtotime($result['date'])),
				'time'      => $result['time'],
				'outlet'    => $result['outlet'],
				'edit'      => $this->url->link('catalog/appointment/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['entry_name'] = $this->language->get('entry_name');

		$data['column_event'] = $this->language->get('column_event');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_contact'] = $this->language->get('column_contact');
		$data['column_date'] = $this->language->get('column_date');
		$data['column_time'] = $this->language->get('column_time');
		$data['column_outlet'] = $this->language->get('column_outlet');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/appointment', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/appointment', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $appointment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/appointment', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($appointment_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($appointment_total - $this->config->get('config_limit_admin'))) ? $appointment_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $appointment_total, ceil($appointment_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/appointment_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['appointment_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');

		$data['text_add'] = $this->language->get('text_add');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_event'] = $this->language->get('text_event');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['entry_event'] = $this->language->get('entry_event');
		$data['entry_name'] = $this->language->get('entry_name');
        $data['entry_date'] = $this->language->get('entry_date');
        $data['entry_time'] = $this->language->get('entry_time');
        $data['entry_contact'] = $this->language->get('entry_contact');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_outlet'] = $this->language->get('entry_outlet');
        $data['entry_message'] = $this->language->get('entry_message');

		// Enhanced CKEditor
		if (!file_exists(DIR_CATALOG.'../vqmod/xml/enhanced_file_manager.xml') || file_exists(DIR_CATALOG.'../vqmod/xml/enhanced_file_manager.xml_')) {				
			$data['fm_installed'] = 0;
		}
		if (file_exists(DIR_CATALOG.'../vqmod/xml/enhanced_file_manager.xml') && $this->config->get('fm_installed') == 1) {				
			$data['fm_installed'] = 1;
		}
		
		if ($this->config->get('ea_cke_enable_ckeditor') == 1) {
			$data['ckeditor_enabled'] = 1;
		}
		else {
			$data['ckeditor_enabled'] = 0;
		}
		
		if ($this->config->get('ea_cke_ckeditor_skin')) {
			$data['ckeditor_skin'] = $this->config->get('ea_cke_ckeditor_skin');
		}
		else {
			$data['ckeditor_skin'] = 'moono-lisa';
		}
		
		if ($this->config->get('ea_cke_codemirror_skin')) {
			$data['codemirror_skin'] = $this->config->get('ea_cke_codemirror_skin');
		}
		else {
			$data['codemirror_skin'] = 'eclipse';
		}
		// Enhanced CKEditor	

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['event'])) {
			$data['error_event'] = $this->error['event'];
		} else {
			$data['error_event'] = '';
		}

		if (isset($this->error['date'])) {
			$data['error_date'] = $this->error['date'];
		} else {
			$data['error_date'] = '';
		}

		if (isset($this->error['time'])) {
			$data['error_time'] = $this->error['time'];
		} else {
			$data['error_time'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('catalog/appointment', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		if (!isset($this->request->get['appointment_id'])) {
			$data['action'] = $this->url->link('catalog/appointment/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/appointment/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/appointment', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['appointment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$appointment_info = $this->model_catalog_appointment->getAppointment($this->request->get['appointment_id']);
		}

		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['calendar_events'] = $this->model_catalog_appointment->getCalendarEvents();
        
        if (isset($this->request->post['event'])) {
			$data['event'] = $this->request->post['event'];
		} elseif (!empty($appointment_info)) {
			$data['event'] = $appointment_info['event_id'];
		} else {
			$data['event'] = 0;
		}
        
        if (isset($this->request->post['date'])) {
			$data['date'] = $this->request->post['date'];
		} elseif (!empty($appointment_info)) {
			$data['date'] = $appointment_info['date'];
		} else {
			$data['date'] = '';
		}
        
        if (isset($this->request->post['time'])) {
			$data['time'] = $this->request->post['time'];
		} elseif (!empty($appointment_info)) {
			$data['time'] = $appointment_info['time'];
		} else {
			$data['time'] = '';
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($appointment_info)) {
			$data['name'] = $appointment_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['contact'])) {
			$data['contact'] = $this->request->post['contact'];
		} elseif (!empty($appointment_info)) {
			$data['contact'] = $appointment_info['contact'];
		} else {
			$data['contact'] = '';
		}
        
        if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($appointment_info)) {
			$data['email'] = $appointment_info['email'];
		} else {
			$data['email'] = '';
		}
        
        if (isset($this->request->post['outlet'])) {
			$data['outlet'] = $this->request->post['outlet'];
		} elseif (!empty($appointment_info)) {
			$data['outlet'] = $appointment_info['outlet'];
		} else {
			$data['outlet'] = '';
		}
        
        if (isset($this->request->post['message'])) {
			$data['message'] = $this->request->post['message'];
		} elseif (!empty($appointment_info)) {
			$data['message'] = $appointment_info['message'];
		} else {
			$data['message'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/appointment_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/appointment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['event']) == "") {
			$this->error['event'] = $this->language->get('error_event');
		}

		if (utf8_strlen($this->request->post['date']) == "") {
			$this->error['date'] = $this->language->get('error_date');
		}

		if (utf8_strlen($this->request->post['time']) == "") {
			$this->error['time'] = $this->language->get('error_time');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/appointment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}