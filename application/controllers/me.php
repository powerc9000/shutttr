<?
class Me extends CI_Controller {
	public function index(){
		if(!$this->user->is_logged_in()){
			redirect("login");
			return;
		}
		if($this->input->post("submitted")){
			//Set their mother effin settings
			if(!$this->user->has_me($this->session->userdata("id"))){
			$this->user->new_me($this->session->userdata("id"));
			}
			$data = array();
			$data["facebook"] = $this->input->post("facebook");
			$data["tumblr"] = $this->input->post("tumblr");
			$data["flickr"] = $this->input->post("flickr");
			$data["d_art"] = $this->input->post("d_art");
			$data["youtube"] = $this->input->post("youtube");
			$data["work"] = ($this->input->post("work"))? 1:0;
			$data["contact"] = ($this->input->post("contact"))? 1:0;
			$selected_photos = $this->input->post("photos");
			$this->user->update_me($this->session->userdata("id"), $data);
			var_dump($selected_photos);
			$this->user->update_me_photos($this->session->userdata("id"),$selected_photos);
		}
		else{
			$data['user'] = $this->user->get_me_settings($this->session->userdata("id"));
			$me_photos = $this->user->get_me_photos($this->session->userdata("id"));
			$all_photos = ($this->post->get_all_photos($this->session->userdata("id")))? $this->post->get_all_photos($this->session->userdata("id")) : array();
			$data["photos"] = array();
			$data2 = array();
			for($i=0;$i<sizeof($me_photos);$i++)
					  {
					  	$data2[] = $me_photos[$i]->photo_id;
					  }
			foreach($all_photos as $key => $photo){
				$data['photos'][$key]->id = $photo->id;
				$data['photos'][$key]->file_name = $photo->file_name;
				if(in_array($photo->id, $data2)){
					
					$data['photos'][$key]->selected = "checked";
				}
				else{
					$data['photos'][$key]->selected = '';
				}
			}
			
			$this->template->load("template","me/index", $data);
		}
	}
}