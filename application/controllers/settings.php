<?php
class Settings extends CI_Controller {
	public function index() {
		if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
    $this->load->library('encrypt');
    if(isset($_POST['first_name']))
		{
      $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('bio', 'Bio', 'required');
        if($_POST['password'] != '')
        {
            $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
            $pass = md5($this->input->post('password'));
        }
        else
        {
          $pass = null;
        }
        if ($this->form_validation->run() == FALSE)
        {
          $username = $this->session->userdata("username");
          $id = $this->user->get_id_by_username($username); 
          $info = $this->user->get_user_info($username, $id);
          $this->session->set_flashdata("message", "Something went terribly wrong please try again!");
          $this->template->load("template","settings/index", $info);
        }
        else
        {
          $first_name = $this->input->post('first_name');
          $last_name = $this->input->post('last_name');
          
          $email = $this->input->post('email');
          $bio = $this->input->post('bio');
          $b_dl = ($this->input->post("b_dl"))? 1:0;
          $gravatar = ($this->input->post("gravatar"))? 1:0;
          $twitter = preg_replace('/@/', '', $this->input->post("twitter"));
          $data = array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'bio' => $bio, "b_dl" => $b_dl, "gravatar"=>$gravatar, "link_to_work"=>$this->input->post("website"), "twitter"=>$twitter);
          if(isset($pass))
          {
            $data['password'] = $pass;
          }
          $user_id = $this->session->userdata('id');
          $this->user->update_user_info($user_id, $data);
          $this->session->set_flashdata(array("message"=>"Information Updated Successfully","type"=>"success"));
          redirect('settings');
        }
      }
      else
      {

	  $username = $this->session->userdata("username");
    $id = $this->user->get_id_by_username($username);	
    $info = $this->user->get_user_info($username, $id);
    
		$this->template->load("template","settings/index", $info); 
  }
	}
  public function new_user()
  {
    if(isset($_POST['first_name']))
    {
      $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('bio', 'Bio', 'trim|required');
        
      
            $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
            $pass = md5($this->input->post('password'));
        
        if ($this->form_validation->run() == FALSE)
        {
          $username = $this->session->userdata("username");
          $id = $this->user->get_id_by_username($username); 
          $info = $this->user->get_user_info($username, $id);
          $this->session->set_flashdata("message", "Something went terribly wrong please try again!");
          $this->template->load("template","login/invite_accepted", $info);
        }
        else
        {
          $first_name = $this->input->post('first_name');
          $last_name = $this->input->post('last_name');
          
          $email = $this->input->post('email');
          $bio = $this->input->post('bio');
         
          $data = array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'bio' => $bio, 'password' => $pass);
          
          $user_id = $this->session->userdata('id');
          $this->db->where('username', $username);
          $this->db->update('users', $data);
          $this->session->set_flashdata("message", "You're now in log in to see shutttr");
          redirect('login');
        }
      }
      else
      {

    $username = $this->session->userdata("username");
    $id = $this->user->get_id_by_username($username); 
    $info = $this->user->get_user_info($username, $id);
    
    $this->template->load("template","login/invite_accepted", $info); 
  }
  }
  public function avatar(){
    
    if ($this->input->post("submitted")) {
      // upload
      $this->load->library("s3");
      $config["upload_path"] = BASEPATH . "../assets/uploads/";
      $config["allowed_types"] = "gif|jpg|png|jpeg";
      $config["encrypt_name"] = true;
      $this->load->library("upload", $config);
      
      
      
      
      if ($this->upload->do_upload()) {
        $upload_data = $this->upload->data();
        $filename = $upload_data["file_name"];
        $config["image_library"] = "GD2";
        $config["source_image"] = BASEPATH . "../assets/uploads/$filename";
        $config["create_thumb"] = FALSE;
        $config['maintain_ratio'] = false;
        $config["width"]   = 200;
        $config["height"] = 200;
        $this->load->library("image_lib", $config);
        $this->image_lib->resize();
        $this->image_lib->crop();
        // successful upload
        $s3_success = $this->s3->putObjectFile(BASEPATH . "../assets/uploads/$filename",
                                               "shutttr",
                                               "user_avatars/$filename",
                                               S3::ACL_PUBLIC_READ);
        if ($s3_success) {
          // sucessfully uploaded to s3
          unlink(BASEPATH . "../assets/uploads/$filename");
          $this->user->add_avatar($filename, $this->session->userdata("id"));
          $this->session->set_flashdata(array("message"=>"Photo Updated Successfully", "type"=>"success"));
          redirect("settings/avatar");
        }
      }
      else{
       $this->session->set_flashdata(array("message"=>$this->upload->display_errors(), "type"=>"error"));
     redirect("settings/avatar");
      }
    }
        else{
          
       
    $this->template->load("template","settings/avatar");
  }
  }

}
