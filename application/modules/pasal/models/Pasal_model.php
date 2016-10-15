<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * pasal Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Pasal_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('pasal.pasal_id', $params['id']);
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
            $this->db->order_by('pasal_last_update', 'desc');
        }
        $this->db->select('pasal.pasal_id, pasal_title,
            pasal_input_date, pasal_last_update');
        $this->db->select('users_user_id, users.user_full_name');

        $this->db->join('users', 'users.user_id = pasal.users_user_id', 'left');
        $res = $this->db->get('pasal');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['pasal_id'])) {
            $this->db->set('pasal_id', $data['pasal_id']);
        }

        if (isset($data['pasal_title'])) {
            $this->db->set('pasal_title', $data['pasal_title']);
        }
        
        if (isset($data['pasal_input_date'])) {
            $this->db->set('pasal_input_date', $data['pasal_input_date']);
        }

        if (isset($data['pasal_last_update'])) {
            $this->db->set('pasal_last_update', $data['pasal_last_update']);
        }

        if (isset($data['users_user_id'])) {
            $this->db->set('users_user_id', $data['users_user_id']);
        }

        if (isset($data['pasal_id'])) {
            $this->db->where('pasal_id', $data['pasal_id']);
            $this->db->update('pasal');
            $id = $data['pasal_id'];
        } else {
            $this->db->insert('pasal');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function delete($id) {
        $this->db->where('pasal_id', $id);
        $this->db->delete('pasal');
    }

}
