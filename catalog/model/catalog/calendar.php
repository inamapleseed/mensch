<?php
class ModelCatalogCalendar extends Model {	

	public function addAppointment($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "appointment SET event_id = '" . (int)$data['event_id'] . "', date = '" . $this->db->escape($data['date']) . "', time = '" . $this->db->escape($data['time']) . "', name = '" . $this->db->escape($data['name']) . "', contact = '" . $this->db->escape($data['contact']) . "', email = '" . $this->db->escape($data['email']) . "', outlet = '" . $this->db->escape($data['outlet']) . "', message = '" . $this->db->escape($data['message']) . "'");

		$appointment_id = $this->db->getLastId();

		return $appointment_id;
	}

	public function getCalendarEvent($cevent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "calendar_event ce LEFT JOIN " . DB_PREFIX . "calendar_event_description ced ON (ce.cevent_id = ced.cevent_id) WHERE ce.cevent_id = '" . (int)$cevent_id . "'");

		return $query->row;
	}

	public function getCalendarEventImage($cevent_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "calendar_event_image cei WHERE cei.cevent_id = '" . (int)$cevent_id . "'";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getCalendarEventTimeSlots($cevent_id, $selected_date) {
		$time = array();

		$sql = "SELECT * FROM " . DB_PREFIX . "calendar_event_timeslot WHERE cevent_id = '" . $cevent_id . "'";
		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$appointments = $this->getAppointment($cevent_id, $selected_date, $result['time']);

			// debug(strtotime(date("Y-m-d H:i")));
			// debug(strtotime($selected_date . ' ' . $result['time']));

			if($appointments['total'] < $result['slot'] && strtotime(date("Y-m-d H:i")) < strtotime($selected_date . ' ' . $result['time'])) {
				$time[] = array(
					'time' => $result['time'],
					'slot' => $result['slot'],
				);
			}
		}

		return $time;
	}

	public function getAppointment($cevent_id, $selected_date, $time) {
		$sql = "SELECT COUNT(*) as total FROM " . DB_PREFIX . "appointment WHERE event_id = '" . (int)$cevent_id . "' AND date = '" . $selected_date . "'AND time = '" . $time . "'";
		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getCalendarEventSpecialTimeSlots($cevent_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "calendar_event_special_timeslot WHERE cevent_id = '" . (int)$cevent_id . "'";
		$query = $this->db->query($sql);
		return $query->rows;
	}
}
?>