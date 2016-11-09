<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Instance Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class instances_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('instances.instance_id', $params['id']);
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
            $this->db->order_by('instance_last_update', 'desc');
        }
        $this->db->select('instances.instance_id, instance_name, instance_email, instance_address,
            instance_phone, instance_input_date, instance_last_update');
        $this->db->select('users_user_id, users.user_full_name');

        $this->db->join('users', 'users.user_id = instances.users_user_id', 'left');
        $res = $this->db->get('instances');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['instance_id'])) {
            $this->db->set('instance_id', $data['instance_id']);
        }

        if (isset($data['instance_name'])) {
            $this->db->set('instance_name', $data['instance_name']);
        }

        if (isset($data['instance_email'])) {
            $this->db->set('instance_email', $data['instance_email']);
        }

        if (isset($data['instance_address'])) {
            $this->db->set('instance_address', $data['instance_address']);
        }

        if (isset($data['instance_phone'])) {
            $this->db->set('instance_phone', $data['instance_phone']);
        }
        
        if (isset($data['instance_input_date'])) {
            $this->db->set('instance_input_date', $data['instance_input_date']);
        }

        if (isset($data['instance_last_update'])) {
            $this->db->set('instance_last_update', $data['instance_last_update']);
        }

        if (isset($data['users_user_id'])) {
            $this->db->set('users_user_id', $data['users_user_id']);
        }

        if (isset($data['instance_id'])) {
            $this->db->where('instance_id', $data['instance_id']);
            $this->db->update('instances');
            $id = $data['instance_id'];
        } else {
            $this->db->insert('instances');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function delete($id) {
        $this->db->where('instance_id', $id);
        $this->db->delete('instances');
    }

}
