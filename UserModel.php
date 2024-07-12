<?php
class UserModel extends CI_Model {

    public function insert($data) {
        $this->db->insert('users', $data);
    }

    public function get_by_login($login) {
        return $this->db->get_where('users', array('login' => $login))->row();
    }
}
