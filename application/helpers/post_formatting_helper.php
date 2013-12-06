<?php

// Thanks, Kyle Bragger :)
function auto_link($str, $type = "both", $popup = false) {
  if ($type != "email") {
    if (preg_match_all("#(^|\\s|\\()((http(s?)://)|(www\\.))(\w+[^\\s\\)\\<]+)#i",
                       $str,
                       $matches)) {
      $pop = ($popup == true) ? " target=\"_blank\" " : "";

      for ($i = 0; $i < count($matches["0"]); $i++) {
        $period = "";
       if (preg_match("|\.$|", $matches["6"][$i])) {
          $period = ".";
          //$matches["6"][$i] = substr($matches["6"][$i], 0, -1);
        }

        $str = str_replace($matches["0"][$i],
                           $matches["1"][$i] . "<a href=\"http".
                           $matches["4"][$i] . "://".
                           $matches["5"][$i] .
                           $matches["6"][$i] . "\"" . $pop . ">http" .
                           $matches["4"][$i] . "://" .
                           $matches["5"][$i] .
                           $matches["6"][$i] . "</a>".
                           $period, $str);
      }
    }
    $str = preg_replace("#(\\s|^|[^\\w])(@([a-z0-9]+))#i", "\\1<a href=\"" . site_url("people/\\3") . "\">\\2</a>", $str);
  }

  if ($type != "url") {
    $str = preg_replace("#\\b([A-Z0-9._%-]+@[A-Z0-9.-]+\\.[A-Z]{2,4})\\b#i", "<a href=\"mailto:\\1\">\\1</a>", $str);
  }
  
  return $str;
}

require_once("markdown_helper.php");