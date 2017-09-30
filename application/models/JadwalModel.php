<?php
    class JadwalModel extends CI_model{
      private $table = "jadwal";
      public function getJadwal($select,$where){
        $this->db->select($select);
        $this->db->from($this->table.' as j');
        $this->db->join('cabor as c', 'c.cabor_id=j.cabor_id');
        $this->db->join('lokasi as l', 'l.lokasi_id=j.lokasi_id');
        $this->db->where($where);

        return $this->db->get()->row();
      }
      public function getJadwals($select,$where=false,$like=false,$order=false,$asc=true){
        $this->db->select($select);
        $this->db->from($this->table.' as j');
        $this->db->join('cabor as c', 'c.cabor_id=j.cabor_id');
        $this->db->join('lokasi as l', 'l.lokasi_id=j.lokasi_id');
        if ($where) {
          $this->db->where($where);
        }
        if ($like) {
          $this->db->like($like);
        }
        if ($order) {
          if ($asc) {
            $this->db->order_by($order,'ASC');
          }else {
            $this->db->order_by($order,'DESC');
          }
        }
        return $this->db->get()->result();
      }
      public function insertJadwal($set){
        $this->db->set($set);
        $insert = $this->db->insert($this->table);

        if ($insert) {
          return true;
        }else {
          return false;
        }
      }
      public function updateJadwal($set,$where){
        $this->db->set($set);
        $this->db->where($where);
        $update = $this->db->update($this->table);

        if ($update) {
          return true;
        }else {
          return false;
        }
      }
      public function deleteJadwal($where){
        $this->db->where($where);
        $delete = $this->db->delete($this->table);

        if ($delete) {
          return true;
        }else {
          return false;
        }
      }
    }
 ?>
