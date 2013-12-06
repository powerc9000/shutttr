<?php

class Message extends CI_Model {
  public function send($conf) {
    $this->db->insert("pm", $conf);
    $this->db->order_by("id", "desc");
    $this->db->limit(1);
    $this->db->select("id");
    $r = $this->db->get("pm")->result();
    $m_id = $r[0]->id;

    $this->db->where("id", $conf["from_id"]);
    $this->db->select("username");
    $r = $this->db->get("users")->result();
    $from_username = $r[0]->username;

    $this->db->where("id", $conf["to_id"]);
    $r = $this->db->get("users")->result();
    $to = $r[0];

    $message_link = site_url("messages/view/$m_id");

    $this->load->library("postmark");
    $this->postmark->reply_to("notifier@shutttr.com");
    $this->postmark->to($to->email);
    $this->postmark->subject("You reveived a message from $from_username on Shutttr");
    $this->postmark->message_html(<<<HTML
Here's the message:<br />      
<blockquote>
<h2>{$conf["subject"]}</h2>
<p style="font-size:16px">{$conf["body"]}</p>
</blockquote>
<a href="$message_link">View it on shutttr</a>
HTML
    );
    $this->postmark->send();
  }
  public function get_for_id($to_id) {
    $this->db->where("to_id", $to_id);
    $q = $this->db->get("pm");
    if ($q->num_rows() > 0) {
      $ar = $q->result();
      $res = array();
      foreach ($ar as $r) {
        $this->db->where("id", $r->from_id);
        $this->db->select("username");
        $u = $this->db->get("users")->result();
        $u = $u[0];
        $u = $u->username; 
        $r->from_username = $u;
        $res[] = $r;
      }
      return $res;
    }
    else {
      return array();
    }
  }
  public function get_message($id) {
    $this->db->where("id", $id);
    $r = $this->db->get("pm")->result();
    if (count($r) == 0) return NULL;
    return $r[0];
  }
  public function num_users_messages() {
    $this->db->where("id", $this->session->userdata("id"));
    return $this->db->count_all_results("pm");
  }
}
