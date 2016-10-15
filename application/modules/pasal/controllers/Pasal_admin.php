<?php

defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * Pasal controllers Class
     *
     * @package     SYSCMS
     * @subpackage  Controllers
     * @category    Controllers
     * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
     */
class Pasal_admin extends CI_Controller {
    
  public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('pasal/Pasal_model');
    }
    
    public function index() {
        $data['pasal'] = $this->Pasal_model->get();
        $data['title'] = 'Pasal';
        $data['main'] = 'pasal/list';
        $this->load->view('admin/layout', $data);
    }
    
    // Add User and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('pasal_title', 'Nama', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('pasal_id')) {
                $params['pasal_id'] = $id;
            } else {
                $params['pasal_input_date'] = date('Y-m-d H:i:s');
            }
            $params['pasal_title'] = $this->input->post('pasal_title');
            $params['users_user_id'] = $this->session->userdata('uid');
            $params['pasal_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Pasal_model->add($params);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Pasal',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('pasal_title')
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Pasal Berhasil');
            redirect('admin/pasal');
        } else {
            if ($this->input->post('pasal_id')) {
                redirect('admin/pasal/edit/' . $this->input->post('pasal_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $object = $this->Pasal_model->get(array('id' => $id));
                if ($object == NULL) {
                    redirect('admin/pasal');
                } else {
                    $data['pasal'] = $object;
                }
            }
            $data['title'] = $data['operation'] . ' Pasal';
            $data['main'] = 'pasal/add';
            $this->load->view('admin/layout', $data);
        }
    }
    
    // View data detail
    public function view($id = NULL) {
        $data['pasal'] = $this->Pasal_model->get(array('id' => $id));
        $data['title'] = 'Pasal';
        $data['main'] = 'pasal/view';
        $this->load->view('admin/layout', $data);
    }

    // Delete to database
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Pasal_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Pasal',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Pasal berhasil');
            redirect('admin/pasal');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/pasal/edit/' . $id);
        }
    }

}
