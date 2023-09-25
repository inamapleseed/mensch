<?php
class ControllerExtensionModuleCustomerBought extends Controller {
	public function index() {
        // Do note that below are the sample for using module helper, you may use it in other modules

		$array = array(
            'oc' => $this,
            'heading_title' => 'Customer Bought',
            'modulename' => 'customer_bought',
            'fields' => array(
                array('type' => 'text', 'label' => 'Title', 'name' => 'title'),
                array('type' => 'text', 'label' => 'Limit', 'name' => 'limit'),
                array('type' => 'text', 'label' => 'Show', 'name' => 'show'),
            ),
        );
        $this->modulehelper->init($array);
	}
}