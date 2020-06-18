<?php
session_start();
//Connect with deatabase
$link= mysqli_connect("localhost","root","","note");
//check the validity of the email
if($_POST['submit']=="SignUp"){
    if(!$_POST['email']) $error.="<br />please enter your email";
    
    else if (!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) $error.="<br />please enter a valid email";
    
     if(!$_POST['password']) $error.="<br />please enter your password";
    //Check the validite of PassWord
    else {
        if(strlen($_POST['password'])<8) $error.="<br />please enter at least 8 caracters password";
        
        if(!preg_match('`[A-Z]`', $_POST['password']))$error.="<br />please enter at least one capital letter in password";
    }
    //Print the Errot If there is an error
    if($error) echo "there is a error :".$error;
    //If there is not a error ...
    else{
        //Connect With the DataBase and Check if the email was reister before in DataBase
        
        $query ="SELECT * FROM `note` WHERE email='".mysqli_real_escape_string($link ,$_POST['email'])."'";
        
        $result= mysqli_query($link, $query);
        $results= mysqli_num_rows($result);
        //Tell the user a message if hisregister before  
        if($results) echo "that email address is already registered , Do you Want To logIn ?.";
        //If he don't register Before ...
        else {
            $query="INSERT INTO `note` (`email`, `password`)VALUES('".mysqli_real_escape_string($link ,$_POST['email'])."', '".$_POST['password']."')";
            mysqli_query($link, $query);
            echo "you SignUp";
            $_SESSION['id']=mysqli_insert_id($link);
            print_r($_SESSION);
            //redirect to login page
        }
    }
}
//To Login the user
if($_POST['submit']=="LogIn"){
     $query ="SELECT * FROM `note` WHERE email='".mysqli_real_escape_string($link ,$_POST['LogEmail'])."' AND password='".$_POST['LogPassword']."' LIMIT 1";
    $result= mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);
    if($row){
        $_SESSION['id']= $row['id'];
        print_r($_SESSION);
        //redirect to logged in page
    }
    else{
        echo "Please enter a correct information ...";
        }
}

?>
<form method="post">
    <input type="email" name="email" id="email" value="<?php error_reporting(0); echo addslashes($_POST['email']); ?>"/>
    <input type="password" name="password" id="password" value="<?php error_reporting(0); echo addslashes($_POST['password']); ?>" />
    <input type="submit" name="submit" value="SignUp"/>
</form>

<form method="post">
    <input type="email" name="LogEmail" id="LogEmail" value="<?php error_reporting(0); echo addslashes($_POST['email']); ?>"/>
    <input type="password" name="LogPassword" id="LogPassword" value="<?php error_reporting(0); echo addslashes($_POST['password']); ?>" />
    <input type="submit" name="submit" value="LogIn"/>
</form>
