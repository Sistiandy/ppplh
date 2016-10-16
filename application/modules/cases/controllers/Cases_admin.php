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
                $params['stage_id'] = STAGE_STAFF;
            }
            $params['activities_activity_id'] = $this->input->post('activity_id');
            $params['instances_instance_id'] = $this->input->post('instance_id');
            $params['case_address'] = $this->input->post('case_address');
            $params['case_note'] = $this->input->post('case_note');
            $params['case_region'] = $this->input->post('case_region');
            $params['channels_channel_id'] = $this->input->post('channel_id');
            $params['case_date'] = $this->input->post('case_date');
            $params['users_user_id'] = $this->session->userdata('uid');
            $params['case_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Cases_model->add($params);

            if (isset($_POST['violation_id'])) {
                $violationId = $_POST['violation_id'];
                $cpt = count($_POST['violation_id']);
                for ($i = 0; $i < $cpt; $i++) {
                    $param['violations_violation_id'] = $violationId[$i];
                    $param['cases_case_id'] = $status;
                    $this->Cases_model->addHasViolations($param);
                }
            }

            if (isset($_POST['pasal_id'])) {
                $pasalId = $_POST['pasal_id'];
                $cpt = count($_POST['pasal_id']);
                for ($i = 0; $i < $cpt; $i++) {
                    $param['pasal_pasal_id'] = $pasalId[$i];
                    $param['cases_case_id'] = $status;
                    $this->Cases_model->addHasPasal($param);
                }
            }

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
            $this->load->model('channels/Channels_model');
            $this->load->model('violations/Violations_model');
            $this->load->model('pasal/Pasal_model');

            $data['ngapp'] = 'ng-app="app"';
            $data['channels'] = $this->Channels_model->get();
            $data['violations'] = $this->Violations_model->get();
            $data['pasal'] = $this->Pasal_model->get();
            $data['title'] = $data['operation'] . ' Kasus Pelanggaran';
            $data['main'] = 'cases/add';
            $this->load->view('admin/layout', $data);
        }
    }

    // View data detail
    public function view($id = NULL) {

        $data['ngapp'] = 'ng-app="app"';
        $data['case'] = $this->Cases_model->get(array('id' => $id));
        $data['casesViolations'] = $this->Cases_model->getHasViolations(array('cases_id' => $id));
        $data['casesViolationsVerify'] = $this->Cases_model->getHasViolations(array('cases_id' => $id, 'verification_by_analis' => TRUE));
        $data['casesViolations1False'] = $this->Cases_model->getHasViolations(array('cases_id' => $id, 'verification_sanksi1' => FALSE));
        $data['casesPasal'] = $this->Cases_model->getHasPasal(array('cases_id' => $id));
        $data['casesDisposisi'] = $this->Cases_model->getCasesDisposisi(array('cases_id' => $id));
        $data['title'] = 'Kasus Pelanggaran';
        $data['main'] = 'cases/view';
        $this->load->view('admin/layout', $data);
    }

    // Disposisi cases
    public function disposisi($id = NULL) {
        if ($_POST) {
            $this->Cases_model->addCasesDisposisi(
                    array(
                        'cases_disposisi_input_date' => date('Y-m-d H:i:s'),
                        'cases_disposisi_last_update' => date('Y-m-d H:i:s'),
                        'cases_case_id' => $id,
                        'from_role_id' => $this->input->post('from_role_id'),
                        'to_role_id' => $this->input->post('to_role_id'),
                        'users_user_id' => $this->session->userdata('uid')
                    )
            );

            $this->Cases_model->add(array('case_id' => $id, 'stage_id' => $this->input->post('stage_id')));

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Cases',
                        'log_action' => 'Disposisi',
                        'log_info' => 'ID:' . $id . ';From role ID:' . $this->input->post('from_role_id') . ';To role ID:' . $this->input->post('to_role_id')
                    )
            );
            $this->session->set_flashdata('success', 'Disposisi Kasus Pelanggaran berhasil');
            redirect('admin/cases/view/' . $id);
        } elseif (!$_POST) {
            redirect('admin/cases/view/' . $id);
        }
    }

    // Penalty cases
    public function penalty($id = NULL) {
        if ($_POST) {
            $this->Cases_model->add(
                    array(
                        'case_id' => $id,
                        'stage_id' => STAGE_STAFF,
                        'sanksi_type' => $this->input->post('sanksi_type')
            ));

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Cases',
                        'log_action' => 'Menentukan Jenis sanksi',
                        'log_info' => 'ID:' . $id . ';Jenis Sanksi:' . $this->input->post('sanksi_type')
                    )
            );
            $this->session->set_flashdata('success', 'Sanksi Kasus Pelanggaran berhasil');
            redirect('admin/cases/view/' . $id);
        } elseif (!$_POST) {
            redirect('admin/cases/view/' . $id);
        }
    }
    
    // Status cases
    public function status($id = NULL) {
        if ($_POST) {
            $this->Cases_model->add(
                    array(
                        'case_id' => $id,
                        'stage_id' => STAGE_STAFF,
                        'case_final_status' => $this->input->post('case_final_status')
            ));

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Cases',
                        'log_action' => 'Menentukan Status Kasus',
                        'log_info' => 'ID:' . $id . ';Status Akhir:' . $this->input->post('case_final_status')
                    )
            );
            $this->session->set_flashdata('success', 'Status Kasus Pelanggaran berhasil');
            redirect('admin/cases/view/' . $id);
        } elseif (!$_POST) {
            redirect('admin/cases/view/' . $id);
        }
    }

    // Verification cases
    public function first_verification($id = NULL) {
        if ($_POST) {
            $this->Cases_model->add(
                    array(
                        'case_id' => $id,
                        'case_for_draft' => $this->input->post('case_for_draft'),
                        'case_is_signatured' => $this->input->post('case_is_signatured'),
                        'sent_meeting_invitation' => $this->input->post('sent_meeting_invitation'),
                        'berita_acara_pemanggilan' => $this->input->post('berita_acara_pemanggilan'),
                        'case_is_published' => $this->input->post('case_is_published'),
                        'create_assignment_verification_letter' => $this->input->post('create_assignment_verification_letter'),
                        'sent_report' => $this->input->post('sent_report'),
                        'stage_id' => STAGE_ANALIS
            ));

            if (isset($_POST['cases_has_violations_id'])) {
                $violationId = $_POST['cases_has_violations_id'];
                $cpt = count($_POST['cases_has_violations_id']);
                for ($i = 0; $i < $cpt; $i++) {
                    $param['cases_has_violations_id'] = $violationId[$i];
                    $param['verification_sanksi1'] = $_POST['verification_sanksi_' . $violationId[$i]];
                    if ($_POST['verification_sanksi_' . $violationId[$i]] == TRUE) {
                        $param['verification_sanksi2'] = TRUE;
                    }
                    $this->Cases_model->addHasViolations($param);
                }
            };

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Cases',
                        'log_action' => 'Verifikasi lapangan pelaksaan sanksi pertama',
                        'log_info' => 'ID:' . $id . ';'
                    )
            );
            $this->session->set_flashdata('success', 'Verifikasi lapangan pelaksaan sanksi pertama berhasil');
            redirect('admin/cases/view/' . $id);
        } elseif (!$_POST) {
            redirect('admin/cases/view/' . $id);
        }
    }

    // Verification cases
    public function first_evaluation($id = NULL) {
        if ($_POST) {
            $this->Cases_model->add(
                    array(
                        'case_id' => $id,
                        'case_evaluation1_note' => $this->input->post('case_evaluation1_note'),
                        'case_evaluation1_status' => $this->input->post('case_evaluation1_status'),
                        'stage_id' => STAGE_STAFF
            ));

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Cases',
                        'log_action' => 'Evaluasi Pertama',
                        'log_info' => 'ID:' . $id . ';'
                    )
            );
            $this->session->set_flashdata('success', 'Evaluasi pertama berhasil');
            redirect('admin/cases/view/' . $id);
        } elseif (!$_POST) {
            redirect('admin/cases/view/' . $id);
        }
    }

    // Verification cases
    public function second_verification($id = NULL) {
        if ($_POST) {
//            $this->Cases_model->add(
//                    array(
//                        'case_id' => $id,
//                        'stage_id' => STAGE_ANALIS
//            ));

            if (isset($_POST['cases_has_violations_id'])) {
                $violationId = $_POST['cases_has_violations_id'];
                $cpt = count($_POST['cases_has_violations_id']);
                for ($i = 0; $i < $cpt; $i++) {
                    $param['cases_has_violations_id'] = $violationId[$i];
                    $param['verification_sanksi2'] = $_POST['verification_sanksi_' . $violationId[$i]];
                    $this->Cases_model->addHasViolations($param);
                }
            };

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Cases',
                        'log_action' => 'Verifikasi lapangan pelaksaan sanksi kedua',
                        'log_info' => 'ID:' . $id . ';'
                    )
            );
            $this->session->set_flashdata('success', 'Verifikasi lapangan pelaksaan sanksi kedua berhasil');
            redirect('admin/cases/view/' . $id);
        } elseif (!$_POST) {
            redirect('admin/cases/view/' . $id);
        }
    }

    // Verification cases
    public function second_evaluation($id = NULL) {
        if ($_POST) {
            $this->Cases_model->add(
                    array(
                        'case_id' => $id,
                        'case_evaluation2_note' => $this->input->post('case_evaluation2_note'),
                        'case_evaluation2_status' => $this->input->post('case_evaluation2_status'),
                        'stage_id' => STAGE_STAFF
            ));

            // activity log
            $this->load->model('logs/Logs_model');
            $this->Logs_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('uid'),
                        'log_module' => 'Cases',
                        'log_action' => 'Evaluasi Kedua',
                        'log_info' => 'ID:' . $id . ';'
                    )
            );
            $this->session->set_flashdata('success', 'Evaluasi kedua berhasil');
            redirect('admin/cases/view/' . $id);
        } elseif (!$_POST) {
            redirect('admin/cases/view/' . $id);
        }
    }

    // Verify to violations
    public function verifyViolations() {
        $id = $this->input->post('cases_has_violations_id');
        $desc = $this->input->post('desc');
        if ($this->input->is_ajax_request()) {
            if ($desc == 'yes') {
                $this->Cases_model->addHasViolations(array('cases_has_violations_id' => $id, 'verification_by_analis' => TRUE));
            } else {
                $this->Cases_model->addHasViolations(array('cases_has_violations_id' => $id, 'verification_by_analis' => FALSE));
            }
            echo $id;
        }
    }

    // Verify to violations
    public function addSanksiPeriode() {
        $id = $this->input->post('cases_has_violations_id');
        $sanksi = $this->input->post('sanksi_periode');
        if ($this->input->is_ajax_request()) {
            $this->Cases_model->addHasViolations(array('cases_has_violations_id' => $id, 'sanksi_periode' => $sanksi));
            echo $id;
        }
    }

}
