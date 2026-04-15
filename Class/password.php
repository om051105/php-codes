<?php
//password is min 8 total charaters
// checks if passowrd contains digits 
$password = "123456789";
if(strlen($password) >= 8 && preg_match('/[0-9]/', $password)) {
    echo "Strong password!";
} else {
    echo "Weak password ";
}
?>