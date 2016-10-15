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
        $this->db->select('cases.case_id, case_address, case_region,
            case_date, sanksi_type, stage_id, case_for_draft, case_is_signatured, sent_meeting_invitation,
            berita_acara_pemanggilan, case_is_published, create_assignment_verification_letter,
            sent_report, case_evaluation1_note, case_evaluation1_status,
            case_evaluation2_note, case_evaluation2_status, case_note,
            case_input_date, case_last_update');
        $this->db->select('cases.users_user_id, users.user_full_name');
        $this->db->select('instances_instance_id, instances.instance_name');
        $this->db->select('channels_channel_id, channels.channel_name');
        $this->db->select('activities_activity_id, activities.activity_title');

        $this->db->join('users', 'users.user_id = cases.users_user_id', 'left');
        $this->db->join('instances', 'instances.instance_id = cases.instances_instance_id', 'left');
        $this->db->join('channels', 'channels.channel_id = cases.channels_channel_id', 'left');
        $this->db->join('activities', 'activities.activity_id = cases.activities_activity_id', 'left');
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

        if (isset($data['instances_instance_id'])) {
            $this->db->set('instances_instance_id', $data['instances_instance_id']);
        }

        if (isset($data['case_address'])) {
            $this->db->set('case_address', $data['case_address']);
        }

        if (isset($data['case_region'])) {
            $this->db->set('case_region', $data['case_region']);
        }

        if (isset($data['channels_channel_id'])) {
            $this->db->set('channels_channel_id', $data['channels_channel_id']);
        }

        if (isset($data['activities_activity_id'])) {
            $this->db->set('activities_activity_id', $data['activities_activity_id']);
        }

        if (isset($data['case_date'])) {
            $this->db->set('case_date', $data['case_date']);
        }

        if (isset($data['sanksi_type'])) {
            $this->db->set('sanksi_type', $data['sanksi_type']);
        }

        if (isset($data['stage_id'])) {
            $this->db->set('stage_id', $data['stage_id']);
        }

        if (isset($data['case_note'])) {
            $this->db->set('case_note', $data['case_note']);
        }

        if (isset($data['case_for_draft'])) {
            $this->db->set('case_for_draft', $data['case_for_draft']);
        }

        if (isset($data['case_is_signatured'])) {
            $this->db->set('case_is_signatured', $data['case_is_signatured']);
        }

        if (isset($data['sent_meeting_invitation'])) {
            $this->db->set('sent_meeting_invitation', $data['sent_meeting_invitation']);
        }

        if (isset($data['berita_acara_pemanggilan'])) {
            $this->db->set('berita_acara_pemanggilan', $data['berita_acara_pemanggilan']);
        }

        if (isset($data['case_is_published'])) {
            $this->db->set('case_is_published', $data['case_is_published']);
        }

        if (isset($data['create_assignment_verification_letter'])) {
            $this->db->set('create_assignment_verification_letter', $data['create_assignment_verification_letter']);
        }

        if (isset($data['sent_report'])) {
            $this->db->set('sent_report', $data['sent_report']);
        }

        if (isset($data['case_evaluation1_note'])) {
            $this->db->set('case_evaluation1_note', $data['case_evaluation1_note']);
        }

        if (isset($data['case_evaluation1_status'])) {
            $this->db->set('case_evaluation1_status', $data['case_evaluation1_status']);
        }

        if (isset($data['case_evaluation2_note'])) {
            $this->db->set('case_evaluation2_note', $data['case_evaluation2_note']);
        }

        if (isset($data['case_evaluation2_status'])) {
            $this->db->set('case_evaluation2_status', $data['case_evaluation2_status']);
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

    // Get From Databases
    function getHasViolations($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('cases_has_violations_id', $params['id']);
        }
        if (isset($params['cases_id'])) {
            $this->db->where('cases_case_id', $params['cases_id']);
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
            $this->db->order_by('cases_has_violations_id', 'desc');
        }
        $this->db->select('cases_has_violations_id, cases_case_id, violations_violation_id,
                verification_by_analis, sanksi_periode, verification_sanksi1, verification_sanksi2');
        $this->db->select('violations.violation_title');

        $this->db->join('violations', 'violations.violation_id = cases_has_violations.violations_violation_id', 'left');
        $res = $this->db->get('cases_has_violations');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function addHasViolations($data = array()) {

        if (isset($data['cases_has_violations_id'])) {
            $this->db->set('cases_has_violations_id', $data['cases_has_violations_id']);
        }

        if (isset($data['cases_case_id'])) {
            $this->db->set('cases_case_id', $data['cases_case_id']);
        }

        if (isset($data['violations_violation_id'])) {
            $this->db->set('violations_violation_id', $data['violations_violation_id']);
        }

        if (isset($data['verification_by_analis'])) {
            $this->db->set('verification_by_analis', $data['verification_by_analis']);
        }

        if (isset($data['sanksi_periode'])) {
            $this->db->set('sanksi_periode', $data['sanksi_periode']);
        }

        if (isset($data['verification_sanksi1'])) {
            $this->db->set('verification_sanksi1', $data['verification_sanksi1']);
        }

        if (isset($data['verification_sanksi2'])) {
            $this->db->set('verification_sanksi2', $data['verification_sanksi2']);
        }
        
        if (isset($data['cases_has_violations_id'])) {
            $this->db->where('cases_has_violations_id', $data['cases_has_violations_id']);
            $this->db->update('cases_has_violations');
            $id = $data['cases_has_violations_id'];
        } else {
            $this->db->insert('cases_has_violations');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function deleteHasViolations($id) {
        $this->db->where('cases_has_violations_id', $id);
        $this->db->delete('cases_has_violations');
    }

    // Get From Databases
    function getHaspasal($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('cases_has_pasal_id', $params['id']);
        }
        if (isset($params['cases_id'])) {
            $this->db->where('cases_case_id', $params['cases_id']);
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
            $this->db->order_by('cases_has_pasal_id', 'desc');
        }
        $this->db->select('cases_has_pasal_id, cases_case_id, pasal_pasal_id');
        $this->db->select('pasal.pasal_title');

        $this->db->join('pasal', 'pasal.pasal_id = cases_has_pasal.pasal_pasal_id', 'left');
        $res = $this->db->get('cases_has_pasal');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function addHasPasal($data = array()) {

        if (isset($data['cases_has_pasal_id'])) {
            $this->db->set('cases_has_pasal_id', $data['cases_has_pasal_id']);
        }

        if (isset($data['cases_case_id'])) {
            $this->db->set('cases_case_id', $data['cases_case_id']);
        }

        if (isset($data['pasal_pasal_id'])) {
            $this->db->set('pasal_pasal_id', $data['pasal_pasal_id']);
        }
        
        if (isset($data['cases_has_pasal_id'])) {
            $this->db->where('cases_has_pasal_id', $data['cases_has_pasal_id']);
            $this->db->update('cases_has_pasal');
            $id = $data['cases_has_pasal_id'];
        } else {
            $this->db->insert('cases_has_pasal');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function deleteHasPasal($id) {
        $this->db->where('cases_has_pasal_id', $id);
        $this->db->delete('cases_has_pasal');
    }

    // Get From Databases
    function getCasesDisposisi($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('cases_disposisi_id', $params['id']);
        }
        
        if (isset($params['cases_id'])) {
            $this->db->where('cases_case_id', $params['cases_id']);
        }
        
        if (isset($params['from_role_id'])) {
            $this->db->where('from_role_id', $params['from_role_id']);
        }
        
        if (isset($params['to_role_id'])) {
            $this->db->where('to_role_id', $params['to_role_id']);
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
            $this->db->order_by('cases_disposisi_last_update', 'desc');
        }
        $this->db->select('cases_disposisi_id, cases_case_id, from_role_id, to_role_id,
                cases_disposisi_input_date, cases_disposisi_last_update');
        $this->db->select('cases_disposisi.users_user_id, users.user_full_name');
        $this->db->select('from_role.role_name AS from_role_name');
        $this->db->select('to_role.role_name AS to_role_name');
        
        $this->db->select('cases.*');
        $this->db->select('cases.instances_instance_id, instances.instance_name');
        $this->db->select('cases.channels_channel_id, channels.channel_name');
        $this->db->select('cases.activities_activity_id, activities.activity_title');

        $this->db->join('cases', 'cases.case_id = cases_disposisi.cases_case_id', 'right');
        $this->db->join('instances', 'instances.instance_id = cases.instances_instance_id', 'left');
        $this->db->join('channels', 'channels.channel_id = cases.channels_channel_id', 'left');
        $this->db->join('activities', 'activities.activity_id = cases.activities_activity_id', 'left');

        $this->db->join('users', 'users.user_id = cases_disposisi.users_user_id', 'left');
        $this->db->join('user_roles AS from_role', 'from_role.role_id = cases_disposisi.from_role_id', 'left');
        $this->db->join('user_roles AS to_role', 'to_role.role_id = cases_disposisi.to_role_id', 'left');
        $res = $this->db->get('cases_disposisi');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Insert some data to table
    function addCasesDisposisi($data = array()) {

        if (isset($data['cases_disposisi_id'])) {
            $this->db->set('cases_disposisi_id', $data['cases_disposisi_id']);
        }

        if (isset($data['from_role_id'])) {
            $this->db->set('from_role_id', $data['from_role_id']);
        }

        if (isset($data['cases_case_id'])) {
            $this->db->set('cases_case_id', $data['cases_case_id']);
        }

        if (isset($data['to_role_id'])) {
            $this->db->set('to_role_id', $data['to_role_id']);
        }

        if (isset($data['cases_disposisi_input_date'])) {
            $this->db->set('cases_disposisi_input_date', $data['cases_disposisi_input_date']);
        }

        if (isset($data['cases_disposisi_last_update'])) {
            $this->db->set('cases_disposisi_last_update', $data['cases_disposisi_last_update']);
        }

        if (isset($data['users_user_id'])) {
            $this->db->set('users_user_id', $data['users_user_id']);
        }
        
        if (isset($data['cases_disposisi_id'])) {
            $this->db->where('cases_disposisi_id', $data['cases_disposisi_id']);
            $this->db->update('cases_disposisi');
            $id = $data['cases_disposisi_id'];
        } else {
            $this->db->insert('cases_disposisi');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Drop some data to table
    function deleteCasesDisposisi($id) {
        $this->db->where('cases_disposisi_id', $id);
        $this->db->delete('cases_disposisi');
    }
    

}
