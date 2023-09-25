<?php 
class ControllerExtensionModuleCustom2 extends controller {
	public function index() {
		$array = array(
            'oc' => $this,
            'heading_title' => 'Homepage Slider',
            'modulename' => 'custom2',
            'fields' => array(
                array('type' => 'repeater', 'label' => 'Content', 'name' => 'repeater', 'fields' => array(
                    array('type' => 'image', 'label' => 'Desktop Image', 'name' => 'image'),
                    array('type' => 'image', 'label' => 'Mobile Image', 'name' => 'mobile_image'),
                    array('type' => 'textarea', 'label' => 'Title 1', 'name' => 'title1', 'ckeditor' => true),
                    array('type' => 'textarea', 'label' => 'Title 2', 'name' => 'title2'),
                    array('type' => 'textarea', 'label' => 'Title 3', 'name' => 'title3'),
                    array('type' => 'text', 'label' => 'Button Title', 'name' => 'btntitle'),
                    array('type' => 'text', 'label' => 'Button Link', 'name' => 'btnlink'),
                )),
            ),
        );
        $this->modulehelper->init($array);
	}
}