<?php
class ControllerExtensionModuleTimeSales extends Controller {
	public function index() {
        // Do note that below are the sample for using module helper, you may use it in other modules

		$array = array(
            'oc' => $this,
            'heading_title' => 'Time Sales',
            'modulename' => 'time_sales',
            'fields' => array(
                array('type' => 'text', 'label' => 'Title', 'name' => 'title'),
            ),
        );
        $this->modulehelper->init($array);
	}
}