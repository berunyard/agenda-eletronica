<?php
defined('BASEPATH'); // nao pode ser acessado pelo navegador

class ActivityController extends CI_Controller {

    public function index() { // exibir a lista de atividades do usuário
        $this->load->model('ActivityModel');
        // obtém id do usuario da sessao
        $user_id = $this->session->userdata('user_id');
        // atividades do metodo geybyuser sao pegas e buscas
        $data['activities'] = $this->ActivityModel->get_by_user($user_id);
        // mostra o activity/index com os dados
        $this->load->view('activity/index', $data);
    }

    public function create() { // exibe o formulário de criação de uma atividade
        $this->load->view('create_activity'); // mostra o formulário
    }

    public function store() { // processar o envio do formulário de criação de atv.
        $this->load->model('ActivityModel');
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
        redirect('activity');
    }

    public function edit($id) { // exibe formulario de edição
        $this->load->model('ActivityModel');
        // obtém dados da atividade pelo id usando o metodo do ActivityModel
        $data['activity'] = $this->ActivityModel->get($id);
        // carrega a view e passa os dados para view
        $this->load->view('edit_activity', $data);
    }

    public function update($id) { // atualizar os dados de uma atv existente
        $this->load->model('ActivityModel');
        // array com novos dados
        $data = array(
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'data_inicio' => $this->input->post('data_inicio'),
            'data_termino' => $this->input->post('data_termino'),
            'status' => $this->input->post('status')
        );
        // atualiza atv no db usando ActivityModel
        $this->ActivityModel->update($id, $data); // updatea o id e data no db
        redirect('activity'); // vai p pag de atv.
    }

    public function delete($id) { // excluir atv
        $this->load->model('ActivityModel');
        $this->ActivityModel->delete($id); // deleta pelo id usando o ActivityMOdel
        redirect('activity'); // vai pra pag de atv (index/ActivityController)
    }
}
