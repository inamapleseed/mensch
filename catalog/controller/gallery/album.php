<?php 
class ControllerGalleryAlbum extends Controller {
  public function index() {

    $this->load->language('gallery/gallery');

	$this->load->model('catalog/gallimage');
	
	$data['breadcrumbs'] = array();

	$data['breadcrumbs'][] = array(
		'text' => $this->language->get('text_home'),
		'href' => $this->url->link('common/home')
	);

	$data['breadcrumbs'][] = array(
		'text' => $this->language->get('text_gallery'),
		'href' => $this->url->link('gallery/album')
	);

	$this->document->setTitle($this->language->get('heading_title'));

	$data['heading_title'] = $this->language->get('heading_title');

	// slick
	$this->document->addStyle('catalog/view/javascript/slick/slick.min.css');
	$this->document->addScript('catalog/view/javascript/slick/slick-custom.min.js');
		

	
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['column_right'] = $this->load->controller('common/column_right');
	$data['content_top'] = $this->load->controller('common/content_top');
	$data['content_bottom'] = $this->load->controller('common/content_bottom');
	$data['footer'] = $this->load->controller('common/footer');
	$data['header'] = $this->load->controller('common/header');

	$data['cat_id'] = 1;

	if(isset($this->request->get['cat_id']) && $this->request->get['cat_id']) {
		$data['cat_id'] = $this->request->get['cat_id'];
	} 	

	$data['gallery_layout'] = $gallery_layout = $this->config->get('config_gallery_layout');

	$category_tab_layout = array('layout_1');
	
	$listing_by_category = false;
	if(in_array($gallery_layout , $category_tab_layout)) {
		$listing_by_category = true;
	}

	$data['gallalbums'] = array();

	$gallalbums = $this->model_catalog_gallimage->getGallalbums();

	if(isset($gallalbums) && $gallalbums) {
		foreach ($gallalbums as $gallalbum) {
		
			$gallalbum_info_current = array();

			$cat_link = '';
			$cat_link = $this->url->link('gallery/album','cat_id='.$gallalbum['gallimage_id']);

			$data['cat_title'] = '';

			if($listing_by_category) {
				$gallalbum_info_current = $this->model_catalog_gallimage->getGallalbum($data['cat_id']);
				$current_cat_link = '';
				$current_cat_link = $this->url->link('gallery/album','cat_id='.$data['cat_id']);
				
				$data['cat_title'] =  $gallalbum_info_current['name'];
			}

			$gallalbum_info = $this->model_catalog_gallimage->getGallalbum($gallalbum['gallimage_id']);

			if ($gallalbum_info) {

				
				$filter_data = array(
					'start' => 0,
					'limit' => 999999,
					'gallimage_id' => $listing_by_category ? $data['cat_id'] : $gallalbum['gallimage_id'],
				);

				$results = $this->model_catalog_gallimage->getGallimage($filter_data);
				$gallimages = array();
				if ($results) {
					foreach ($results as $result) {
						if ($result['image']) {                  
							$thumb = $this->model_tool_image->resize($result['image'], 400, 400);
							//$popupimage = 'image/' . $result['image'];
							$popupimage = $this->model_tool_image->resize($result['image'], 700, 700);
							$popupimage2 = $this->model_tool_image->resize($result['image'], 200, 200);
						} else {
							$thumb = $this->model_tool_image->resize('placeholder.png', 400, 400);
							$popupimage = 'image/placeholder.png';
							$popupimage2 = 'image/placeholder.png';
						}
				

						$gallimages[] = array(
							'gallimage_id' => $result['gallimage_id'],
							'title' => $result['title'],
							'link'  => html_entity_decode($result['link'], ENT_QUOTES, 'UTF-8'),
							'thumb' => $thumb,
							'image' => $popupimage,
							'image2' => $popupimage2,
							'ori_image'=> 'image/'.$result['image'],
						);
					}
				}

				if(is_array($gallimages) && $gallimages) {
					$featured_image = $gallimages[0]['ori_image'];
				}else {
					$featured_image =  $this->model_tool_image->resize('no_image.png', 400, 400);
				}
			
				$data['gallalbums'][] = array(
					'cat_link' => $cat_link,
					'gallimage_id' => $gallalbum_info['gallimage_id'],
					'name'        => $gallalbum_info['name'],
					'featured_image' => $featured_image,
					'description' => utf8_substr(strip_tags(html_entity_decode($gallalbum_info['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'thumb'   	 => $gallalbum_info['image'],
					'href'        => $this->url->link('gallery/gallery', 'gallimage_id=' . $gallalbum_info['gallimage_id']),
					'gallalbum' => $gallimages,
				);
			}
			if($gallalbum_info_current) {
				$data['gallalbums_current'] = array(
					'cat_link' => $cat_link,
					'gallimage_id' => $gallalbum_info_current['gallimage_id'],
					'name'        => $gallalbum_info_current['name'],
					'featured_image' => $featured_image,
					'description' => utf8_substr(strip_tags(html_entity_decode($gallalbum_info_current['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'thumb'   	 => $gallalbum_info_current['image'],
					'href'        => $this->url->link('gallery/gallery', 'gallimage_id=' . $gallalbum_info_current['gallimage_id']),
					'gallalbum' => $gallimages,
				);
			}
			
		}
	}


    if (version_compare(VERSION, '2.2.0.0', '>=')) {
		$this->response->setOutput($this->load->view('gallery/gallery_'.$gallery_layout , $data));
    } else {   
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/gallery/album.tpl')) {
      $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/gallery/album.tpl', $data));
    } else {
      $this->response->setOutput($this->load->view('default/template/gallery/album.tpl', $data));
    }
    }
  }
}
?>