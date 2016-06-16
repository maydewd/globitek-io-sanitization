<?php

  //
  // COUNTRY QUERIES
  //

  // Find all countries, ordered by name
  function find_all_countries() {
    global $db;
    $sql = "SELECT * FROM countries ORDER BY name ASC;";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  function find_country_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM countries ";
    $sql .= "WHERE id=?;";
    return prepareAndExecute($db, $sql, "i", $id);
  }

  function validate_country($country, $errors=array()) {
    if (is_blank($country['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif (!has_length($country['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_format($country['name'])) {
      $errors[] = "Name must be composed of alpha characters, spaces, hyphens, and apostrophes";
    }

    if (is_blank($country['code'])) {
      $errors[] = "Code cannot be blank.";
    } elseif (!has_length($country['code'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Code must be between 2 and 255 characters.";
    } elseif (!has_valid_state_code($country['code'])) {
      $errors[] = "Code must be 2 alpha characters";
    }

    return $errors;
  }

  // Add a new state to the table
  // Either returns true or an array of errors
  function insert_country($country) {
    global $db;

    $errors = validate_country($country);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO countries ";
    $sql .= "(name, code) ";
    $sql .= "VALUES (?,?);";

    $result = prepareAndExecute($db, $sql, "ss", $country['name'],
      $country['code']);
    // For INSERT statments, any errors would have already been thrown
    return true;
  }

  // Edit a state record
  // Either returns true or an array of errors
  function update_country($country) {
    global $db;

    $errors = validate_country($country);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE countries SET ";
    $sql .= "name=?, ";
    $sql .= "code=? ";
    $sql .= "WHERE id=? ";
    $sql .= "LIMIT 1;";

    $result = prepareAndExecute($db, $sql, "ssi", $country['name'],
      $country['code'], $country['id']);
    // For update_state statments, any errors would have already been thrown
    return true;
  }

  //
  // STATE QUERIES
  //

  // Find all states, ordered by name
  function find_all_states() {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find all states, ordered by name
  function find_states_for_country_id($country_id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE country_id=? ";
    $sql .= "ORDER BY name ASC;";
    return prepareAndExecute($db, $sql, "i", $country_id);
  }

  // Find state by ID
  function find_state_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE id=?;";
    return prepareAndExecute($db, $sql, "i", $id);
  }

  function validate_state($state, $errors=array()) {
    if (is_blank($state['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif (!has_length($state['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_format($state['name'])) {
      $errors[] = "Name must be composed of alpha characters, spaces, hyphens, and apostrophes";
    }

    if (is_blank($state['code'])) {
      $errors[] = "Code cannot be blank.";
    } elseif (!has_length($state['code'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Code must be between 2 and 255 characters.";
    } elseif (!has_valid_state_code($state['code'])) {
      $errors[] = "Code must be 2 alpha characters";
    }

    return $errors;
  }

  // Add a new state to the table
  // Either returns true or an array of errors
  function insert_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO states ";
    $sql .= "(name, code, country_id) ";
    $sql .= "VALUES (?,?,?);";

    $result = prepareAndExecute($db, $sql, "ssi", $state['name'],
      $state['code'], $state['country_id']);
    // For INSERT statments, any errors would have already been thrown
    return true;
  }

  // Edit a state record
  // Either returns true or an array of errors
  function update_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE states SET ";
    $sql .= "name=?, ";
    $sql .= "code=? ";
    $sql .= "WHERE id=? ";
    $sql .= "LIMIT 1;";

    $result = prepareAndExecute($db, $sql, "ssi", $state['name'],
      $state['code'], $state['id']);
    // For update_state statments, any errors would have already been thrown
    return true;
  }

  //
  // TERRITORY QUERIES
  //

  // Find all territories, ordered by state_id
  function find_all_territories() {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "ORDER BY state_id ASC, position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find all territories whose state_id (foreign key) matches this id
  function find_territories_for_state_id($state_id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE state_id=? ";
    $sql .= "ORDER BY position ASC;";
    return prepareAndExecute($db, $sql, "i", $state_id);
  }

  // Find territory by ID
  function find_territory_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories WHERE id=?";
    return prepareAndExecute($db, $sql, "i", $id);
  }

  function validate_territory($territory, $errors=array()) {
    if (is_blank($territory['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif (!has_length($territory['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_format($territory['name'])) {
      $errors[] = "Name must be composed of alpha characters, spaces, hyphens, and apostrophes";
    }

    if (is_blank($territory['position'])) {
      $errors[] = "Position cannot be blank.";
    } elseif (!has_valid_int_format($territory['position'])) {
      $errors[] = "Position must be an integer";
    }

    return $errors;
  }

  // Add a new territory to the table
  // Either returns true or an array of errors
  function insert_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO territories ";
    $sql .= "(name, position, state_id) ";
    $sql .= "VALUES (?,?,?);";

    $result = prepareAndExecute($db, $sql, "sii", $territory['name'],
      $territory['position'], $territory['state_id']);
    // For INSERT statments, any errors would have already been thrown
    return true;
  }

  // Edit a territory record
  // Either returns true or an array of errors
  function update_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE territories SET ";
    $sql .= "name=?, ";
    $sql .= "position=? ";
    $sql .= "WHERE id=? ";
    $sql .= "LIMIT 1;";

    $result = prepareAndExecute($db, $sql, "sii", $territory['name'],
      $territory['position'], $territory['id']);
    // For update_territory statments, any errors would have already been thrown
    return true;
  }

  //
  // SALESPERSON QUERIES
  //

  // Find all salespeople, ordered last_name, first_name
  function find_all_salespeople() {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // To find salespeople, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same territory ID.
  function find_salespeople_for_territory_id($territory_id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (salespeople_territories.salesperson_id = salespeople.id) ";
    $sql .= "WHERE salespeople_territories.territory_id=? ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    return prepareAndExecute($db, $sql, "i", $territory_id);
  }

  // Find salesperson using id
  function find_salesperson_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople WHERE id=?;";
    return prepareAndExecute($db, $sql, "i", $id);
  }

  function validate_salesperson($salesperson, $errors=array()) {
    if (is_blank($salesperson['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($salesperson['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_format($salesperson['first_name'])) {
      $errors[] = "Name must be composed of alpha characters, spaces, hyphens, and apostrophes";
    }

    if (is_blank($salesperson['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($salesperson['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_format($salesperson['last_name'])) {
      $errors[] = "Name must be composed of alpha characters, spaces, hyphens, and apostrophes";
    }

    if (is_blank($salesperson['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($salesperson['email'])) {
      $errors[] = "Email must be a valid format.";
    } elseif (!has_full_email_address($salesperson['email'])) {
      $errors[] = "Email must be fully formed to include a user and domain";
    }

    if (is_blank($salesperson['phone'])) {
      $errors[] = "Phone cannot be blank.";
    } elseif (!has_length($salesperson['phone'], array('max' => 255))) {
      $errors[] = "Phone must be less than 255 characters.";
    } elseif (!has_full_phone_number($salesperson['phone'])) {
      $errors[] = "Phone must contain 10 numbers";
    }

    return $errors;
  }

  // Add a new salesperson to the table
  // Either returns true or an array of errors
  function insert_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO salespeople ";
    $sql .= "(first_name, last_name, email, phone) ";
    $sql .= "VALUES (?,?,?,?);";

    $result = prepareAndExecute($db, $sql, "ssss", $salesperson['first_name'],
      $salesperson['last_name'], $salesperson['email'], $salesperson['phone']);
    // For INSERT statments, any errors would have already been thrown
    return true;
  }

  // Edit a salesperson record
  // Either returns true or an array of errors
  function update_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE salespeople SET ";
    $sql .= "first_name=?, ";
    $sql .= "last_name=?, ";
    $sql .= "phone=?, ";
    $sql .= "email=? ";
    $sql .= "WHERE id=? ";
    $sql .= "LIMIT 1;";

    $result = prepareAndExecute($db, $sql, "ssssi", $salesperson['first_name'],
      $salesperson['last_name'], $salesperson['phone'], $salesperson['email'], $salesperson['id']);
    // For update_salesperson statments, any errors would have already been thrown
    return true;
  }

  // To find territories, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same salesperson ID.
  function find_territories_by_salesperson_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (territories.id = salespeople_territories.territory_id) ";
    $sql .= "WHERE salespeople_territories.salesperson_id=? ";
    $sql .= "ORDER BY territories.name ASC;";
    return prepareAndExecute($db, $sql, "i", $id);
  }

  //
  // USER QUERIES
  //

  // Find all users, ordered last_name, first_name
  function find_all_users() {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  // Find user using id
  function find_user_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM users WHERE id=? LIMIT 1";
    return prepareAndExecute($db, $sql, "i", $id);
  }

  // if the $id parameter is specified, the query excludes username
  // uniqueness check against users with the given id
  function validate_user($user, $errors=array(), $id=null) {
    if (is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_format($user['first_name'])) {
      $errors[] = "Name must be composed of alpha characters, spaces, hyphens, and apostrophes";
    }

    if (is_blank($user['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_format($user['last_name'])) {
      $errors[] = "Name must be composed of alpha characters, spaces, hyphens, and apostrophes";
    }

    if (is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($user['email'])) {
      $errors[] = "Email must be a valid format.";
    } elseif (!has_full_email_address($user['email'])) {
      $errors[] = "Email must be fully formed to include a user and domain";
    }

    if (is_blank($user['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($user['username'], array('max' => 255))) {
      $errors[] = "Username must be less than 255 characters.";
    } elseif (contains_banned_string($user['username'])) {
      $errors[] = "Username cannot contain any banned keywords";
    } elseif (!has_unique_username($user['username'], $id)) {
      $errors[] = "Username already taken";
    }

    return $errors;
  }

  // Add a new user to the table
  // Either returns true or an array of errors
  function insert_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, username, created_at) ";
    $sql .= "VALUES (?,?,?,?,?);";

    $result = prepareAndExecute($db, $sql, "sssss", $user['first_name'],
      $user['last_name'], $user['email'], $user['username'], $created_at);
    // For INSERT statments, any errors would have already been thrown
    return true;
  }

  // Edit a user record
  // Either returns true or an array of errors
  function update_user($user) {
    global $db;

    $errors = validate_user($user, array(), $user['id']);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE users SET ";
    $sql .= "first_name=?, ";
    $sql .= "last_name=?, ";
    $sql .= "email=?, ";
    $sql .= "username=? ";
    $sql .= "WHERE id=? ";
    $sql .= "LIMIT 1;";

    $result = prepareAndExecute($db, $sql, "ssssi", $user['first_name'],
      $user['last_name'], $user['email'], $user['username'], $user['id']);
    // For update_user statments, any errors would have already been thrown
    return true;
  }

  // Delete a user record
  // Either returns true or exits with errors
  function delete_user($user_id) {
    global $db;

    $sql = "DELETE FROM users WHERE id=? LIMIT 1;";

    prepareAndExecute($db, $sql, "i", $user_id);
    // For delete_user statments, any errors would have already been thrown
    return true;
  }

?>
