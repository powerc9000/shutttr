<?php

class Challenge extends CI_Model {
	public function get_current_challenge(){
		$this->db->where("active",1);
		$result = $this->db->get("challenges")->result();
		return $result[0];
	}
	public function get_all_challenges(){
		return $this->db->get("challenges")->result();
	}
	public function get_challenge($id){
		$this->db->where("id",$id);
		$query = $this->db->get("challenges");
		if($query->num_rows() >0){
			$result = $query->result();
			return $result[0];
		}
		else{
			return false;
		}

	}
	public function get_challenge_entries($id){
		$this->db->where("challenge_id",$id);
		$result = $this->db->get("challenge_photos")->result();
		$photos =array();
		foreach($result as $photo){
			 $photos[]=$this->post->get_post_info_by_id($photo->post_id);
			 
		}		
		return $photos;
	}
	public function new_challenge($data){
		$this->db->insert("challenges",$data);
	}
}