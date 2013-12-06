<?php

class Comment extends CI_Model {
  public function add($photo_id, $user_id, $body) {
    $time = date('Y-m-d G:i:s', time());
    $this->db->insert("comments", array(
      "user_id" => $user_id,
      "post_id" => $photo_id,
      "body" => $body,
      'timestamp' => $time
    ));
    return $this->db->insert_id();
  }
  
  public function get_photo_comments($photo_id) {
    $this->db->where("post_id", $photo_id);
    $this->db->order_by('timestamp', 'asc');
    $query = $this->db->get("comments");
    if (!$query->num_rows()) return array();
    $result = $query->result();
    
    $comments = array();
    foreach ($result as $comment) {
      $this->db->where("id", $comment->user_id);
      $user_query = $this->db->get("users");
      $user_result = $user_query->result();
      $comments[] = array(
        'comment_id' => $comment->id,
        "user" => $user_result[0],
        "body" => $comment->body,
        "timestamp" => $comment->timestamp

      );
    }
    
    return $comments;
  }
  public function get_number_of_comments_for_post($postid)
  {
    $this->db->where('post_id', $postid);
    return $this->db->count_all_results('comments');
  }
  public function get_comment_by_id($comment_id)
  {
    $comments = '';
    
      $this->db->where('id', $comment_id);
      $comment = $this->db->get('comments');
      $comments = $comment->result();
    return $comments;
  }
  public function count_num_user_comments($user_id)
  {
    $this->db->where('user_id', $user_id); 
    return $this->db->count_all_results('comments');
  }
  public function get_all_user_comments($user_id){
    $this->db->where('user_id', $user_id);
    $query = $this->db->get('comments');
    return $query->result();
  }
  public function get_user_comments_paginated($user_id, $data)
  {
    $this->db->where('user_id', $user_id);
    $this->db->order_by('timestamp', 'desc');
    $query = $this->db->get('comments', $data["per_page"], $data["page"]);
    return $query->result();
  }
  public function like_comment($comment_id, $user_id){
    $this->db->insert("comment_likes", array("user_id"=>$user_id, "comment_id"=>$comment_id, "timestamp"=>time()));
  }
  public function unlike_comment($comment_id, $user_id){
    $this->db->where("comment_id",$comment_id);
    $this->db->where("user_id",$user_id);
    $this->db->delete("comment_likes");
  }
  public function is_liked($comment_id, $user_id){
    $this->db->where("comment_id",$comment_id);
    $this->db->where("user_id",$user_id);
    $count = $this->db->count_all_results("comment_likes");
    if($count>0){return true;}else{return false;}

  }
  public function number_likes($comment_id){
    $this->db->where("comment_id",$comment_id);
    $count = $this->db->count_all_results("comment_likes");
    return $count;
  }
  
}
