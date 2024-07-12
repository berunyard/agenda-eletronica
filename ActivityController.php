<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActivityController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('user/login');
        }
    }

    public function index() {
        $this->load->model('ActivityModel');
        $data['activities'] = $this->ActivityModel->get_by_user($this->session->userdata('user_id'));
        $this->load->view('list_activities', $data);
    }

    public function create() {
        $this->load->view('create_activity');
    }

    public function store() {
        $this->load->model('ActivityModel');
        $data = array(
            'user_id' => $this->session->userdata('user_id'),
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'data_inicio' => $this->input->post('data_inicio'),
            'data_termino' => $this->input->post('data_termino'),
            'status' => 'pendente'
        );
        $this->ActivityModel->insert($data);
        redirect('activity');
    }

    public function edit($id) {
        $this->load->model('ActivityModel');
        $data['activity'] = $this->ActivityModel->get($id);
        $this->load->view('edit_activity', $data);
    }

    public function update($id) {
        $this->load->model('ActivityModel');
        $data = array(
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'data_inicio' => $this->input->post('data_inicio'),
            'data_termino' => $this->input->post('data_termino'),
            'status' => $this->input->post('status')
        );
        $this->ActivityModel->update($id, $data);
        redirect('activity');
    }

    public function delete($id) {
        $this->load->model('ActivityModel');
        $this->ActivityModel->delete($id);
        redirect('activity');
    }
}
