<?php
  $this->db->where("id", $message->from_id);
  $this->db->select("username");
  $r = $this->db->get("users")->result();
  $username = $r[0]->username;
?>
<br />
<div id="container">
  <div id="content" class="single-message">
    <h2><?= $message->subject ?></h2>
    <small>from <a href="<?= site_url("people/$username") ?>"><?= $username ?></a></small>
    <a href="<?= site_url("message/$username/".base64_encode("RE: ".$message->subject)) ?>" class="fancy">
      Reply
    </a><br />
    <p><?= $message->body ?></p>
  </div>
</div>
