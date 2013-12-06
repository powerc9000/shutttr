<?php

class Announcement extends CI_Model {
  public function get() {
    // get the data
    $user_id = $this->session->userdata("id");
    $announcements = $this->db->get("announcements")->result();
    $this->db->where("user_id", $user_id);
    $this->db->select("announcement_id");
    $_views = $this->db->get("announcements_viewed")->result();
    $views = array();
    foreach ($_views as $view) {
      $views[] = $view->announcement_id;
    }
    // find the right announcement
    $return = false;
    foreach ($announcements as $announcement) {
			if($announcement->live ==! "0"){
      if (!in_array($announcement->id, $views)) {
        $return = $announcement;
        // TODO: hide button
       // 	$this->db->insert("announcements_viewed", array(
      //    "announcement_id" => $announcement->id,
      //     "user_id" => $user_id
       //  ));
        break;
      }
    }
}
    
    return $return;
  }
  public function announcement_viewed($id, $user_id){ 
    if($this->db->insert("announcements_viewed", array("announcement_id" => $id, "user_id" => $user_id)))
          {
    
      $user_id = $this->session->userdata("id");
    $announcements = $this->db->get("announcements")->result();
    $this->db->where("user_id", $user_id);
    $this->db->select("announcement_id");
    $_views = $this->db->get("announcements_viewed")->result();
    $views = array();
    foreach ($_views as $view) {
      $views[] = $view->announcement_id;
    }
    
    // find the right announcement
    $return = false;
    foreach ($announcements as $announcement) {
      if (!in_array($announcement->id, $views)) {
        $return = $announcement;
        // TODO: hide button
       //   $this->db->insert("announcements_viewed", array(
      //    "announcement_id" => $announcement->id,
      //     "user_id" => $user_id
       //  ));
        break;
      }
    }
    
    return $return;
          }
          else
          {
            return false;
          }
   
       
  }

  public function new_announcement($body, $creator_id)
  {   
       $this->db->insert("announcements", array(
        "body" => $body,
        //"urgency" => $urgency,
				"creator_id" => $creator_id,
				"timestamp" => date('Y-m-d H:i:s'),
				"live" => '1'
        
      ));
      
  }
   public function get_all_announcements() {
    $this->db->order_by("id", "desc");
    $announce_query = $this->db->get("announcements");
    $announce_result = $announce_query->result();
    for($i=0; $i < sizeof($announce_result); $i++)
    {
    $announce[] = (array) $announce_result[$i];
    }
    return $announce;
  }
  public function delete_announcement($id)
  {
      $this->db->where('id', $id);
      $this->db->delete("announcements");
       
      
  }
 public function hide_announcement($id)
  {
      $this->db->where('id', $id);
      $this->db->set("live", "0");
			$this->db->update("announcements");
      
  }
 public function unhide_announcement($id)
  {
      $this->db->where('id', $id);
      $this->db->set("live", "1");
			$this->db->update("announcements");
      
  }
}