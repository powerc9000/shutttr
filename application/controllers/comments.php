<?php

class Comments extends CI_Controller {
  public function add_photo() {
    // validate form
    if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
    if($this->session->userdata('comment_blocked') == 1 or $this->session->userdata('unblocked_time') > time())
    {
      $this->session->set_flashdata("message", "You cannot comment!");
      redirect('posts');
    }
      $this->load->library("form_validation");
        // $this->form_validation->set_rules("rating",
        //                                   "rating",
        //                                   "trim|required|numeric|greater_than[0]|less_than[5.5]");
        $this->form_validation->set_rules("body", "comment", "trim|required");
        $this->form_validation->set_rules("photo_id", "photo_id", "trim|required|integer");
        if (!$this->form_validation->run()) {
          $this->session->set_flashdata("global_message", validation_errors());
          redirect($this->input->post("url") ? $this->input->post("url") : "home");
          return;
        }
        
        // everything looks good. continue
        $this->load->model("comment");
        $post_id = $this->input->post("photo_id");
        $body = $this->input->post("body");
        $insert_id = $this->comment->add($post_id,
                                  $this->session->userdata("id"),
                                  $body);
        //Email the post owner of the comment!
        $this->load->library('email');
        $this->load->library('postmark');
        
        $this->load->model('user');
        $this->load->model('post');
        $poster_username = $this->user->get_username_by_id($this->session->userdata("id"));
        $userid = $this->user->get_userid_by_postid($post_id);
        $username = $this->user->get_username_by_id($userid);
        $email = $this->user->get_email_by_username($username);
        $slug = $this->post->get_slug_by_id($post_id);
        $url = site_url("posts/post/$slug#comment-$insert_id");
        
        if($userid != $this->session->userdata("id"))
        {
        $this->postmark->to($email);
        $this->postmark->subject("Someone responded to your post");
        $this->postmark->message_html("<p>$poster_username commented on your post</p><p>$body</p><p>you can see the comment at <a href=\"$url\">$url</a></p>");
        $this->postmark->send();
        }
        $pattern = '/\@(\S+)/';
        preg_match_all($pattern, $body, $matches);
        if(!empty($matches))
        {
          $users = array_unique($matches[1]);
          $username = $this->user->get_username_by_id($this->session->userdata("id"));
          foreach($users as $user){
            $user = trim($user, ',');
            if($this->user->username_exists($user)){
            $email = $this->user->get_email_by_username($user);
            
            $this->postmark->to($email);
            $this->postmark->subject("$username mentioned you on shutttr");
            $this->postmark->message_html("<p>$username mentioned you in a comment on shutttr</p><p>$body</p><p>you can see the comment at <a href=\"$url\">$url</a></p>");
            $this->postmark->send();
            }
          }
        }
        $key = $this->input->post('key');
        //The key exists only if submited by ajax so if javascript is not working they can still comment
        if(!isset($key) or $key == '')
        {
        redirect($this->input->post("url") ? $this->input->post("url") : "home");
        }
        else
        {
         echo $insert_id;
        }
      

  }
  
  public function add_critique() {
    // validate form
 if (!$this->user->is_logged_in()) {
			$this->session->set_flashdata("message", "You must be logged in to view this page!");
		  redirect("login/index");
		  return;
		}
    $this->load->library("form_validation");
    $this->form_validation->set_rules("rating",
                                      "rating",
                                      "trim|required|numeric|greater_than[0]|less_than[5.5]");
    $this->form_validation->set_rules("body", "comment", "trim|required");
    $this->form_validation->set_rules("critique_id", "critiqeu_id", "trim|required|integer");
    if (!$this->form_validation->run()) {
      $this->session->set_flashdata("form_errors", validation_errors());
      redirect($this->input->post("url") ? $this->input->post("url") : "home");
      return;
    }
    
    // validated
    $this->load->model("critique_comment");
    $this->critique_comment->add($this->input->post("critique_id"),
                                 $this->session->userdata("id"),
                                 $this->input->post("rating"),
                                 $this->input->post("body"));
    redirect($this->input->post("url"));
  }
  public function flag_comment($flagger, $commentid, $photoid, $commenter)
  {
     if (!$this->user->is_logged_in()) {
      $this->session->set_flashdata("message", "You must be logged in to view this page!");
      redirect("login/index");
      return;
    }
    $this->load->model('flag');
    $this->load->model('post');
    $this->load->model('comment');
    $comment_body = $this->comment->get_comment_by_id($commentid);
    $data = array(
      'flagger' => $flagger,
      'flaggee' => $commenter,
      'post_id' => $photoid,
      'comment_id' => $commentid,
      'timestamp' => date('Y-m-d h:i:s'),
      'action_taken_id' => '0',
      'comment_body' => $comment_body[0]->body
      );

    $this->flag->flag_comment($data);
    $this->load->library('email');
    $this->load->library('postmark');
    
    $this->load->model('user');
    $email = ($this->user->get_email_by_username($this->user->get_username_by_id($commenter)));

    $this->postmark->to($email);
    $this->postmark->subject('your post has been flagged');
    $this->postmark->message_plain('someone flagged one of your comments no action is required on your part but this email is here to notify you');
    $this->postmark->send();
    
    redirect("posts/post/$photoid");
    
  }
  public function like_comment($comment_id){
     if (!$this->user->is_logged_in()) {
      $this->session->set_flashdata("message", "You must be logged in to view this page!");
      redirect("login/index");
      return;
    }
    $this->load->model('comment');
    $this->load->model("post");

    $comment_info = $this->comment->get_comment_by_id($comment_id);
    $post = $this->post->get_slug_by_id($comment_info[0]->post_id);
    $email = $this->user->get_email_by_id($comment_info[0]->user_id);
    $username = $this->user->get_username_by_id($this->session->userdata("id"));
    $comment_id = $comment_info[0]->id;
    $this->comment->like_comment($comment_id, $this->session->userdata("id"));

    $url = site_url("posts/post/$post#comment-$comment_id");
    $this->load->library('email');
    $this->load->library('postmark');
    $this->postmark->to($email);
    $this->postmark->subject('Someone liked you comment on Shutttr');
    $this->postmark->message_plain("$username liked your comment you can see the comment at <a href=\"$url\">$url</a>");
    $this->postmark->send();
    redirect($_SERVER["HTTP_REFERER"]);
  }
  public function unlike_comment($comment_id){
    $this->load->model('comment');
    $comment_info = $this->comment->get_comment_by_id($comment_id);
    $comment_id = $comment_info[0]->id;
    $user_id = $this->session->userdata("id");
    $this->comment->unlike_comment($comment_id,$user_id);
    redirect($_SERVER["HTTP_REFERER"]);
  }
}