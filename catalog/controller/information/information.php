<?php
class ControllerInformationInformation extends Controller {
	public function index() {
		$this->load->language('information/information');

		$this->load->model('catalog/information');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
	
		$data['bg'] = $this->load->controller('extension/module/custom5/migrate');
		// debug($data['bg']);

		$information_id = 0;
	
		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			
			$this->document->setTitle($information_info['meta_title']);
			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);


			$data['information_repeater_info'] = array();

			$information_repeater_info  = $this->model_catalog_information->getInformationRepeater($information_id);
			$image_direction = '';
			
			if(isset($information_repeater_info) && $information_repeater_info) {
				foreach($information_repeater_info as $info) {

					if($info['row_type'] == 'image_left') {
						$image_direction = 'ltr';
					}
					if($info['row_type'] == 'image_right') {
						$image_direction = 'rtl';
					}
					if($info['row_type'] == 'fullwidth_top') {
						$image_direction = 'ttb';
					}
					if($info['row_type'] == 'fullwidth_bottom') {
						$image_direction = 'btt';
					}

					$data['information_repeater_info'][] =array(
						'information_repeater_id' => $info['information_repeater_id'],
						'language_id' => $info['language_id'],
						'information_id' => $info['information_id'],
						'type' => $info['type'],
						'row_type' => $info['row_type'] == 'image_left' || $info['row_type'] == 'image_right' ? 'flex' : 'fullwidth flex',
						'image_direction' => $image_direction,
						'description' => $info['description'],
						'image' => $info['image'],
					);
				}
			}

			// $data['information_repeater_info'] 

			$data['breadcrumbs'][] = array(
				'text' => $information_info['title'],
				'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
			);

			$data['heading_title'] = $information_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$this->load->model('tmdform/form');
			$data['informationlinks'] ='';
			$data['informationlinks'] = $this->model_tmdform_form->getInformationform($information_id);
        	$data['logged'] = $this->customer->isLogged();

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('information/information', $data));
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/information', 'information_id=' . $information_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

	public function agree() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}
}