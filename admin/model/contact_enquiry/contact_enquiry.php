<?php
class ModelContactEnquiryContactEnquiry extends Model {

	public function getContact($contact_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "contact_id WHERE contact_id = '" . (int)$contact_id . "'");

		return $query->row;
	}

	public function getContacts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contact";

		$implode = array();

		if (!empty($data['filter_contact_name'])) {
			$implode[] = "contact_name LIKE '%" . $this->db->escape($data['filter_contact_name']) . "%'";
		}
                
		if (!empty($data['filter_contact_phone'])) {
			$implode[] = "contact_phone LIKE '%" . $this->db->escape($data['filter_contact_phone']) . "%'";
		}
                
		if (!empty($data['filter_contact_email'])) {
			$implode[] = "contact_email LIKE '%" . $this->db->escape($data['filter_contact_email']) . "%'";
		}
                
		if (!empty($data['filter_contact_message'])) {
			$implode[] = "(contact_subject LIKE '%" . $this->db->escape($data['filter_contact_message']) . "%' OR contact_message LIKE '%" . $this->db->escape($data['filter_contact_message']) . "%')";
		}
                
		if (!empty($data['filter_contact_date'])) {
			$implode[] = "contact_date LIKE '%" . $this->db->escape($data['filter_contact_date']) . "%'";
		}
                
		if (!empty($data['filter_contact_status'])) {
			$implode[] = "contact_status LIKE '%" . $this->db->escape($data['filter_contact_status']) . "%'";
		}

        if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'contact_name',
			'contact_phone',
			'contact_email',
            'contact_message',
            'contact_status',
            'contact_date'
		);
                
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY contact_date";
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

	public function getTotalContacts($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "contact";

		$implode = array();

		if (!empty($data['filter_contact_name'])) {
			$implode[] = "contact_name LIKE '%" . $this->db->escape($data['filter_contact_name']) . "%'";
		}
                
		if (!empty($data['filter_contact_phone'])) {
			$implode[] = "contact_phone LIKE '%" . $this->db->escape($data['filter_contact_phone']) . "%'";
		}
                
		if (!empty($data['filter_contact_email'])) {
			$implode[] = "contact_email LIKE '%" . $this->db->escape($data['filter_contect_email']) . "%'";
		}
                
		if (!empty($data['filter_contact_message'])) {
			$implode[] = "(contact_subject LIKE '%" . $this->db->escape($data['filter_contact_message']) . "%' OR contact_message LIKE '%" . $this->db->escape($data['filter_contact_message']) . "%')";
		}
                
        if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(s.contact_date) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_contact_status'])) {
			$implode[] = "contact_status LIKE '%" . $this->db->escape($data['filter_contact_status']) . "%'";
		}

        if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
//echo $sql;die;
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}
