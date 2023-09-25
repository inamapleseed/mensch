<?php
class ControllerExtensionModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;		

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		//$this->document->addStyle('catalog/view/javascript/slick/slick.min.css');
		//$this->document->addScript('catalog/view/javascript/slick/slick-custom.min.js');

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		$data['config_parallax_slider'] = $this->config->get('config_parallax_slider');

		$data['parallax_margin'] = $setting['height'];

		$data['mobile_parallax_margin'] = $setting['mobile_height'];


		// debug($setting);

		$data['dots'] = $setting['dots'];
		$data['arrows'] = $setting['arrows'];
		$data['autoplayspeed'] = $setting['autoplayspeed'];

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image']) || $result['video']) {

				// Windows server might need to explode: \r or \r\n or \n
				// Linux server only need to explode \n or PHP_EOL
				// Note: PHP_EOL do not necessary equals to \r\n
				if(trim($result['description']) != ''){
					$spliter = "\n";
					$result['description'] = explode($spliter, $result['description']);
					
					foreach($result['description'] as $index => &$each){
						$each = '<span class="slideshow-text-' . $index . '">' . $each . '</span>';
					}

					$result['description'] = implode($spliter, $result['description']);
				}
				
				if(!is_file(DIR_IMAGE . $result['mobile_image'])){
					$result['mobile_image'] = $result['image'];
				}

				$video_pathinfo = '';
                if( $result['video'] != 'Video File'){
                    $video_pathinfo = pathinfo( $result['video'] );
                    $video_pathinfo = $video_pathinfo['extension'];
                }
				
				$data['banners'][] = array(
					'title'			=> $result['title'],
					'description'	=> $result['description'],
					'link_text' 	=> $result['link_text'],
					'link' 			=> $result['link'],
					'theme' 		=> $result['color_theme'],
					'mobile_theme' 	=> 'mobile_' . $result['mobile_color_theme'],
					'image' 		=> $this->model_tool_image->resize(
										$result['image'], 
										$setting['width'], 
										$setting['height'], 'a'),
					'mobile_image' 	=> $this->model_tool_image->resize(
										$result['mobile_image'], 
										$setting['mobile_width'], 
										$setting['mobile_height'], 'h'),
					'video' 	        => $result['video'],
					'mobile_video' 	    => $result['mobile_video'],
					'video_extension' 	=> $video_pathinfo,
				);
			}
		}
		
		$data['module'] = $module++;

		if(isset($setting['return_json']) && $setting['return_json'] === true){
			return $data;
		}

		return $this->load->view('extension/module/slideshow', $data);
	}
}
