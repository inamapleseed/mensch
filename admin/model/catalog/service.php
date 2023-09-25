<?php
class ModelCatalogService extends Model {
	public function addService($data, $ifcopy = 0) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service SET status = '" . (int)$data['status'] . "', acom = '" . (int)$data['acom'] . "', sauthor_id = '" . (int)$data['sauthor_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', gal_thumb_w = '" . (int)$data['gal_thumb_w'] . "', gal_thumb_h = '" . (int)$data['gal_thumb_h'] . "', gal_popup_w = '" . (int)$data['gal_popup_w'] . "', gal_popup_h = '" . (int)$data['gal_popup_h'] . "', gal_slider_h = '" . (int)$data['gal_slider_h'] . "', gal_slider_w = '" . (int)$data['gal_slider_w'] . "', gal_slider_t = '" . (int)$data['gal_slider_t'] . "', date_pub = '" . $this->db->escape($data['date_pub']) . "', date_added = '" . $this->db->escape($data['date_added']) . "', date_updated = '" . $this->db->escape($data['date_updated']) . "'");
		$service_id = $this->db->getLastId(); 
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "sb_service SET image = '" . $this->db->escape($data['image']) . "' WHERE service_id = '" . (int)$service_id . "'");
		}
		
		if (isset($data['image2'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "sb_service SET image2 = '" . $this->db->escape($data['image2']) . "' WHERE service_id = '" . (int)$service_id . "'");
		}
		
		foreach (@$data['service_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_description SET service_id = '" . (int)$service_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_desc = '" . $this->db->escape($value['meta_desc']) . "', meta_key = '" . $this->db->escape($value['meta_key']) . "', ctitle = '" . $this->db->escape($value['ctitle']) . "', ntags = '" . $this->db->escape($value['ntags']) . "', description2 = '" . $this->db->escape($value['description2']) . "'");
		}
		if (isset($data['service_store'])) {
			foreach ($data['service_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_to_store SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		if (isset($data['service_group'])) {
			foreach ($data['service_group'] as $group_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_to_group SET service_id = '" . (int)$service_id . "', group_id = '" . (int)$group_id . "'");
			}
		}
		if (isset($data['service_scategory'])) {
			foreach ($data['service_scategory'] as $scategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_to_scategory SET service_id = '" . (int)$service_id . "', scategory_id = '" . (int)$scategory_id . "'");
			}
		}
		if (isset($data['service_related'])) {
			foreach ($data['service_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_related SET service_id = '" . (int)$service_id . "', product_id = '" . (int)$related_id . "'");
			}
		}
		
		if (isset($data['service_nrelated'])) {
			foreach ($data['service_nrelated'] as $nrelated_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_related SET service_id = '389657" . (int)$service_id . "', product_id = '" . (int)$nrelated_id . "'");
			}
		}
		
		if (isset($data['service_gallery'])) {
			foreach ($data['service_gallery'] as $service_gallery) {
				if ($ifcopy) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_gallery SET service_id = '" . (int)$service_id . "', image = '" . $this->db->escape(html_entity_decode($service_gallery['image'], ENT_QUOTES, 'UTF-8')) . "', text = '" . $this->db->escape($service_gallery['text']) . "', sort_order = '" . (int)$service_gallery['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_gallery SET service_id = '" . (int)$service_id . "', image = '" . $this->db->escape(html_entity_decode($service_gallery['image'], ENT_QUOTES, 'UTF-8')) . "', text = '" . $this->db->escape(serialize($service_gallery['text'])) . "', sort_order = '" . (int)$service_gallery['sort_order'] . "'");
				}
			}
		}
		
		if (isset($data['service_video'])) {
			foreach ($data['service_video'] as $service_video) {
				if ($ifcopy) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_video SET service_id = '" . (int)$service_id . "', video = '" . $this->db->escape(html_entity_decode($service_video['video'], ENT_QUOTES, 'UTF-8')) . "', text = '" . $this->db->escape($service_video['text']) . "', width = '" . (int)$service_video['width'] . "', height = '" . (int)$service_video['height'] . "', sort_order = '" . (int)$service_video['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_video SET service_id = '" . (int)$service_id . "', video = '" . $this->db->escape(html_entity_decode($service_video['video'], ENT_QUOTES, 'UTF-8')) . "', text = '" . $this->db->escape(serialize($service_video['text'])) . "', width = '" . (int)$service_video['width'] . "', height = '" . (int)$service_video['height'] . "', sort_order = '" . (int)$service_video['sort_order'] . "'");
				}
			}
		}
		if (isset($data['service_layout'])) {
			foreach ($data['service_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_to_layout SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'service_id=" . (int)$service_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('service');
	}

	public function editService($service_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "sb_service SET status = '" . (int)$data['status'] . "', acom = '" . (int)$data['acom'] . "', sauthor_id = '" . (int)$this->request->post['sauthor_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', gal_thumb_w = '" . (int)$data['gal_thumb_w'] . "', gal_thumb_h = '" . (int)$data['gal_thumb_h'] . "', gal_popup_w = '" . (int)$data['gal_popup_w'] . "', gal_popup_h = '" . (int)$data['gal_popup_h'] . "', gal_slider_h = '" . (int)$data['gal_slider_h'] . "', gal_slider_w = '" . (int)$data['gal_slider_w'] . "', gal_slider_t = '" . (int)$data['gal_slider_t'] . "', date_pub = '" . $this->db->escape($data['date_pub']) . "', date_added = '" . $this->db->escape($data['date_added']) . "', date_updated = '" . $this->db->escape($data['date_updated']) . "' WHERE service_id = '" . (int)$service_id . "'");
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "sb_service SET image = '" . $this->db->escape($data['image']) . "' WHERE service_id = '" . (int)$service_id . "'");
		}
		if (isset($data['image2'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "sb_service SET image2 = '" . $this->db->escape($data['image2']) . "' WHERE service_id = '" . (int)$service_id . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_description WHERE service_id = '" . (int)$service_id . "'");
		foreach (@$data['service_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_description SET service_id = '" . (int)$service_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_desc = '" . $this->db->escape($value['meta_desc']) . "', meta_key = '" . $this->db->escape($value['meta_key']) . "', ctitle = '" . $this->db->escape($value['ctitle']) . "', ntags = '" . $this->db->escape($value['ntags']) . "', description2 = '" . $this->db->escape($value['description2']) . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_to_store WHERE service_id = '" . (int)$service_id . "'");

		if (isset($data['service_store'])) {
			foreach ($data['service_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_to_store SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_to_group WHERE service_id = '" . (int)$service_id . "'");

		if (isset($data['service_group'])) {
			foreach ($data['service_group'] as $group_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_to_group SET service_id = '" . (int)$service_id . "', group_id = '" . (int)$group_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_to_scategory WHERE service_id = '" . (int)$service_id . "'");
		
		if (isset($data['service_scategory'])) {
			foreach ($data['service_scategory'] as $scategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_to_scategory SET service_id = '" . (int)$service_id . "', scategory_id = '" . (int)$scategory_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_related WHERE service_id = '" . (int)$service_id . "'");

		if (isset($data['service_related'])) {
			foreach ($data['service_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_related SET service_id = '" . (int)$service_id . "', product_id = '" . (int)$related_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_related WHERE service_id = '389657" . (int)$service_id . "'");
		
		if (isset($data['service_nrelated'])) {
			foreach ($data['service_nrelated'] as $nrelated_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_related SET service_id = '389657" . (int)$service_id . "', product_id = '" . (int)$nrelated_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_gallery WHERE service_id = '" . (int)$service_id . "'");
		if (isset($data['service_gallery'])) {
			foreach ($data['service_gallery'] as $service_gallery) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_gallery SET service_id = '" . (int)$service_id . "', image = '" . $this->db->escape(html_entity_decode($service_gallery['image'], ENT_QUOTES, 'UTF-8')) . "', text = '" . $this->db->escape(serialize($service_gallery['text'])) . "', sort_order = '" . (int)$service_gallery['sort_order'] . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_video WHERE service_id = '" . (int)$service_id . "'");
		if (isset($data['service_video'])) {
			foreach ($data['service_video'] as $service_video) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_video SET service_id = '" . (int)$service_id . "', video = '" . $this->db->escape(html_entity_decode($service_video['video'], ENT_QUOTES, 'UTF-8')) . "', text = '" . $this->db->escape(serialize($service_video['text'])) . "', width = '" . (int)$service_video['width'] . "', height = '" . (int)$service_video['height'] . "', sort_order = '" . (int)$service_video['sort_order'] . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_to_layout WHERE service_id = '" . (int)$service_id . "'");
		
		if (isset($data['service_layout'])) {
			foreach ($data['service_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_to_layout SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'service_id=" . (int)$service_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'service_id=" . (int)$service_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		$this->cache->delete('service');
	}
    public function copyService($service_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) WHERE n.service_id = '" . (int)$service_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
						
			$data = array_merge($data, array('service_description' => $this->getServiceDescriptions($service_id,1)));
			$data = array_merge($data, array('service_scategory' => $this->getServiceNcategories($service_id)));
			$data = array_merge($data, array('service_layout' => $this->getServiceLayouts($service_id)));
			$data = array_merge($data, array('service_store' => $this->getServiceStores($service_id)));
			$data = array_merge($data, array('service_group' => $this->getServiceGroups($service_id)));
			$data = array_merge($data, array('service_related' => $this->getServiceRelated($service_id)));
			$data = array_merge($data, array('service_gallery' => $this->getArticleImages($service_id)));
			$data = array_merge($data, array('service_video' => $this->getArticleVideos($service_id)));
			
			$this->addService($data,1);
		}
	}
	public function deleteService($service_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_description WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'service_id=" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_to_scategory WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_to_layout WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_to_store WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_to_group WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_related WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_gallery WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_video WHERE service_id = '" . (int)$service_id . "'");
		$this->cache->delete('service');
	}	
	public function getServiceStory($service_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'service_id=" . (int)$service_id . "') AS keyword FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) WHERE n.service_id = '" . (int)$service_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getServiceDescriptions($service_id, $ifcopy = 0) {
		$service_description_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_description WHERE service_id = '" . (int)$service_id . "'");
		foreach ($query->rows as $result) {
			if ($ifcopy) { $result['title'] = $result['title'] . ' copy'; }
			$service_description_data[$result['language_id']] = array(
				'title'       => $result['title'],
				'ctitle'      => $result['ctitle'],
				'ntags'       => $result['ntags'],
				'description' => $result['description'],
				'description2' => $result['description2'],
				'meta_desc'   => $result['meta_desc'],
				'meta_key'    => $result['meta_key'],
				'cfield1'     => $result['cfield1'],
				'cfield2'     => $result['cfield2'],
				'cfield3'     => $result['cfield3'],
				'cfield4'     => $result['cfield4'],
			);
		}
		return $service_description_data;
	}
    public function getServiceStores($service_id) {
		$service_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_to_store WHERE service_id = '" . (int)$service_id . "'");

		foreach ($query->rows as $result) {
			$service_store_data[] = $result['store_id'];
		}
		
		return $service_store_data;
	}

    public function getServiceGroups($service_id) {
		$service_group_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_to_group WHERE service_id = '" . (int)$service_id . "'");

		foreach ($query->rows as $result) {
			$service_group_data[] = $result['group_id'];
		}
		
		return $service_group_data;
	}

	public function getServiceLayouts($service_id) {
		$service_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_to_layout WHERE service_id = '" . (int)$service_id . "'");
		
		foreach ($query->rows as $result) {
			$service_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $service_layout_data;
	}
	public function getServiceRelated($service_id) {
		$service_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_related WHERE service_id = '" . (int)$service_id . "'");
		
		foreach ($query->rows as $result) {
			$service_related_data[] = $result['product_id'];
		}
		
		return $service_related_data;
	}	
	public function getServiceNrelated($service_id) {
		$service_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_related WHERE service_id = '389657" . (int)$service_id . "'");
		$query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_related WHERE product_id = '" . (int)$service_id . "' AND service_id LIKE '389657%'");
		
		foreach ($query->rows as $result) {
			$service_related_data[] = $result['product_id'];
		}
		foreach ($query2->rows as $result2) {
		 if (!in_array(str_replace("389657", "", $result2['service_id']), $service_related_data)) {
			$service_related_data[] = str_replace("389657", "", $result2['service_id']);
		 }
		}
		
		return $service_related_data;
	}	
	public function getServiceNcategories($service_id) {
		$service_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_to_scategory WHERE service_id = '" . (int)$service_id . "'");
		
		foreach ($query->rows as $result) {
			$service_category_data[] = $result['scategory_id'];
		}

		return $service_category_data;
	}
	
	public function getService() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY n.date_added");
	
		return $query->rows;
	}
	
	public function getServiceLimited($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) LEFT JOIN " . DB_PREFIX . "sb_sauthor na ON (n.sauthor_id = na.sauthor_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND LOWER(nd.title) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND n.status = '" . (int)$data['filter_status'] . "'";
		}
	
		$sort_data = array(
			'nd.title',
			'n.sort_order',
			'n.date_added',
			'na.name'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
		} else {
			$sql .= " ORDER BY n.date_added";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
		} else {
				$sql .= " ASC";
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
			
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getTotalServiceByAuthorId($sauthor_id) {
     	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sb_service WHERE sauthor_id = '" . (int)$sauthor_id . "'");
		return $query->row['total'];
	}
	
	public function getAuthorIdbyArticle($service_id) {
     	$query = $this->db->query("SELECT sauthor_id FROM " . DB_PREFIX . "sb_service WHERE service_id = '" . (int)$service_id . "'");
		return $query->row['sauthor_id'];
	}
	
	public function getTotalService($data = array()) {
		$sql = "SELECT COUNT(DISTINCT n.service_id) AS total FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id)";
		
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND LOWER(nd.title) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND n.status = '" . (int)$data['filter_status'] . "'";
		}
		$query = $this->db->query($sql);
		return $query->row['total'];
	}	
	
	public function getArticleImages($service_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_gallery WHERE service_id = '" . (int)$service_id . "'");

		return $query->rows;
	}
	
	public function getArticleVideos($service_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_service_video WHERE service_id = '" . (int)$service_id . "'");

		return $query->rows;
	}
	
	public function addArchiveYear($data, $store=0) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "sb_service_archive SET year = '" . (int)$data['year'] . "', months = '" . $this->db->escape(serialize($data['months'])) . "', store_id = '" . (int)$store . "'");
	}
	
	public function deleteArchive() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_service_archive");
		$this->cache->delete('service');
	}
	
	public function getServiceDA() {

		$group_restriction = $this->config->get('scategory_bservice_restrictgroup') ? " group_id," : '';

		$group_restriction_join = $this->config->get('scategory_bservice_restrictgroup') ? "  LEFT JOIN " . DB_PREFIX . "sb_service_to_group n2g ON (n.service_id = n2g.service_id) " : '';

		$query = $this->db->query("SELECT date_added, store_id,".$group_restriction." n.service_id FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_to_store n2s ON (n.service_id = n2s.service_id)".$group_restriction_join." LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' ORDER BY n.date_added");
	
		return $query->rows;
	}
	
	public function getServiceDU() {

		$group_restriction = $this->config->get('scategory_bservice_restrictgroup') ? " group_id," : '';

		$group_restriction_join = $this->config->get('scategory_bservice_restrictgroup') ? "  LEFT JOIN " . DB_PREFIX . "sb_service_to_group n2g ON (n.service_id = n2g.service_id) " : '';

		$query = $this->db->query("SELECT date_updated, store_id,".$group_restriction." n.service_id FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_to_store n2s ON (n.service_id = n2s.service_id)".$group_restriction_join." LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' ORDER BY n.date_updated");
	
		return $query->rows;
	}
	
	public function getServiceDP() {

		$group_restriction = $this->config->get('scategory_bservice_restrictgroup') ? " group_id," : '';

		$group_restriction_join = $this->config->get('scategory_bservice_restrictgroup') ? "  LEFT JOIN " . DB_PREFIX . "sb_service_to_group n2g ON (n.service_id = n2g.service_id) " : '';

		$query = $this->db->query("SELECT date_pub, store_id,".$group_restriction." n.service_id FROM " . DB_PREFIX . "sb_service n LEFT JOIN " . DB_PREFIX . "sb_service_to_store n2s ON (n.service_id = n2s.service_id)".$group_restriction_join." LEFT JOIN " . DB_PREFIX . "sb_service_description nd ON (n.service_id = nd.service_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' ORDER BY n.date_pub");
	
		return $query->rows;
	}
}
?>
