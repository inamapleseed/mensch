<?php
class ModelCatalogAppointment extends Model {
	public function addAppointment($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "appointment SET event_id = '" . (int)$data['event'] . "', date = '" . $this->db->escape($data['date']) . "', time = '" . $this->db->escape($data['time']) . "', name = '" . $this->db->escape($data['name']) . "', contact = '" . $this->db->escape($data['contact']) . "', email = '" . $this->db->escape($data['email']) . "', outlet = '" . $this->db->escape($data['outlet']) . "', message = '" . $this->db->escape($data['message']) . "'");

		$appointment_id = $this->db->getLastId();

		$this->cache->delete('appointment');

		return $appointment_id;
	}

	public function editAppointment($appointment_id, $data) {		
		$this->db->query("UPDATE " . DB_PREFIX . "appointment SET event_id = '" . (int)$data['event'] . "', date = '" . $this->db->escape($data['date']) . "', time = '" . $this->db->escape($data['time']) . "', name = '" . $this->db->escape($data['name']) . "', contact = '" . $this->db->escape($data['contact']) . "', email = '" . $this->db->escape($data['email']) . "', outlet = '" . $this->db->escape($data['outlet']) . "', message = '" . $this->db->escape($data['message']) . "' WHERE appointment_id = '" . (int)$appointment_id . "'");
		
		$this->cache->delete('appointment');
	}

	public function deleteAppointment($appointment_id) {		
		$this->db->query("DELETE FROM " . DB_PREFIX . "appointment WHERE appointment_id = '" . (int)$appointment_id . "'");
	}

	public function getAppointments($data = array()) {	
		$sql = "SELECT * FROM " . DB_PREFIX . "appointment";

        if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
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

	public function getAppointment($appointment_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "appointment WHERE appointment_id = '" . (int)$appointment_id . "'");

		return $query->row;
	}

	public function getCalendarEvents() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "calendar_event ce LEFT JOIN " . DB_PREFIX . "calendar_event_description ced ON (ce.cevent_id = ced.cevent_id)");

		return $query->rows;
	}
    
    public function getCalendarEvent($cevent_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'cevent_id=" . (int)$cevent_id . "') AS keyword FROM " . DB_PREFIX . "calendar_event ce LEFT JOIN " . DB_PREFIX . "calendar_event_description ced ON (ce.cevent_id = ced.cevent_id) WHERE ce.cevent_id = '" . (int)$cevent_id . "' AND ced.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getTotalAppointment($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "appointment";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}