<?php

defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * Violations controllers Class
     *
     * @package     SYSCMS
     * @subpackage  Controllers
     * @category    Controllers
     * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
     */
class Violations_admin extends CI_Controller {
    
  public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('violations/Violations_model');
    }
    
    public function index() {
        $data['violations'] = $this->Violations_model->get();
        $data['title'] = 'Pelanggaran';
        $data['main'] = 'violations/list';
        $this->load->view('admin/layout', $data);
    }
    
    // Add User and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('violation_title', 'Nama', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('violation_id')) {
                $params['violation_id'] = $id;
            } else {
                $params['violation_input_date'] = date('Y-m-d H:i:s');
            }
            $params['violation_title'] = $this->input->post('violation_title');
            $params['users_user_id'] = $this->session->userdata('uid');
            $params['violation_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Violations_model->add($params);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Violations',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('violation_title')
                    )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' Petugas Berhasil');
            redirect('admin/violations');
        } else {
            if ($this->input->post('violation_id')) {
                redirect('admin/violations/edit/' . $this->input->post('violation_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $object = $this->Violations_model->get(array('id' => $id));
                if ($object == NULL) {
                    redirect('admin/violations');
                } else {
                    $data['violation'] = $object;
                }
            }
            $data['title'] = $data['operation'] . ' Pelanggaran';
            $data['main'] = 'violations/add';
            $this->load->view('admin/layout', $data);
        }
    }
    
    // View data detail
    public function view($id = NULL) {
        $data['violation'] = $this->Violations_model->get(array('id' => $id));
        $data['title'] = 'Pelanggaran';
        $data['main'] = 'violations/view';
        $this->load->view('admin/layout', $data);
    }

    // Delete to database
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Violations_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $id,
                        'log_module' => 'Violations',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Pelanggaran berhasil');
            redirect('admin/violations');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/violations/edit/' . $id);
        }
    }

}
