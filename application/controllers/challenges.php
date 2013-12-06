<?php

class Challenges extends CI_Controller {
	public function index(){
		$challenge = $this->challenge->get_current_challenge();
		$this->template->load("challenges/challenge_template","challenges/challenge_index",array("challenge"=>$challenge, "title"=>"Challenges"));
	}
	public function challenge($id){
		$challenge = $this->challenge->get_challenge($id);
		if($challenge){
			$this->template->load("challenges/challenge_template","challenges/challenge_single",array("challenge"=>$challenge, "title"=>$challenge->title));
		}
		else{
			redirect("404");
		}
	}
	public function all(){
		$challenges = $this->challenge->get_all_challenges();
		$this->template->load("challenges/challenge_template","challenges/challenge_all",array("challenges"=>$challenges));
	}
	public function new_challenge(){
		if(!$this->user->is_admin()){
			redirect("404");
		}
		else{
			if($this->input->post("submitted")){
				$data['start_date'] = strtotime($this->input->post("start_date"));
				$data['end_date'] = strtotime($this->input->post("end_date"));
				$data['title'] = $this->input->post("title");
				$data['description'] = $this->input->post("description");
				$data['active'] = 1;
				$this->challenge->new_challenge($data);
			}
			else{
				$this->template->load("challenges/challenge_template","challenges/new");
			}
		}
	}
}