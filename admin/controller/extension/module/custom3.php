<?php 
class ControllerExtensionModuleCustom3 extends controller {
	public function index() {
		$array = array(
            'oc' => $this,
            'heading_title' => 'Compare The Models',
            'modulename' => 'custom3',
            'fields' => array(
                // array('type' => 'repeater', 'label' => 'Content', 'name' => 'repeater', 'fields' => array(
                //     array('type' => 'image', 'label' => 'Image', 'name' => 'image'),
                    array('type' => 'text', 'label' => 'Section Title', 'name' => 'title'),
                //     array('type' => 'textarea', 'label' => 'Text Content', 'name' => 'text', 'ckeditor' =>true),
                // )),
            ),
        );
        $this->modulehelper->init($array);
	}
}