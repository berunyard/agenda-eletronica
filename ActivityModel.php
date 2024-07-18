<?php

/*class ActivityModel extends Model {

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
}*/

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table = 'activities';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'nome', 'descricao', 'data_inicio', 'data_termino', 'status'];


    public function insertActivity($data)
    {
        return $this->insert($data);
    }

    public function getActivity($id)
    {
        return $this->find($id);
    }

    public function getActivitiesByUser($user_id)
    {
        return $this->where('user_id', $user_id)->findAll();
    }

    public function updateActivity($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteActivity($id)
    {
        return $this->delete($id);
    }
}

