<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class followup_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->current_session      = $this->setting_model->getCurrentSession();
        $this->current_session_name = $this->setting_model->getCurrentSessionName();
        $this->start_month          = $this->setting_model->getStartMonth();
    }

    public function getclasses($id = null)
    {
        $this->db->select()->from('classes');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function get_enquiry_type()
    {
        $this->db->select('*');
        $this->db->from('followup_type');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getComplaintSource()
    {

        $this->db->select('*');
        $this->db->from('source');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getComplaintType()
    {
        $this->db->select('*');
        $this->db->from('complaint_type');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_reference()
    {
        $this->db->select('*');
        $this->db->from('reference');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_enquiry_student($enquiry_id)
    {
        $this->db->select('*');
        $this->db->from('followup_students');
        $this->db->where('followup_id', $enquiry_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add($data)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->insert('followup', $data);
        $id        = $this->db->insert_id();
        $message   = INSERT_RECORD_CONSTANT . " On  followup id " . $id;
        $action    = "Insert";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $record_id;
            //return $return_value;
        }
    }

    public function getenquiry_list($id = null, $status = 'active')
    {

        if (!empty($id) and !empty($status)) {

            $this->db->where("followup.id", $id);
        }

        $query = $this->db->select('followup.*,classes.class as classname')->
            join("classes", "followup.class = classes.id", "left")->
            where('followup.status', $status)->order_by("followup.id", "desc")->
            get("followup");

        if (!empty($id) and !empty($status)) {

            return $query->row_array();
        } else {

            return $query->result_array();
        }
    }

    public function getFollowByEnquiry($id)
    {

        $query = $this->db->select("*")->where("followup_id", $id)->order_by("id", "desc")->get("followup_follow_up");

        return $query->row_array();
    }

    public function getfollow_up_list($enquiry_id, $follow_up = null)
    {
        $this->db->select()->from('followup_follow_up');
        if ($follow_up != null) {
            $this->db->where('followup_follow_up.id', $follow_up);
            $this->db->where('followup_follow_up.followup_id', $enquiry_id);
            $this->db->order_by('followup_follow_up.id desc');
        } else {
            $this->db->where('followup_follow_up.followup_id', $enquiry_id);
            $this->db->order_by('followup_follow_up.id desc');
        }
        $query = $this->db->get();
        if ($follow_up != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function add_follow_up($data)
    {
        $this->db->insert('followup_follow_up', $data);
    }

    public function follow_up_update($enquiry_id, $follow_up_id, $data)
    {
        $this->db->where('id', $follow_up_id);
        $this->db->where('followup_id', $enquiry_id);
        $this->db->update('followup_follow_up', $data);
        redirect('admin/followup/follow_up_edit/' . $enquiry_id . '/' . $follow_up_id . '');
    }

    public function enquiry_update($id, $data)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->update('followup', $data);
        $message   = UPDATE_RECORD_CONSTANT . " On  followup id " . $id;
        $action    = "Update";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
    }

    public function enquiry_delete($id)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('followup');
        $message   = DELETE_RECORD_CONSTANT . " On  followup id " . $id;
        $action    = "Delete";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================
        $this->db->trans_complete(); # Completing transaction
        /* Optional */
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
    }
    public function enquiry_students_delete($id)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('followup_id', $id);
        $this->db->delete('followup_students');
        $message   = DELETE_RECORD_CONSTANT . " followup students  On  followup id " . $id;
        $action    = "Delete";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================
        $this->db->trans_complete(); # Completing transaction
        /* Optional */
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
    }

    public function delete_follow_up($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('followup_follow_up');
    }

    public function next_follow_up_date($enquiry_id)
    {
        $this->db->select('max(`id`) as id');
        $this->db->from('followup_follow_up');
        $this->db->where('followup_id', $enquiry_id);
        $query = $this->db->get();
        $data  = $query->row_array();
        $id    = $data['id'];
        $this->db->select('*');
        $this->db->from('followup_follow_up');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function changeStatus($data)
    {

        $this->db->where("id", $data["id"])->update("followup", $data);
    }

    public function searchEnquiry($source, $status = 'active', $date_from='', $date_to='')
    {

        $condition = 0;

        if (!empty($source)) {

            $condition = 1;
            $this->db->where("source", $source);
        }
        if (!empty($status)) {

            if ($status != 'all') {
                $condition = 1;
                $this->db->where("status", $status);
            } else {

                $condition = 1;
            }
        }

        if ((!empty($date_from)) && (!empty($date_to))) {
            $condition = 1;
            $this->db->where("date >= ", $date_from);
            $this->db->where("date <= ", $date_to);
        }

        if ($condition == 0) {

            $this->db->where("followup.status", "active");
        }

        $query = $this->db->select('followup.*,classes.class as classname')->join("classes", "classes.id = followup.class", "left")->get("followup");
        return $query->result_array();
    }

}
