<?php
/*
$CI = get_instance();
$CI->db->where("username", $CI->session->userdata("username"));
$CI->db->where("can_login", 0);
if ($CI->db->count("blocked")) {
  $CI->session->sess_destroy();
  $CI->session->set_flashdata("error", "Your account has been blocked from logging in.");
}
*/