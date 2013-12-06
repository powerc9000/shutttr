<?
class Invite extends CI_Controller {
	public function index($uid=false){
		if($this->user->is_logged_in()){
			redirect("posts");
			return;
		}
		
		$this->load->library('form_validation');
		
			
		
		if($uid){
			if($this->user->does_invite_id_exist($uid)){
			if($this->input->post("form_submitted")){
				$username = $this->input->post("username");
				$email = $this->input->post("email");
				$fname = $this->input->post("first_name");
				$lname = $this->input->post("last_name");
				$password = $this->input->post("password");
				$passconf = $this->input->post("passconf");
				$bio = $this->input->post("bio");
				$referer_data = $this->user->get_referer_data($uid);
				$this->form_validation->set_rules("username", "Username", "required|trim|required|max_length[256]|alpha_dash");

				$this->form_validation->set_rules("email", "Email", "required");
				$this->form_validation->set_rules("first_name", "First Name", "required");
				$this->form_validation->set_rules("last_name", "Last Name", "required");
				$this->form_validation->set_rules("password", "Password", "required|matches[passconf]");
				$this->form_validation->set_rules("passconf", "Password Confirmation", "required");
				$this->form_validation->set_rules("bio", "About yourself", "required");
				if($this->form_validation->run())
				{
					if($this->user->is_username_taken($username) or $this->user->is_email_taken($email)){
						$this->session->set_flashdata(array("message"=>"That Username or password is already taken", "type"=>"error"));
						$this->load->view("invite/form" , array("uid" => $uid));
						return;
					}

					$id = $this->user->new_user($fname, $lname, $username, md5($password), $email, $bio, $uid);
					if($referer_data){
						$this->user->new_invite_ref($referer_data[0]->user_id, $id);
					}
					$this->load->library('email');
        			$this->load->library('postmark');
        			$this->postmark->to($email);
        			$this->postmark->subject("Welcome to Shutttr!");
       			 	$this->postmark->message_html("<p>You've been accepted into Shutttr!</p><p>We are really excited to have you here!</p><p>Come check check it out, start posting and start recieveing critique today!</p><p>Also in case you forgot your username is $username</p><p>Have fun!</p>");
        			$this->postmark->send();
          			$this->load->view('login/invite_accepted');
				}
				else{
					$this->load->view("invite/form" , array("uid" => $uid));
					return;
				}
			}
			else{
				$this->load->view("invite/form" , array("uid" => $uid));
				return;
			}
		}
		else{
			echo "Invalid invite code!";
			return;
		}
		}
		else{
			if($this->input->post("form_submitted"))
			{
				$key = $this->input->post("key");
				redirect("invite/$key");
			}
			else{
			$this->load->view("invite/key_form");
			}
		}

		
	}
	public function invite_email(){
		if(!$this->user->is_logged_in()){
			redirect("login");
			return;
		}
		$invites = (int) $this->user->number_invites($this->session->userdata("id"));
		if($this->input->post("form_submitted"))
		{
			
			$email = $this->input->post("email");
			if(!$this->user->is_member($email))
			{

				if($invites > 0){
			    $this->load->helper("invite_key");
				$key = invite_keys(1);
				$this->user->new_invite_key($key, $this->session->userdata("id"));
				$this->user->set_invites($invites -1, $this->session->userdata("id"));
				$url = site_url("invite/$key");
				$name = implode(" ", $this->user->get_full_name_by_id($this->session->userdata("id")));
				
				$this->load->library('email');
		        $this->load->library('postmark');
				$this->postmark->to($email);
if($name = "Barrett Shepherd"):
		    		$this->postmark->subject("You've been spotted to join an awesome photo community called Shutttr!");
		       	$this->postmark->message_html("<p>Hey! You have really awesome photography work, and the Shutttr community would love to have you as an addition. If you would like to find out more about what were all about, check out <a href=\"$url\"> $url</a>!</p> <p>In simple terms Shutttr is a community for photographers where memebers can share, learn, and grow to become better at photography or help others. Its all around a cool community with cool people behind it.</p> <p>If you have ANY questions or comments please feel free to email me, barrett@barrettshepherd.com. I am the Co-Founder/Community Manager and would be more than happy to help answer anything or hear any suggestions.</p>");
	else:
	    			$this->postmark->subject("$name wants you to join Shutttr!");
		       	$this->postmark->message_html("<p>Hey! You've been invited to Shutttr by $name.</p><p>You can sign up here!: <a href=\"$url\">$url</a></p><p>Just in case you were wondering...</p><p>Shutttr is a community geared toward professional and amateur photographers, as well as photo enthusiasts. With Shutttr, getting quality critiques on your photos is easier than ever before! Come check it out!</p>"); endif;
		        $this->postmark->send();
		        $this->session->set_flashdata(array("message"=>"Your invite was sent", "type"=>"success"));
		        redirect("invite/email");
		        }
		        else{
		        	$this->session->set_flashdata(array("message"=>"You don't have any invites left!", "type"=>"error"));
		        	redirect("posts");
		        }
		        }
		        else{

		        	$this->session->set_flashdata(array("message"=>"This person is already a member", "type"=>"error"));
		        	redirect("posts");

		        }

		       }
		        else
		        {
		        	$data["number_invites"] = $this->user->number_invites($this->session->userdata("id"));
		        	$this->template->load("template","invite/email_form", $data);
		        }
		
	}
}