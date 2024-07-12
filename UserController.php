<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    public function register() {
        $this->load->view('register');
    }

    public function store() {
        $this->load->model('UserModel');
        $data = array(
            'login' => $this->input->post('login'),
            'senha' => password_hash($this->input->post('senha'), PASSWORD_BCRYPT)
        );
        $this->UserModel->insert($data);
        redirect('user/login');
    }

    public function login() {
        $this->load->view('login');
    }

    public function authenticate() {
        $this->load->model('UserModel');
        $login = $this->input->post('login');
        $senha = $this->input->post('senha');
        $user = $this->UserModel->get_by_login($login);
        if ($user && password_verify($senha, $user->senha)) {
            $this->session->set_userdata('user_id', $user->id);
            redirect('activity');
        } else {
            redirect('user/login');
        }
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        redirect('user/login');
    }
}
