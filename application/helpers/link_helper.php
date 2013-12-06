<?php

function secure_link($text, $href, $options = array()) {
  $javascript = true;
  if (isset($options["js"]) && !$options["js"]){
    $javascript = false;
    unset($options["js"]);
  }
  
  if ($javascript) {
    $attributes = " href=\"$href\"";
    foreach ($options as $name => $value) {
      $attributes .= " $name=\"$value\"";
    }
    return "<a$attributes data-secure-link>$text</a>";
  }
  else {
    
  }
}