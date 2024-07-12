<?php
class ActivityModel extends CI_Model {

    public function insert($data) {
        $this->db->insert('activities', $data);
    }

    public function get($id) {
        return $this->db->get_where('activities', array('id' => $id))->row();
    }

    public function get_by_user($user_id) {
        return $this->db->get_where('activities', array('user_id' => $user_id))->result();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('activities', $data);
    }

    public function delete($id) {
        $this->db->delete('activities', array('id' => $id));
    }
}

