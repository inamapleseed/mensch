<?php 
class ControllerExtensionModuleCustom5 extends controller {
	public function index() {
		$array = array(
            'oc' => $this,
            'heading_title' => 'Background Colors and more',
            'modulename' => 'custom5',
            'fields' => array(
                    array('type' => 'image', 'label' => 'Product Listing - Background Image', 'name' => 'bg_image1'),
                    array('type' => 'image', 'label' => 'About Page - Background Image', 'name' => 'bg_image2'),
                    array('type' => 'image', 'label' => 'Booking Page - Background Image', 'name' => 'bg_image3'),
                    array('type' => 'image', 'label' => 'Blog Page - Background Image', 'name' => 'bg_image4'),
                    array('type' => 'image', 'label' => 'Contact Page - Background Image', 'name' => 'bg_image5'),
                    array('type' => 'text', 'label' => 'Product Inner - Features Background Color', 'name' => 'bg2'),
            )
        );
        $this->modulehelper->init($array);
	}
}