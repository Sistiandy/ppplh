<?php

defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * Dashboard controllers Class
     *
     * @package     SYSCMS
     * @subpackage  Controllers
     * @category    Controllers
     * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
     */
class Dashboard_admin extends CI_Controller {
    
  public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
    }
    
    public function index() {
        $this->load->model('cases/Cases_model');
        $this->load->model('users/Users_model');
        $this->load->model('instances/Instances_model');
        $this->load->model('activities/Activities_model');
        
        $data['users'] = count($this->Users_model->get());
        $data['cases'] = count($this->Cases_model->get());
        $data['instances'] = count($this->Instances_model->get());
        $data['activities'] = count($this->Activities_model->get());
        $data['title'] = 'Dashboard';
        $data['main'] = 'dashboard/dashboard';
        $this->load->view('admin/layout', $data);
    }

}
