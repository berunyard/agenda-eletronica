<?php
defined('BASEPATH'); // nao pode ser acessado pelo navegador

class UserController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('UserModel');
        $this->load->database();
    }
    
    public function register() { // exibe formulário de registro
        $this->load->view('register'); // carrega a view do register.php
    }

    public function store() { // processa e store o formulário de registro
        $this->load->model('UserModel');
        // cria array com login e senha (post)
        $data = array(
            'login' => $this->input->post('login'),
            'senha' => password_hash($this->input->post('senha'), PASSWORD_BCRYPT)
        );
        // pega o metodo insert do UserModel para inserir na db
        $this->UserModel->insert($data);
        // vai pro login
        redirect('user/login');
    }

    public function login() { // exibe formulário de login
        $this->load->view('login'); // carrega a view do login.php
    }

    public function authenticate() { // processa e autentica o formulário de login
        $this->load->model('UserModel');
        // obtém dados de login e senha
        $login = $this->input->post('login');
        $senha = $this->input->post('senha');
        // pega o metodo do UserModel e busca pelo login do usuário
        $user = $this->UserModel->get_by_login($login);
        // a senha existe e esta correta?
        if ($user && password_verify($senha, $user->senha)) {
            // define a sessão
            $this->session->set_userdata('user_id', $user->id);
            redirect('activity');
        } else {
            // volta pra pág de login
            redirect('user/login');
        }
    }

    public function logout() {
        // remove os dados da sessão
        $this->session->unset_userdata('user_id');
        // vai pra pág de login
        redirect('user/login');
    }
}
