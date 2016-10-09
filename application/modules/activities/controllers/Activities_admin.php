<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Activities controllers Class
 *
 * @package     SYSCMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Activities_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('activities/Activities_model');
    }

    public function index() {
        $data['activities'] = $this->Activities_model->get();
        $data['title'] = 'Jenis Kegiatan';
        $data['main'] = 'activities/list';
        $this->load->view('admin/layout', $data);
    }

    // Add User and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('activity_title', 'Judul Kegiatan', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('activity_id')) {
                $params['activity_id'] = $id;
            } else {
                $params['activity_input_date'] = date('Y-m-d H:i:s');
            }
            $params['activity_title'] = $this->input->post('activity_title');
            $params['users_user_id'] = $this->session->userdata('uid');
            $params['activity_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Activities_model->add($params);

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Activities',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('activity_title')
                    )
            );

            if ($this->input->is_ajax_request()) {
                echo $status;
            } else {
                $this->session->set_flashdata('success', $data['operation'] . ' Jenis Kegiatan Berhasil');
                redirect('admin/activities');
            };
        } else {
            if ($this->input->post('activity_id')) {
                redirect('admin/activities/edit/' . $this->input->post('activity_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $object = $this->Activities_model->get(array('id' => $id));
                if ($object == NULL) {
                    redirect('admin/activities');
                } else {
                    $data['activity'] = $object;
                }
            }
            $data['title'] = $data['operation'] . ' Jenis Kegiatan';
            $data['main'] = 'activities/add';
            $this->load->view('admin/layout', $data);
        }
    }

    // View data detail
    public function view($id = NULL) {
        $data['activity'] = $this->Activities_model->get(array('id' => $id));
        $data['title'] = 'Jenis Kegiatan';
        $data['main'] = 'activities/view';
        $this->load->view('admin/layout', $data);
    }

    // Delete to database
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Activities_model->delete($id);
            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $id,
                        'log_module' => 'Activities',
                        'log_action' => 'Hapus',
                        'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
                    )
            );
            $this->session->set_flashdata('success', 'Hapus Jenis Kegiatan berhasil');
            redirect('admin/activities');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/activities/edit/' . $id);
        }
    }

}
