<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * institution Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Institutions_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('institutions.institution_id', $params['id']);
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
            $this->db->order_by('institution_last_update', 'desc');
        }
        $this->db->select('institutions.institution_id, institution_name, institution_email, institution_address,
            institution_phone, institution_input_date, institution_last_update');
        $this->db->select('users_user_id, users.user_full_name');

        $this->db->join('users', 'users.user_id = institutions.users_user_id', 'left');
        $res = $this->db->get('institutions');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['institution_id'])) {
            $this->db->set('institution_id', $data['institution_id']);
        }

        if (isset($data['institution_name'])) {
            $this->db->set('institution_name', $data['institution_name']);
        }

        if (isset($data['institution_email'])) {
            $this->db->set('institution_email', $data['institution_email']);
        }

        if (isset($data['institution_address'])) {
            $this->db->set('institution_address', $data['institution_address']);
        }

        if (isset($data['institution_phone'])) {
            $this->db->set('institution_phone', $data['institution_phone']);
        }
        
        if (isset($data['institution_input_date'])) {
            $this->db->set('institution_input_date', $data['institution_input_date']);
        }

        if (isset($data['institution_last_update'])) {
            $this->db->set('institution_last_update', $data['institution_last_update']);
        }

        if (isset($data['users_user_id'])) {
            $this->db->set('users_user_id', $data['users_user_id']);
        }

        if (isset($data['institution_id'])) {
            $this->db->where('institution_id', $data['institution_id']);
            $this->db->update('institutions');
            $id = $data['institution_id'];
        } else {
            $this->db->insert('institutions');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function delete($id) {
        $this->db->where('institution_id', $id);
        $this->db->delete('institutions');
    }

}
