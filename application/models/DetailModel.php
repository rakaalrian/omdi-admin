<?php
    class DetailModel extends CI_model{
      private $table = "jadwal_detail";
      public function getDetail($select,$where){
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->where($where);

        return $this->db->get()->row();
      }
      public function getDetails($select,$where=false,$like=false,$order=false,$asc=true){
        $this->db->select($select);
        $this->db->from($this->table.' as d');
        $this->db->join('pk as p','p.pk_id=d.pk_id');
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
      public function insertDetail($set){
        $this->db->set($set);
        $insert = $this->db->insert($this->table);

        if ($insert) {
          return true;
        }else {
          return false;
        }
      }
      public function updateDetail($set,$where){
        $this->db->set($set);
        $this->db->where($where);
        $update = $this->db->update($this->table);

        if ($update) {
          return true;
        }else {
          return false;
        }
      }
      public function deleteDetail($where){
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
