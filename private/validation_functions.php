<?php

  // is_blank('abcd')
  function is_blank($value) {
    return trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    // TODO
    return (strlen(trim($value)) >= $options['min']) && (strlen(trim($value)) <= $options['max']);
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    // TODO
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    return (preg_match($regex, $value));
  }

?>
