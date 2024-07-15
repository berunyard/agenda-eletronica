<?php
class ActivityModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert($data) { // inserir dado/registro na tabela 'users'
        $this->db->insert('activities', $data); // insere o dado $data na tabela 'users' do banco
    }

    public function get($id) { // pegar atividade pelo id
        // consulta e retorna pelo banco de dados
        return $this->db->get_where('activities', array('id' => $id))->row();
    }

    public function get_by_user($user_id) { // pegar todas as atividades de um usuário pelo id
        // consulta e retorna pelo banco de dados
        return $this->db->get_where('activities', array('user_id' => $user_id))->result();
    }

    public function update($id, $data) { // atualizar atividade
        $this->db->where('id', $id); // condição para atualização
        $this->db->update('activities', $data); // atualiza no database
    }

    public function delete($id) { // deleta atividade 
        $this->db->delete('activities', array('id' => $id)); // deleta atv no databse com o id dado pelo usuário
    }
}

