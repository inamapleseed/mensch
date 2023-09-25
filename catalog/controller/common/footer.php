<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		/* extension bganycombi - Buy Any Get Any Product Combination Pack */
		$data['bganycombi_module'] = $this->load->controller('extension/bganycombi');
		// Echo mailchimp
		$data['mailchimp'] = ''	;
		if ($this->config->get('newsletter_module_status')) $data['mailchimp'] = $this->load->controller('extension/module/newsletter_module');

		// Please get license key for this mailchimp extension before use it thanks
		//if ($this->config->get('mailchimp_integration_status')) $data['mailchimp'] = $this->load->controller('module/mailchimp_integration');
			
		$this->load->language('common/footer');

		//Theme Settings
		//Header Settings
		$data['config_header_layout'] = $this->config->get('config_header_layout');
		
		$data['config_primary_button_border_radius'] = $this->config->get('config_primary_button_border_radius');

		$data['config_header_letter_case'] = $this->config->get('config_header_letter_case');

		
		// Main Slider Settngs 
		$data['config_parallax_slider'] = $this->config->get('config_parallax_slider');


		// Load Theme Color 
		$data['config_font'] = $this->config->get('config_default_font');
		$data['config_primary_color'] = $this->config->get('config_primary_color');
		$data['config_secondary_color'] = $this->config->get('config_secondary_color');
		$data['config_icon_color'] = $this->config->get('config_icon_color');

		$data['config_section_padding'] = $this->config->get('config_section_padding');

		$data['config_h2_letter_case'] = $this->config->get('config_h2_letter_case');
		$data['config_h3_letter_case'] = $this->config->get('config_h3_letter_case');

		// Footer Style
		$data['config_footer_background_color'] = $this->config->get('config_footer_background_color');
		$data['config_footer_background_color2'] = $this->config->get('config_footer_background_color2');
		$data['config_footer_color2'] = $this->config->get('config_footer_color2');
		$data['config_footer_bottom_background_color'] = $this->config->get('config_footer_bottom_background_color');
		$data['config_footer_bottom_text_color'] = $this->config->get('config_footer_bottom_text_color');
		$data['config_footer_bottom_link_color'] = $this->config->get('config_footer_bottom_link_color');
		$data['config_footer_link_color'] = $this->config->get('config_footer_link_color');
		$data['config_footer_link_hover_color'] = $this->config->get('config_footer_link_hover_color');
		$data['config_footer_text_color'] = $this->config->get('config_footer_text_color');

		// Button
		$data['config_primary_button_background_color'] = $this->config->get('config_primary_button_background_color');
		$data['config_primary_button_text_color'] = $this->config->get('config_primary_button_text_color');

		$data['config_button_border_width'] = $this->config->get('config_button_border_width');
		$data['config_button_border_radius'] = $this->config->get('config_button_border_radius');
		$data['config_primary_button_border_color'] = $this->config->get('config_primary_button_border_color');

		$data['config_secondary_button_text_color'] = $this->config->get('config_secondary_button_text_color');
		$data['config_secondary_button_background_color'] = $this->config->get('config_secondary_button_background_color');

		$data['config_secondary_button_border_width'] = $this->config->get('config_secondary_button_border_width');
		$data['config_secondary_button_border_color'] = $this->config->get('config_secondary_button_border_color');

		

		$data['primary_color_rgb'] = '';
		if($data['config_primary_color']) {
			$hex = $data['config_primary_color'];
			list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
			$data['primary_color_rgb'] = $r.','.$g.','.$b;
		}
		$data['hover_underline'] = false;


		$data['open'] = nl2br($this->config->get('config_open'));
		$data['comment'] = $this->config->get('config_comment');
		$data['gmap_iframe'] = html($this->config->get('config_gmap_iframe'));
		// Load Color and font
		$data['text_body_color']                = $this->config->get('text_body_color');
		$data['text_body_font']                = $this->config->get('text_body_font');
		$data['text_body_size']                = $this->config->get('text_body_size');

		$data['text_link_color']                = $this->config->get('text_link_color');
		$data['text_link_hover_color']        	= $this->config->get('text_link_hover_color');
		$data['text_menu_color']                = $this->config->get('text_menu_color');
		$data['text_menu_hover_color']        	= $this->config->get('text_menu_hover_color');
		$data['text_submenu_color']             = $this->config->get('text_submenu_color');
		$data['text_submenu_hover_color']       = $this->config->get('text_submenu_hover_color');
		$data['text_category_menu_color']       = $this->config->get('text_category_menu_color');
		$data['text_category_menu_hover_color'] = $this->config->get('text_category_menu_hover_color');
		$data['text_h2_color']                  = $this->config->get('text_h2_color');
		$data['text_h3_color']                  = $this->config->get('text_h3_color');
		$data['text_product_title_color']       = $this->config->get('text_product_title_color');
		$data['text_p_theme_color']        		= $this->config->get('text_p_theme_color');
		$data['text_footer_heading_color'] 		= $this->config->get('text_footer_heading_color');

		$data['text_link_font']                  = $this->config->get('text_link_font');
		$data['text_link_hover_font']            = $this->config->get('text_link_hover_font');
		$data['text_menu_font']                  = $this->config->get('text_menu_font');
		$data['text_menu_hover_font']            = $this->config->get('text_menu_hover_font');
		$data['text_category_menu_font']         = $this->config->get('text_category_menu_font');
		$data['text_category_menu_hover_font']   = $this->config->get('text_category_menu_hover_font');
		$data['text_h2_font']                    = $this->config->get('text_h2_font');
		$data['text_h3_font']                    = $this->config->get('text_h3_font');
		$data['text_p_light_font']               = $this->config->get('text_p_light_font');
		$data['text_p_dark_font']                = $this->config->get('text_p_dark_font');
		$data['text_product_title_font']         = $this->config->get('text_product_title_font');
		$data['text_pop_up_text_font']         = $this->config->get('text_pop_up_text_font');
		$data['text_p_theme_font']         = $this->config->get('text_p_theme_font');
		$data['text_footer_heading_font'] = $this->config->get('text_footer_heading_font');

		
		$data['text_link_size']                  = $this->config->get('text_link_size');
		$data['text_link_hover_size']            = $this->config->get('text_link_hover_size');
		$data['text_menu_size']                  = $this->config->get('text_menu_size');
		$data['text_menu_hover_size']            = $this->config->get('text_menu_hover_size');
		$data['text_category_menu_size']         = $this->config->get('text_category_menu_size');
		$data['text_category_menu_hover_size']   = $this->config->get('text_category_menu_hover_size');
		$data['text_h2_size']                    = $this->config->get('text_h2_size');
		$data['text_h3_size']                    = $this->config->get('text_h3_size');
		$data['text_p_light_size']               = $this->config->get('text_p_light_size');
		$data['text_p_dark_size']                = $this->config->get('text_p_dark_size');
		$data['text_product_title_size']         = $this->config->get('text_product_title_size');
		$data['text_pop_up_text_size']           = $this->config->get('text_pop_up_text_size');
		$data['text_p_theme_size']         		 = $this->config->get('text_p_theme_size');
		$data['text_footer_heading_size'] = $this->config->get('text_footer_heading_size');

		if($data['text_link_color']  == $data['text_link_hover_color']) {
			$data['hover_underline'] = true;
		}
		// color and font

		//category

		$data['h2_image'] 	= $this->config->get('config_h2_header_image');
		$data['h2_style'] 	= $this->config->get('config_header_style');
		$data['config_background_image'] 	= $this->config->get('config_background_image');
		$data['config_background_style'] 	= $this->config->get('config_background_style');
		$data['theme_default_product_box_background'] 				= $this->config->get('theme_default_product_box_background');
		$data['theme_default_product_box_border'] 				= $this->config->get('theme_default_product_box_border');
		$data['theme_default_product_box_padding'] 					= $this->config->get('theme_default_product_box_padding');
		$data['theme_default_product_box_radius'] 					= $this->config->get('theme_default_product_box_radius');
		
		$data['theme_default_product_box_hover'] 					= $this->config->get('theme_default_product_box_hover');
		$data['theme_default_product_box_category'] 				= $this->config->get('theme_default_product_box_category');
		$data['theme_default_product_box_brand'] 					= $this->config->get('theme_default_product_box_brand');

		$data['theme_default_product_category_level_one_margin'] 	= $this->config->get('theme_default_product_category_level_one_margin');
		$data['theme_default_product_category_level_one_radius'] 	= $this->config->get('theme_default_product_category_level_one_radius');
		$data['theme_default_product_category_level_one_border'] 	= $this->config->get('theme_default_product_category_level_one_border');
		$data['theme_default_product_category_price_color']	 		= $this->config->get('theme_default_product_category_price_color');
		$data['theme_default_product_category_layout_setting'] 		= $this->config->get('theme_default_product_category_layout_setting');
		$data['theme_default_product_category_listing'] 			= $this->config->get('theme_default_product_category_listing');
		$data['theme_default_product_sticker_radius'] 				= $this->config->get('theme_default_product_sticker_radius');
		$data['theme_default_product_sticker_padding'] 				= $this->config->get('theme_default_product_sticker_padding');
		$data['theme_default_product_sticker_position'] 			= $this->config->get('theme_default_product_sticker_position');
		$data['theme_default_product_align'] 						= $this->config->get('theme_default_product_align');

		$data['theme_default_product_category_level_one_padding'] 	= $this->config->get('theme_default_product_category_level_one_padding');
		$data['theme_default_product_category_level_two_padding'] 	= $this->config->get('theme_default_product_category_level_two_padding');
		$data['theme_default_product_category_level_three_padding'] = $this->config->get('theme_default_product_category_level_three_padding');
		$data['theme_default_product_category_level_four_padding'] 	= $this->config->get('theme_default_product_category_level_four_padding');

		$data['theme_default_product_category_level_one'] 			= $this->config->get('theme_default_product_category_level_one');
		$data['theme_default_product_category_level_one_hover'] 	= $this->config->get('theme_default_product_category_level_one_hover');
		$data['theme_default_product_category_text_level_one'] 		= $this->config->get('theme_default_product_category_text_level_one');
		$data['theme_default_product_category_text_level_one_hover'] = $this->config->get('theme_default_product_category_text_level_one_hover');

		$data['theme_default_product_category_level_two'] 			= $this->config->get('theme_default_product_category_level_two');
		$data['theme_default_product_category_level_two_hover'] 	= $this->config->get('theme_default_product_category_level_two_hover');
		$data['theme_default_product_category_text_level_two'] 		= $this->config->get('theme_default_product_category_text_level_two');
		$data['theme_default_product_category_text_level_two_hover'] = $this->config->get('theme_default_product_category_text_level_two_hover');
		//category

					

		$data['scripts'] = $this->document->getScripts('footer');

		$data['styles'] = $this->document->getStyles();

		$data['class'] = 'common-home';
		if (isset($this->request->get['route'])) {
			$data['class'] = str_replace('/', '-', $this->request->get['route']);
		}
		
        $data['update_price_status'] = $this->config->get('update_price_status');

		$data['text_address'] = $this->language->get('text_address');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_whatsapp'] = $this->language->get('text_whatsapp');
		$data['text_email'] = $this->language->get('text_email');

		$data['store']		= $this->config->get('config_name'); // In Store Tab - Store Name
		$data['comment']		= $this->config->get('config_comment');
		$data['address']	= nl2br($this->config->get('config_address'));
		$data['telephone']	= $this->config->get('config_telephone');
		$data['fax']		= $this->config->get('config_fax');
		$data['whatsapp']		= $this->config->get('config_whatsapp');
		$data['email']		= $this->config->get('config_email');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_fcs'] = $this->language->get('text_fcs');

		$this->language->load('extension/module/news_latest');
		$data['blog_url'] = $this->url->link('news/ncategory');
		$data['blog_name'] = $this->language->get('text_blogpage');
		
		/* xml */
		$this->load->model('tmdform/form');

		$data['forminfos'] = array();
		$data1 = array();
		$form_infos = $this->model_tmdform_form->getForms($data1);

		foreach ($form_infos as $forminfo) {
			if ($forminfo['footerlink']==1) {
				$data['forminfos'][] = array(
					'title' => $forminfo['title'],
					'href'  => $this->url->link('tmdform/form', 'form_id=' . $forminfo['form_id'])
				);
			}
		}	

		if(isset($this->request->get['form_id'])){
			$data['form_id'] = $this->request->get['form_id'];
		} else {
			$data['form_id'] = 0;
		}

		$forminfo = $this->model_tmdform_form->getForm($data['form_id']);
		if(isset($forminfo['title'])){
			$data['entry_title'] = $forminfo['title'];
		} else {
			$data['entry_title'] = $this->language->get('entry_formtitle');
		}

		$data['common_pop'] = $this->url->link('tmdform/popupform/popupformpage&form_id=');			
		/* xml */

		$this->load->model('catalog/information');
	
		$theme = $this->config->get('config_theme');
		$menu_id = $this->config->get($theme . "_footer");

		$data['menu'] = $this->load->controller('common/menu', $menu_id);

		$data['testimonial'] = array(
			'title' => 'Testimonials',
			'href'  => $this->url->link('testimonial/testimonial')
		);

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/account', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

		$data['powered'] = sprintf($this->language->get('text_powered'), date('Y', time()), $this->config->get('config_name'));

        $data['text_view_all_results'] = $this->config->get('live_search_view_all_results')[$this->config->get('config_language_id')]['name'];
		$data['live_search_ajax_status'] = $this->config->get('live_search_ajax_status');
		$data['live_search_show_image'] = $this->config->get('live_search_show_image');
		$data['live_search_show_price'] = $this->config->get('live_search_show_price');
		$data['live_search_show_description'] = $this->config->get('live_search_show_description');
		$data['live_search_href'] = $this->url->link('product/search', 'search=');
		$data['live_search_min_length'] = $this->config->get('live_search_min_length');
		$data['live_search_image_height'] = $this->config->get('live_search_image_height');
		
		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		// Social Media 

		$data['social_icons'] = $this->load->controller('component/social_icons');
		

		return $this->load->view('common/footer', $data);
	}
}
