<?php

class Admin extends CI_Controller {
  // TODO: require admin/mod status everywhere.
  
  public function index() {
    if ($this->session->userdata("group") == "admin") {
    	$this->template->load("template", "admin/index");
  	}
  	else {
  	  $this->load->view("misc/404");
  	}
  }
  
  public function invite($username = false) {
    if ($this->session->userdata("group") == "admin") {
      if ($username) {
        if ($this->user->is_invited($username)) {
          $this->template->load("template","misc/error");
        }
        else {
          $user_data = $this->user->invite_user($username); // this returns the email and uid
          $email = $user_data["email"];
          $uid = $user_data["uid"];
      
          $this->load->library("postmark");
          $this->postmark->to($email, "To Name");
          $this->postmark->reply_to("notifier@postmark.com", "Reply To");
          $this->postmark->subject("You have been invited to shutttr");
          $this->postmark->message_html(
            "
            <p>Hi,</p>
<p>
Were glad to have you as one of the candidates of Shutttr closed testing! Use the following link to signup for your account and start using Shutttr click <a href=\"" . site_url("login/register/$uid") . "\">here</a>. In case you forgot your username, your username is $username. 
</p>
<p>
Thanks,
<br />
The Shutttr Team
</p>
      <p> <a href=\"" . site_url("login/register/$uid") . "\"> Click</a> to activate your account.</p>"
          );
          $this->postmark->send();
          // $this->template->load("template","admin/invited", array("username" => $username));
          redirect("admin/invites");
        }
      }
      else {
      	$this->template->load("template", "misc/404");
      }
    }
  	else {
  	  $this->template->load("template","misc/404");
  	}
  }
  
  public function invites() {
    $this->load->library("pagination");
    $this->load->library("uri");
    
    $config["base_url"] = site_url("admin/invites");
    $config["total_rows"] = $this->db->count_all("invite_queue");
    $config["per_page"] = 20;
    $config["num_links"] = 20;
    
    $this->pagination->initialize($config);
    
    $waiting_list = $this->user->get_waiting_list(array(
      "per_page" => $config["per_page"],
      "page" => $this->uri->segment(3)
    ));
    $data["waiting_list"] = array();
    foreach ($waiting_list as $applicant) {
      if ($applicant->invited = 3) {
        $data["waiting_list"][] = $applicant;
      }
    }
    $data['total_signups'] = $config['total_rows'];
		//$data['total_closed_testing'] = $this->user->total_closed_testing; 
    $this->template->load("template","admin/invite", $data);
  }
  
  public function deny_invite($username = false) {
    if ($this->user->is_admin()) {
      if ($username) {
        if ($this->user->is_denied($username)) {
          $this->template->load("template","misc/error");
        }
        else {
          $user_data = $this->user->deny_user($username);
          $user = $this->db->where("username", $username)->get("invite_queue")->result();
          $user = $user[0];
          $this->load->library("postmark");
          $this->postmark->to($user->email);
          $this->postmark->subject("Sorry, you have not been accepted into Shutttr");
          $this->postmark->message_html(<<<EOF
<p>The Shutttr staff has reviewed your application for an invitation and chosen not to accept. This could be for one or more of the following reasons:</p>
<ul>
<li>We did not see display of photography that meets our standards given the resources you provided. We do not look exclusively for artistic excellence, however we do strive to maintain a community full of enthusiasm for photography.</li>
<li>The links you provided were broken and we were not able to review your request.</li>
</ul>
<p>If you feel that we have not accurately reviewed your application, you may send a message to <a href="mailto:invitations@shutttr.com">invitations@shutttr.com</a> either with new material that fits our standards or with corrected links. Be sure to include information such as your name, username, etc.</p>
<p>Thanks,<br/> The Shutttr Staff</p>
EOF
          );
          $this->postmark->send();
          $this->session->set_flashdata("notice", "Invite Request Denied");
          // $this->template->load("template","admin/invite_denied");
          redirect("admin/invites");
        }
      }
    }
  }

  public function invite_all() {
    // is this a good idea, why would it ever be smart to invite _everyone_?
    if ($this->session->userdata("group") == "admin") {
      //  TODO: add code to invite all users, send emails and update invited to 1
      echo "all invited";
    }
    else {
      $this->template->load("template","misc/404");
    }
  }

	public function user_panel() {
		if ($this->session->userdata("group") == "admin") {
    $users = $this->user->get_all_user_info();
    $this->template->load("template", "admin/user_panel", array(
      "users" => $users
    ));
	}
}
	
	public function change_group($username = false, $group = false , $referrer = false) {
	  if ($this->session->userdata("group") == "admin") {
      if ($username && $group && $referrer) {
        $this->user->change_user_group($username, $group);
        $this->session->set_flashdata("global_message", array("success", "User group changed!"));
       	redirect(base64_decode($referrer));
      }
      else {
        $this->template->load("tembase_urlplate","misc/error");
      }
    }
  	else {
  	  $this->template->load("template","misc/404");
  	}
  }
	
	public function posts_flags() {
	if ($this->session->userdata("group") == "admin") {
		$this->load->model("flag");
		$flags = $this->flag->get_flags();
		//$this->user->get_username_by_id("user_id");
	//	trigger_error("Illegal use of images in admin panel. Please consult the manual for more information.");
		$this->template->load("template", "admin/posts_flags", array(
  	"flags" => $flags
		));
	}
}
	public function block($username = false, $referrer = false, $flagging = false) {
	  if ($this->session->userdata("group") == "admin") {
      if ($username && $referrer) {
        $this->user->block_user($username);
        $this->load->model("flag");
        if ($flagging) $this->flag->take_action($flagging, "blocked");
        $this->session->set_flashdata("global_message", array("success", "User blocked!"));
       	redirect(base64_decode($referrer));
      }
      else {
        $this->template->load("tembase_urlplate","misc/error");
      }
    }
  	else {
  	  $this->template->load("template","misc/404");
  	}
  }
	
	public function hide_photo ($post_id = false, $referrer = false){
		$flagging = $post_id;
		if ($this->session->userdata("group") == "admin") {
      if ($post_id && $referrer) {
				$this->post->hide_photo($post_id);
				$this->load->model("flag");
				if ($flagging) $this->flag->take_action($flagging, "post_hidden");
				 $this->session->set_flashdata("global_message", array("success", "Post Hidden!"));
       	redirect(base64_decode($referrer));
	}
  else {
        $this->template->load("template","misc/error");
      }
    }
  	else {
  	  $this->template->load("template","misc/404");
  	}
  }
  public function new_announcement()
  {
    $this->load->model('announcement');
    if($this->user->is_admin($this->session->userdata("username")))
    {
      $body = $this->input->post("body");
     // $urgency = $this->input->post('urgency');
			$creator_id = $this->session->userdata("id");
    $this->announcement->new_announcement($body, $creator_id);
    redirect('admin/announcements');
  }
  else
  {
    redirect("posts/photos");
  }
  }
  public function announcements()
  {
    if($this->user->is_admin($this->session->userdata("username")))
    {
    $this->load->model('announcement');
    $all_announce = $this->announcement->get_all_announcements();
	 
$options = array(
  '1' => '1',
  '2' => '2',
  '3' => '3',
  '4' => '4',
  '5' => '5',
  '6' => '6'
);
   	$this->template->load("template","admin/add_announcement", array('announcements' => $all_announce, 'options' => $options));
  }
  else
  {
$this->load->view('misc/404');
}

}
 public function delete_announcement()
  {
    $this->load->model('announcement');
    if($this->user->is_admin($this->session->userdata("username")))
    {
      $id = $this->input->post('val');
      $urgency = '4';
    $this->announcement->delete_announcement($id);
    redirect('admin/announcements');
  }
  else
  {
    redirect("posts/photos");
  }
  }

	public function hide_announcement($id)
  {
    $this->load->model('announcement');
    if($this->user->is_admin($this->session->userdata("username")))
    {
    $this->announcement->hide_announcement($id);
    redirect('admin/announcements');
  }
  else
  {
    redirect("posts/photos");
  }
  }

	public function unhide_announcement($id)
  {
    $this->load->model('announcement');
    if($this->user->is_admin($this->session->userdata("username")))
    {
    $this->announcement->unhide_announcement($id);
    redirect('admin/announcements');
  }
  else
  {
    redirect("posts/photos");
  }
  }
  public function announcement_viewed()
  {
    $this->load->model('announcement');
    $announcement_id = $this->input->post('id');
    $userid = $this->session->userdata("id");
    $next_announcement = $this->announcement->announcement_viewed($announcement_id, $userid);
    for($i=0; $i < sizeof($next_announcement); $i++)
    {
      $announce = (array) $next_announcement;
    }
   echo json_encode($announce);
    
    
  }
  public function comment_flags()
  {
    //get all flags
    $this->load->model('flag');
    
    
    if($this->user->is_admin($this->session->userdata("username")))
    {
    $comment_flags = $this->flag->get_all_comment_flags();
    
    $this->template->load('template','admin/comment_flags', array('comment_flags' => $comment_flags));
    
    }
    else
    {
      $this->load->view('misc/404');
    }
    
  }
  
  public function delete_comment($commentid, $action_taken_id = false)
  {
    $this->load->model('flag');
    if($this->user->is_admin($this->session->userdata("username")))
    {
      if($action_taken_id)
      {
        $this->flag->take_comment_action($commentid, $action_taken_id);
      }
    }
    
    $this->flag->delete_comment($commentid);
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function edit_user($username)
  {
     if($this->user->is_admin($this->session->userdata("username")))
     {
       $data = $this->user->get_user_info($username);
       $this->template->load('template', 'admin/user_edit', array('data'=>$data));
     }
  }

 public function stats(){
	$total_beta = $this->db->get_where('invite_queue', array('invited' => 0))->num_rows();
	$total_closed_testing = $this->db->get_where('invite_queue', array('closed_testing' => 1))->num_rows();
  $this->db->where('type != 0');
	$total_users = $this->db->get("users")->num_rows();
		$this->template->load('template', 'admin/stats', array('total_beta' => $total_beta, 'total_closed_testing' => 	$total_closed_testing, 'total_users' => $total_users));
	
	}
  public function block_login($username, $time)
  {
    if($this->user->is_admin($this->session->userdata('username')))
    {
    $this->load->helper('date');
    $time = time() + $time;
    $unblocked_at = date('F jS Y g:i a', $time);
    $this->user->block_user_login($username, $time);
    $this->load->library('email');
    $this->load->library('postmark');
    
    $this->load->model('user');
    $email = $this->user->get_email_by_username($username);

    $this->postmark->to($email);
    $this->postmark->subject('Login Block');
    $this->postmark->message_plain("You have been blocked from logging into Shutttr until $unblocked_at . Sorry but that's the way it is.. bitch!");
    $this->postmark->send();
    redirect($_SERVER['HTTP_REFERER']);
    }
  }
  public function block_comment($username, $time)
  {
    if($this->user->is_admin($this->session->userdata('username')))
    {
    $this->load->helper('date');
    $time = time() + $time;
    $unblocked_at = date('F jS Y g:i a', $time);
    $this->user->block_user_comment($username, $time);
    $this->load->library('email');
    $this->load->library('postmark');
    
    $this->load->model('user');
    $email = $this->user->get_email_by_username($username);

    $this->postmark->to($email);
    $this->postmark->subject('Comment Block');
    $this->postmark->message_plain("You have been blocked from commenting on Shutttr until $unblocked_at . Sorry but that's the way it is.. bitch!");
    $this->postmark->send();
    redirect($_SERVER['HTTP_REFERER']);
    }
  }
  public function block_critique($username, $time)
  {
    if($this->user->is_admin($this->session->userdata('username')))
    {
    $this->load->helper('date');
    $time = time() + $time;
    $unblocked_at = date('F jS Y g:i a', $time);
    $this->user->block_user_critique($username, $time);
    $this->load->library('email');
    $this->load->library('postmark');
    
    $this->load->model('user');
    $email = $this->user->get_email_by_username($username);

    $this->postmark->to($email);
    $this->postmark->subject('Critique Block');
    $this->postmark->message_plain("You have been blocked from critiquing on Shutttr until $unblocked_at . Sorry but that's the way it is.. bitch!");
    $this->postmark->send();
    redirect($_SERVER['HTTP_REFERER']);
    }
  }
  public function unblock_login($username)
  {
    if($this->user->is_admin($this->session->userdata('username')))
    {
    $this->user->unblock_user_login($username);
    $this->load->library('email');
    $this->load->library('postmark');
    
    $this->load->model('user');
    $email = $this->user->get_email_by_username($username);

    $this->postmark->to($email);
    $this->postmark->subject('Login Block Update');
    $this->postmark->message_plain("By the grace of the gods you can login to shutttr but remeber we're watching you");
    $this->postmark->send();
    redirect($_SERVER['HTTP_REFERER']);
    }
  }
  public function unblock_comment($username)
  {
    if($this->user->is_admin($this->session->userdata('username')))
    {
    $this->user->unblock_user_comment($username);
    $this->load->library('email');
    $this->load->library('postmark');
    
    $this->load->model('user');
    $email = $this->user->get_email_by_username($username);

    $this->postmark->to($email);
    $this->postmark->subject('Comment Block Update');
    $this->postmark->message_plain("By the grace of the gods you can comment on shutttr but remeber we're watching you");
    $this->postmark->send();
    redirect($_SERVER['HTTP_REFERER']);
    }
  }
  public function unblock_critique($username)
  {
    if($this->user->is_admin($this->session->userdata('username')))
    {
    $this->user->unblock_user_critique($username);
    $this->load->library('email');
    $this->load->library('postmark');
    
    $this->load->model('user');
    $email = $this->user->get_email_by_username($username);

    $this->postmark->to($email);
    $this->postmark->subject('Critique Block Update');
    $this->postmark->message_plain("By the grace of the gods you can critique on shutttr but remeber we're watching you");
    $this->postmark->send();
    redirect($_SERVER['HTTP_REFERER']);
    }
  }

  public function metrics()
  {
    if($this->session->userdata('logged_in'))
    {
      if($this->user->is_admin($this->session->userdata('username')))
      {
        $this->load->model('metric');
        $top_commenters = $this->metric->top_ten_commenters();
        $monthly_likes = $this->metric->monthly_likes();
        $monthly_comments = $this->metric->monthly_comments();
        $montly_posts = $this->metric->monthly_posts();
        $daily_likes = $this->metric->daily_likes();
        $daily_comments = $this->metric->daily_comments();
        $daily_posts = $this->metric->daily_posts();
        $data = array(
          'commenters' =>$top_commenters, 
          'monthly_likes' => $monthly_likes,
          'monthly_comments' => $monthly_comments,
          'monthly_posts' => $montly_posts,
          'daily_likes' => $daily_likes,
          'daily_comments' => $daily_comments,
          'daily_posts' => $daily_posts
          );
        
        $this->template->load('template', 'admin/metrics', $data);
      }
      else
      {
        redirect('misc/404');
      }
    }
    else
    {
      redirect('login');
    }
  }
  public function delete_comment_flag($id, $key=false)
  {
    if($this->user->is_admin($this->session->userdata("username")))
    {
      $this->load->model('flag');
        $this->flag->delete_comment_flag($id);
        if($key)
        {
          echo "hello!";
        }
        else
        {
          redirect($_SERVER['HTTP_REFERER']);
        }

    }
    else
    {
      redirect('misc/404');
    }
  }
  public function early_supporter_badge()
  {
    $people = $this->user->get_all_user_info();
    
    foreach($people as $p)
    {
      $q=array();
      foreach($p['badges'] as $badges)
    { 
      $q[] = $badges['id'];
        
       }
       
       if(!in_array(1, $q))
       {
        $this->db->insert("badges", array("user_id"=>$p['user']->id, "badge_id"=>1));
        
       }
       
    }
   
  }

  public function invite_keys(){
    if($this->user->is_admin($this->session->userdata("username"))){
      if($this->input->post("form_submitted"))
      {
      $this->load->helper("invite_key");
      $number_of_keys = (int) $this->input->post("invite_keys");
      $data["keys"] = invite_keys($number_of_keys);
      
      foreach($data["keys"] as $key)
      {
        $this->user->new_invite_key($key);
      }
      $this->template->load("template", "admin/show_keys", $data);
    }
    else{
      $this->template->load("template", "admin/invite_keys_form");
    }

    }
    else{
      redirect('misc/404');
    }
    
  }

  public function update_invites(){
    if($this->user->is_admin($this->session->userdata("username"))){
    $number = $this->input->post("invites");
    $id = $this->input->post("userid");
    $this->db->where("id",$id);
    $this->db->update("users",array("invites"=>$number));
    redirect($_SERVER['HTTP_REFERER']);
  }
  else{
    redirect("misc/404");
  }
  }
 public function update_lift_tickets(){
    if($this->user->is_admin($this->session->userdata("username"))){
    $number = $this->input->post("lift_tickets");
    $id = $this->input->post("userid");
    $this->db->where("user_id",$id);
    $this->db->update("lift_tickets",array("amount"=>$number));
    redirect($_SERVER['HTTP_REFERER']);
  }
  else{
    redirect("misc/404");
  }
  }
  public function give_everyone_a_me_in_the_db(){
    $users = $this->user->get_all_user_info();
    var_dump($users);
    foreach($users as $user){
      $this->user->new_me($user['user']->id);
    }
  }
}
