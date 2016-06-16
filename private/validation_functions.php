<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    $length = strlen($value);
    if(isset($options['max']) && ($length > $options['max'])) {
      return false;
    } elseif(isset($options['min']) && ($length < $options['min'])) {
      return false;
    } elseif(isset($options['exact']) && ($length != $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    return strpos($value, '@') && preg_match('/\A[A-Za-z0-9\-\._@]+\Z/', $value);
  }

  function has_valid_username_format($value) {
    return preg_match('/\A[A-Za-z0-9_]+\Z/', $value) == true;
  }

  function has_valid_phone_format($value) {
    return preg_match('/\A[\s0-9\-\(\)]+\Z/', $value) == true;
  }

  // My custom validation
  // matches all valid integers
  function has_valid_int_format($value) {
    return filter_var($value, FILTER_VALIDATE_INT) == true;
  }

  // My custom validation
  // matches all alpha characters, spaces, hyphens, and apostrophes
  function has_valid_name_format($value) {
    return preg_match('/\A[\sA-Za-z\'-]+\Z/', $value) == true;
  }

  // My custom validation
  // checks for a fully valid email address (per RFC 822 specifications)
  // includes checking for user and domain, not just the @ sign
  function has_full_email_address($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL) == true;
  }

  // My custom validation
  // used to check if a string contains a banned value
  function contains_banned_string($value) {
    return preg_match('(fake|evil|profane|inappropriate)', $value) == true;
  }

  // My custom validation
  // checks that the state code is a 2 character numeric string
  function has_valid_state_code($value) {
    return preg_match('/\A[a-zA-Z]{2}\Z/', $value) == true;
  }

  // My custom validation
  // checks that a string has the correct number of numeric characters for a full phone number
  function has_full_phone_number($value) {
    return preg_match_all( "/[0-9]/", $value) === 10;
  }

  // check to see if a given username already exists in the database
  // if the $id parameter is specified, the query excludes users with the given id
  function has_unique_username($value, $id=null) {
    global $db;
    if (is_null($id)) {
      $sql = "SELECT * from users WHERE username=?;";
      $result = prepareAndExecute($db, $sql, "s", $value);
    }
    else {
      $sql = "SELECT * from users WHERE username=? AND id!=?;";
      $result = prepareAndExecute($db, $sql, "si", $value, $id);
    }
    return mysqli_num_rows($result) === 0;
  }

?>
