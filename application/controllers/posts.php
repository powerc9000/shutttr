<?php

class Posts extends CI_Controller {

  public function index($page = false) {
  	if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		$num_posts  = $this->post->count_num_posts();
		
		$num_pages = ceil($num_posts / 10);
		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("posts");
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
    ));
    $data['stream'] = "posts/page";
    $data['what_stream'] = 'All Posts';
    $data['num_pages'] = ceil($num_posts / 10);
    ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
		$this->template->load("template", "posts/all_posts", $data);
		return;
	

  }
  
  public function post($slug = false, $extra = false){
  	if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
  	if (!$slug) {
      $this->load->view("misc/404");
      return;
    }
  	if ($this->post->post_exists($slug) && !$extra) {
  		$this->load->model('tag');
  	  $info = $this->post->get_post_info($slug);
		  $user_info = $this->user->get_info_by_id($info->user_id);
		  if ($info && $user_info) {
  		  $user_id = $this->session->userdata("id");
  		  $photo_id = $info->id;
  		  
  		 
  		  $tags = $this->tag->get_tags_for_post($photo_id);
  		  $this->load->model('comment_flags');
  		 
		    $this->post->update_view_count_photo($photo_id, $user_id, $info->user_id);
				$has_liked = $this->post->has_liked_photo($photo_id, $user_id);
  		  $view_count = $this->post->count_views_post($photo_id);
 				$likes_count = $this->post->count_likes_post($photo_id);
 				$rating = $this->post->get_photo_rating($info->id);
 				$this->load->library("uri");
 				
 			  $this->load->model("comment");
 			  $this->load->helper("post_formatting");
 			  $does_follow = $this->user->does_a_follow_b($this->session->userdata("id"), $user_info->id);
  		  $this->template->load("template", "posts/photo", array(
  		    "user" => $user_info,
  		    "photo" => $info,
  		    "tags" => $tags,
			    "view_count" => $view_count,
					"likes_count" => $likes_count,
					"has_liked" => $has_liked,
					"url" => $this->uri->uri_string(),
					"comment_errors" => $this->session->flashdata("form_errors"),
					"comments" => $this->comment->get_photo_comments($info->id),
					"slug" => $slug,
					"critiques" => $this->post->get_all_critiques($info->id),
					"rating" => $rating,
					"does_follow" => $does_follow
  		  ));
      }
    }
	  else {
		  $this->load->view("misc/404");
		}
  }
  
  public function photos($page = false) {
	 if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		
		$num_posts  = $this->post->count_num_posts(1);
		
		$num_pages = ceil($num_posts / 10);
		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("posts/photos");
		}
		else
		{
			$post_number = false;
		}
    $this->load->library("pagination");
    $this->load->library("uri");
    $this->load->model("comment");
    $this->load->model('tag');
    
	  $config["base_url"] = site_url("posts/photos");
	  
	  $config["per_page"] = 10;
	  $config["num_links"] = 20;
	  $this->load->helper('date');
	  $this->pagination->initialize($config);
	  $data['popular_tags'] = $this->tag->get_top_tags();
    $data["photos"] = $this->post->get_all_posts_paginated(array(
      "per_page" => $config["per_page"],
      "page" => $post_number
    ),1);
    $data['stream'] = "posts/photos/page";
    $data['what_stream'] = 'Photos';
    $data['num_pages'] = ceil($num_posts / 10);
    ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
		$this->template->load("template","posts/all_posts", $data);
		return;
		
  }
  
  
	
	public function critiques($page=false) {
		if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		
		$num_posts  = $this->post->count_num_posts(4);
		
		$num_pages = ceil($num_posts / 10);
		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("posts/critiques");
		}
		else
		{
			$post_number = false;
		}
    $this->load->library("pagination");
    $this->load->library("uri");
    $this->load->model("comment");
    $this->load->model('tag');
    
	  $config["base_url"] = site_url("posts/photos");
	  
	  $config["per_page"] = 10;
	  $config["num_links"] = 20;
	  $this->load->helper('date');
	  $this->pagination->initialize($config);
	  $data['popular_tags'] = $this->tag->get_top_tags();
    $data["photos"] = $this->post->get_all_posts_paginated(array(
      "per_page" => $config["per_page"],
      "page" => $post_number
    ),4);
    $data['stream'] = "posts/critiques/page";
    $data['what_stream'] = 'Critiques';
    $data['num_pages'] = ceil($num_posts / 10);
    ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
		$this->template->load("template", "posts/all_posts", $data);
		return;
	  
	}
	
	public function critique($slug = false, $extra = false) {
	  if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
  	if (!$slug) {
      $this->template->load("template", "misc/404");
  		return;
    }
    
    if ($this->post->critique_exists($slug) && !$extra) {
      $critique_info = $this->post->get_critique_info($slug);
      $poster_info = $this->user->get_info_by_id($critique_info->user_id);
      
      if ($critique_info && $poster_info) {
        // $logged_in_id = $this->session->userdata("id");
        // $critique_id = $critique_info->id;
        $photo = $this->post->get_post_by_id($critique_info->photo_id);
        $photo_poster = $this->user->get_info_by_id($photo->user_id);
        $this->load->model("critique_comment");
        $comments = $this->critique_comment->get_critique_comments($critique_info->id);
        $this->load->helper("post_formatting");
 			  $does_follow = $this->user->does_a_follow_b($this->session->userdata("id"), $poster_info->id);
        
        $this->template->load("template", "posts/critique", array(
          "photo" => $photo,
          "photo_poster" => $photo_poster,
          "critique" => $critique_info,
          "critique_poster" => $poster_info,
          "comments" => $comments,
          "errors" => $this->session->flashdata("form_errors"),
          "rating" => $this->post->get_critique_rating($critique_info->id),
					"does_follow" => $does_follow,
					"slug" => $slug
        ));
      }
      
      else {
        $this->template->load("template", "misc/error");
      }
    }
    else {
      // critique not found
		  $this->template->load("template", "misc/404");
		}
	}
	
  public function questions($page=false) {
    if (!$this->user->is_logged_in()){
      redirect("login/index");
      return;
	    }
	$this->load->model('tag');
    $this->load->library("pagination");
    $this->load->library("uri");
    $this->load->model("comment");
    $num_posts  = $this->post->count_num_posts(2);
		
		$num_pages = ceil($num_posts / 10);
		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("posts/questions");
		}
		else
		{
			$post_number = false;
		}
    $config["base_url"] = site_url("posts/questions");
    
    $config["per_page"] = 10;
    $config["num_links"] = 20;
    $data['popular_tags'] = $this->tag->get_top_tags();
    $data['stream'] = 'posts/questions/page';
    $this->pagination->initialize($config);
    $data['what_stream'] = "Questions";

    $data["photos"] = $this->post->get_all_posts_paginated(array(
      "per_page" => $config["per_page"],
      "page" => $post_number
    ),2);
    $data['num_pages'] = ceil($num_posts / 10);
    ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
    $this->template->load("template", "posts/all_posts", $data);
  }
  public function links($page=false) {
    if (!$this->user->is_logged_in()){
      redirect("login/index");
      return;
	    }
	$this->load->model('tag');
    $this->load->library("pagination");
    $this->load->library("uri");
    $this->load->model("comment");
    $num_posts  = $this->post->count_num_posts(3);
		
		$num_pages = ceil($num_posts / 10);
		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("posts/links");
		}
		else
		{
			$post_number = false;
		}
    $config["base_url"] = site_url("posts/questions");
    
    $config["per_page"] = 10;
    $config["num_links"] = 20;
    $data['popular_tags'] = $this->tag->get_top_tags();
    $data['stream'] = 'posts/links/page';
    $this->pagination->initialize($config);
    $data['what_stream'] = "Links";

    $data["photos"] = $this->post->get_all_posts_paginated(array(
      "per_page" => $config["per_page"],
      "page" => $post_number
    ),3);
    $data['num_pages'] = ceil($num_posts / 10);
    ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
    $this->template->load("template", "posts/all_posts", $data);
  }

	public function like_post($slug = false, $extra = false){
	 if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		if ($this->post->post_exists($slug) && !$extra) {
		  $info = $this->post->get_post_info($slug);
		  $user_info = $this->user->get_info_by_id($info->user_id);
		  if ($info && $user_info) {
  		  $user_id = $this->session->userdata("id");
  		  $photo_id = $info->id;
				$slug = $info->slug;
  		  $post_type = "1";
			  $this->post->like_photo($photo_id, $user_id, $info->user_id);
			  $this->load->library('email');
        	  $this->load->library('postmark');
        	  $email = $this->user->get_email_by_id($info->user_id);
        	  $username = $this->user->get_username_by_id($user_id);
        	  $url = site_url("posts/post/$info->slug");
        	  $this->postmark->to($email);
	        $this->postmark->subject("Someone liked your post");
	        $this->postmark->message_html("<p>$username liked your post</p><p>you can see the post at <a href=\"$url\">$url</a></p>");
	        $this->postmark->send();
			  echo "hi";
			  redirect('posts/post/'.  $slug , 'location');
		  }
			else {
			  $this->load->view("misc/404");	
			}
    }
  }
  
	public function unlike_post($slug = false, $extra = false){
	 if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		if ($this->post->post_exists($slug) && !$extra) {
		  $info = $this->post->get_post_info($slug);
		  $user_info = $this->user->get_info_by_id($info->user_id);
			if ($info && $user_info) {
			 	$user_id = $this->session->userdata("id");
  		  $photo_id = $info->id;
				$slug = $info->slug;
  		  $post_type = "1";
				if ($this->post->has_liked_photo($photo_id, $user_id)) {
			    $this->post->unlike_photo($photo_id, $user_id, $info->user_id);
			    redirect('posts/post/'.  $slug , 'location');
		    }
	    }
    }
		else {
			$this->template->load("template", "misc/404");
		}
	}
	
	public function flag_photo(){
		if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		$reason_id = $this->input->post("reason_id");
		$post_id = $this->input->post("id");
    if (!$post_id || !$reason_id) {
      $this->template->load("template", "misc/404");
      return;
    }
		$this->load->model("flag");
	//	$reason_id = $this->input->post("reason_id");
	//	$post_id = $this->input->post("id");
		$flagger_id = $this->session->userdata("id");
		$flaggee_id = $this->input->post("flaggee_id");
		$this->flag->flag_posts_photo($post_id, $reason_id, $flagger_id, $flaggee_id);
	}
	
	public function friends() {
	  $this->template->load("template", "posts/friends", array(
	    "posts" => $this->post->get_activity_from_followees($this->session->userdata("id"))
	  ));
	}
	
public function top_photos($page = false) {
	 if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		
		$num_posts  = $this->post->count_num_posts(1);
		
		$num_pages = ceil($num_posts / 10);
		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("posts/top_photos");
		}
		else
		{
			$post_number = false;
		}
    $this->load->library("pagination");
    $this->load->library("uri");
    $this->load->model("comment");
    $this->load->model('tag');
    
	  $config["base_url"] = site_url("posts/top_photos");
	  
	  $config["per_page"] = 10;
	  $config["num_links"] = 20;
	  $this->load->helper('date');
	  $this->pagination->initialize($config);
	  $data['popular_tags'] = $this->tag->get_top_tags();
    $data["photos"] = $this->post->get_top_photos_paginated(array(
      "per_page" => $config["per_page"],
      "page" => $post_number
    ),1);
    $data['stream'] = "posts/top_photos";
    $data['what_stream'] = 'Popular';
    $data['num_pages'] = ceil($num_posts / 10);
    ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
		$this->template->load("template", "posts/all_posts", $data);
		return;
		
  }
	public function tagged_with($tag, $page=false)
	{	$this->load->model('tag');
	$config["per_page"] = 10;
		$num_posts  = $this->tag->get_number_of_posts_with_tag($tag);
		$this->load->library("pagination");
		
		$num_pages = ceil($num_posts / 10);
		if($num_pages == 0){$num_pages = 1;}
		
		
		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("posts/tagged_with/$tag");
		}
		else
		{
			$post_number = false;
		}

		$data['photos'] = $this->tag->get_posts_by_tag_paginated($tag, array(
      "per_page" => $config["per_page"],
      "page" => $post_number));
		$data['popular_tags'] = $this->tag->get_top_tags();
		$data['num_pages'] = ceil($num_posts / 10);
		$tag = implode(' ', explode('-', $tag));
		$data['what_stream'] = "Posts tagged with $tag";
		$data['stream'] = "posts/tagged_with/$tag";
		

    	($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;

		$this->template->load("template", "posts/all_posts", $data);
		
	}
	public function close_post($postid, $username)
	{
		if($this->session->userdata('username') == $username | $this->user->is_admin($this->session->userdata('username')))
		{
			$this->post->close_post($postid);
			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			redirect('posts/photos');
		}
	}
	public function open_post($postid, $username)
	{
		if($this->session->userdata('username') == $username | $this->user->is_admin($this->session->userdata('username')))
		{
			$this->post->open_post($postid);
			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			redirect('posts/photos');
		}

	}
	
	public function delete($postid, $username)
	{
		if($this->session->userdata('username') == $username | $this->user->is_admin($this->session->userdata('username')))
		{
			
		
			if(! $this->post->is_post_flagged($postid))
			{
				$this->post->delete_post($postid);
				redirect('posts');
			}
			else
			{
				$this->post->hide_post($postid);
				redirect('posts/');
			}
		}
		else
		{
			redirect('posts/');
		}
	}
	public function edit($postid, $username)
	{
		$this->load->model('tag');
		if($this->session->userdata('username') == $username | $this->user->is_admin($this->session->userdata('username')))
		{
			$info = $this->post->get_post_info_by_id($postid);
			$tags = $this->tag->get_tags_for_post($postid);
			$this->template->load("template", "edit/photo", array('info' =>$info, 'tags'=>$tags, 'username'=>$username));
			
		}
	}
	public function save_edit($username,$postid, $slug)
	{
		$this->load->model('tag');
		if($this->session->userdata('username') == $username | $this->user->is_admin($this->session->userdata('username')))
		{
			$this->load->library("form_validation");
      		$this->form_validation->set_rules("title", "title", "trim|required");
      		$this->form_validation->set_rules("description", "description", "trim|required");
      		if($this->form_validation->run())
			{
				$this->tag->delete_tags_by_id($postid);
				$tags = $this->input->post('tags');
				$this->tag->new_tags($tags, $postid, 1);
				$title = $this->input->post('title');
				$description = $this->input->post('description');
				$this->post->update_post($postid, $title, $description);
				redirect("posts/post/$slug");
			}
			else
			{
				$info = $this->post->get_photo_info_by_id($postid);
				$tags = $this->tag->get_tags_for_post($postid);
				$this->template->load("template", "edit/photo", array(
	          "errors" => validation_errors(), 'info'=>$info, 'tags' =>$tags, 'username'=>$username
	        ));
			}

		}
	}
	public function hide_post($postid)
	{
		if($this->user->is_admin($this->session->userdata("username")))
		{
			$this->post->hide_post($postid);
			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function unhide_post($postid)
	{
		if($this->user->is_admin($this->session->userdata("username")))
		{
			$this->post->unhide_post($postid);
			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function following($page=false){
		if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
		 $userid = $this->session->userdata("id");
		$num_posts  = $this->post->count_num_posts_from_following($userid);
		
		$num_pages = ceil($num_posts / 10);
		

		if ($page) {
		  ($page <= $num_pages) ? $post_number = ($page*10)-10 : redirect("posts/following");
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
	 
      $data["photos"] = $this->post->get_all_following_paginated($userid, array(
      "per_page" => $config["per_page"],
      "page" => $post_number
    ));
   
    $data['stream'] = "posts/following";
    $data['what_stream'] = 'Posts from people you follow';
    $data['num_pages'] = ceil($num_posts / 10);
    ($page) ? $data['cur_page'] = $page : $data['cur_page'] = 1;
		$this->template->load("template", "posts/all_posts", $data);
		return;
	}
	public function viewer($slug, $extra = false){
		if ($this->post->stack_exist($slug) && !$extra) {
		$stack_id = $this->post->get_id_by_slug($slug);
		$photos = $this->post->get_stack_photos($stack_id);
		
		$post_info = $this->post->get_post_info_by_id($stack_id);
		if(empty($photos)){
			$filename->filename= $post_info->file_name;
			$photos = array($filename);
		}
		$this->load->view("posts/viewer", array("photos"=>$photos,"info"=>$post_info));

	}
	else{
		$this->load->view("misc/404");
	}
}
 
}
