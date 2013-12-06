<?php
class People extends CI_Controller {
	public function index($page=false) {
		  if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		$num_people  = $this->user->count_num_users();
	    $num_pages = ceil($num_people / 6);
	    

	    if ($page) {
	      ($page <= $num_pages) ? $post_number = ($page*6)-6 : redirect("people");
	    }
	    else
	    {
	      $post_number = false;
	    }
	    
	    $this->load->library("pagination");
      $config["base_url"] = site_url("people");
      $config["total_rows"] = $num_people;
      $config["per_page"] = 6;
      $config["num_links"] = 1;
      $this->pagination->initialize($config);
      	$this->load->library("uri");

	    $data['users'] = $this->user->get_all_user_info_paginated(array("per_page"=>6, "page"=>$post_number));
	    
	    $data['num_pages'] = $num_pages;
      ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
		  $this->template->load("template", "people/directory", $data);
	}
	
	public function profile($username = false, $extra = false) {
     if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		if ($this->user->username_exists($username) && !$extra) {
		  $id = $this->user->get_id_by_username($username);	
		  $info = $this->user->get_user_info($username, $id);
		  $user_group = $this->session->userdata("user_group");
			$inviter = $this->user->invited_by($id);
		//	var_dump($inviter);
		  if($info['user']->type != 0)
		
			//$inviter = $this->user->invited_by($id);
		  {
			  if ($info) {
							$id = $this->user->get_id_by_username($username);	
							$inviter = $this->user->invited_by($id);
		  			  $this->template->set("title", $info["user"]->first_name. " " .$info["user"]->last_name );
		  			  $logged_in_user;
							$inviter;
		  			  $info["does_follow"] = $this->user->does_a_follow_b($this->session->userdata("id"),
		  			                                                      $id);
		  			   $info['inviter'] = $inviter;
		    	    $this->template->load("template", "people/profile", $info);
		  		  }
		  		
		  else {
		    // invalid username
		    $this->load->view("misc/404");
		  }
		}
		//its an account we don't want them to see
		else
		{
			$this->load->view("misc/404");
		}
    }
	 	else {
		  $this->load->view("misc/404");
   	}
  }
  
  
  public function follow($username = false, $referrer = false) {
    if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
    if (!$username) {
      $this->template->load("template", "misc/404");
      return;
    }
    if ($username == $this->session->userdata("username")) {
    	$this->session->set_flashdata(array("message"=>"You can't Follow Yourself", "type"=>"error"));
      redirect($_SERVER['HTTP_REFERER']);
      return;
    }
    $this->user->make_a_follow_b($this->session->userdata("username"), $username);
    $this->session->set_flashdata(array("message"=>"You are now following $username", "type"=>"success"));
    redirect($_SERVER['HTTP_REFERER']);
  }
  
  public function unfollow($username = false, $referrer = false) {
    if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
    if (!$username) {
      $this->template->load("template", "misc/404");
      return;
    }
    if ($username == $this->session->userdata("username")) {
      redirect($referrer ? base64_decode($referrer) : "home");
      return;
    }
    
    $this->user->make_a_unfollow_b($this->session->userdata("username"), $username);
    $this->session->set_flashdata(array("message"=>"You are no longer following $username", "type"=>"success"));
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function comments($username = false, $page = false)
  {
  	 if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}

		if ($this->user->username_exists($username)) {
			$user_id = $this->user->get_id_by_username($username);
			$num_comments  = $this->comment->count_num_user_comments($user_id);
		    $num_pages = ceil($num_comments / 10);
		    

		    if ($page) {
		      ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("people/$username/comments");
		    }
		    else
		    {
		      $post_number = false;
		    }

			$this->load->model('post');
			$config["base_url"] = site_url("people/$username/comments");
			$name = implode(' ',$this->user->get_full_name_by_username($username)); 
			$data['what_stream'] = "$name's Comments";
			$data['stream'] = "people/$username/comments/page";
			$data['comments'] = $this->comment->get_user_comments_paginated($user_id, array('per_page'=>10, 'page'=>$post_number));
			$data['num_pages'] = $num_pages;
      		($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
			$this->template->load('template', 'people/comments', $data);
		}
		else
		{
			$this->load->view('misc/404');
		}

  }
  public function critiques($username = false, $page=false)
  {
  	if ($this->user->username_exists($username)) {
		  $user_id = $this->user->get_id_by_username($username);
		  $num_posts  = $this->post->count_num_posts(4, $user_id);
		
		
		$num_pages = ceil($num_posts / 10);
		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("people/$username/critiques");
		}
		else
		{
			$post_number = false;
		}
		$this->load->library("pagination");
	    $this->load->library("uri");
	    $this->load->model('tag');
	    $this->load->model("comment");

	    
	  $config["base_url"] = site_url("posts");
	  $config["total_rows"] = $this->db->count_all("posts");
	  $config["per_page"] = 10;
	  $config["num_links"] = 20;
	  $this->load->helper('date');
	  $this->pagination->initialize($config);
	  $data['popular_tags'] = $this->tag->get_top_tags();
      $data["photos"] = $this->post->get_all_posts_paginated(array(
      "per_page" => $config["per_page"],
      "page" => $post_number
    ),4, $user_id);
    $data['stream'] = "people/$username/critiques/page";
    $name = implode(' ', $this->user->get_full_name_by_username($username));
    $data['what_stream'] = "$name's Critiques";
    $data['num_pages'] = ceil($num_posts / 10);
    ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
		$this->template->load("template", "posts/all_posts", $data);
		return;
	
    }
    else {
		  // invalid username
		  $this->template->load("template", "misc/404");
		}
  	
  }
  
  public function posts($username, $page=false)
  {
  	if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		if ($this->user->username_exists($username)) {
		  $user_id = $this->user->get_id_by_username($username);
		  $num_posts  = $this->post->count_num_posts(false, $user_id);
		
		
		$num_pages = ceil($num_posts / 10);
		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("people/$username/posts");
		}
		else
		{
			$post_number = false;
		}
		$this->load->library("pagination");
	    $this->load->library("uri");
	    $this->load->model('tag');
	    $this->load->model("comment");

	    
	  $config["base_url"] = site_url("posts");
	  $config["total_rows"] = $this->db->count_all("posts");
	  $config["per_page"] = 10;
	  $config["num_links"] = 20;
	  $this->load->helper('date');
	  $this->pagination->initialize($config);
	  $data['popular_tags'] = $this->tag->get_top_tags();
      $data["photos"] = $this->post->get_all_posts_paginated(array(
      "per_page" => $config["per_page"],
      "page" => $post_number
    ),false, $user_id);
    $data['stream'] = "people/$username/posts/page";
    $name = implode(' ', $this->user->get_full_name_by_username($username));
    $data['what_stream'] = "$name's Posts";
    $data['num_pages'] = ceil($num_posts / 10);
    ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
		$this->template->load("template", "posts/all_posts", $data);
		return;
	
    }
    else {
		  // invalid username
		  $this->template->load("template", "misc/404");
		}
  	
  }
}
