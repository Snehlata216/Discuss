<?php
 $host="localhost:8000";
 $username="root";
 $password=null;
 $database="discuss";

 $conn=new mysqli($host,$username,$password,$database);
 
 if ($conn->connect_error) {
     die("not connected with DB ". $conn->connect_error);
 }
//   echo "Database Connnected";
 
?>