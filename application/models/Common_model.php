<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common_model extends CI_Model
{

    public function add($tbl, $data)
    {
        $this->db->insert($tbl, $data);
        return $this->db->insert_id();
    }

    public function login($data)
    {

        $this->db->where($data);

        $result = $this->db->get('users');

        if ($result->num_rows() == 1) {
            $data = $result->row(0);
            return $data;
        } else {
            return false;
        }

    }

    public function getSingle($table, $where)
    {

        $this->db->where($where);

        $result = $this->db->get($table);

        if ($result->num_rows() == 1) {
            $data = $result->row(0);
            return $data;
        } else {
            return false;
        }

    }

    public function get($table)
    {
        $this->db->order_by('id', 'desc');
        $q = $this->db->get($table);
        return $q->result();
    }

    public function getCounts($table)
    {
        $aa = $this->db->query("SELECT * FROM " . $table . " where status = 1 ");
        return $aa->num_rows();
    }

    public function delete($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
        return true;
    }

    public function update($table, $data, $where)
    {
        $this->db->where($where);

        if ($this->db->update($table, $data)) {
            return true;
        }

        return false;
    }

    public function getWhere($table, $where)
    {
        $this->db->where($where);
        $this->db->order_by('id', 'desc');
        $q = $this->db->get($table);
        return $q->result();
    }

    public function create_slug($name, $tbl)
    {
        $count = 0;
        $name = url_title($name, "dash", true);
        $slug_name = $name . '-' . strtotime("now"); // Create temp name
        while (true) {
            $this->db->select('id');
            $this->db->where('slug', $slug_name); // Test temp name
            $query = $this->db->get($tbl);
            if ($query->num_rows() == 0) {
                break;
            }

            $slug_name = $name . '-' . (++$count); // Recreate new temp name
        }
        return $slug_name; // Return temp name
    }
}
