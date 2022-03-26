<?php

$con = new mysqli("localhost","root","","phpcrud");

if($con->connect_error){
  die("Error Connect Try again..!".$con->connect_error);
}
?>