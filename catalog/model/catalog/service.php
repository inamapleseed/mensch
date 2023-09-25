<?php
class ModelCatalogService extends Model {
	public function getPrevNext($ncat=0, $service_id=0){ // Return array

		if(!$ncat) return array();

		if(!$service_id) return array(); // If no service_id then don't run

		// Select all service of the same scategory

		$sql = 'SELECT 
		DISTINCT n2c.service_id 
		FROM `' . DB_PREFIX . 'sb_service_to_scategory` n2c 
		LEFT JOIN `' . DB_PREFIX . 'sb_service` n 
		ON (n.service_id= n2c.service_id) 
		WHERE n2c.scategory_id="' . (int)$ncat . '"
		ORDER BY n.date_added ASC';

		$query = $this->db->query($sql);

		// If there's more than 1 service retrieved

		$response = array();

		if($query->num_rows){
			$prev_service_id = 0;
			$next_service_id = 0;

			foreach($query->rows as $index => $each_service){
				if($each_service['service_id'] == $service_id){
					// Get Previous
					if(isset($query->rows[$index-1])){ 
						$prev_service_id = $query->rows[$index-1]['service_id'];
					}

					// Get Next
					if(isset($query->rows[$index+1])){ 
						$next_service_id = $query->rows[$index+1]['service_id'];
					}
					break;
				} // End IF each_service == $service_id
			} // End Foreach

			$response['prev_service_id']   =   $prev_service_id;
			$response['next_service_id']   =   $next_service_id;

		}

		return $response;
	}


	public function getServiceStory($service_id) {

		$group_restriction = $this->config->get('scategory_bservice_restrictgroup') ? " AND n2g.group_id = '" . (int)$this->config->get('config_customer_group_id') . "' " : '';

		$group_restriction_join = $this->config->get('scategory_bservice_restrictgroup') ? " LEFT JOIN " . DB_PREFIX . "sb_service_to_group n2g ON (n.service_id = n2g.service_id) " : '';

		$query = $this->db->query("SELECT DISTINCT *, nau.name as author, n.image as image, nau.image as nimage FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) LEFT JOIN " . DB_PREFIX . "sb_service_to_store n2s ON (n.service_id = n2s.service_id)".$group_restriction_join." LEFT JOIN " . DB_PREFIX . "sb_sauthor nau ON (n.sauthor_id = nau.sauthor_id) WHERE n.service_id = '" . (int)$service_id . "'  AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.date_pub < NOW()".$group_restriction);
		if ($query->num_rows) {
			return array(
				'service_id'          => $query->row['service_id'],
				'title'            => $query->row['title'],
				'ctitle'           => $query->row['ctitle'],
				'description'      => $query->row['description'],
				'description2'     => $query->row['description2'],
				'meta_desc'        => $query->row['meta_desc'],
				'meta_key'         => $query->row['meta_key'],
				'ntags'            => $query->row['ntags'],
				'cfield1'          => $query->row['cfield1'],
				'cfield2'          => $query->row['cfield2'],
				'cfield3'          => $query->row['cfield3'],
				'cfield4'          => $query->row['cfield4'],
				'image'            => $query->row['image'],
				'image2'           => $query->row['image2'],
				'nimage'           => $query->row['nimage'],
				'acom'             => $query->row['acom'],
				'author'           => $query->row['author'],
				'sauthor_id'       => $query->row['sauthor_id'],
				'date_added'       => $query->row['date_added'],
				'date_updated'     => $query->row['date_updated'],
				'sort_order'       => $query->row['sort_order'],
				'gal_thumb_w'      => $query->row['gal_thumb_w'],
				'gal_thumb_h'      => $query->row['gal_thumb_h'],
				'gal_popup_w'      => $query->row['gal_popup_w'],
				'gal_popup_h'      => $query->row['gal_popup_h'],
				'gal_slider_h'     => $query->row['gal_slider_h'],
				'gal_slider_w'     => $query->row['gal_slider_w'],
				'gal_slider_t'     => $query->row['gal_slider_t'],
			);
		} else {
			return false;
		}
	}

	public function getService($data = array()) {

		$group_restriction = $this->config->get('scategory_bservice_restrictgroup') ? " AND n2g.group_id = '" . (int)$this->config->get('config_customer_group_id') . "' " : '';

		$group_restriction_join = $this->config->get('scategory_bservice_restrictgroup') ? " LEFT JOIN " . DB_PREFIX . "sb_service_to_group n2g ON (n.service_id = n2g.service_id) " : '';

		$sql = "SELECT n.service_id FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) LEFT JOIN " . DB_PREFIX . "sb_service_to_store n2s ON (n.service_id = n2s.service_id)".$group_restriction_join." LEFT JOIN " . DB_PREFIX . "sb_sauthor nau ON (n.sauthor_id = nau.sauthor_id) ";
		if (!empty($data['filter_scategory_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "sb_service_to_scategory n2n ON (n.service_id = n2n.service_id)";			
			}
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.date_pub < NOW()" . $group_restriction;	
		
		if (!empty($data['filter_scategory_id'])) {
				if (!empty($data['filter_sub_scategory'])) {
					$implode_data = array();
					
					$implode_data[] = "n2n.scategory_id = '" . (int)$data['filter_scategory_id'] . "'";
					
					$this->load->model('catalog/scategory');
					
					$ncategories = $this->model_catalog_scategory->getncategoriesByParentId($data['filter_scategory_id']);
										
					foreach ($ncategories as $scategory_id) {
						$implode_data[] = "n2n.scategory_id = '" . (int)$scategory_id . "'";
					}
								
					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND n2n.scategory_id = '" . (int)$data['filter_scategory_id'] . "'";
				}
			}		
		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "LOWER(nd.title) LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR nd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "LOWER(nd.ntags) LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			$sql .= ")";
		}
		
		if (!empty($data['filter_author_id'])) {
			$sql .= " AND n.sauthor_id = '" . (int)$data['filter_author_id'] . "'";
		}
		
		if (!empty($data['filter_year']) && !empty($data['filter_month'])) {
			$m = (int)$data['filter_month'] > 9 ? (int)$data['filter_month'] : '0'.(int)$data['filter_month'];
			$y = (int)$data['filter_year'];
			$dateInterval = $m . '-' . $y;
			if ($this->config->get('service_archive_date') == 'du') {
				$sql .= " AND DATE_FORMAT(n.date_updated,'%m-%Y') = '". $dateInterval ."'";
			} elseif ($this->config->get('service_archive_date') == 'dp') {
				$sql .= " AND DATE_FORMAT(n.date_pub,'%m-%Y') = '". $dateInterval ."'";
			} else {
				$sql .= " AND DATE_FORMAT(n.date_added,'%m-%Y') = '". $dateInterval ."'";
			}
		}
		// for just year filter (without month)
		if (!empty($data['filter_year']) && empty($data['filter_month'])) {
			$y = (int)$data['filter_year'];
			if ($this->config->get('service_archive_date') == 'du') {
				$sql .= " AND DATE_FORMAT(n.date_updated,'%Y') = '". $y ."'";
			} elseif ($this->config->get('service_archive_date') == 'dp') {
				$sql .= " AND DATE_FORMAT(n.date_pub,'%Y') = '". $y ."'";
			} else {
				$sql .= " AND DATE_FORMAT(n.date_added,'%Y') = '". $y ."'";
			}
		}
		
		if (!$this->config->get('scategory_bservice_order')) {
			$sql .= " ORDER BY n.date_added DESC ";
			} else {
			$sql .= " ORDER BY n.sort_order";	
		}	
        			
		if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
	
		$articles_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$articles_data[$result['service_id']] = $this->getServiceStory($result['service_id']);
		}

		return $articles_data;
	}
	public function getServiceLayoutId($service_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_to_layout WHERE service_id = '" . (int)$service_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return  $this->config->get('config_layout_service');
		}
	}
	public function getProductRelated($service_id) {
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_related nr LEFT JOIN " . DB_PREFIX . "sb_service n ON (nr.service_id = n.service_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (nr.product_id = p2s.product_id) WHERE nr.service_id = '" . (int)$service_id . "' AND n.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		$this->load->model('catalog/product');
		foreach ($query->rows as $result) { 
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}
		
		return $product_data;
	}	
	public function getServiceRelated($service_id) {
		$service_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_related WHERE service_id = '389657" . (int)$service_id . "'");
		$query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_related WHERE product_id = '" . (int)$service_id . "' AND service_id LIKE '389657%'");
		
		foreach ($query->rows as $result) {
			$service_related_data[$result['product_id']] = $this->getServiceStory($result['product_id']);
		}
		foreach ($query2->rows as $result2) {
		 if (!in_array(str_replace("389657", "", $result2['service_id']), $service_related_data)) {
			$service_related_data[str_replace("389657", "", $result2['service_id'])] = $this->getServiceStory(str_replace("389657", "", $result2['service_id']));
		 }
		}
		
		return $service_related_data;
	}
	public function getTotalService($data = array()) {

		$group_restriction = $this->config->get('scategory_bservice_restrictgroup') ? " AND n2g.group_id = '" . (int)$this->config->get('config_customer_group_id') . "' " : '';

		$group_restriction_join = $this->config->get('scategory_bservice_restrictgroup') ? " LEFT JOIN " . DB_PREFIX . "sb_service_to_group n2g ON (n.service_id = n2g.service_id) " : '';

		$sql = "SELECT COUNT(DISTINCT n.service_id) AS total FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) LEFT JOIN " . DB_PREFIX . "sb_service_to_store n2s ON (n.service_id = n2s.service_id)".$group_restriction_join." LEFT JOIN " . DB_PREFIX . "sb_sauthor nau ON (n.sauthor_id = nau.sauthor_id) ";
		if (!empty($data['filter_scategory_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "sb_service_to_scategory n2n ON (n.service_id = n2n.service_id)";			
		}
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.date_pub < NOW()" . $group_restriction;	
	
		if (!empty($data['filter_scategory_id'])) {
			if (!empty($data['filter_sub_scategory'])) {
				$implode_data = array();
				
				$implode_data[] = "n2n.scategory_id = '" . (int)$data['filter_scategory_id'] . "'";
				
				$this->load->model('catalog/scategory');
				
				$ncategories = $this->model_catalog_scategory->getncategoriesByParentId($data['filter_scategory_id']);
					
				foreach ($ncategories as $scategory_id) {
					$implode_data[] = "n2n.scategory_id = '" . (int)$scategory_id . "'";
				}
							
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND n2n.scategory_id = '" . (int)$data['filter_scategory_id'] . "'";
			}
		}	
		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "LOWER(nd.title) LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR nd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "LOWER(nd.ntags) LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			$sql .= ")";
		}		
		
		if (!empty($data['filter_author_id'])) {
			$sql .= " AND n.sauthor_id = '" . (int)$data['filter_author_id'] . "'";
		}
		
		if (!empty($data['filter_year']) && !empty($data['filter_month'])) {
			$m = (int)$data['filter_month'] > 9 ? (int)$data['filter_month'] : '0'.(int)$data['filter_month'];
			$y = (int)$data['filter_year'];
			$dateInterval = $m . '-' . $y;
			if ($this->config->get('service_archive_date') == 'du') {
				$sql .= " AND DATE_FORMAT(n.date_updated,'%m-%Y') = '". $dateInterval ."'";
			} elseif ($this->config->get('service_archive_date') == 'dp') {
				$sql .= " AND DATE_FORMAT(n.date_pub,'%m-%Y') = '". $dateInterval ."'";
			} else {
				$sql .= " AND DATE_FORMAT(n.date_added,'%m-%Y') = '". $dateInterval ."'";
			}
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	public function getScategoriesbyServiceId($service_id) {
		$query = $this->db->query("SELECT scategory_id FROM " . DB_PREFIX . "sb_service_to_scategory WHERE service_id = '" . (int)$service_id . "'");

		return $query->rows;
	}
	public function getSauthor($sauthor_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_sauthor WHERE sauthor_id = '" . (int)$sauthor_id . "'");

		return $query->row;
	}
	public function getSauthorDescriptions($sauthor_id) {
		$sauthor_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_sauthor_description WHERE sauthor_id = '" . (int)$sauthor_id . "'");
		
		foreach ($query->rows as $result) {
			$sauthor_description_data[$result['language_id']] = array(
				'ctitle'           => $result['ctitle'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $sauthor_description_data;
	}
	public function getArticleGallery($service_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_gallery WHERE service_id = '" . (int)$service_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}
	public function getArticleVideos($service_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_video WHERE service_id = '" . (int)$service_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}
	public function getArchive() {

		$id_by_restriction = $this->config->get('scategory_bservice_restrictgroup') ?  (((int)$this->config->get('config_store_id')+1) * 10000) + ((int)$this->config->get('config_customer_group_id') * 10) : (int)$this->config->get('config_store_id');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_archive WHERE store_id = '" . $id_by_restriction . "' ORDER BY year DESC");

		return $query->rows;
	}
 	public function getServiceCategories($data = array()) {
		$sql = "SELECT ncd.* FROM " . DB_PREFIX . "sb_service_to_scategory ntn LEFT JOIN " . DB_PREFIX . "sb_scategory nc ON (ntn.scategory_id = nc.scategory_id) LEFT JOIN " . DB_PREFIX . "sb_scategory_description ncd ON (ntn.scategory_id = ncd.scategory_id) LEFT JOIN " . DB_PREFIX . "sb_service n ON (ntn.service_id = n.service_id) LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON ntn.service_id = nd.service_id LEFT JOIN " . DB_PREFIX . "sb_service_to_store n2s ON (ntn.service_id = n2s.service_id)";
		$sql .= " WHERE ncd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.date_added < NOW() AND nc.status = 1";
		
		if(!empty($data['parent_id'])) {
			$sql .= " AND nc.parent_id = '".(int)$data['parent_id']."'";
		}
		$sql .= " GROUP BY ntn.scategory_id";

		$query = $this->db->query($sql);

		return $query->rows;
 	}
}
?>
