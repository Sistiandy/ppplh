<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api controllers class
 *
 * @package     SYSCMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $res = array('message' => 'Nothing here');

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }
    
    public function getInstances($id = NULL) {
        $this->load->model('instances/Instances_model');
        $res = $this->Instances_model->get();

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }
    
    public function getActivities($id = NULL) {
        $this->load->model('activities/Activities_model');
        $res = $this->Activities_model->get();

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }
    
    public function getViolationsByCase($id = NULL) {
        $this->load->model('cases/Cases_model');
        $res = $this->Cases_model->getHasViolations(array('cases_id' => $id));

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }

}
