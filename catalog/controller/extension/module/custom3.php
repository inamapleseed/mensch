<?php
class ControllerExtensionModuleCustom3 extends Controller {
	public function index() {
		// Handle custom2 fields
		$oc = $this;
		$language_id = $this->config->get('config_language_id');
		$modulename  = 'custom3';
	    $this->load->library('modulehelper');
	    $Modulehelper = Modulehelper::get_instance($this->registry);

		$data['title'] = $Modulehelper->get_field ( $oc, $modulename, $language_id, 'title' );

		$this->load->model('catalog/product');
		$product_info = $this->model_catalog_product->getProducts();

		foreach($product_info as $prod_info) {
			// get specs
			$data['specs'] = $this->model_catalog_product->getProductSpecs($prod_info['product_id']);

			// get products w/ specs only
			if($data['specs']){
				foreach($data['specs'] as $specs){
					$data['id_with_specs'] = $specs['product_id'];
				}

				$data['product_w_specs'][] = $this->model_catalog_product->getProduct($data['id_with_specs']);
				$data['specs2'][] = $this->model_catalog_product->getProductSpecs($data['id_with_specs']);
			}
		}
		foreach($data['product_w_specs'] as $pwspecs){
			$data['der_products'][] = array(
				'product_id' => $pwspecs['product_id'],
				'image'		=> $pwspecs['image'],
				'name'		=> $pwspecs['name'],
				'price'		=> $pwspecs['price'],
				'special'	=> $pwspecs['special'],
			);
		}

		return $this->load->view('extension/module/custom3', $data);
	}
}
