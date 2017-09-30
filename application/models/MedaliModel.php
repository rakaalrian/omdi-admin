<?php
    class MedaliModel extends CI_model{
      private $table = "medali";
      public function getMedali($select,$where){
        $this->db->select($select);
        $this->db->from($this->table.' as m');
        $this->db->join('pk as p','m.pk_id=p.pk_id');
        $this->db->where($where);

        return $this->db->get()->row();
      }
      public function getMedalis($select,$where=false,$like=false,$order=false,$asc=true){
        $this->db->select($select);
        $this->db->from($this->table.' as m');
        $this->db->join('pk as p','m.pk_id=p.pk_id');
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
          $this->db->order_by('medali_id','ASC');
        }

        return $this->db->get()->result();
      }
      public function updateMedali($set,$where){
        $this->db->set($set);
        $this->db->where($where);
        $update = $this->db->update($this->table);

        if ($update) {
          return true;
        }else {
          return false;
        }
      }
    }
 ?>
