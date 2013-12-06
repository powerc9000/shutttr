<?php

class Welcome extends CI_Controller {
  public function index() {
		if ($this->user->is_logged_in()) {
	       redirect("posts");
	       return;
	     }
			$this->load->view("welcome/signup");
	}
	public function signup() {
    if ($this->input->post("form_submitted")) {
      // the form was submitted
      $this->load->library("form_validation");
      $this->form_validation->set_rules("first_name",
                                        "first name",
                                        "trim|required|max_length[256]");
      $this->form_validation->set_rules("twitter",
                                        "Twitter",
                                        "trim|max_length[256]");
      $this->form_validation->set_rules("username",
                                        "username",
                                        "trim|required|max_length[256]|alpha_dash|no_space_in_username");
      $this->form_validation->set_rules("email",
                                        "email address",
                                        "trim|required|max_length[256]|valid_email");
      $this->form_validation->set_rules("link_to_work",
                                        "link to work",
                                        "trim|required");
      
      
      if ($this->form_validation->run()) {
        // valid input
        
        $email = $this->input->post("email");
        //check for username / email exist in queue or users table
        if ($this->user->is_email_taken($email) | $this->user->is_username_taken($email)) {
          $this->load->view("welcome/signup", array(
            "validation_errors" => "<p>The username / email you provided is not available.</p>"
            // this overrides the form_validation library's validation_errors()
          ));
        }
        
        else {
          $this->user->request_invite($this->input->post("first_name"),
                                      $this->input->post("twitter"),
                                      $this->input->post("email"),
                                      $this->input->post("link_to_work"),
                                      $this->input->post("username"));
          $this->load->view("welcome/signup", array("success" => true));
        }
      }
      else {
       $this->load->view("welcome/signup");
      }
    }
    else {
      // the user is requesting a form
      $this->load->view("welcome/signup");
    }
      // $this->template->load("template", "welcome/index");
  }
}