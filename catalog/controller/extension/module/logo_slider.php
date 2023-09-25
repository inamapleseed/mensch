<?php
class ControllerExtensionModuleLogoSlider extends Controller {
	public function index($setting) {
		// if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
		// 	$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
		// 	$data['html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
		//
		// 	return $this->load->view('extension/module/html', $data);
		// }
		$oc = $this;
		$language_id = $this->config->get('config_language_id');
		$modulename  = 'logo_slider';

		$this->document->addStyle('catalog/view/javascript/slick/slick.min.css');
		$this->document->addScript('catalog/view/javascript/slick/slick-custom.min.js');

		$this->load->library('modulehelper');
		$Modulehelper = Modulehelper::get_instance($this->registry);
		$data = array(
			'main_title'  	   => $Modulehelper->get_field ( $oc, $modulename, $language_id, 'main_title'),
			'items'  	   => $Modulehelper->get_field ( $oc, $modulename, $language_id, 'items'),
		);

		return $this->load->view('extension/module/logo_slider', $data);
	}
}
