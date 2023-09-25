<?php
	class ControllerInformationStores extends Controller {
		public function index() {
			$this->load->language('information/stores');

			$this->document->setTitle($this->language->get('heading_title'));

			$this->load->model('tool/image');
			$this->load->model('localisation/location');

			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);
			
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('information/contact')
			);
			$data['heading_title'] = $this->language->get('heading_title');
			$data['locations'] = array();
			
			$store_location_layout = $data['store_location_layout'] = $this->config->get('config_store_location_layout');

			if($store_location_layout == 'layout_3') {
				foreach((array)$this->config->get('config_location') as $location_id) {
					$location_info = $this->model_localisation_location->getLocation($location_id);
					
					if ($location_info) {
						if ($location_info['image']) {
							$image = $this->model_tool_image->resize($location_info['image'], $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
						}
						else {
							$image = false;
						}
						
						$data['locations'][$location_info['region']][] = array(
						'location_id' => $location_info['location_id'],
						'name'        => $location_info['name'],
						'address'     => nl2br($location_info['address']),
						'geocode'     => str_replace(" ", "", $location_info['geocode']),
						'telephone'   => $location_info['telephone'],
						'region'   => $location_info['region'],
						'fax'         => $location_info['fax'],
						'image'       => 'image/'.$location_info['image'],
						'open'        => nl2br($location_info['open']),
						'comment'     => $location_info['comment'],
						'gmap_iframe'     => html($location_info['gmap_iframe']),
						);
					}
				}
			}else {
				foreach((array)$this->config->get('config_location') as $location_id) {
					$location_info = $this->model_localisation_location->getLocation($location_id);
					
					if ($location_info) {
						if ($location_info['image']) {
							$image = $this->model_tool_image->resize($location_info['image'], $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
						}
						else {
							$image = false;
						}
						
						$data['locations'][] = array(
						'location_id' => $location_info['location_id'],
						'name'        => $location_info['name'],
						'address'     => nl2br($location_info['address']),
						'geocode'     => str_replace(" ", "", $location_info['geocode']),
						'telephone'   => $location_info['telephone'],
						'region'   => $location_info['region'],
						'fax'         => $location_info['fax'],
						'image'       => 'image/'.$location_info['image'],
						'open'        => nl2br($location_info['open']),
						'comment'     => $location_info['comment'],
						'gmap_iframe'     => html($location_info['gmap_iframe']),
						);
					}
				}
			}

			$data = $this->load->controller('component/common', $data);

			$this->response->setOutput($this->load->view('information/stores_'.$store_location_layout, $data));
		}
    }
?>