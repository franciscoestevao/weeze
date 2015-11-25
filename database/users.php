<?php
  function userExists($username, $password) {
    global $db;
    
    $stmt = $db->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->execute(array($username, sha1($password)));  

    return $stmt->fetch() !== false;
  }
?>
