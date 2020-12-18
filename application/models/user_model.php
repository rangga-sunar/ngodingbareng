<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //========================= START USER MANAGE ===========================
    public function getUser()
    {
        $this->db->select('*');
        $this->db->from('tab_user');

        $query = $this->db->get();
        $results = array();

        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    public function appUser($id)
    {
        $this->db->set('is_active', '1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('tab_user');
    }

    public function noActive($id)
    {
        $this->db->set('is_active', '0', FALSE);
        $this->db->where('id', $id);
        $this->db->update('tab_user');
    }

    public function delUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tab_user', ['id' => $id]);
    }

    public function getAccess()
    {
        $this->db->select('*');
        $this->db->where('id', $this->session->userdata('id'));
        $this->db->from('tab_user');

        $query = $this->db->get();
        $results = array();

        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    public function saveaccess($data, $where)
    {
        $this->db->where($where);
        $this->db->update('tab_user', $data);
        return TRUE;
    }

    //========================= END USER MANAGE =============================

    //========================= START DRAWING ===============================
    public function Drawing($project)
    {
        $this->db->select('*');
        $this->db->from('tab_drawing');
        $this->db->where('program', $project);

        $query = $this->db->get();
        $results = array();

        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    public function Drawing_bck($project)
    {
        $this->db->select('*');
        $this->db->from('tab_drawing as a');
        $this->db->join('tab_changenum as b', 'a.change_no = b.change_no', 'left');
        $this->db->where('a.program', $project);

        $query = $this->db->get();
        $results = array();

        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    public function saveDraw($data)
    {
        $this->db->insert('tab_drawing', $data);
        return TRUE;
    }

    public function DelDraw($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tab_drawing', ['id' => $id]);
    }

    public function updatedrawing($data, $where)
    {
        $this->db->where($where);
        $this->db->update('tab_drawing', $data);
        return TRUE;
    }

    public function getDrawByid($id)
    {
        return $this->db->get_where('tab_drawing', ['id' => $id])->row_array();
    }

    //========================= END DRAWING ===============================




    public function getCode()
    {
        $this->db->select('RIGHT(tab_counter.ctr_id,4) as code', FALSE);
        $this->db->order_by('ctr_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tab_counter');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $code = intval($data->code) + 1;
        } else {
            $code = 1;
        }

        $codemax = str_pad($code, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
        $coderesult = "CTR-" . $codemax;    // hasilnya ODJ-9921-0001 dst.
        return $coderesult;
    }
}
