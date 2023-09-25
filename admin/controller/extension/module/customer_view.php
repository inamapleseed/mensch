<?php
class ControllerExtensionModuleCustomerView extends Controller {
	public function index() {
        // Do note that below are the sample for using module helper, you may use it in other modules

		$array = array(
            'oc' => $this,
            'heading_title' => 'Customer View',
            'modulename' => 'customer_view',
            'fields' => array(
                array('type' => 'text', 'label' => 'Title', 'name' => 'title'),
                array('type' => 'text', 'label' => 'Limit', 'name' => 'view'),
                array('type' => 'text', 'label' => 'Show', 'name' => 'show'),
            ),
        );
        $this->modulehelper->init($array);
	}
}