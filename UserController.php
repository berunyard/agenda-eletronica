<?php
/*use CodeIgniter\Controller;
defined('BASEPATH'); // nao pode ser acessado pelo navegador

class UserController extends Controller {

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
}*/

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new UserModel(); // inicializa UserModel
    }

    public function register()
    {
        // carrega registro view
        return view('register');
    }

    public function store()
    {
        // valida a data
        $validationRules = [
            'login' => 'required',
            'senha' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // processa data
        $data = [
            'login' => $this->request->getPost('login'),
            'senha' => password_hash($this->request->getPost('senha'), PASSWORD_BCRYPT)
        ];

        // vai pra db
        $this->userModel->insert($data);

        // redireciona p pag de login
        return redirect()->to('login');
    }

    public function login()
    {
        // tela de login
        return view('login');
    }

    public function authenticate()
    {
        // valida data do formulario
        $validationRules = [
            'login' => 'required',
            'senha' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // login
        $login = $this->request->getPost('login');
        $senha = $this->request->getPost('senha');

        // pega usuario login
        $user = $this->userModel->getByLogin($login);

        // verifica senha
        if ($user && password_verify($senha, $user->senha)) {
            // sessao
            $session = session();
            $session->set('user_id', $user->id);

            // volta pra activity pag
            return redirect()->to('activity');
        } else {
            // redireciona pra login se falhar
            return redirect()->to('login');
        }
    }

    public function logout()
    {
        // bye bye
        $session = session();
        $session->remove('user_id');

        // vai p pagina de login
        return redirect()->to('login');
    }
}

