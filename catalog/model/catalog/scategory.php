<?php
class ModelCatalogscategory extends Model {
	public function getscategory($scategory_id) {

		$group_restriction = $this->config->get('scategory_bnews_restrictgroup') ? " AND c2g.group_id = '" . (int)$this->config->get('config_customer_group_id') . "' " : '';

		$group_restriction_join = $this->config->get('scategory_bnews_restrictgroup') ? " LEFT JOIN " . DB_PREFIX . "sb_scategory_to_group c2g ON (c.scategory_id = c2g.scategory_id) " : '';

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "sb_scategory c LEFT JOIN " . DB_PREFIX . "sb_scategory_description cd ON (c.scategory_id = cd.scategory_id) LEFT JOIN " . DB_PREFIX . "sb_scategory_to_store c2s ON (c.scategory_id = c2s.scategory_id)".$group_restriction_join." WHERE c.scategory_id = '" . (int)$scategory_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'" . $group_restriction);
		
		return $query->row;
	}
	
	public function getscategories($parent_id = 0) {

		$group_restriction = $this->config->get('scategory_bnews_restrictgroup') ? " AND c2g.group_id = '" . (int)$this->config->get('config_customer_group_id') . "' " : '';

		$group_restriction_join = $this->config->get('scategory_bnews_restrictgroup') ? " LEFT JOIN " . DB_PREFIX . "sb_scategory_to_group c2g ON (c.scategory_id = c2g.scategory_id) " : '';

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_scategory c LEFT JOIN " . DB_PREFIX . "sb_scategory_description cd ON (c.scategory_id = cd.scategory_id) LEFT JOIN " . DB_PREFIX . "sb_scategory_to_store c2s ON (c.scategory_id = c2s.scategory_id)".$group_restriction_join." WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ". $group_restriction ." ORDER BY c.sort_order, LCASE(cd.name)");
		
		return $query->rows;
	}

	public function getscategoriesByParentId($scategory_id) {
		$scategory_data = array();
		
		$scategory_query = $this->db->query("SELECT scategory_id FROM " . DB_PREFIX . "sb_scategory WHERE parent_id = '" . (int)$scategory_id . "'");
		
		foreach ($scategory_query->rows as $scategory) {
			$scategory_data[] = $scategory['scategory_id'];
			
			$children = $this->getscategoriesByParentId($scategory['scategory_id']);
			
			if ($children) {
				$scategory_data = array_merge($children, $scategory_data);
			}			
		}
		
		return $scategory_data;
	}
		
	public function getscategoryLayoutId($scategory_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_scategory_to_layout WHERE scategory_id = '" . (int)$scategory_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_scategory');
		}
	}
					
	public function getTotalscategoriesByscategoryId($parent_id = 0) {

		$group_restriction = $this->config->get('scategory_bnews_restrictgroup') ? " AND c2g.group_id = '" . (int)$this->config->get('config_customer_group_id') . "' " : '';

		$group_restriction_join = $this->config->get('scategory_bnews_restrictgroup') ? " LEFT JOIN " . DB_PREFIX . "sb_scategory_to_group c2g ON (c.scategory_id = c2g.scategory_id) " : '';

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sb_scategory c LEFT JOIN " . DB_PREFIX . "sb_scategory_to_store c2s ON (c.scategory_id = c2s.scategory_id)".$group_restriction_join." WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'" . $group_restriction);
		
		return $query->row['total'];
	}
}
?>