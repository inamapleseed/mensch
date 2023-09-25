<?php
class ModelCatalogInformation extends Model {
	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}

	public function getInformations() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");

		return $query->rows;
	}

	public function getInformationLayoutId($information_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getInformationRepeater($information_id) {
		$information_repeater_data = array();

		$information_repeater_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_repeater WHERE information_id = '" . (int)$information_id. "' AND language_id = '".(int)$this->config->get('config_language_id')."'");

		// foreach ($information_repeater_query->rows as $information_repeater) {
		// 	$information_repeater_description_data = array();

		// 	$information_repeater_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_repeater WHERE information_id = '" . (int)$information_id . "' AND information_repeater_id = '" . (int)$information_repeater['information_repeater_id'] . "'");

		// 	// debug($information_repeater_description_data);
		// 	$information_repeater_data[$information_repeater['language_id']][] = array(
		// 		'information_repeater_id'  =>  $information_repeater['information_repeater_id'],
		// 		'row_type' => isset($information_repeater['row_type']) && $information_repeater['row_type'] ? $information_repeater['row_type'] :'',
		// 		'image'      => isset($information_repeater['image']) && $information_repeater['image']? $information_repeater['image'] :'',
		// 		'description' => isset($information_repeater['description']) && $information_repeater['description']? $information_repeater['description'] :'',
		// 		'is_brand' => isset($information_repeater['is_brand']) && $information_repeater['is_brand']? $information_repeater['is_brand'] : '',
		// 	);
		// };
	

		return $information_repeater_query->rows;
	}

}