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
class Reports_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('cases/Cases_model');
    }

    public function index() {
        $this->load->model('activities/Activities_model');
        $data['cases'] = $this->Cases_model->get();
        $data['types'] = $this->Activities_model->get();
        $data['title'] = 'Kasus Pelanggaran';
        $data['main'] = 'cases/list';
        $this->load->view('admin/layout', $data);
    }

    public function taat() {
        // Apply Filter
        // Get $_GET variable
        $q = $this->input->get(NULL, TRUE);

        $data['q'] = $q;
        $params = array();

        // Kegiatan
        if (isset($q['a']) && !empty($q['a']) && $q['a'] != '') {
            $params['activity_id'] = $q['a'];
        }

        // Wilayah Kerja
        if (isset($q['r']) && !empty($q['r']) && $q['r'] != '') {
            $params['case_region'] = $q['r'];
        }

        // Date start
        if (isset($q['ds']) && !empty($q['ds']) && $q['ds'] != '') {
            $params['date_start'] = $q['ds'];
        }

        // Date end
        if (isset($q['de']) && !empty($q['de']) && $q['de'] != '') {
            $params['date_end'] = $q['de'];
        }
        $params['case_final_status'] = 'Taat';
        $this->load->model('activities/Activities_model');
        $data['types'] = $this->Activities_model->get();
        $data['cases'] = $this->Cases_model->get($params);
        $data['title'] = 'Kasus Pelanggaran Taat';
        $data['status'] = 'taat';
        $data['main'] = 'reports/list';
        $this->load->view('admin/layout', $data);
    }

    public function dibekukan() {

        // Apply Filter
        // Get $_GET variable
        $q = $this->input->get(NULL, TRUE);

        $data['q'] = $q;
        $params = array();

        // Kegiatan
        if (isset($q['a']) && !empty($q['a']) && $q['a'] != '') {
            $params['activity_id'] = $q['a'];
        }

        // Wilayah Kerja
        if (isset($q['r']) && !empty($q['r']) && $q['r'] != '') {
            $params['case_region'] = $q['r'];
        }

        // Date start
        if (isset($q['ds']) && !empty($q['ds']) && $q['ds'] != '') {
            $params['date_start'] = $q['ds'];
        }

        // Date end
        if (isset($q['de']) && !empty($q['de']) && $q['de'] != '') {
            $params['date_end'] = $q['de'];
        }
        $params['case_final_status'] = 'Tidak Taat';
        $this->load->model('activities/Activities_model');
        $data['types'] = $this->Activities_model->get();
        $data['cases'] = $this->Cases_model->get($params);
        $data['title'] = 'Kasus Pelanggaran Dibekukan';
        $data['status'] = 'dibekukan';
        $data['main'] = 'reports/list';
        $this->load->view('admin/layout', $data);
    }

    public function pdf($final = 'taat') {
        // Apply Filter
        // Get $_GET variable
        $q = $this->input->get(NULL, TRUE);

        $data['q'] = $q;
        $params = array();

        // Kegiatan
        if (isset($q['a']) && !empty($q['a']) && $q['a'] != '') {
            $params['activity_id'] = $q['a'];
        }

        // Wilayah Kerja
        if (isset($q['r']) && !empty($q['r']) && $q['r'] != '') {
            $params['case_region'] = $q['r'];
        }

        // Date start
        if (isset($q['ds']) && !empty($q['ds']) && $q['ds'] != '') {
            $params['date_start'] = $q['ds'];
        }

        // Date end
        if (isset($q['de']) && !empty($q['de']) && $q['de'] != '') {
            $params['date_end'] = $q['de'];
        }
        if ($final == 'taat') {
            $params['case_final_status'] = 'Taat';
        } else {
            $params['case_final_status'] = 'Tidak Taat';
        }
        $data['title'] = $final == 'taat' ? 'Kasus Pelanggaran Taat' : "Kasus Pelanggaran Tidak Taat";
        $data['cases'] = $this->Cases_model->get($params);
        $this->load->helper('dompdf');
        $html = $this->load->view('reports/pdf', $data, true);
        $data = pdf_create($html, 'Laporan-' . $final, 'A4');
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
        $data['main'] = 'reports/view';
        $this->load->view('admin/layout', $data);
    }

}
