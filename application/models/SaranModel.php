<?php
    class SaranModel extends CI_model{
      private $table = "saran";
      public function getSaran($select,$where){
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->where($where);

        return $this->db->get()->row();
      }
      public function getSarans($select,$where=false,$like=false,$order=false,$asc=true){
        $this->db->select($select);
        $this->db->from($this->table);
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
      public function deleteSaran($where){
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
