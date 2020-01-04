<?php
include_once "sql_connect.php";
include_once "functions.php";

if (isset($_POST['username']))
{
    if (isset($_POST['password']))
    {
        $username = strtolower($_POST['username']);
        $password = strtolower($_POST['password']);
        //check if user exists
        $q_user = mysql_query("SELECT * FROM registration");
        while ($a_user = mysql_fetch_array($q_user))
        {
            $a_username = strtolower($a_user['username']);
            if ($a_username == $username)
            {
                //Flags that it does exist for error purposes
                $exists = true;
                $a_pass = strtolower($a_user['password']);
                if ($password == $a_pass)
                {
                    $id = $a_user['id'];
                    $_SESSION['id'] = $id;
                    
                    
                    print "Logged in successfully.";
                    print "<a href='index.php?id=$id'>Home</a>";
                    header( "Location: index.php?id=$id" ) ;
                }
                else
                {
                    print "Invalid username or password.";
                }
            }
        }
    }
    else
    {
        print "Invalid username or password.";
    }
}

sForm("forms", "login.php");
sTB("username");
sPW("password");
sSubmit("Submit", "Login");

?>