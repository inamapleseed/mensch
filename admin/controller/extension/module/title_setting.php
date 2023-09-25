<?php
class ControllerExtensionModuleTitleSetting extends Controller {
	public function index() {
        // Do note that below are the sample for using module helper, you may use it in other modules

		$array = array(
            'oc' => $this,
            'heading_title' => 'Title Setting',
            'modulename' => 'title_setting',
            'fields' => array(
                array('type' => 'text', 'label' => 'Related Product Title', 'name' => 'related_product_title'),
            ),
        );
        $this->modulehelper->init($array);
	}
}