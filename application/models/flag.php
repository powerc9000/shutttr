<?php

class Flag extends CI_Model {
	public function flag_posts_photo ($post_id, $reason_id, $flagger_id, $flaggee_id){
		if (!($flaggee_id && $flagger_id && $post_id && $reason_id) || $flagger_id == $flaggee_id) return;
  	$this->db->where("flaggee_id", $flaggee_id);
		$this->db->where("post_id", $post_id);
  	$num_rows = $this->db->count_all_results("posts_flags");
  	if ($num_rows) return;
  	$this->db->insert("posts_flags", array(
    	"post_type" => 1,
			"timestamp" => date('Y-m-d H:i:s'),
    	"flaggee_id" => $flaggee_id,
			"post_id" => $post_id,
			"reason_id" => $reason_id,
    	"flagger_id" => $flagger_id
  	));
	}
	public function get_flags($post = false) {
    //  get flag data for post
    if ($post) {
      $this->db->where("post_type", $post["type"]);
      $this->db->where("post_id", $post["id"]);
    }
  //	$this->db->where("action_taken_id", 0);
  	$flags_query = $this->db->get("posts_flags");
    if ($flags_query->num_rows() == 0) return false;
    $flags_result = $flags_query->result();
    $flags_result = $flags_result;
    $this->load->config("flags");
    $flag_opts = $this->config->item("flags_reasons");
    $flags = array();
    foreach ($flags_result as $flag) {
      $this->db->where("id", $flag->post_id);
      $post = $this->db->get("posts")->result();
      $this->db->where("id", $flag->flaggee_id);
      $flaggee = $this->db->get("users")->result();
			$this->db->where("id", $flag->flagger_id);
      $flagger = $this->db->get("users")->result();
      $flags[] = array(
        "flag" => $flag,
        "reason" => $flag_opts[$flag->reason_id],
        "post" => $post[0],
        "flaggee" => $flaggee[0],
				"flagger" => $flagger[0]
      );
    }
  	return $flags;
  }
  
  public function take_action($post_id, $action) {
    $this->load->config("flags");
    $actions = $this->config->item("actions_id");
    $this->db->where("post_id", $post_id);
    $this->db->set("action_taken_id", $actions[$action]);
    $this->db->update("posts_flags");
  }
  public function get_all_comment_flags()
  {
    $this->db->order_by("id", "desc");
      $comment_query = $this->db->get("comment_flags");
      $comment_result = $comment_query->result();
      $comment_flags = '';
      for($i=0; $i < sizeof($comment_result); $i++)
      {
      $comment_flags[] = (array) $comment_result[$i];
      }
      return $comment_flags;
  }
  public function flag_comment($data)
  {
    $this->db->insert('comment_flags', $data);
  }
  public function has_user_flagged_comment($userid, $commentid)
  {
    $this->db->where('flagger', $userid);
    $this->db->where('comment_id', $commentid);
    $row = $this->db->count_all_results('comment_flags');
    
    if($row > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public function delete_comment($commentid)
  {
    $this->db->where('id', $commentid);
    $this->db->delete('comments');
  //  $this->db->where('comment_id', $commentid);
  //  $this->db->delete('comment_flags');
  }

  public function hide_comment($commentid)
  {
    $this->db->where('id', $commentid);
    $this->db->delete('photo_comments');
  //  $this->db->where('comment_id', $commentid);
  //  $this->db->delete('comment_flags');
  }
  public function take_comment_action($commentid, $action_taken_id)
  {
    $this->db->where('comment_id', $commentid);
    $this->db->update('comment_flags', array('action_taken_id' => $action_taken_id));
  }
  public function delete_comment_flag($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('comment_flags');
  }
}

