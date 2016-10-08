<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * case Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Cases_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('cases.case_id', $params['id']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('case_last_update', 'desc');
        }
        $this->db->select('cases.case_id, case_title,
            case_input_date, case_last_update');
        $this->db->select('users_user_id, users.user_full_name');

        $this->db->join('users', 'users.user_id = cases.users_user_id', 'left');
        $res = $this->db->get('cases');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['case_id'])) {
            $this->db->set('case_id', $data['case_id']);
        }

        if (isset($data['case_title'])) {
            $this->db->set('case_title', $data['case_title']);
        }
        
        if (isset($data['case_input_date'])) {
            $this->db->set('case_input_date', $data['case_input_date']);
        }

        if (isset($data['case_last_update'])) {
            $this->db->set('case_last_update', $data['case_last_update']);
        }

        if (isset($data['users_user_id'])) {
            $this->db->set('users_user_id', $data['users_user_id']);
        }

        if (isset($data['case_id'])) {
            $this->db->where('case_id', $data['case_id']);
            $this->db->update('cases');
            $id = $data['case_id'];
        } else {
            $this->db->insert('cases');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function delete($id) {
        $this->db->where('case_id', $id);
        $this->db->delete('cases');
    }

}
