<?php 
class ControllerExtensionModuleCustom4 extends controller {
	public function index() {
        $choices = array(
            array(
                'label' => 'Black',
                'value' => '#000',
            ),
            array(
                'label' => 'White',
                'value' => '#fff',
            ),
        );

		$array = array(
            'oc' => $this,
            'heading_title' => 'Homepage - Features',
            'modulename' => 'custom4',
            'fields' => array(
                array('type' => 'repeater', 'label' => 'Content', 'name' => 'repeater', 'fields' => array(
                    array('type' => 'image', 'label' => 'Image', 'name' => 'image'),
                    array('type' => 'text', 'label' => 'Title', 'name' => 'title'),
                    array('type' => 'textarea', 'label' => 'Short Description', 'name' => 'text', 'ckeditor' => true),
                    array('type' => 'text', 'label' => 'Link', 'name' => 'link'),
                    array('type' => 'dropdown', 'label' => 'Text Color', 'name' => 'color', 'choices' => $choices),
                )),
            ),
        );
        $this->modulehelper->init($array);
	}
}