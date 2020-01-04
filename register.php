<?php
include_once "sql_connect.php";
include_once "functions.php";

$username = "";
$email = "";
$email2 = "";
if (isset($_GET['register']))
{
    if ($_GET['register'] == true)
    {
        //make it so that fail is 0 before it starts, if it is 1 at the end, then display error
        $fail = 0;
        
        //verify username was typed
        if (isset($_POST['username']))
        {
            $username = $_POST['username'];
        }
        else
        {
            $fail = 1;
        }
        
        //verify password was typed
        if (isset($_POST['password']))
        {
            $password = $_POST['password'];
        }
        else
        {
            $fail = 1;
        }
        //verify password 2 was typed
        if (isset($_POST['password2']))
        {
            $password2 = $_POST['password2'];
        }
        else
        {
            $fail = 1;
        }
        
        //verify that email was typed
         if (isset($_POST['email']))
        {
            $email = $_POST['email'];
        }
        else
        {
            $fail = 1;
        }
        
        //verify that email2 was typed
        if (isset($_POST['email2']))
        {
            $email2 = $_POST['email2'];
        }
        else
        {
            $fail = 1;
        }
        
        if (isset($_POST['agree']))
        {
            $agree = $_POST['agree'];
        }
        else
        {
            print "<br />Please Agree.";
            $fail = 1;
        }
        //Check to see if anyone already has their username;
        $q = mysql_query("SELECT * FROM registration");
        while ($user = mysql_fetch_array($q))
        {
            if ($user['username'] == $username)
            {
                print "Someone already has your username.";
                $fail = 2;
            }
        }
        
        //Check passwords if they match
        if ($password != $password2)
        {
            print "Your passwords don't match. Fix it.";
            $fail = 3;
        }
        
        //Check emails if they match.
        if ($email != $email2)
        {
            print "Your emails do not match. Fix it.";
            $fail = 4;
        }
        
        
        
        if ($fail == 0)
        {
            print "Inserting into the database.";
            mysql_query("INSERT INTO registration (username, password, email) VALUES ('$username', '$password', '$email')");
        }
        
    }
}
sForm("register", "register.php?register=true");

$agree[0] = "";

print "<table>
        <tr>
            <td>Username</td><td>";
                sTB("username", 20, $username);
print "
            </td>
        </tr>
        <tr>
            <td>Password:</td><td> ";
                sPW("password", 20);
print "
            </td>
            <td>Re-enter password:</td><td> ";
                sPW("password2", 20);
print "
            </td>
        </tr>
        <tr>
            <td>Email:</td><td> ";
                sTB("email", 40, $email);
print "
            </td>
            <td>Re-enter Email: </td><td>";
                sTB("email2", 40, $email2);
print "
            </td>
        </tr>
        <tr>
            <td></td><td>Agree to terms of service:</td><td> ";
                sCB("agree", $agree);
print "</td><td>"; sSubmit("register", "Register");
print "</td>
    </tr>
</table>";


?>