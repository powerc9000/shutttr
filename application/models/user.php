<?php

class User extends CI_Model {
  public function is_registered($login, $pass) {
    $md5_pass = md5($pass); // to avoid calculating the md5 twice

    $this->db->where("username", $login);
    $this->db->where("password", $md5_pass);
    $this->db->or_where("email", $login);
    $this->db->where("password", $md5_pass);
    $query = $this->db->get("users");

    return $query->num_rows() > 0;
  }

  public function has_blocked_downloading($user_id) {
    $this->db->where(array("id" => $user_id, "b_dl" => 1));
    return $this->db->count_all_results("users");
  }

  public function is_username_taken($username) {
    $this->db->where("username", $username);
    if ($this->db->count_all_results("users")) {
      return true;
    }
    else {
      $this->db->where("username", $username);
      return $this->db->count_all_results("invite_queue");
    }
  }
public function is_username_taken_in_users($username) {
  $this->db->where("username", $username);
    if ($this->db->count_all_results("users") > 0) {
      return true;
    }
    
  }
  public function is_email_taken($email) {
    $this->db->where("email", $email);
    if ($this->db->count_all_results("users") > 0) {
      return true;
    }
    else {
      $this->db->where("email", $email);
      return $this->db->count_all_results("invite_queue");
    }
  }
  public function is_email_taken_in_users($email) {
    $this->db->where("email", $email);
    if ($this->db->count_all_results("users") > 0) {
      return true;
    }
  }

  public function username_exists($login) {
    $this->db->where("username", $login);
    return $this->db->count_all_results("users");
  }
 
  public function is_login_blocked($username) {
    $this->load->helper('date');
    
    $this->db->where("username", $username);
    $this->db->or_where("email", $username);
    $this->db->where('can_login', 1);
    $count = $this->db->count_all_results('blocked');
    if($count >0)
    {
      $this->db->where("username", $username);
      $this->db->or_where("email", $username);
      $query = $this->db->get('blocked');
      $gofigure = $query->result();
      $time = $gofigure[0]->unblock_time;
      if(date('U') > $time)
      {
        $this->db->where("username", $username);
        $this->db->or_where("email", $username);
        $this->db->delete('blocked');
        return false;
      }
      else
      {
        return true;
      }
    }
    else
    {
      return false;
    }
  }
  public function is_comment_blocked($username) {
    $this->load->helper('date');
    
    $this->db->where("username", $username);
    $this->db->or_where("email", $username);
    $this->db->where('can_comment', 1);
    $count = $this->db->count_all_results('blocked');
    if($count >0)
    {
      $this->db->where("username", $username);
      $this->db->or_where("email", $username);
      $query = $this->db->get('blocked');
      $gofigure = $query->result();
      $time = $gofigure[0]->unblock_time;
      if(date('U') > $time)
      {
        $this->db->where("username", $username);
        $this->db->or_where("email", $username);
        $this->db->update('blocked', array('can_comment' => 0));
        return array('blocked'=>0, 'unblocked_time'=>0);
      }
      else
      {
        return array('blocked'=>1, 'unblocked_time'=>$time);
      }
    }
    else
    {
      return array('blocked'=>0, 'unblocked_time'=>0);
    }
  }
  public function is_critique_blocked($username) {
    $this->load->helper('date');
    
    $this->db->where("username", $username);
    $this->db->or_where("email", $username);
    $this->db->where('can_critique', 1);
    $count = $this->db->count_all_results('blocked');
    if($count >0)
    {
      $this->db->where("username", $username);
      $this->db->or_where("email", $username);
      $query = $this->db->get('blocked');
      $gofigure = $query->result();
      $time = $gofigure[0]->unblock_time;
      if(date('U') > $time)
      {
        $this->db->where("username", $username);
        $this->db->or_where("email", $username);
        $this->db->update('blocked', array('can_critique' => 0));
        return 0;
      }
      else
      {
        return 1;
      }
    }
    else
    {
      return 0;
    }
  }
  
  public function block_user_login($username, $time) {
      $this->db->where("username", $username);
      $count = $this->db->count_all_results('blocked');
      if($count > 0)
      {
        $this->db->where("username", $username);
        $this->db->set("can_login", 1);
        $this->db->set("unblock_time", $time);
        $this->db->update("blocked");
      }
      else
      {
        $this->db->where("username", $username);
        $this->db->insert('blocked', array('can_login' =>1, 'unblock_time' => $time, 'username' => $username));
      }
      
  }

public function unblock_user_login($username) {
  
    $this->db->where("username", $username);
    $this->db->delete('blocked');
  
  }
  public function block_user_comment($username, $time) {
    
    
    $this->db->where("username", $username);
      $count = $this->db->count_all_results('blocked');
      if($count > 0)
      {
        $this->db->where("username", $username);
        $this->db->set("can_comment", 1);
        $this->db->set("unblock_time", $time);
        $this->db->update("blocked");
      }
      else
      {
        $this->db->where("username", $username);
        $this->db->insert('blocked', array('can_comment' =>1, 'unblock_time' => $time, 'username' => $username));
      }
  
  }

public function unblock_user_comment($username) {
  
    $this->db->where("username", $username);
    $this->db->update('blocked', array('can_comment' => 0));
  
  }
  public function block_user_critique($username, $time) {
    
    $this->db->where("username", $username);
      $count = $this->db->count_all_results('blocked');
      if($count > 0)
      {
        $this->db->where("username", $username);
        $this->db->set("can_critique", 1);
        $this->db->set("unblock_time", $time);
        $this->db->update("blocked");
      }
      else
      {
        $this->db->where("username", $username);
        $this->db->insert('blocked', array('can_critique' =>1, 'unblock_time' => $time, 'username' => $username));
      }
  
  }

public function unblock_user_critique($username) {
  
    $this->db->where("username", $username);
    $this->db->update('blocked', array('can_critique' => 0));
  
  }


  public function get_user_info($username) {
    // get the data for the user
  	$this->db->where("username", $username);
  	$user_query = $this->db->get("users");
    if ($user_query->num_rows() == 0) return false;
    $user_result = $user_query->result();
    $user_result = $user_result[0];
    
    // get the badges
    $user_id = $user_result->id;
    $this->db->where("user_id", $user_id);
    $badges_query = $this->db->get("badges");
    $has_badges = $badges_query->num_rows();
    $badges_result = $badges_query->result();
    
 	  // build an array of badges and badge names
    $badge_proto = $has_badges ? $badges_result : array();
    $this->config->load("user_info");
    $badges = array();
    $badge_opts = $this->config->item("badges");
    foreach ($badge_proto as $badge) {
      $badges[] = array(
        "id" => $badge->badge_id,
        "name" => $badge_opts[$badge->badge_id]
      );
    }
    $type_opts = $this->config->item("types");
    $this->db->where('username', $username);
    $count = $this->db->count_all_results('blocked');
    if($count > 0)
    {
      $this->db->where('username', $username);
      $query = $this->db->get('blocked');
      $result = $query->result();
      $comment = $result[0]->can_comment;
      $critique = $result[0]->can_critique;
      $login = $result[0]->can_login;
      $unblocked = $result[0]->unblock_time;
    }
    else
    {
      $comment=0;
      $critique=0;
      $login=0;
      $unblocked=0;
    }
  
  	return array(
      "badges" => $badges,
      "type" => $type_opts[$user_result->type],
      "user" => $user_result,
      "comment_blocked" => $comment,
      "critique_blocked" => $critique,
      "login_blocked" => $login,
      "unblocked_time" => $unblocked

    );
  }
  public function get_all_users()
  {
    $query = $this->db->get("users");
    $result = $query->result();
    return $result;
  }
  public function get_all_user_info() {
    // get all rows from user table
		$this->db->order_by("id", "desc");
    $this->db->where("type != 0");
    $user_query = $this->db->get("users");
    $user_result = $user_query->result();
    $this->config->load("user_info");
    $type_opts = $this->config->item("types");
    
    // get badge and type info for each user individually
    $return = array();
    foreach($user_result as $user_info) {
      // badges
      $this->db->where("user_id", $user_info->id);
      $badges_query = $this->db->get("badges");
      $has_badges = $badges_query->num_rows();
      $badges_result = $badges_query->result();
      $badges = array();
      $badge_opts = $this->config->item("badges");
      $badge_proto = $has_badges ? $badges_result : array();
      foreach ($badge_proto as $badge) {
        $badges[] = array(
          "id" => $badge->badge_id,
          "name" => $badge_opts[$badge->badge_id]
        );
      }
      
      // add to array
      $return[] = array(
        "badges" => $badges,
        "type" => $type_opts[$user_info->type],
        "user" => $user_info
      );
    }
    return $return;
  }
  public function get_all_user_info_paginated($data) {
    // get all rows from user table
   
    
    $this->db->order_by("id", "desc");
    $this->db->where("type != 0 and blocked !=1");
    // $user_query = $this->db->get("users", $data["per_page"], $data["page"]);
    $user_query = $this->db->get("users", 6, $data["page"]);
    $user_result = $user_query->result();
    $this->config->load("user_info");
    $type_opts = $this->config->item("types");
    // get badge and type info for each user individually
    $return = array();
    foreach($user_result as $user_info) {
      // badges
      $this->db->where("user_id", $user_info->id);
      $badges_query = $this->db->get("badges");
      $has_badges = $badges_query->num_rows();
      $badges_result = $badges_query->result();
      $badges = array();
      $badge_opts = $this->config->item("badges");
      $badge_proto = $has_badges ? $badges_result : array();
      foreach ($badge_proto as $badge) {
        $badges[] = array(
          "id" => $badge->badge_id,
          "name" => $badge_opts[$badge->badge_id]
        );
      }
      
      // add to array
      $return[] = array(
        "badges" => $badges,
        "type" => $type_opts[$user_info->type],
        "user" => $user_info
      );
    }
    return $return;
  }
  
  
	public function change_user_group($username, $group_id) {
    $this->db->where("username", $username);
    $this->db->set("group_id", $group_id);
    $this->db->update("users");
  }
  
  public function get_waiting_list($data) {
    $this->db->where("invited", 0);
		$this->db->order_by("id", "asc");
    $query = $this->db->get("invite_queue", $data["per_page"], $data["page"]);
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    else {
      return array();
    }
  }
 
  public function is_email($str) {
    return strpos($str, "@");
  }

/* public function total_closed_testing($data) {
    $this->db->where("closed_testing", 1);
    $query = $this->db->get("invite_queue");
    if ($query->num_rows() > 0) {
      return;
    }
    else {
      return;
    }
  } */

  public function get_username_by_email($email) {
    $this->db->where("email", $email);
    $this->db->select("username");
    $query = $this->db->get("users");

    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result[0]->username; // get the username
    }
    else {
      // email does not exist
      return false;
    }
  }
  
  public function get_email_by_username($username) {
    $this->db->where("username", $username);
    $this->db->select("email");
    $query = $this->db->get("users");
    
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result[0]->email; // get the email address
    }
    else {
      // username does not exist
      return false;
    }
  }
  public function get_email_by_id($id)
  {
    
    $this->db->where("id", $id);
    $this->db->select("email");
    $query = $this->db->get("users");
    
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result[0]->email; // get the email address
    }
    else {
      // username does not exist
      return false;
    }
  }

  public function get_id_by_username($username) {
    $this->db->where("username", $username);
    $this->db->select("id");
    $query = $this->db->get("users");
    
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result[0]->id; // get the id
    }
    else {
      // username does not exist
      return false;
    }
  }
	public function get_username_by_id($id) {
    $this->db->where("id", $id);
    $this->db->select("username");
    $query = $this->db->get("users");

    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result[0]->username; // get the username
    }
    else {
      // id does not exist
      return false;
    }
  }
  public function get_full_name_by_id($id) {
    $this->db->where("id", $id);
    $this->db->select("first_name");
    $this->db->select("last_name");
    $query = $this->db->get("users");

    if ($query->num_rows() > 0) {
      $result = $query->result();
      $name = array('first_name' => $result[0]->first_name, 'last_name' => $result[0]->last_name);
      return $name;
    }
    else {
      // id does not exist
      return false;
    }
  }
	public function get_first_name_by_id($id) {
    $this->db->where("id", $id);
    $this->db->select("first_name");
    $query = $this->db->get("users");

    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result[0]->first_name;
    }
    else {
      // id does not exist
      return false;
    }
  }
  
  public function get_info_by_id($id) {
    $this->db->where("id", $id);
    $query = $this->db->get("users");

    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result[0]; // get the username
    }
    else {
      // id does not exist
      return false;
    }
  }
  
  public function get_group_by_username($username) {
    $this->db->where("username", $username);
    $this->db->select("group_id");
    $query = $this->db->get("users");
    
    if ($query->num_rows() > 0) {
      $result = $query->result();
      $group_id = $result[0]->group_id; // get the email address
      
      $this->db->where("id", $group_id);
      $this->db->select("group_type");
      $query2 = $this->db->get("groups");
      
      if ($query2->num_rows() > 0) {
        $result = $query2->result();
        return $result[0]->group_type;
      }
      else {
        return false;
      }
    }
    else {
      // username does not exist
      return false;
    }
  }
  
  public function is_invited($username) {
    $this->db->where("username", $username);
    $this->db->where("invited", 1);
    return ($this->db->count_all_results("invite_queue") > 0);
  }

  public function is_denied($username) {
    $this->db->where("username", $username);
    $this->db->where("invited", 2);
    return ($this->db->count_all_results("invite_queue") > 0);
  }
  
  public function invite_user($username) {
    // first set invited to true
    $this->db->where("username", $username);
    $this->db->set("invited", 1);
    $this->db->update("invite_queue");
  
    // now get user info
    $this->db->where("username", $username);
    $query = $this->db->get("invite_queue");
    if ($query->num_rows() > 0) {
      $row = $query->result();
      $row = $row[0];
      $email = $row->email;
      $uid = $row->uid;
    
      return array(
        "email" => $email,
        "uid" => $uid
      );
    }
	}
	
	 public function deny_user($username) {
    // first set invited to true
    $this->db->where("username", $username);
    $this->db->set("invited", 2);
    $this->db->update("invite_queue");
	}
	
	public function get_username_by_uid($uid) {
	  $this->db->where("uid", $uid);
	  $query = $this->db->get("invite_queue");
	  if ($query->num_rows() > 0) {
	    $result = $query->result();
	    return $result[0]->username;
	  }
	  else {
	    return false;
	  }
	}
	
	public function activate_user($username) {
	  // get the data
	  $this->db->where("username", $username);
	  $row = $this->db->get("invite_queue")->result();
	  $row = $row[0];
	  
	  // copy into users table
	  unset($row->uid);
	  unset($row->id);
	  unset($row->invited);
	  $row->type = 1;
	  $row->group_id = 4;
	  $this->db->insert("users", $row);
	  
	  $this->db->where("username", $username);
	  $id_res = $this->db->get("users")->result();
	  // early supporter badge
		$badges_row = array(
      "user_id" => $id_res[0]->id,
      "badge_id" => 1
    );
    $this->db->insert("badges", $badges_row); 
 
	  // delete from invite_queue...not yet! we're not done with them!
	  
	}

	public function is_logged_in() {
	  return $this->session->userdata("logged_in");
	}
	
	public function is_admin($username = false) {
	  if (!$username) {
  	  return $this->session->userdata("group") == "admin";
	  }
	  else {
	    $this->db->where("username", $username);
	    $this->db->select("group_id");
	    $query = $this->db->get("users");
	    $result = $query->result();
	    $result = $result[0]->group_id;
	    return $result == 1;
	  }
	}
	
	public function send_reset_link($email) {
	  $this->db->where("email", $email);
	  $query = $this->db->get("users");
	  
	  if ($query->num_rows() > 0) {
	    $result = $query->result();
	    $result = $result[0];
	    $uid = base64_encode(md5($result->username) . rand() . $result->password /* already md5ed */);
	    $username = $result->username;
		  $first_name = $result->first_name;
		
	    $this->load->library("postmark");
	    $this->postmark->to($email);
	    $this->postmark->reply_to("notifier@postmark.com", "Reply To");
      $this->postmark->subject("Shutttr Password Reset");
      $this->postmark->message_html(
        "Hey $first_name! Your username is $username and if you would like to reset your password click <a href=\"" . site_url("reset/password/$uid") . "\">here</a>."
      );
      $this->postmark->send();
      
      $this->db->insert("reset_keys", array(
        "user_id" => $result->id,
        "key" => md5($uid)
      ));
      
      return true;
	  }
	  else {
	    return false;
	  }
	}
	
	public function get_username_by_reset_uid($uid) {
	  $md5uid = md5($uid);
	  // check if valid uid
	  $this->db->where("key", $md5uid);
	  $query = $this->db->get("reset_keys");
	  if ($query->num_rows() == 0) {
	  return false;
	  }
	  
	  // delete the reset key
	  $this->db->where("key", $md5uid);
	  $this->db->delete("reset_keys");
	  
	  // return the username
	  $result = $query->result();
	  return $result[0]->username;
	}
		public function display_user_announcements(){
    $query = $this->db->get("announcements");
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    else {
      return array();
    }
	}
	
	public function make_a_follow_b($follower, $followee) { // params are usernames
	  $follower_id = $this->get_id_by_username($follower);
	  $followee_id = $this->get_id_by_username($followee);
	  $this->db->insert("following", array(
	    "follower_id" => $follower_id,
	    "followee_id" => $followee_id
	  ));
	}
	
	public function make_a_unfollow_b($follower, $followee) { // params are usernames
	  $follower_id = $this->get_id_by_username($follower);
	  $followee_id = $this->get_id_by_username($followee);
	  $this->db->where("follower_id", $follower_id);
	  $this->db->where("followee_id", $followee_id);
	  $this->db->delete("following");
	}
	
	public function does_a_follow_b($a, $b) { // params are ids
	  $this->db->where(array(
	    "follower_id" => $a,
	    "followee_id" => $b
	  ));
	  return $this->db->count_all_results("following");
	}
  public function correct_email_pass($email, $pass)
  {
    $this->db->where('email', $email);
    $this->db->where('password', $pass);
    $this->db->from('users');
    $count = $this->db->count_all_results();
    if($count > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  public function send_temp_pass($email) {
    $this->db->where("email", $email);
	  $query = $this->db->get("users");
	  
	  if ($query->num_rows() > 0) {
	    $result = $query->result();
	    $result = $result[0];
      $this->db->where("email", $email);
      $new_pass = base64_encode(rand() . rand() . rand() . rand());
      $this->db->set("password", md5($new_pass));
      $this->db->update("users");
      
      $this->load->library("postmark");
	    $this->postmark->to($email);
	    $this->postmark->reply_to("notifier@postmark.com", "Reply To");
      $this->postmark->subject("New Shutttr Password");
      $this->postmark->message_html(
        "Hey " . $result->first_name . ", you said that you forgot your password, so we've generated" .
        " a new one for you! You can log in using this password:<br /><br />$new_pass<br /><br />" .
        " after you log in, you can change your password to something more memorable in settings."
      );
      $this->postmark->send();
      
      return true;
	  }
	  else {
	    return false;
	  }
  }
  public function get_user_comments($userid, $data)
  {
  
    $this->db->where('user_id', $userid);
    $query = $this->db->get('comments');
    $result = $query->result();
    return $result;
  }
  public function get_user_critiques($userid)
  {
  
    $this->db->where('user_id', $userid);
    $query = $this->db->get('critiques');
    $result = $query->result();
    return $result;
  }
  public function get_userid_by_slug($slug)
  {
    $this->db->where('slug', $slug);
    $this->db->select('user_id');
    $query = $this->db->get('posts');
    $result = $query->result();
    return $result[0]->user_id;
  }
  public function get_full_name_by_username($username)
  {
    $this->db->where("username", $username);
    $this->db->select("first_name");
    $this->db->select("last_name");
    $query = $this->db->get("users");

    if ($query->num_rows() > 0) {
      $result = $query->result();
      $name = array('first_name' => $result[0]->first_name, 'last_name' => $result[0]->last_name);
      return $name;
    }
    else {
      // id does not exist
      return false;
    }
  }
  public function get_number_comments($id)
  {
     
    $this->db->where('user_id', $id);
    return $this->db->count_all_results('comments');
  }
  public function get_number_posts($id)
  {
     
    $this->db->where('user_id', $id);
    return $this->db->count_all_results('posts');
  }
  public function get_number_critiques($id)
  {
     
    $this->db->where('user_id', $id);
    return $this->db->count_all_results('critiques');
  }
  public function new_user($fname, $lname, $username, $password, $email, $bio, $uid = false)
  {
    $this->db->insert('users', array('first_name'=>$fname, 'last_name'=>$lname, 'username'=>$username, 'password'=>$password, 'email'=>$email, 'bio'=>$bio, 'group_id'=>4));
    $id = $this->db->insert_id();

    if($uid)
    {
      $this->db->where('key',$uid);
      $this->db->delete("invite_key");
    }
    else{
      $this->db->where('username',$username);
      $this->db->delete('invite_queue');
    }
    $this->db->insert("lift_tickets", array("user_id"=>$id, "amount"=>3));
    $this->db->insert("badges", array("user_id"=>$id,"badge_id"=>1));
    $this->new_me($id);
    return $id;
  }

  public function get_invite_queue_email_by_username($username)
  {
    $this->db->where('username', $username);
    $this->db->select('email');
    $query = $this->db->get('invite_queue');
    $result= $query->result();
    return $result[0]->email;
  }
  public function count_num_users()
  {
    $this->db->where('type != 0 and blocked != 1');
    return $this->db->count_all_results('users');
  }
  public function update_user_info($user_id, $data)
  {
    $this->db->where('id', $user_id);
    $this->db->update('users', $data);
  }
  public function get_userid_by_postid($post_id)
  {
    $this->db->where('id', $post_id);
    $this->db->select('user_id');
    $query = $this->db->get("posts");
    $result = $query->result();
    return $result[0]->user_id;

  }
  public function request_invite($first_name, $twitter, $email, $link_to_work, $username) {
    $md5_username = md5($username);
    $this->db->insert("invite_queue", array(
      "first_name" => $first_name,
      "twitter" => $twitter,
      "username" => $username,
      "email" => $email,
      "link_to_work" => $link_to_work,
      "timestamp" => date('Y-m-d H:i:s'),
      "uid" => base64_encode(md5($username) . rand() . $md5_username)
      // this is very secure and to be unique
    ));
  }
  public function get_all_followers($userid){
    $this->db->where("followee_id", $userid);
    $query = $this->db->get("following");
    return $query->result();
  }
  public function get_all_following($userid){
    $this->db->where("follower_id", $userid);
    $query = $this->db->get("following");
    return $query->result();
  }
  public function update_user_rank($userid, $rank){
    $this->db->where("id",$userid);
    $this->db->update("users", array("rank"=>$rank));
    $this->db->query(<<<SQL
UPDATE users a
INNER JOIN (SELECT (SELECT ROUND(COUNT(*) / (SELECT COUNT(*) FROM users) * 100)
            FROM users AS users2 WHERE users2.rank < users1.rank) AS n, id FROM users AS users1) b
ON a.id = b.id
SET a.p_rank = b.n;
SQL
    );
  }
  public function does_invite_id_exist($uid){
    $this->db->where("key", $uid);
    $count = $this->db->count_all_results("invite_key");
    if($count > 0){return true;}
  }
  public function new_invite_key($key, $uid=false){
    $data["key"] = $key;
    if($uid){$data["user_id"] = $uid;}
    $this->db->insert("invite_key", $data);
  }
  public function is_member($email){
    $this->db->where("email", $email);
    $count = $this->db->count_all_results("users");
    if($count > 0){return true;}
  }
  public function number_invites($id){
    $this->db->where("id", $id);
    $this->db->select("invites");
    $query = $this->db->get("users");
    $result = $query->result();
    return $result[0]->invites;
  }
 public function number_lift_tickets($id){
    $this->db->where("user_id", $id);
    $this->db->select("amount");
    $query = $this->db->get("lift_tickets");
    $result = $query->result();
    return $result[0]->amount;
  }
  public function set_invites($number, $id){
    $this->db->where("id", $id);
    $this->db->update("users", array("invites"=>$number));
  }
  public function avatar($username, $size = false){
    $this->db->where("username",$username);
    $this->db->select("gravatar");
    $query= $this->db->get("users");
    $result = $query->result();
    $gravatar = $result[0]->gravatar;
    if($gravatar){
      $email = $this->user->get_email_by_username($username);
      $email = md5(strtolower(trim($email)));
      $s = $size;
      $default = urlencode(site_url("assets/images/default.png"));

      $url = "http://www.gravatar.com/avatar/$email?size=$s&d=$default";
      
    }
    else{
      $this->db->where("username",$username);
      $this->db->select("avatar");
      $query= $this->db->get("users");
      $result = $query->result();
      $avatar = $result[0]->avatar;
      if($avatar){
      $url = "http://shutttr.s3.amazonaws.com/user_avatars/$avatar";
      
      }
      else{
        $url = site_url("assets/images/default.png");
      }
    }
    return $url;
  }
  public function add_avatar($filename, $user_id){
    $this->db->where("id",$user_id);
    $this->db->update("users", array("avatar"=>$filename, "gravatar"=>0));
  }
  public function view_guidelines($id) {
    $this->db->query("UPDATE `users` SET `guideline_views`=`guideline_views`+1 WHERE `id`=?", $id);
  }
  public function guideline_views($id) {
    $r = $this->db->where("id", $id)->select("guideline_views")->get("users")->result();
    return $r[0];
  }
  public function new_me($userid){
    $this->db->insert("me_settings",array("user_id"=>$userid));
  }
  public function update_me($userid,$data){
    $this->db->where("user_id",$userid);
    $this->db->update("me_settings",$data);
  }
  public function has_me($userid){
    $this->db->where("user_id",$userid);
    $count = $this->db->count_all_results("me_settings");
    return ($count>0)? True: False;
  }
  public function get_me_settings($userid){
    $this->db->where("user_id",$userid);
    $query =$this->db->get("me_settings");
    $result = $query->result();
    
      return $result[0];
    }
  public function get_me_photos($userid){
     $this->db->where("user_id",$userid);
    $query =$this->db->get("me_photos");
    $result = $query->result();
    
      return $result;
  }
  public function update_me_photos($userid, $photos){
    $this->db->where("user_id",$userid);
    $this->db->delete("me_photos");
    foreach($photos as $photo){
      $this->db->insert("me_photos", array("user_id"=>$userid,"photo_id"=>$photo));
    }
  }
  public function get_referer_data($uid){
    $this->db->where("key", $uid);
    $query= $this->db->get("invite_key");
    if($query->num_rows() > 0){
    $result = $query->result();
    return $result;
  }
  else{
    return false;
  }

  }
  public function new_invite_ref($inviter_id, $invitee_id){
    $this->db->insert("who_invited_who", array("inviter_id"=>$inviter_id, "invitee_id"=>$invitee_id));
  }

public function invited_by($id){
		$this->db->select("inviter_id");
   	$this->db->where("invitee_id", $id);
    $query = $this->db->get("who_invited_who");
    $result = $query->result();
    return $result;
	
	}
 
}
