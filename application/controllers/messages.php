<?php

class Messages extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model("message");
  }
  public function index() {
    if (!$this->user->is_logged_in()) {
      $this->session->set_flashdata("notice", "You must be logged in to view this page");
      redirect("login");
    }
    $user_id = $this->session->userdata("id");
    $this->template->load("template", "messages/index", array(
      "messages" => $this->message->get_for_id($user_id)
    ));
  }
  public function create($to_username, $subject = "") {
    if (!$this->user->is_logged_in()) {
      $this->session->set_flashdata("notice", "You must be logged in to view this page");
      redirect("login");
    }
    $this->template->load("template", "messages/create", array(
      "to_username" => $to_username,
      "subject" => base64_decode($subject)
    ));
  }
  public function send() {
    if (!$this->user->is_logged_in()) {
      $this->session->set_flashdata("notice", "You must be logged in to view this page");
      redirect("login");
    }
    $from_id = $this->session->userdata("id");
    $to_id = $this->user->get_id_by_username($this->input->post("to_username"));
    $to_username = $this->input->post("to_username");
    $subject = $this->input->post("subject");
    $body = $this->input->post("body");
    $this->message->send(array(
      "from_id" => $from_id,
      "to_id" => $to_id,
      "subject" => $subject,
      "body" => $body
    ));
    redirect("people/$to_username");
  }
  public function view($id) {
    $message = $this->message->get_message($id);
    if (!$message) {
      $this->session->flashdata("notice", "Message does not exist");
      redirect("messages");
    }
    $user_id = $this->session->userdata("id");
    if ($user_id != $message->from_id && $user_id != $message->to_id) {
      $this->session->flashdata("notice", "You don't have permission to view that message");
      redirect("messages");
    }
    $this->template->load("template", "messages/view", array(
      "message" => $message
    ));
  }
}
