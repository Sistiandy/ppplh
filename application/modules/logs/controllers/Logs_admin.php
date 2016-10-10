<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Logs controllers Class
 *
 * @package     SYSCMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Logs_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('logs/Logs_model');
    }

    public function index() {
        $data['logs'] = $this->Logs_model->get();
        $data['title'] = 'Log Aktifitas';
        $data['main'] = 'logs/list';
        $this->load->view('admin/layout', $data);
    }

}
