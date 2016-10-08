<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * activity Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Activities_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('activities.activity_id', $params['id']);
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
            $this->db->order_by('activity_last_update', 'desc');
        }
        $this->db->select('activities.activity_id, activity_title,
            activity_input_date, activity_last_update');
        $this->db->select('users_user_id, users.user_full_name');

        $this->db->join('users', 'users.user_id = activities.users_user_id', 'left');
        $res = $this->db->get('activities');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['activity_id'])) {
            $this->db->set('activity_id', $data['activity_id']);
        }

        if (isset($data['activity_title'])) {
            $this->db->set('activity_title', $data['activity_title']);
        }
        
        if (isset($data['activity_input_date'])) {
            $this->db->set('activity_input_date', $data['activity_input_date']);
        }

        if (isset($data['activity_last_update'])) {
            $this->db->set('activity_last_update', $data['activity_last_update']);
        }

        if (isset($data['users_user_id'])) {
            $this->db->set('users_user_id', $data['users_user_id']);
        }

        if (isset($data['activity_id'])) {
            $this->db->where('activity_id', $data['activity_id']);
            $this->db->update('activities');
            $id = $data['activity_id'];
        } else {
            $this->db->insert('activities');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function delete($id) {
        $this->db->where('activity_id', $id);
        $this->db->delete('activities');
    }

}
