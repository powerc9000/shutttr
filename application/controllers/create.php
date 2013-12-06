<?php

class Create extends CI_Controller {
  public function index(){
    if (!$this->user->is_logged_in()) {
      $this->session->set_flashdata("message", "You must be logged in to view this page!");
      redirect("login/index");
      return;
    }
    $this->template->load('template', 'new/index');
  }
  public function photo() {
   if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
    $this->load->library("s3");
    if ($this->input->post("submitted")) {
      // upload
      $this->load->library("form_validation");
      $this->form_validation->set_rules("title", "title", "trim|required");
      $this->form_validation->set_rules("desc", "description", "trim|required");
      if (!$this->form_validation->run()) {
        $this->template->load("template", "new/photo", array(
          "errors" => validation_errors()
        ));
        return;
      }
      $this->load->model("post");
      $this->load->model("tag");
      $slug = $this->post->create_photo(array(
            "title" => $this->input->post("title"),
            
            "desc" => $this->input->post("desc"),
						"reason_id" => $this->input->post("reason_id")
          ));
          $global_photo_id = $this->db->insert_id();
          $this->tag->new_tags($this->input->post('tags'), $global_photo_id, 1);
          
          $this->load->library("upload");
          $this->load->library("image_lib");
          $errors =false;
      for($i=0; $i<sizeof($_FILES['file']['name']); $i++)
      {

        $_FILES['userfile']['name']    = $_FILES['file']['name'][$i];
        $_FILES['userfile']['type']    = $_FILES['file']['type'][$i];
        $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
        $_FILES['userfile']['error']       = $_FILES['file']['error'][$i];
        $_FILES['userfile']['size']    = $_FILES['file']['size'][$i];
      $config["upload_path"] = BASEPATH . "../assets/uploads/";
  		$config["allowed_types"] = "gif|jpg|png|jpeg";
      $config["encrypt_name"] = true;
      $this->upload->initialize($config);
      
      
      
      
      if ($this->upload->do_upload()) {
        $upload_data = $this->upload->data();
       
        $filename = $upload_data["file_name"];
        $config["image_library"] = "GD2";
        $config["source_image"]	= BASEPATH . "../assets/uploads/$filename";
        $config["new_image"] = BASEPATH . "../assets/uploads/medium/$filename";
        $config["create_thumb"] = FALSE;
        $config["maintain_ratio"] = TRUE;
        $config["width"]	 = 700;
        $config["height"]	= 700;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        

        
        // successful upload
        $s3_success = $this->s3->putObjectFile(BASEPATH . "../assets/uploads/$filename",
                                               "shutttr",
                                               "photo_uploads/$filename",
                                               S3::ACL_PUBLIC_READ);
        if ($s3_success) {
          // sucessfully uploaded to s3
          unlink(BASEPATH . "../assets/uploads/$filename");
          
         

          
          $s3_success = $this->s3->putObjectFile(BASEPATH . "../assets/uploads/medium/$filename",
                                                 "shutttr",
                                                 "photo_uploads_medium/$filename",
                                                 S3::ACL_PUBLIC_READ);
          if ($s3_success) {
            unlink(BASEPATH . "../assets/uploads/medium/$filename");
            
          }
        }
        $this->post->new_stack_photo($global_photo_id, $filename);
      }

      else {
        // upload errors
        $errors = "one or more of your photos could not be uploaded";
      }
      
    }
    if($errors){
      $this->session->set_flashdata(array("message"=>$errors,"type"=>"error"));
    }
    redirect("posts/post/$slug");
  }
    else {
      // display form
      $this->template->load("template", "new/photo");
    }
  }
  
  public function critique($photo_slug) {
	 if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
    if ($this->input->post("submitted")) {
      // form submitted
      $this->load->library("form_validation");
      $this->form_validation->set_rules("title", "title", "trim|required");
      $this->form_validation->set_rules("rating",
                                        "title",
                                        "trim|required|numeric|greater_than[0]|less_than[5.5]");
      $this->form_validation->set_rules("body", "critique", "trim|required");
      if (!$this->form_validation->run()) {
        $this->template->load("template", "new/critique", array(
          "photo_slug" => $photo_slug,
          "photo" => $this->post->get_post_info($photo_slug),
          "errors" => validation_errors()
        ));
        return;
      }
      
      // valid input
      $photo_id = $this->post->get_post_id_by_slug($photo_slug);
      $slug = $this->post->create_critique($this->input->post("title"),
                                           $this->input->post("rating"),
                                           $this->input->post("body"),
                                           $photo_id);
      $this->load->library('email');
            $this->load->library('postmark');
            $email = $this->user->get_email_by_id($this->user->get_userid_by_postid($photo_id));
            $username = $this->user->get_username_by_id($this->user->get_userid_by_slug($slug));
            $url = site_url("posts/post/$slug");
            $this->postmark->to($email);
          $this->postmark->subject("Someone critiqued your post");
          $this->postmark->message_html("<p>$username critiqued your photo</p><p>you can see the critique at <a href=\"$url\">$url</a></p>");
          $this->postmark->send();
      redirect("posts/post/$slug");
    }
    else {
      // display form
      $this->template->load("template", "new/critique", array(
        "photo_slug" => $photo_slug,
        "photo" => $this->post->get_post_info($photo_slug),
        "errors" => ""
      ));
    }
  }
  
  public function question() {
    if (!$this->user->is_logged_in()) {
 			$this->session->set_flashdata("message", "You must be logged in to view this page!");
 		  redirect("login/index");
 		  return;
 		}
 		if ($this->input->post("submitted")) {
 		  // post info submitted
 		  $this->load->library("form_validation");
 		  $this->form_validation->set_rules("title", "title", "required|max_length(256)");
 		  $this->form_validation->set_rules("question", "question", "required");
      if(!$this->form_validation->run())
      {
        $this->template->load('template', "new/question", array('errors' => validation_errors()));
      }
      else
      {

        $this->load->model("post");
        $this->load->model("tag");
        $title = $this->input->post('title');
        $question = $this->input->post('question');
        $slug = $this->post->create_question($title, $question);
        $post_id = $this->db->insert_id();
        $this->tag->new_tags($this->input->post('tags'), $post_id, 2);
        redirect("posts/post/$slug");
      }
 		}
 		else {
 		  // display form
 		  $this->template->load('template', "new/question", 'hello');
 		}
  }
  public function link() {
    if (!$this->user->is_logged_in()) {
      $this->session->set_flashdata("message", "You must be logged in to view this page!");
      redirect("login/index");
      return;
    }
    if ($this->input->post("submitted")) {
      // post info submitted
      $this->load->library("form_validation");
      $this->form_validation->set_rules("title", "title", "required|max_length(256)");
      $this->form_validation->set_rules("link", "link", "required|prep_url");
      $this->form_validation->set_rules("question", "description", "required");

      if(!$this->form_validation->run())
      {
        $this->template->load('template', "new/link", array('errors' => validation_errors()));
      }
      else
      {

        $this->load->model("post");
        $this->load->model("tag");
        $title = $this->input->post('title');
        $link = $this->input->post('link');
        $desc = $this->input->post('question');
        $slug = $this->post->create_link($title, $link, $desc);
        $post_id = $this->db->insert_id();
        $this->tag->new_tags($this->input->post('tags'), $post_id, 3);
        redirect("posts/post/$slug");
      }
    }
    else {
      // display form
      $this->template->load('template', "new/link", 'hello');
    }
  }
  
}