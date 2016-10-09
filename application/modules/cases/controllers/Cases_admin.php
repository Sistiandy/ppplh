<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cases controllers Class
 *
 * @package     SYSCMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Cases_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('cases/Cases_model');
    }

    public function index() {
        $data['cases'] = $this->Cases_model->get();
        $data['title'] = 'Kasus Pelanggaran';
        $data['main'] = 'cases/list';
        $this->load->view('admin/layout', $data);
    }

    // Add User and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('instance_id', 'Instansi', 'trim|required|xss_clean');
        $this->form_validation->set_rules('case_address', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('case_region', 'Wilayah', 'trim|required|xss_clean');
        $this->form_validation->set_rules('channel_id', 'Pelimpahan', 'trim|required|xss_clean');
        $this->form_validation->set_rules('activity_id', 'Jenis Kegiatan', 'trim|required|xss_clean');
        $this->form_validation->set_rules('case_date', 'Tanggal', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('case_id')) {
                $params['case_id'] = $id;
            } else {
                $params['case_input_date'] = date('Y-m-d H:i:s');
            }
            $params['activities_activity_id'] = $this->input->post('activity_id');
            $params['instances_instance_id'] = $this->input->post('instance_id');
            $params['case_address'] = $this->input->post('case_address');
            $params['case_region'] = $this->input->post('case_region');
            $params['channels_channel_id'] = $this->input->post('channel_id');
            $params['case_date'] = $this->input->post('case_date');
            $params['users_user_id'] = $this->session->userdata('uid');
            $params['case_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Cases_model->add($params);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Cases',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $status . ';ID Instansi:' . $this->input->post('instance_id')
                    )
            );

            if ($this->input->is_ajax_request()) {
                echo $status;
            } else {
                $this->session->set_flashdata('success', $data['operation'] . ' Kasus Pelanggaran Berhasil');
                redirect('admin/cases');
            }
        } else {
            if ($this->input->post('case_id')) {
                redirect('admin/cases/edit/' . $this->input->post('case_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $object = $this->Cases_model->get(array('id' => $id));
                if ($object == NULL) {
                    redirect('admin/cases');
                } else {
                    $data['case'] = $object;
                }
            }
            $this->load->model('instances/Instances_model');
            $this->load->model('channels/Channels_model');
            $this->load->model('activities/Activities_model');

            $data['ngapp'] = 'ng-app="app"';
            $data['instances'] = $this->Instances_model->get();
            $data['channels'] = $this->Channels_model->get();
            $data['activities'] = $this->Activities_model->get();
            $data['title'] = $data['operation'] . ' Kasus Pelanggaran';
            $data['main'] = 'cases/add';
            $this->load->view('admin/layout', $data);
        }
    }

    // View data detail
    public function view($id = NULL) {
        $data['case'] = $this->Cases_model->get(array('id' => $id));
        $data['title'] = 'Kasus Pelanggaran';
        $data['main'] = 'cases/view';
        $this->load->view('admin/layout', $data);
    }

    // Delete to database
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Cases_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $id,
                        'log_module' => 'Cases',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';ID Instansi:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Kasus Pelanggaran berhasil');
            redirect('admin/cases');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/cases/edit/' . $id);
        }
    }

}
