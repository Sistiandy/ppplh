<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * channel Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Channels_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('channels.channel_id', $params['id']);
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
            $this->db->order_by('channel_id', 'desc');
        }
        $this->db->select('channels.channel_id, channel_name');

        $res = $this->db->get('channels');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function add($data = array()) {

        if (isset($data['channel_id'])) {
            $this->db->set('channel_id', $data['channel_id']);
        }

        if (isset($data['channel_name'])) {
            $this->db->set('channel_name', $data['channel_name']);
        }

        if (isset($data['channel_id'])) {
            $this->db->where('channel_id', $data['channel_id']);
            $this->db->update('channels');
            $id = $data['channel_id'];
        } else {
            $this->db->insert('channels');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function delete($id) {
        $this->db->where('channel_id', $id);
        $this->db->delete('channels');
    }

}
