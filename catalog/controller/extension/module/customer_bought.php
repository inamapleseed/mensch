<?php
class ControllerExtensionModuleCustomerBought extends Controller {
	private static $module_id = 1;

	public function index() {

		$language_id = $this->config->get('config_language_id');
		$modulename  = 'customer_bought';
		
		$data['heading_title'] = $this->modulehelper->get_field ( $this, $modulename, $language_id, 'title');

		$this->document->addStyle('catalog/view/javascript/slick/slick.min.css');
		$this->document->addScript('catalog/view/javascript/slick/slick-custom.min.js');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		// << Related Options
		if ( !$this->model_module_related_options ) {
			$this->load->model('module/related_options');
		}
		// >> Related Options

		$data['products'] = array();
		$product_infos = $this->model_catalog_product->getCustomerBought();
		foreach($product_infos as $product){
			$data['products'][] = $this->load->controller('component/product_info', $product['product_id']);
		}
		
		$data['uqid'] = 1001;
		if(count($data['products'])){
			return $this->load->view('extension/module/customer_bought', $data);
		}
	}
}