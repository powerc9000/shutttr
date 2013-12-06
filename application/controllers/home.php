<?php
class Home extends CI_Controller {
  public function index() {
     if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		  $username = $this->session->userdata("username");
		  $email = $this->session->userdata("email");
    	$this->template->load("template", "home/index", array(
    	  "username" => $username,
    	  "email" => $email,
    	  "is_admin" => $this->session->userdata("group") == "admin")
    	);
	}
}