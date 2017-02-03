<?php
  require_once('../private/initialize.php');
  $errors = [];

  // Check for post request
  if (is_post_request()) {

    $all_fields = array(
      'Username'=>$_POST['username'],
      'First name'=>$_POST['firstname'],
      'Last name'=>$_POST['lastname'],
      'Email'=>$_POST['email']
    );

    // Ensure form fields are not blank
    foreach ($all_fields as $fieldname=>$field) {
      if (is_blank($field)) {
        array_push($errors, $fieldname.' cannot be blank.');
      }
    }

    // Check that all fields are no longer than 255 char
    $options1 = ["min"=>0, "max"=>255];
    foreach ($all_fields as $fieldname=>$field) {
      if (!has_length($field, $options1)) {
        array_push($errors, $fieldname. ' cannot be longer than 255 characters.');
      }
    }

    // Check that first name and last name are no shorter than 2 characters
    $options2 = ["min"=>2, "max"=>5000];
    if (!has_length($all_fields['First name'], $options2)) {
      array_push($errors, 'First name cannot be shorter than 2 characters.');
    }
    if (!has_length($all_fields['Last name'], $options2)) {
      array_push($errors, 'Last name cannot be shorter than 2 characters.');
    }

    // Check that username is longer than 8 char
    $options3 = ["min"=>8, "max"=>5000];
    if (!has_length($all_fields['Username'], $options3)) {
      array_push($errors, 'Username must be longer than 8 characters.');
    }

    // Check that email is valid
    if (!has_valid_email_format($all_fields['Email'])) {
      array_push($errors, 'Please enter a valid email address (e.g. debra293@gmail.com).');
    }

    // Check for unique username
    $result = find_user($_POST['username']);
    while ($row = $result->fetch_assoc()) {
       $unique_username = ($_POST['username'] != $row['username']);
    }

    // Insert into database and redirect
    if (sizeof($errors) == 0) {
      $sql = "INSERT INTO users (first_name, last_name, username, email) VALUES ('".
      $all_fields['First name']."', '".
      $all_fields['Last name']."', '".
      $all_fields['Username']."', '".
      $all_fields['Email']."')";

      $result = db_query($db, $sql);
      if ($result) {
        echo 'all validated!';
        redirect_to('registration_success.php');
      } else {
        echo db_error($db);
        exit;
      }

    }
  }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    if (isset($errors)) {
      echo display_errors($errors);
    }
  ?>

  <?php
    function prepopulate($previous) {
      if (isset($_POST[$previous])) {
        echo "value='".$_POST[$previous]."'";
      }
    }
    ?>

  <form id="reg_form" action="" method="post">
    <table>
      <tr><td>First Name: </td><td><input type="text" name="firstname" <?php prepopulate('firstname'); ?>></td></tr>
      <tr><td>Last Name: </td><td><input type="text" name="lastname"  <?php prepopulate('lastname'); ?>></td></tr>
      <tr><td>Email: </td><td><input type="text" name="email"  <?php prepopulate('email'); ?>></td></tr>
      <tr><td>Username: </td><td><input type="text" name="username"  <?php prepopulate('username'); ?>></td></tr>
  </table><br>
  <input type="submit" value="Register">
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
