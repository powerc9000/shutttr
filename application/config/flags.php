<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config["flags_reasons"] = array(
  "WTF",
//TODO: Add reasons!
  "Pornography",
  "Not related to photography",
  "Inappropriate or not allowed",
	"Not original work"
);

$config["actions_taken"] = array(
	"WTF",
	"blocked",
	"Post Hidden"
);

$config["actions_id"] = array(
	"WTF" => 0,
	"blocked" => 1,
	"post_hidden" => 2
);