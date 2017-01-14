<?php

function fields_match($field1, $field2) {
  return $field1 == $field2;
}

function field_exists($field) {
  return $field != '' && $field != null;
}

function field_above_length($field, $min_length) {
  return strlen($field) >= $min_length;
}

function field_below_length($field, $max_length) {
  return strlen($field) <= $max_length;
}

function field_has_length($field, $length) {
  return strlen($field) == $length;
}