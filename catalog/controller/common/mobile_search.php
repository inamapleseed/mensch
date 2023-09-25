<?php
class ControllerCommonMobileSearch extends Controller {
	public function index() {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}
		$data['config_display_header_search_icon']  = $this->config->get('config_display_header_search_icon');

		$data['searchbar'] = true;

		return $this->load->view('common/header/mobile_search', $data);
	}
}