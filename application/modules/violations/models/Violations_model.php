<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * violation Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Violations_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('violations.violation_id', $params['id']);
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
            $this->db->order_by('violation_last_update', 'desc');
        }
        $this->db->select('violations.violation_id, violation_title,
            violation_input_date, violation_last_update');
        $this->db->select('users_user_id, users.user_full_name');

        $this->db->join('users', 'users.user_id = violations.users_user_id', 'left');
        $res = $this->db->get('violations');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['violation_id'])) {
            $this->db->set('violation_id', $data['violation_id']);
        }

        if (isset($data['violation_title'])) {
            $this->db->set('violation_title', $data['violation_title']);
        }
        
        if (isset($data['violation_input_date'])) {
            $this->db->set('violation_input_date', $data['violation_input_date']);
        }

        if (isset($data['violation_last_update'])) {
            $this->db->set('violation_last_update', $data['violation_last_update']);
        }

        if (isset($data['users_user_id'])) {
            $this->db->set('users_user_id', $data['users_user_id']);
        }

        if (isset($data['violation_id'])) {
            $this->db->where('violation_id', $data['violation_id']);
            $this->db->update('violations');
            $id = $data['violation_id'];
        } else {
            $this->db->insert('violations');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function delete($id) {
        $this->db->where('violation_id', $id);
        $this->db->delete('violations');
    }

}
