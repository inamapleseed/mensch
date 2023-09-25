<?php
class ModelCatalogCalendarEvent extends Model {
	public function addCalendarEvent($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', gwidth = '" . (int)$data['gwidth'] . "', gheight = '" . (int)$data['gheight'] . "', pwidth = '" . (int)$data['pwidth'] . "', pheight = '" . (int)$data['pheight'] . "', awidth = '" . (int)$data['awidth'] . "', aheight = '" . (int)$data['aheight'] . "', position = '" . $this->db->escape($data['position']) . "', resize = '" . (int)$data['resize'] . "', imgperrow = '" . (int)$data['imgperrow'] . "', thumbstyle = '" . $this->db->escape($data['thumbstyle']) . "', popstyle = '" . $this->db->escape($data['popstyle']) . "', cpage = '" . (int)$data['cpage'] . "', date_added = NOW()");

		$cevent_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "calendar_event SET image = '" . $this->db->escape($data['image']) . "' WHERE cevent_id = '" . (int)$cevent_id . "'");
		}
		
		foreach ($data['cevent_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_description SET cevent_id = '" . (int)$cevent_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', price = '" . $this->db->escape($value['price']) . "', duration = '" . $this->db->escape($value['duration']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
		
		if (isset($data['cevent_store'])) {
			foreach ($data['cevent_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_to_store SET cevent_id = '" . (int)$cevent_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'cevent_id=" . (int)$cevent_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['cevent_image'])) {
			foreach ($data['cevent_image'] as $cevent_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_image SET cevent_id = '" . (int)$cevent_id . "', link = '" .  $this->db->escape($cevent_image['link']) . "', image = '" .  $this->db->escape($cevent_image['image']) . "', sort_order = '" . (int)$cevent_image['sort_order'] . "'");

				$cevent_image_id = $this->db->getLastId();

				foreach ($cevent_image['cevent_image_description'] as $language_id => $cevent_image_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_image_description SET cevent_image_id = '" . (int)$cevent_image_id . "', language_id = '" . (int)$language_id . "', cevent_id = '" . (int)$cevent_id . "', title = '" .  $this->db->escape($cevent_image_description['title']) . "'");
				}
			}
		}

		if (isset($data['cevent_timeslots'])) {
			foreach ($data['cevent_timeslots'] as $cevent_timeslot) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_timeslot SET cevent_id = '" . (int)$cevent_id . "', time = '" .  $this->db->escape($cevent_timeslot['time']) . "', slot = '" .  (int)$cevent_timeslot['slot'] . "'");
			}
		}

		if (isset($data['cevent_special_timeslots'])) {
			foreach ($data['cevent_special_timeslots'] as $cevent_special_timeslot) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_special_timeslot SET cevent_id = '" . (int)$cevent_id . "', type = '" .  $this->db->escape($cevent_special_timeslot['type']) . "', date = '" .  $this->db->escape($cevent_special_timeslot['date']) . "', time = '" .  $this->db->escape($cevent_special_timeslot['time']) . "', slot = '" .  (int)$cevent_special_timeslot['slot'] . "'");
			}
		}
		
		$this->cache->delete('cevent');

		return $cevent_id;
	}

	public function editCalendarEvent($cevent_id, $data) {		
		$this->db->query("UPDATE " . DB_PREFIX . "calendar_event SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', gwidth = '" . (int)$data['gwidth'] . "', gheight = '" . (int)$data['gheight'] . "', pwidth = '" . (int)$data['pwidth'] . "', pheight = '" . (int)$data['pheight'] . "', awidth = '" . (int)$data['awidth'] . "', aheight = '" . (int)$data['aheight'] . "', position = '" . $this->db->escape($data['position']) . "', resize = '" . (int)$data['resize'] . "', imgperrow = '" . (int)$data['imgperrow'] . "', thumbstyle = '" . $this->db->escape($data['thumbstyle']) . "', popstyle = '" . $this->db->escape($data['popstyle']) . "', cpage = '" . (int)$data['cpage'] . "', date_modified = NOW() WHERE cevent_id = '" . (int)$cevent_id . "'");
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "calendar_event SET image = '" . $this->db->escape($data['image']) . "' WHERE cevent_id = '" . (int)$cevent_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_description WHERE cevent_id = '" . (int)$cevent_id . "'");

		foreach ($data['cevent_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_description SET cevent_id = '" . (int)$cevent_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', price = '" . $this->db->escape($value['price']) . "', duration = '" . $this->db->escape($value['duration']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_to_store WHERE cevent_id = '" . (int)$cevent_id . "'");

		if (isset($data['cevent_store'])) {
			foreach ($data['cevent_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_to_store SET cevent_id = '" . (int)$cevent_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'cevent_id=" . (int)$cevent_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'cevent_id=" . (int)$cevent_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_image WHERE cevent_id = '" . (int)$cevent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_image_description WHERE cevent_id = '" . (int)$cevent_id . "'");

		if (isset($data['cevent_image'])) {
			foreach ($data['cevent_image'] as $cevent_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_image SET cevent_id = '" . (int)$cevent_id . "', link = '" .  $this->db->escape($cevent_image['link']) . "', image = '" .  $this->db->escape($cevent_image['image']) . "', sort_order = '" . (int)$cevent_image['sort_order'] . "'");

				$cevent_image_id = $this->db->getLastId();

				foreach ($cevent_image['cevent_image_description'] as $language_id => $cevent_image_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_image_description SET cevent_image_id = '" . (int)$cevent_image_id . "', language_id = '" . (int)$language_id . "', cevent_id = '" . (int)$cevent_id . "', title = '" .  $this->db->escape($cevent_image_description['title']) . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_timeslot WHERE cevent_id = '" . (int)$cevent_id . "'");

		if (isset($data['cevent_timeslots'])) {
			foreach ($data['cevent_timeslots'] as $cevent_timeslot) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_timeslot SET cevent_id = '" . (int)$cevent_id . "', time = '" .  $this->db->escape($cevent_timeslot['time']) . "', slot = '" .  (int)$cevent_timeslot['slot'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_special_timeslot WHERE cevent_id = '" . (int)$cevent_id . "'");

		if (isset($data['cevent_special_timeslots'])) {
			foreach ($data['cevent_special_timeslots'] as $cevent_special_timeslot) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "calendar_event_special_timeslot SET cevent_id = '" . (int)$cevent_id . "', type = '" .  $this->db->escape($cevent_special_timeslot['type']) . "', date = '" .  $this->db->escape($cevent_special_timeslot['date']) . "', time = '" .  $this->db->escape($cevent_special_timeslot['time']) . "', slot = '" .  (int)$cevent_special_timeslot['slot'] . "'");
			}
		}
		
		$this->cache->delete('cevent');

	}

	public function deleteCalendarEvent($cevent_id) {		
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event WHERE cevent_id = '" . (int)$cevent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_description WHERE cevent_id = '" . (int)$cevent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_to_store WHERE cevent_id = '" . (int)$cevent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'cevent_id=" . (int)$cevent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_image WHERE cevent_id = '" . (int)$cevent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_image_description WHERE cevent_id = '" . (int)$cevent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_timeslot WHERE cevent_id = '" . (int)$cevent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "calendar_event_special_timeslot WHERE cevent_id = '" . (int)$cevent_id . "'");
	}
    
    public function getCalendarEvent($cevent_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'cevent_id=" . (int)$cevent_id . "') AS keyword FROM " . DB_PREFIX . "calendar_event ce LEFT JOIN " . DB_PREFIX . "calendar_event_description ced ON (ce.cevent_id = ced.cevent_id) WHERE ce.cevent_id = '" . (int)$cevent_id . "' AND ced.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCalendarEvents($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "calendar_event ce LEFT JOIN " . DB_PREFIX . "calendar_event_description ced ON (ce.cevent_id = ced.cevent_id) WHERE ced.language_id = '" . (int)$this->config->get('config_language_id') . "'";
        
        if (!empty($data['filter_name'])) {
			$sql .= " AND ce.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'ced.name',
			'ce.sort_order',
			'ce.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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
	
	public function getCalendarEventDescriptions($cevent_id) {
		$cevent_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "calendar_event_description WHERE cevent_id = '" . (int)$cevent_id . "'");

		foreach ($query->rows as $result) {
			$cevent_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'price'			   => $result['price'],
				'duration'		   => $result['duration'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $cevent_description_data;
	}
	
	public function getCalendarEventStores($cevent_id) {
		$cevent_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "calendar_event_to_store WHERE cevent_id = '" . (int)$cevent_id . "'");

		foreach ($query->rows as $result) {
			$cevent_store_data[] = $result['store_id'];
		}

		return $cevent_store_data;
	}

	public function getCalendarEventImages($cevent_id) {
		$cevent_image_data = array();

		$cevent_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "calendar_event_image WHERE cevent_id = '" . (int)$cevent_id . "' ORDER BY sort_order ASC");

		foreach ($cevent_image_query->rows as $cevent_image) {
			$cevent_image_description_data = array();

			$cevent_image_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "calendar_event_image_description WHERE cevent_image_id = '" . (int)$cevent_image['cevent_image_id'] . "' AND cevent_id = '" . (int)$cevent_id . "'");

			foreach ($cevent_image_description_query->rows as $cevent_image_description) {
				$cevent_image_description_data[$cevent_image_description['language_id']] = array('title' => $cevent_image_description['title']);
			}

			$cevent_image_data[] = array(
				'cevent_image_description' => $cevent_image_description_data,
				'link'                     => $cevent_image['link'],
				'image'                    => $cevent_image['image'],
				'sort_order'               => $cevent_image['sort_order']
			);
		}

		return $cevent_image_data;
	}

	public function getCalendarEventTimeSlots($cevent_id) {
		$cevent_timeslot_data = array();

		$cevent_timeslot_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "calendar_event_timeslot WHERE cevent_id = '" . (int)$cevent_id . "'");

		foreach ($cevent_timeslot_query->rows as $cevent_timeslot) {
			$cevent_timeslot_data[] = array(
				'time' => $cevent_timeslot['time'],
				'slot' => $cevent_timeslot['slot'],
			);
		}


		return $cevent_timeslot_data;
	}

	public function getCalendarEventSpecialTimeSlots($cevent_id) {
		$cevent_special_timeslot_data = array();

		$cevent_special_timeslot_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "calendar_event_special_timeslot WHERE cevent_id = '" . (int)$cevent_id . "'");

		foreach ($cevent_special_timeslot_query->rows as $cevent_special_timeslot) {
			$cevent_special_timeslot_data[] = array(
				'type' => $cevent_special_timeslot['type'],
				'date' => $cevent_special_timeslot['date'],
				'time' => $cevent_special_timeslot['time'],
				'slot' => $cevent_special_timeslot['slot'],
			);
		}

		return $cevent_special_timeslot_data;
	}

	public function getTotalCalendarEvent() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "calendar_event");

		return $query->row['total'];
	}
}