<?php
session_start();

function is_authenticated() {
  return isset($_SESSION['user']);
}

function is_admin() {
  if (is_authenticated()) {
    return $_SESSION['user']->is_admin;
  }
  return false;
}