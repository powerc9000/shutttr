<?php

class Misc extends CI_Controller {
  public function not_found() {
		$this->load->view('misc/404');
  }

  public function guidelines() {
    if (!$this->user->is_logged_in()) {
      $this->session->set_flashdata("notice", "You must be logged in to view this page.");
      redirect("login");
    }
    $id = $this->session->userdata("id");
    $this->user->view_guidelines($id);
    $this->template->load('template.php', 'misc/guidelines');
  }
}
