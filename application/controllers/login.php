<?php

class Login extends CI_Controller {
  public function index() {
    $data = array();
    $data["validation_errors"] = $this->session->flashdata("login_validation_errors");
    $data["message"] = $this->session->flashdata("message");
    // flashdata receives information that was set by the previous page, useful for redirects
    
    // repopulate the form with some flashdata
    $login = $this->session->flashdata("login");
    $data["login"] = $login ? $login : ""; // the login from the flashdata if set, otherwise `""`.
	  if ($this->user->is_logged_in()) {
		  redirect("posts");
		  return;
    }
    $this->load->view("login/index");
  }
  
  public function auth() {
    $this->load->library("form_validation");
    $this->form_validation->set_rules("login", "username/email", "trim|required|max_length[256]");
    $this->form_validation->set_rules("password", "password", "trim|required");
    
    if ($this->form_validation->run()) {
      // input is valid, now to authenticate...
      $login = $this->input->post("login");
      $pass = md5($this->input->post("password"));
      if ($this->user->is_login_blocked($login)) {
        // valid user
        $this->session->set_flashdata("login_validation_errors", 
                                      "Your account has been blocked. If you have any questions email hello@shutttr.com");
        redirect("login");
        return;
      }
      // nope, he's good, log him in
      if ($this->user->is_email($login)) {
        $email = $login;
        $username = $this->user->get_username_by_email($email);
      }
      else {
        $username = $login;
        $email = $this->user->get_email_by_username($username);
      }
      if ($this->user->username_exists($username)) {
        if($this->user->correct_email_pass($email, $pass))
        {
        $comment_blocked = $this->user->is_comment_blocked($username);
        $this->session->sess_destroy();
        $this->session->set_userdata(array(
          "username" => $username,
          "email" => $email,
		      "id" => $this->user->get_id_by_username($username),
          "group" => $this->user->get_group_by_username($username),
          "can_comment" => $comment_blocked['blocked'],
          "can_critique" => $this->user->is_critique_blocked($username),
          'unblocked_time' => $comment_blocked['unblocked_time'],
          "logged_in" => true
        ));
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        $result = $query->result();
        $login_times = $result[0]->logins;
        $login_times++;
        $this->db->where('username', $username);
        $this->db->update('users', array('logins'=>$login_times));
        
        redirect("posts");
      }
      else
      {
        $this->session->set_flashdata("login_validation_errors",
                                      "<p>The login information is incorrect</p>");
        $this->session->set_flashdata("login", $login);
        redirect("login");
      }
      }

       else
      {
        $this->session->set_flashdata("login_validation_errors",
                                      "<p>The login information is incorrect</p>");
        $this->session->set_flashdata("login", $login);
        redirect("login");
      }
      }
    
    else {
      // if there were validation errors, set some flashdata for remembering the errors in
      // validation, and then redirect back to the login form.
      $this->session->set_flashdata("login_validation_errors", validation_errors());
      // unfortunately, repopulating the form can't be as simple as `set_value(<field>)` because
      // there is a redirect between the submition and repopulation steps.
      $this->session->set_flashdata("login", $this->input->post("login"));
      redirect("login");
    }
  }
  
  public function register($uid=false) {
	if ($this->user->is_logged_in()) {
	       redirect("posts/photos");
	       return;
	     }
       if($uid)
       {
         $username = $this->user->get_username_by_uid($uid);
          
        }
           else{
             redirect("misc/404"); 
           }
       if($this->user->is_invited($username))
       {
    if ($this->input->post("form_submitted")) {
      // the form was submitted
      $this->load->library("form_validation");
      $this->form_validation->set_rules("first_name",
										                    "first name",
										                    "trim|required|max_length[256]");
	    $this->form_validation->set_rules("last_name",
										                    "last name",
										                    "trim|required|max_length[256]");
	    
      
      $this->form_validation->set_rules("bio",
                                        "about yourself",
                                        "trim|required");
      $this->form_validation->set_rules("password", "password", "trim|required|matches[passconf]");
      $this->form_validation->set_rules("passconf", "password confirmation", "trim|required");
      
      if ($this->form_validation->run()) {
        // valid input
        
		    //check for username / email exist in queue or users table
        
        
            
            $email = $this->user->get_invite_queue_email_by_username($username);
        
          $this->user->new_user($this->input->post("first_name"),
									                    $this->input->post("last_name"),
									                    $username,
                                      md5($this->input->post("password")),
                                      $email,
                                      $this->input->post("bio"));
        //confirmation email
         $this->load->library('email');
        $this->load->library('postmark');
        $this->postmark->to($email);
        $this->postmark->subject("Welcome to Shutttr!");
        $this->postmark->message_html("<p>We are really excited to have you here!</p><p>Also in case you forgot your username is $username</p><p>Have fun!</p>");
        $this->postmark->send();
          $this->load->view('login/invite_accepted'); // no need to show any data
        
      }
      else {
        $this->load->view("login/register", array('uid'=>$uid));
      }
    }

    else {
      // the user is requesting a form
      $this->load->view("login/register", array('uid'=>$uid));
    }
  }
  else
  {
    echo "Bad activation URL!!!!!";
  }
  }
  
  public function invited() {
    $this->template->load("template","login/invited");
  }
  
  public function activate($uid) {
	  if ($this->user->is_logged_in()) {
      redirect("posts/photos");
      return;
    }
    $username = $this->user->get_username_by_uid($uid);
    if ($username) {
      if ($this->user->is_invited($username)) {
        // valid activation url
        $this->user->activate_user($username);
        $data['user'] = $this->user->get_user_info($username);
		$this->template->load("template", "login/invite_accepted", $data);
      }
      else {
        echo "You have not been invited yet.";
      }
    }
    else {
      // invalid uid
      echo "Invalid activation url";
    }
  }

  public function logout(){
	  $this->session->sess_destroy();
	  redirect("login");
	}
	
	// TODO Make it so if you refresh the page it dosent resend the email
  // public function forgot() {
  //   if ($this->user->is_logged_in()) {
  //     redirect("posts/photos");
  //     return;
  //   }
  //   if ($this->input->post("submitted")) {
  //     // form submitted
  //     $this->load->library("form_validation");
  //     $this->form_validation->set_rules("email", "email address", "trim|required|valid_email");
  //     //success!
  //      $this->template->load("template","login/forgot_success");
  //     if ($this->form_validation->run()) {
  //         if (!$this->user->send_reset_link($this->input->post("email"))) {
  //           $this->template->load("template","misc/error"); // not a valid email
  //         }
  //       }
  //       else {
  //         // invalid input
  //         $this->template->load("template","login/forgot");
  //       }
  //   }
  //   else {
  //     // requesting form
  //     $this->template->load("template","login/forgot");
  //   }
  // }
  public function forgot() {
    if ($this->user->is_logged_in()) {
      redirect("posts/photos");
      return;
    }
    if ($this->input->post("submitted")) {
      // form submitted
      $this->load->library("form_validation");
      $this->form_validation->set_rules("email", "email address", "trim|required|valid_email");
      //success!
      $this->template->load("template","login/forgot_success");
      if ($this->form_validation->run()) {
        if (!$this->user->send_temp_pass($this->input->post("email"))) {
          $this->template->load("template", "misc/error"); // not a valid email
        }
      }
      else {
        // invalid input
        $this->template->load("template","login/forgot");
      }
    }
    else {
      // requesting form
      $this->template->load("template","login/forgot");
    }
  }
  // 
  // public function reset($uid = false) {
  //   // TODO: make this work
  //   if ($this->input->post("submitted")) {
  //     // form submitted, validation
  //     $this->load->library("form_validation");
  //     // reset password
  //     $uid = $this->input->post("uid");
  //      $username = $this->user->get_username_by_reset_uid($uid); // also deletes the uid if it is found
  //      if (!$username) {
  //        $this->template->load("template", "misc/error");
  //        return;
  //      }
  //      $this->user->reset_password($username, $this->input->post("password"));
  //    }
  //    else {
  //      // load the view sending the uid and rendering as a hidden field
  //       echo "success";
  //    }
  // }
}