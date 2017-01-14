<?php

function format_date($date) {
  return date('G:i, d M Y', strtotime($date));
}