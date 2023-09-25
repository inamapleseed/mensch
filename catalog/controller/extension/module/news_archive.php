<?php  
class ControllerExtensionModuleNewsArchive extends Controller {
	public function index() {

		$this->language->load('extension/module/news_archive');
		
    	$data['heading_title'] = $this->language->get('heading_title');
    	$data['text_categories'] = $this->language->get('text_categories');
    	$data['text_year'] = $this->language->get('text_year');
    	$data['button_filter'] = $this->language->get('button_filter');
		
		$months = $this->config->get('news_archive_months');
		
		$data['archives'] = array();
		$data['article_listing_layout'] = $this->config->get('config_article_listing_layout');	
		$data['article_inner_layout'] = $this->config->get('config_article_inner_layout');	

		$with_dropdown = false;
		$dropdown_layout = array(
			'layout_1','layout_2'
		);

		if(in_array($data['article_listing_layout'],$dropdown_layout)){
			$with_dropdown = true;
		}
		
		$lid = $this->config->get('config_language_id');
		
		$m_name = array();
		
		$m_name[1] = (isset($months['jan'][$lid]) && $months['jan'][$lid]) ? $months['jan'][$lid] : 'January';
		$m_name[2] = (isset($months['feb'][$lid]) && $months['feb'][$lid]) ? $months['feb'][$lid] : 'February';
		$m_name[3] = (isset($months['march'][$lid]) && $months['march'][$lid]) ? $months['march'][$lid] : 'March';
		$m_name[4] = (isset($months['april'][$lid]) && $months['april'][$lid]) ? $months['april'][$lid] : 'April';
		$m_name[5] = (isset($months['may'][$lid]) && $months['may'][$lid]) ? $months['may'][$lid] : 'May';
		$m_name[6] = (isset($months['june'][$lid]) && $months['june'][$lid]) ? $months['june'][$lid] : 'June';
		$m_name[7] = (isset($months['july'][$lid]) && $months['july'][$lid]) ? $months['july'][$lid] : 'July';
		$m_name[8] = (isset($months['aug'][$lid]) && $months['aug'][$lid]) ? $months['aug'][$lid] : 'August';
		$m_name[9] = (isset($months['sep'][$lid]) && $months['sep'][$lid]) ? $months['sep'][$lid] : 'September';
		$m_name[10] = (isset($months['oct'][$lid]) && $months['oct'][$lid]) ? $months['oct'][$lid] : 'October';
		$m_name[11] = (isset($months['nov'][$lid]) && $months['nov'][$lid]) ? $months['nov'][$lid] : 'November';
		$m_name[12] = (isset($months['dec'][$lid]) && $months['dec'][$lid]) ? $months['dec'][$lid] : 'December';
		
		$this->load->model('catalog/news');
		
		$years = $this->model_catalog_news->getArchive();
		
		foreach ($years as $year) {
			$data_month = array();
			$total = 0;
			$months = unserialize($year['months']);
			foreach ($months as $mo => $articles) {
				$total += $articles;
				$data_month[] = array(
					//'name' => $m_name[$mo] . ' '. $year['year'],
					'name' => $m_name[$mo],
					'href' => $this->url->link('news/ncategory', 'archive=' . $year['year'] . '-' . $mo),
					'num' => $mo,
				);	
			}
			$data['archives'][] = array(
				'year' => $year['year'],
				'month' => $data_month,
				'yr_href' => $this->url->link('news/ncategory', 'archive=' . $year['year']),
			);
		}

		if (isset($this->request->get['ncat'])) {
			$parts = explode('_', (string)$this->request->get['ncat']);
			$data['search_url'] .= '&ncat=' . implode('_', $parts);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['ncategory_id'] = $parts[0];
		} else {
			$data['ncategory_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		if (isset($parts[2])) {
			$data['child_id_lvl2'] = $parts[2];
		} else {
			$data['child_id_lvl2'] = 0;
		}

		$data['ncategories'] = array();
					
		$ncategories = $this->model_catalog_ncategory->getncategories(0);
		
		foreach ($ncategories as $ncategory) {
			$children_data = array();
			
			$children = $this->model_catalog_ncategory->getncategories($ncategory['ncategory_id']);
			
			foreach ($children as $child) {	
				$children_lvl2 = $this->model_catalog_ncategory->getncategories($child['ncategory_id']);
				foreach($children_lvl2 as $child_lvl2) {

					$active = $active_1 = $active_2 = in_array($child_lvl2['ncategory_id'], $parts)?'active':'';

					$children_lv2_data[] = array(
						'active' => $active_2,
						'ncategory_id' => $child_lvl2['ncategory_id'],
						'name'        => $child_lvl2['name'],
						'href'        => $this->url->link('news/ncategory', 'ncat=' . $ncategory['ncategory_id'] . '_' .$child['ncategory_id'].'_'. $child_lvl2['ncategory_id'])	
					);		
				}

				$children_data[] = array(
					'active' => $active_1,
					'ncategory_id' => $child['ncategory_id'],
					'name'        => $child['name'],
					'href'        => $this->url->link('news/ncategory', 'ncat=' . $ncategory['ncategory_id'] . '_' . $child['ncategory_id']),
					'children' => $children_lv2_data
				);					
			}

			$data['ncategories'][] = array(
				'active' => $active,
				'ncategory_id' => $ncategory['ncategory_id'],
				'name'        => $ncategory['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('news/ncategory', 'ncat=' . $ncategory['ncategory_id'])	
			);
		}

		
		$data['cat'] = "";

		if(isset($this->request->get['ncat'])){
			
			$data['cat'] = $this->request->get['ncat'];
			$data['latest'] = $this->url->link('news/ncategory', 'ncat=' . $this->request->get['ncat']. '&sort=DESC');
			$data['oldest'] = $this->url->link('news/ncategory', 'ncat=' . $this->request->get['ncat']. '&sort=ASC');
			$data['default'] = $this->url->link('news/ncategory', 'ncat=' . $this->request->get['ncat']);
		} else {
			$data['latest'] = $this->url->link('news/ncategory', 'sort=DESC');
			$data['oldest'] = $this->url->link('news/ncategory', 'sort=ASC');
			$data['default'] = $this->url->link('news/ncategory');
		}

		$data['sorted'] = "";
		if(isset($this->request->get['sort'])) {
			$data['sorted'] = $this->request->get['sort'];
		}
	
		$data['catdefault'] = $this->url->link('news/ncategory');

		
		$data['ncategory_id'] = isset($this->request->get['ncat']) ? $this->request->get['ncat'] : '';
		$data['archive_query'] = isset($this->request->get['archive']) ? $this->request->get['archive'] : '';
		$data['achive_yr'] = isset($this->request->get['archive']) ? explode('-', $this->request->get['archive'])[0] : '';

		if($with_dropdown) {
			return $this->load->view('extension/module/news_archive_dropdown', $data);
		}else {
			return $this->load->view('extension/module/news_archive_normal', $data);

		}

		
  	}
}