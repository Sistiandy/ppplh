<?php

defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * Institutions controllers Class
     *
     * @package     SYSCMS
     * @subpackage  Controllers
     * @category    Controllers
     * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
     */
class Institutions_admin extends CI_Controller {
    
  public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('institutions/Institutions_model');
    }
    
    public function index() {
        $data['institutions'] = $this->Institutions_model->get();
        $data['title'] = 'Institusi';
        $data['main'] = 'institutions/list';
        $this->load->view('admin/layout', $data);
    }
    
    // Add User and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('institution_name', 'Nama', 'trim|required|xss_clean');
        $this->form_validation->set_rules('institution_phone', 'No. Telepon', 'trim|required|xss_clean');
        $this->form_validation->set_rules('institution_address', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('institution_id')) {
                $params['institution_id'] = $id;
            } else {
                $params['institution_input_date'] = date('Y-m-d H:i:s');
            }
            $params['institution_name'] = $this->input->post('institution_name');
            $params['institution_address'] = $this->input->post('institution_address');
            $params['institution_email'] = $this->input->post('institution_email');
            $params['institution_phone'] = $this->input->post('institution_phone');
            $params['users_user_id'] = $this->session->userdata('uid');
            $params['institution_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Institutions_model->add($params);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Institutions',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('institution_name')
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Petugas Berhasil');
            redirect('admin/institutions');
        } else {
            if ($this->input->post('institution_id')) {
                redirect('admin/institutions/edit/' . $this->input->post('institution_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $object = $this->Institutions_model->get(array('id' => $id));
                if ($object == NULL) {
                    redirect('admin/institutions');
                } else {
                    $data['institution'] = $object;
                }
            }
            $data['title'] = $data['operation'] . ' Institusi';
            $data['main'] = 'institutions/add';
            $this->load->view('admin/layout', $data);
        }
    }
    
    // View data detail
    public function view($id = NULL) {
        $data['institution'] = $this->Institutions_model->get(array('id' => $id));
        $data['title'] = 'Institusi';
        $data['main'] = 'institutions/view';
        $this->load->view('admin/layout', $data);
    }

    // Delete to database
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Institutions_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $id,
                        'log_module' => 'Institutions',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Institusi berhasil');
            redirect('admin/institutions');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/institutions/edit/' . $id);
        }
    }

}
