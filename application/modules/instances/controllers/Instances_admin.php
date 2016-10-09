<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * instances controllers Class
 *
 * @package     SYSCMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Instances_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('instances/Instances_model');
    }

    public function index() {
        $data['instances'] = $this->Instances_model->get();
        $data['title'] = 'Instansi';
        $data['main'] = 'instances/list';
        $this->load->view('admin/layout', $data);
    }

    // Add User and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('instance_name', 'Nama', 'trim|required|xss_clean');
        $this->form_validation->set_rules('instance_phone', 'No. Telepon', 'trim|required|xss_clean');
        $this->form_validation->set_rules('instance_address', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('instance_id')) {
                $params['instance_id'] = $id;
            } else {
                $params['instance_input_date'] = date('Y-m-d H:i:s');
            }
            $params['instance_name'] = $this->input->post('instance_name');
            $params['instance_address'] = $this->input->post('instance_address');
            $params['instance_email'] = $this->input->post('instance_email');
            $params['instance_phone'] = $this->input->post('instance_phone');
            $params['users_user_id'] = $this->session->userdata('uid');
            $params['instance_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Instances_model->add($params);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Instansi',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('instance_name')
                    )
            );

            if ($this->input->is_ajax_request()) {
                echo $status;
            } else {
                $this->session->set_flashdata('success', $data['operation'] . ' Instansi Berhasil');
                redirect('admin/instances');
            }
        } else {
            if ($this->input->post('instance_id')) {
                redirect('admin/instances/edit/' . $this->input->post('instance_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $object = $this->Instances_model->get(array('id' => $id));
                if ($object == NULL) {
                    redirect('admin/instances');
                } else {
                    $data['instance'] = $object;
                }
            }
            $data['title'] = $data['operation'] . ' Instansi';
            $data['main'] = 'instances/add';
            $this->load->view('admin/layout', $data);
        }
    }

    // View data detail
    public function view($id = NULL) {
        $data['instance'] = $this->Instances_model->get(array('id' => $id));
        $data['title'] = 'Instansi';
        $data['main'] = 'instances/view';
        $this->load->view('admin/layout', $data);
    }

    // Delete to database
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Instances_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $id,
                        'log_module' => 'instances',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Instansi berhasil');
            redirect('admin/instances');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/instances/edit/' . $id);
        }
    }

}
