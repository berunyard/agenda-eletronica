<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ActivityModel;

defined('BASEPATH'); // nao pode ser acessado pelo navegador

class ActivityController extends Controller
{

    /*public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('ActivityModel');
        $this->load->database();
    }*/

    public function index()
    { // exibir a lista de atividades do usuário
        $session = \Config\Services::session();
        // obtém id do usuario da sessao
        if (!$session->get('user_id')) {
            return redirect()->to('login'); // redireciona se nao tiver feito login
        }
        // atividades do metodo getbyuser sao pegas e buscas
        $activityModel = new ActivityModel();
        // mostra o activity/index com os dados
        $user_id = $session->get('user_id');
        $data['activities'] = $activityModel->getByUser($user_id);

        return view('activity/index', $data);
    }

    public function create()
    { // exibe o formulário de criação de uma atividade
        return view('create_activity');
        //$this->load->view('create_activity'); // mostra o formulário
    }

    public function store()
    { // processar o envio do formulário de criação de atv.

        $session = \Config\Services::session();

        // checa se logou
        if (!$session->get('user_id')) {
            return redirect()->to('login'); // redireciona se nao tiver feito login
        }

        // carrega activity model
        $activityModel = new ActivityModel();

        // preparar p inserir a data
        $data = [
            'user_id' => $session->get('user_id'),
            'nome' => $this->request->getPost('nome'),
            'descricao' => $this->request->getPost('descricao'),
            'data_inicio' => $this->request->getPost('data_inicio'),
            'data_termino' => $this->request->getPost('data_termino'),
            'status' => 'pendente'
        ];

        // insere na db
        $activityModel->insert($data);

        // redireciona db
        return redirect()->to('activity');
        /*$this->load->model('ActivityModel');
        // array com os detalhes de cada nova atividade
        $data = array(
            'user_id' => $this->session->userdata('user_id'),
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'data_inicio' => $this->input->post('data_inicio'),
            'data_termino' => $this->input->post('data_termino'),
            'status' => 'pendente'
        );
        // insere no db
        $this->ActivityModel->insert($data);
        // vai pra pag de atv.
        redirect('activity');*/
    }

    public function edit($id)
    { // exibe formulario de edição
        // carrega activitymodel
        $activityModel = new ActivityModel();

        // pega atv por id
        $data['activity'] = $activityModel->find($id);

        // carrega
        return view('edit_activity', $data);
        /*$this->load->model('ActivityModel');
        // obtém dados da atividade pelo id usando o metodo do ActivityModel
        $data['activity'] = $this->ActivityModel->get($id);
        // carrega a view e passa os dados para view
        $this->load->view('edit_activity', $data);*/
    }

    public function update($id)
    { // atualizar os dados de uma atv existente
        $activityModel = new ActivityModel();
        //$this->load->model('ActivityModel');
        // array com novos dados
        $data = [
            'nome' => $this->request->getPost('nome'),
            'descricao' => $this->request->getPost('descricao'),
            'data_inicio' => $this->request->getPost('data_inicio'),
            'data_termino' => $this->request->getPost('data_termino'),
            'status' => $this->request->getPost('status')
        ];
        //$data = array(
        //'nome' => $this->input->post('nome'),
        //'descricao' => $this->input->post('descricao'),
        //'data_inicio' => $this->input->post('data_inicio'),
        //'data_termino' => $this->input->post('data_termino'),
        //'status' => $this->input->post('status')
        // );
        // atualiza atv no db usando ActivityModel
        $activityModel->update($id, $data); // updatea o id e data no db
        return redirect()->to('activity');
        // redirect('activity'); // vai p pag de atv.
    }

    public function delete($id)
    { // excluir atv
        $activityModel = new ActivityModel();

        $activityModel->delete($id);

        return redirect()->to('activity');

        /*$this->load->model('ActivityModel');
        $this->ActivityModel->delete($id); // deleta pelo id usando o ActivityMOdel
        redirect('activity'); // vai pra pag de atv (index/ActivityController)*/
    }
}
