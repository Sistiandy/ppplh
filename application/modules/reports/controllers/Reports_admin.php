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
        $data['cases'] = $this->Cases_model->get();
        $data['title'] = 'Kasus Pelanggaran';
        $data['main'] = 'cases/list';
        $this->load->view('admin/layout', $data);
    }

    public function taat() {
        $data['cases'] = $this->Cases_model->get(array('case_final_status' => 'Taat'));
        $data['title'] = 'Kasus Pelanggaran Taat';
        $data['status'] = 'taat';
        $data['main'] = 'reports/list';
        $this->load->view('admin/layout', $data);
    }

    public function dibekukan() {
        $data['cases'] = $this->Cases_model->get(array('case_final_status' => 'Tidak Taat'));
        $data['title'] = 'Kasus Pelanggaran Dibekukan';
        $data['status'] = 'dibekukan';
        $data['main'] = 'reports/list';
        $this->load->view('admin/layout', $data);
    }

    public function pdf($final = 'taat') {
        $data['title'] = $final == 'taat'? 'Kasus Pelanggaran Taat' : "Kasus Pelanggaran Tidak Taat";
        $data['cases'] = $this->Cases_model->get(array('case_final_status' => $final == 'taat'? 'Taat' : "Tidak Taat"));
        $this->load->helper('dompdf');
        $html = $this->load->view('reports/pdf', $data, true);
        $data = pdf_create($html, 'Laporan-'.$final, 'A4');
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
