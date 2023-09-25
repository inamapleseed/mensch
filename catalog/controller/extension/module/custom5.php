<?php
class ControllerExtensionModuleCustom5 extends Controller {
	public function index() {
		// Handle custom2 fields
		$oc = $this;
		$language_id = $this->config->get('config_language_id');
		$modulename  = 'custom5';
	    $this->load->library('modulehelper');
	    $Modulehelper = Modulehelper::get_instance($this->registry);

		$data['repeater'] = $Modulehelper->get_field ( $oc, $modulename, $language_id, 'repeater' );

		return $this->load->view('extension/module/custom5', $data);
	}
	public function migrate() {
		// Handle custom2 fields
		$oc = $this;
		$language_id = $this->config->get('config_language_id');
		$modulename  = 'custom5';
	    $this->load->library('modulehelper');
	    $Modulehelper = Modulehelper::get_instance($this->registry);

		$data['product_listing'] = $Modulehelper->get_field ( $oc, $modulename, $language_id, 'bg_image1' );
		$data['about'] = $Modulehelper->get_field ( $oc, $modulename, $language_id, 'bg_image3' );
		$data['booking'] = $Modulehelper->get_field ( $oc, $modulename, $language_id, 'bg_image2' );
		$data['blog'] = $Modulehelper->get_field ( $oc, $modulename, $language_id, 'bg_image4' );
		$data['contacts'] = $Modulehelper->get_field ( $oc, $modulename, $language_id, 'bg_image5' );
		$data['featuresbg'] = $Modulehelper->get_field ( $oc, $modulename, $language_id, 'bg2' );

		return $data;
	}
}