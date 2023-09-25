<?php
class ControllerCommonSearch extends Controller {
	public function index() {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}
		$data['config_display_header_search_icon']  = $this->config->get('config_display_header_search_icon');

		$data['display_search'] = false;
		$data['popup_search'] = $data['searchbar'] = false;

		if($data['config_display_header_search_icon'] != 'none') { 
			$data['display_search'] = true;
			if($data['config_display_header_search_icon'] == 'popup') {
				$data['popup_search'] = true;
			}else {
				$data['searchbar'] = true;
			}
		}

		return $this->load->view('common/header/search', $data);
	}
}