<?php

class Post extends CI_Model {
  public function post_exists($slug) {
    $this->db->where("slug", $slug);
    return $this->db->count_all_results("posts");
  }
  
  public function critique_exists($slug) {
    $this->db->where("slug", $slug);
    return $this->db->count_all_results("critiques");
  }

  public function get_post_info($slug) {
    $this->db->where("slug", $slug);
    $photo_query = $this->db->get("posts");
    if ($photo_query->num_rows() == 0) return false;
    $photo_result = $photo_query->result();
    $photo_result = $photo_result[0];
    return $photo_result;
  }
  public function get_post_info_by_id($id) {
    $this->db->where("id", $id);
    $photo_query = $this->db->get("posts");
    if ($photo_query->num_rows() == 0) return false;
    $photo_result = $photo_query->result();
    $photo_result = $photo_result[0];
    return $photo_result;
  }

  
  public function get_critique_info($slug) {
    $this->db->where("slug", $slug);
    $critique_query = $this->db->get("critiques");
    
    if ($critique_query->num_rows() == 0) return false;
    
    $critique_result = $critique_query->result();
    $critique_result = $critique_result[0];
    $critique_result->rating /= 2;
    return $critique_result;
  }
  
  public function update_view_count_photo($photo_id, $user_id, $poster_id) {
	  if (!$user_id) return;
	  if ($user_id == $poster_id) return;
	  
    $this->db->where("user_id", $user_id);
    $num_rows = $this->db->count_all_results("view_count");
    
    if ($num_rows) return;
    
    $this->db->insert("view_count", array(
      "post_type" => 1,
      "post_id" => $photo_id,
      "user_id" => $user_id
    ));
  }

  public function like_photo($photo_id, $user_id, $poster_id) {
	if (!$user_id) return;
	if ($user_id == $poster_id) return;
    
    $time = date('Y-m-d H:i:s');
    $this->db->insert("likes", array(
      "post_type" => 1,
      "post_id" => $photo_id,
      "user_id" => $user_id,
      "timestamp" => $time
    ));
  }

	public function unlike_photo($photo_id, $user_id, $poster_id){
	if (!$user_id) return;
	if ($user_id == $poster_id) return;	
		$this->db->where("user_id", $user_id);
		$this->db->where("post_id", $photo_id);
	  $this->db->delete("likes");
		
	}

	public function has_liked_photo($photo_id, $user_id){
		$this->db->where("user_id", $user_id);
		$this->db->where("post_id", $photo_id);
    if ($this->db->count_all_results("likes")) {
      return true;
    }
    else {
      return false;
    }
  }

  public function count_views_post($photo_id) {
    $this->db->where("post_id", $photo_id);
    return $this->db->count_all_results("view_count");
  }
 
	public function count_likes_post($photo_id) {
    $this->db->where("post_id", $photo_id);
    return $this->db->count_all_results("likes");
  }
	
	public function get_all_posts($user_id = false) {
	  if ($user_id) $this->db->where("user_id", $user_id);
    $query = $this->db->get("posts");
    
      return $query->result();
  
	}
	public function get_all_photos($user_id=false){
   if ($user_id) $this->db->where("user_id", $user_id);
    $this->db->order_by("id", "desc");
    $this->db->where("post_type", 1);
    $query = $this->db->get("posts");
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    else {
      return array();
    }
    
  }
	public function get_all_photos_paginated($data, $user_id = false) {
	  if ($user_id) $this->db->where("user_id", $user_id);
		$this->db->order_by("id", "desc");
    $this->db->where("post_type", 1);
    $query = $this->db->get("posts", $data["per_page"], $data["page"]);
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    else {
      return array();
    }
	}
  public function get_all_posts_paginated_for_user($userid){
    $this->db->where("user_id", $userid);
    $query = $this->db->get("posts");
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    else {
      return array();
    }

  }
  public function get_all_posts_paginated($data, $type=false, $user_id = false ) {
    if ($user_id) $this->db->where("user_id", $user_id);
    if($type) $this->db->where("post_type", $type);
    $this->db->order_by("id", "desc");
     
    $query = $this->db->get("posts", $data['per_page'], $data['page']);
//     $query = $this->db->query(<<<SQL
// SELECT
//   id, timestamp, user_id, hidden, slug, file_name, description, link, rank, closed, post_type, post_title, post_date, NULL, NULL    , NULL 
// FROM
// posts
// 
// UNION ALL
// 
// SELECT
//   id, timestamp, user_id, hidden, slug, NULL     , body       , NULL, NULL, NULL  , NULL     , name      , post_date, body, photo_id, rating
// FROM
// critiques
// 
// ORDER BY
//   post_date
// DESC
// SQL
// . " LIMIT " . $data["per_page"] . " OFFSET " . ($data["page"] ? $data["page"] : 0));
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    else {
      return array();
    }

  }
	
	public function get_all_critiques($photo_id = false) {
	  if ($photo_id) $this->db->where("photo_id", $photo_id);
    $query = $this->db->get("posts");
    $critiques_proto = array();
    if ($query->num_rows() > 0) {
      $critiques_proto = $query->result();
    }
    
    $critiques = array();
    foreach ($critiques_proto as $critique) {
      $this->db->where("id", $critique->photo_id);
      $photo_query = $this->db->get("posts");
      $photo = $photo_query->result();
      $photo = $photo[0];
      
      $this->db->where("id", $photo->user_id);
      $photo_poster_query = $this->db->get("users");
      $photo_poster = $photo_poster_query->result();
      $photo_poster = $photo_poster[0];
      
      $this->db->where("id", $critique->user_id);
      $critique_poster_query = $this->db->get("users");
      $critique_poster = $critique_poster_query->result();
      $critique_poster = $critique_poster[0];
      
      $critique->rating /= 2;
      
      $critiques[] = array(
        "critique" => $critique,
        "photo" => $photo,
        "photo_poster" => $photo_poster,
        "critique_poster" => $critique_poster
      );
    } 
    
    return $critiques;
	}
	
	public function get_all_critiques_paginated($data, $photo_id = false) {
	  if ($photo_id) $this->db->where("photo_id", $photo_id);
		$this->db->order_by("id", "desc");
    $query = $this->db->get("critiques", $data["per_page"], $data["page"]);
    $critiques_proto = array();
    if ($query->num_rows() > 0) {
      $critiques_proto = $query->result();
    }
    
    $critiques = array();
    foreach ($critiques_proto as $critique) {
      $this->db->where("id", $critique->photo_id);
      $photo_query = $this->db->get("posts");
      $photo = $photo_query->result();
      $photo = $photo[0];
      
      $this->db->where("id", $photo->user_id);
      $photo_poster_query = $this->db->get("users");
      $photo_poster = $photo_poster_query->result();
      $photo_poster = $photo_poster[0];
      
      $this->db->where("id", $critique->user_id);
      $critique_poster_query = $this->db->get("users");
      $critique_poster = $critique_poster_query->result();
      $critique_poster = $critique_poster[0];
      

      $critique->rating /= 2;
      
      $critiques[] = array(
        "critique" => $critique,
        "photo" => $photo,
        "photo_poster" => $photo_poster,
        "critique_poster" => $critique_poster
      );
    } 
    
    return $critiques;

	}
	
  public function get_all_questions_paginated($config, $user_id = false) {
    if ($user_id) $this->db->where("user_id", $user_id);
    $this->db->where('post_type', 2);
    $this->db->order_by("id", "desc");
    $query = $this->db->get("posts", $config["per_page"], $config["page"]);
    return $query->num_rows > 0
           ? $query->result()
           : array();
  }
	public function create_photo($data) {
	  $slug = preg_replace("/[^a-zA-Z0-9]/", "-", $data["title"]) .
            "-p" .
            ($this->db->count_all("posts") + 1);
	  $this->db->insert("posts", array(
	    "post_title" => $data["title"],
	    "user_id" => $this->session->userdata("id"),
	    "slug" => $slug,
	    "description" => $data["desc"],
	    "post_date" => date("Ymd"),
      "post_type" => 1
	  ));
	  return $slug;
	}
	
	public function create_critique($title, $rating, $body, $photo_id) {
	  $slug = preg_replace("/[^a-zA-Z0-9]/", "-", $title) .
            "-c" .
            ($this->db->count_all("posts") + 1);
    $this->db->insert("posts", array(
      "post_title" => $title,
      "rating" => $rating * 2,
      "description" => $body,
      "photo_id" => $photo_id,
      "user_id" => $this->session->userdata("id"),
      "slug" => $slug,
      "timestamp" => date('Y-m-d H:i:s'),
      "post_type" => 4
    ));
    return $slug;
	}
	
	public function get_post_by_id($id) {
	  $this->db->where("id", $id);
	  $query = $this->db->get("posts");
	  $result = $query->result();
	  return $result[0];
	}
	
	public function get_critique_rating($id) {
	  $this->load->model("critique_comment");
	  $comments = $this->critique_comment->get_critique_comments($id);
	  $counter = 0;
	  foreach ($comments as $comment) {
	    $counter += $comment["rating"];
	  }
	  return count($comments) ? round($counter / count($comments)) / 2 : 2.5;
	}
	
	public function get_photo_rating($id) {
	  $this->db->where("photo_id", $id);
	  $critiques_query = $this->db->get("posts");
	  $result = $critiques_query->result();
    $ratings = array();
	  foreach($result as $r)
    {
      $ratings[] = $r->rating;
    }
    $total_ratings = sizeof($ratings);
    if($total_ratings > 0)
    {
    $total = 0;
    foreach($ratings as $rate)
    {
      $total = $rate/2 + $total;
    }
    $average = $total/$total_ratings;
  }
  else
  {
    $average='unknown';
  }
	  
    return $average;
	}
	
	public function get_activity_from_followees($user_id) {
	  // get followees
	  $followees = $this->db->where("follower_id", $user_id)
	                        ->select("followee_id")
	                        ->get("following")
	                        ->result();
	  
	  // get activity
	  $in = array();
	  foreach($followees as $followee) {
	    $in[] = $followee->followee_id;
	  }
	  $in = implode(", ", $in);
	  //     SELECT
	  //         id, timestamp, user_id, hidden, slug, post_date, photo_name, file_name, description, NULL, NULL, NULL
	  //     FROM
	  //         photos
	  // 
	  //     UNION ALL
	  // 
	  //     SELECT
	  //         id, timestamp, user_id, hidden, slug, post_date, NULL       , NULL      , NULL      , body, photo_id, rating
	  //     FROM
	  //         critiques
	  // 
	  //     ORDER BY
	  //         timestamp
	  //     ASC
	  $q = $this->db->query(<<<SQL
SELECT
    id, timestamp, user_id, hidden, slug, post_date, photo_name, file_name, description, NULL, NULL, NULL
FROM
    photos
SQL
 . " WHERE user_id=0" . ($in ? " OR user_id IN ($in)" : "")
 . <<<SQL

UNION ALL

SELECT
    id, timestamp, user_id, hidden, slug, post_date, NULL       , NULL      , NULL      , body, photo_id, rating
FROM
    critiques 
SQL
 . " WHERE user_id=0" . ($in ? " OR user_id IN ($in)" : "") . " ORDER BY post_date DESC");
	  return $q->result();
	}

	 public function hide_photo($post_id) {
    $this->db->where("id", $post_id);
    $this->db->set("hidden", 1);
    $this->db->update("photos");
  }
  public function get_number_of_flags($id)
  {
    $this->db->where('post_id', $id);
    $flags = $this->db->count_all_results('posts_flags');
    return $flags;
  }
  public function update_photo_rank($id, $rank)
  {
    $this->db->where('id', $id);
    $this->db->update('posts', array('rank'=>$rank));
  }
  public function get_top_photos_paginated($data)
  {

    $this->db->order_by('rank','desc');
    $this->db->where("post_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
    $this->db->where('post_type', 1);
    $query = $this->db->get("posts", $data["per_page"], $data["page"]);
    return $query->result();
    
  }
  public function close_post($postid)
  {
    $this->db->where('id', $postid);
    $this->db->update('photos', array('closed' => 1));
  }
  public function open_post($postid)
  {
    $this->db->where('id', $postid);
    $this->db->update('photos', array('closed' => 0));
  }
  public function get_all_month_photos()
  {
    $this->db->where("post_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
    $this->db->where('post_type', 1);
    $query = $this->db->get("posts");
    return $query->result();
   
  }
  public function is_post_flagged($postid)
  {
    $this->db->where('post_id',$postid);
    $flags = $this->db->get('posts_flags')->num_rows();
    if($flags > 0 )
    {
      return true;
    }
  }
  public function hide_post($postid)
  {
    $this->db->where('id', $postid);
    $this->db->update('posts', array('hidden' => 1));
  }
  public function unhide_post($postid)
  {
    $this->db->where('id', $postid);
    $this->db->update('posts', array('hidden' => 0));
  }
  public function update_post($postid, $title, $description)
  {
    $this->db->where('id', $postid);
    $this->db->update('posts', array('post_title' => $title, 'description'=>$description));
  }
  public function get_number_of_ratings($postid)
  {
    $this->db->where('photo_id', $postid);
    $count = $this->db->count_all_results('posts');
    return $count;
  }
  public function get_slug_by_id($id)
  {
    $this->db->where('id', $id);
    $this->db->select('slug');
    $query = $this->db->get('posts');
    $result = $query->result();
    return $result[0]->slug;
  }
  public function create_question($title, $question)
  {
    $slug = preg_replace("/[^a-zA-Z0-9]/", "-", $title) .
            "-p" .
            ($this->db->count_all("posts") + 1);
    $this->db->insert('posts', array('post_title'=>$title, 'slug' => $slug, 'user_id'=>$this->session->userdata('id'), 'description'=>$question, 'post_type' =>2));
    return $slug;
    
  }
  public function create_link($title, $link, $desc)
  {
    $slug = preg_replace("/[^a-zA-Z0-9]/", "-", $title) .
            "-p" .
            ($this->db->count_all("posts") + 1);
    $this->db->insert('posts', array('post_title'=>$title, 'slug' => $slug, 'user_id'=>$this->session->userdata('id'), 'description'=>$desc, 'post_type' =>3, 'link'=>$link));
    return $slug;
    
  }
  public function relative_time($timestamp){
    $since = time() - $timestamp;
    
    $chunks = array(
        array(31536000,'year'),
        array(2592000,'month'),
        array(604800,'week'),
        array(86400,'day'),
        array(3600,'hour'),
        array(60, 'minute'),
        array(1, 'second')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 ' . $name : $count . ' ' . $name . 's';
    return $print;
  }
  public function get_post_type_by_id($postid)
  {
    $this->db->where('id', $postid);
    $this->db->select('post_type');
    $query = $this->db->get('posts');
    $result = $query->result();
    return $result[0]->post_type;
  }
  public function count_num_posts($type=false, $user_id=false)
  {
    ($type) ? $this->db->where("post_type", $type) : false;
    if($user_id) $this->db->where("user_id", $user_id);
    $count = $this->db->count_all_results('posts');
    return $count;
  }
  public function get_number_of_likes_for_post($postid){
    $this->db->where("post_id", $postid);
    return $this->db->count_all_results("likes");
  }
  public function has_user_liked($userid, $postid)
  {
    $this->db->where('post_id', $postid);
    $this->db->where('user_id', $userid);
    $count = $this->db->count_all_results('likes');
    if($count>0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public function delete_post($postid)
  {
      $this->db->where('post_id', $postid);
      $this->db->delete('tag_assoc');
      $this->db->where('post_id', $postid);
      $this->db->delete('likes');
     
      $this->db->where('post_id', $postid);
      $this->db->delete('comments');
       $this->db->where('id',$postid);
      $this->db->delete('posts');
  }
  public function get_post_id_by_slug($slug)
  {
    $this->db->where('slug', $slug);
    $this->db->select('id');
    $query = $this->db->get('posts');
    $result = $query->result();
    return $result[0]->id;
  }
  public function count_num_posts_from_following($userid){
    $this->db->where("follower_id", $userid);
    $this->db->join('following', 'posts.user_id = following.followee_id');
    
    $count = $this->db->count_all_results("posts");
    return $count;

  }
  public function get_all_following_paginated($userid, $data){
    $this->db->select("posts.id, posts.timestamp , user_id, hidden, slug, file_name, description, link, post_date, photo_id, rating, rank, closed, post_type,  post_title" );
    $this->db->where("follower_id", $userid);
    $this->db->order_by("posts.id", "desc");
    $this->db->join('following', 'posts.user_id = following.followee_id');
    
    $query = $this->db->get("posts", $data["per_page"], $data["page"]);
    return $query->result();
    
  }
  public function get_photo_by_id($id){
    $this->db->where("id",$id);
    $this->db->select("file_name");
    $query = $this->db->get("posts");
    $result = $query->result();
    return $result[0]->file_name;
  }
public function get_id_by_slug($slug) {
	  $this->db->where("slug", $slug);
		$this->db->select("id");
	  $query = $this->db->get("posts");
	  $result = $query->result();
	  return $result[0]->id;
	}
  public function new_stack_photo($post_id, $filename){
    $this->db->insert("stacks",array("post_id"=>$post_id,"filename"=>$filename));
  }
  public function get_stack_photos($post_id){
    $this->db->where("post_id",$post_id);
    return $this->db->get("stacks")->result();
  }
 public function stack_exist($slug) {
    $this->db->where("slug", $slug);
    return $this->db->count_all_results("posts");
  }
  public function delete_stack($id){
    $this->db->where("id",$id);
    $this->db->delete("posts");
    $this->db->where("post_id",$id);
    $this->db->delete("stacks");
  }
}
