<?php
class ControllerExtensionModuleContactFormWithMap extends Controller {
	public function index() {
        // Do note that below are the sample for using module helper, you may use it in other modules

        $choices = array(
            array(
                'label' => 'Left',
                'value' => 'left',
            ),
            array(
                'label' => 'Right',
                'value' => 'right',
            ),
        );

		$array = array(
            'oc' => $this,
            'heading_title' => 'Contact Form With Map',
            'modulename' => 'contact_form_with_map',
            'fields' => array(
                array('type' => 'text', 'label' => 'Title', 'name' => 'title'),
                array('type' => 'text', 'label' => 'Form Title', 'name' => 'form_title'),
                array('type' => 'text', 'label' => 'Background Color(E.g #000000)', 'name' => 'background_color'),
                array('type' => 'image', 'label' => 'Background Image', 'name' => 'background_image'),
                array('type' => 'text', 'label' => 'Text Color', 'name' => 'text_color'),
                array('type' => 'dropdown', 'label' => 'Map Position', 'name' => 'map_position', 'choices' => $choices),
                array('type' => 'textarea', 'label' => 'Map iFrame', 'name' => 'map_iframe'),
                array('type' => 'repeater', 'label' => 'Contact Details', 'name' => 'contact_details',
                'fields' => array(
                    array('type' => 'image', 'label' => 'Image', 'name' => 'image'),
                    array('type' => 'text', 'label' => 'Label', 'name' => 'label'),
                    array('type' => 'textarea', 'label' => 'Text', 'name' => 'text', 'ckeditor'=>true),
                ),
                
            ),
            ),
        );
        $this->modulehelper->init($array);
	}
}