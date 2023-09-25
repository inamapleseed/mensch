<?php
class ModelCatalogSauthor extends Model {
	public function addAuthor($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "sb_sauthor SET name = '" . $this->db->escape($data['name']) . "', adminid = '" . $this->db->escape($data['adminid']) . "'");

		$sauthor_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "sb_sauthor SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE sauthor_id = '" . (int)$sauthor_id . "'");
		}

		foreach ($data['sauthor_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "sb_sauthor_description SET sauthor_id = '" . (int)$sauthor_id . "', language_id = '" . (int)$language_id . "', ctitle = '" . $this->db->escape($value['ctitle']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'sauthor_id=" . (int)$sauthor_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('sauthor');
	}

	public function editAuthor($sauthor_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "sb_sauthor SET name = '" . $this->db->escape($data['name']) . "', adminid = '" . $this->db->escape($data['adminid']) . "' WHERE sauthor_id = '" . (int)$sauthor_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "sb_sauthor SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE sauthor_id = '" . (int)$sauthor_id . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_sauthor_description WHERE sauthor_id = '" . (int)$sauthor_id . "'");
		foreach ($data['sauthor_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "sb_sauthor_description SET sauthor_id = '" . (int)$sauthor_id . "', language_id = '" . (int)$language_id . "', ctitle = '" . $this->db->escape($value['ctitle']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'sauthor_id=" . (int)$sauthor_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'sauthor_id=" . (int)$sauthor_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('sauthor');
	}

	public function deleteAuthor($sauthor_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_sauthor WHERE sauthor_id = '" . (int)$sauthor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "sb_sauthor_description WHERE sauthor_id = '" . (int)$sauthor_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'sauthor_id=" . (int)$sauthor_id . "'");

		$this->cache->delete('sauthor');
	}	

	public function getAuthor($sauthor_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'sauthor_id=" . (int)$sauthor_id . "') AS keyword FROM " . DB_PREFIX . "sb_sauthor WHERE sauthor_id = '" . (int)$sauthor_id . "'");

		return $query->row;
	}

	public function getAuthorAdminID($sauthor_id) {
		$query = $this->db->query("SELECT adminid FROM " . DB_PREFIX . "sb_sauthor WHERE sauthor_id = '" . (int)$sauthor_id . "'");
		return $query->row['adminid'];
	}
	
	public function getAuthors() {
		$sql = "SELECT * FROM " . DB_PREFIX . "sb_sauthor";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getSauthorDescriptions($sauthor_id) {
		$sauthor_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sb_sauthor_description WHERE sauthor_id = '" . (int)$sauthor_id . "'");
		
		foreach ($query->rows as $result) {
			$sauthor_description_data[$result['language_id']] = array(
				'ctitle'            => $result['ctitle'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $sauthor_description_data;
	}
	public function getTotalAuthors() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sb_sauthor");

		return $query->row['total'];
	}	
}
?>