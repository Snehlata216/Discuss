<!DOCTYPE html>
<html lang="en">

<head>
   <title>Discuss Project</title>
   <?php include('./client/commonFiles.php') ?>
</head>

<body>
   <?php
   session_start();
   include('./client/header.php');

   // Check if 'user' is set in session
   $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

   // Signup and Login conditions
   if (isset($_GET['signup']) && !$user) {
      include('./client/signup.php');
   } elseif (isset($_GET['login']) && !$user) {
      include('./client/login.php');
   } 
   
   // If user is logged in, allow these pages
   elseif (isset($_GET['ask'])) {
      include('./client/ask.php');
   } 
   elseif (isset($_GET['q-id'])) {
      $qid = intval($_GET['q-id']); // Sanitize input
      include('./client/question-details.php');
   } 
   elseif (isset($_GET['c-id'])) {
      $cid = intval($_GET['c-id']); // Sanitize input
      include('./client/questions.php');
   } 
   elseif (isset($_GET['u-id'])) {
      $uid = intval($_GET['u-id']); // Sanitize input
      include('./client/questions.php');
   } 
   elseif (isset($_GET['latest'])) {
      include('./client/questions.php');
   } 
   elseif (isset($_GET['search'])) {
      $search = htmlspecialchars($_GET['search']); // Sanitize input
      include('./client/questions.php');
   } 
   else {
      include('./client/questions.php');
   }
   ?>
</body>

</html>
