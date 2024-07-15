<?php
class UserModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) { // inserir dado/registro na tabela 'users'
        $this->db->insert('users', $data); // insere o dado $data na tabela 'users' do banco
    }

    public function get_by_login($login) { // busca usuário pelo login
        // executa consulta no banco de dados para obter o registro do usuário pelo login
        return $this->db->get_where('users', array('login' => $login))->row();
    }
}
