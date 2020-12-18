<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MKII_model extends CI_Model
{
    var $table = 'tab_drawing';
    var $column_order = array('program', 'title', 'issue', 'release_date', null); //set column field database for datatable orderable
    var $column_search = array('program', 'title', 'issue', 'release_date', 'remark'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id' => 'desc'); // default order 

    function __construct()
    {
        parent::__construct();
    }

    //========================= START FPPC ===============================

    private function _get_datatables_query()
    {
        $this->db->like('program', 'AH');
        $this->db->or_like('program', 'MKII');
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

    public function upload_file($data, $where)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return TRUE;
    }

    //========================= START REFERENCE ===========================

    public function Reference($project)
    {
        $this->db->select('*');
        $this->db->from('tab_reference');
        $this->db->where('program', $project);

        $query = $this->db->get();
        $results = array();

        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    public function saveref($data)
    {
        $this->db->insert('tab_reference', $data);
        return TRUE;
    }

    public function delref($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tab_reference', ['id' => $id]);
    }

    public function uploadref($data, $where)
    {
        $this->db->where($where);
        $this->db->update('tab_reference', $data);
        return TRUE;
    }

    //========================= END REFERENCE===============================

    //========================= START CHANGENUM ===========================

    public function changenum($project)
    {
        $this->db->select('*');
        $this->db->from('tab_changenum');
        $this->db->where('project', $project);

        $query = $this->db->get();
        $results = array();

        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    public function savechangenum($data)
    {
        $this->db->insert('tab_changenum', $data);
        return TRUE;
    }

    public function delchangenum($id)
    {
        $this->db->where('id_change', $id);
        $this->db->delete('tab_changenum', ['id_change' => $id]);
    }

    public function uploadchangenum($data, $where)
    {
        $this->db->where($where);
        $this->db->update('tab_changenum', $data);
        return TRUE;
    }

    //========================= END CHANGENUM ===============================

}
