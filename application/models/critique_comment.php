<?php

class Critique_Comment extends CI_Model {
  public function add($critique_id, $user_id, $rating, $body) {
    $this->db->insert("critique_comments", array(
      "user_id" => $user_id,
      "critique_id" => $critique_id,
      "rating" => $rating * 2,
      "body" => $body
    ));
  }
  
  public function get_critique_comments($critique_id) {
    $this->db->where("critique_id", $critique_id);
    $query = $this->db->get("critique_comments");
    if (!$query->num_rows()) return array();
    $result = $query->result();
    
    $comments = array();
    foreach ($result as $comment) {
      $this->db->where("id", $comment->user_id);
      $user_query = $this->db->get("users");
      $user_result = $user_query->result();
      $comments[] = array(
        "user" => $user_result[0],
        "body" => $comment->body,
        "rating" => $comment->rating
      );
    }
    
    return $comments;
  }
}