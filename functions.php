<html>
<head>
    <title>SimmerMe</title>
<link rel="stylesheet" 
type="text/css" href="style1.css" />
</head>
<body>
    
<?php
session_start();
if (isset($_SESSION['id']))
{
    $user = $_SESSION['id'];
}
else
{
    $user = -1;
}
//mysql_query("INSERT INTO hits SET page='{$_SERVER['PHP_SELF']}', user=$user") or die(mysql_error());
if (isset($_GET['logout']))
{
    session_start();
    session_unset();
}

/*if (isset($_SESSION['id']) == 1)
{
    $user = get_account($_SESSION['id']);
    print "Currently logged in as: " . $user['name'] . " <a href='view_threads.php?logout=1'>[Logout]</a><br />";
}
else
{
    mini_login_screen();
}
*/


/*This is just intended to help me easily create forms for web pages using PHP
functions.*///cm3rt

function sForm($name, $targetURL , $GET="")
//Create a new form setting its' name, target URL, and optionally a label.
//Paramaters are (name[string], targetURL[string], optional GET[string], optional label[float]).
{
    print "\n<form action='$targetURL?$GET' id='$name' name='$name' method='post'>";
}    

function sTB($name, $max_len="", $value="", $size="24", $label="")
//Create a standard text box. Set name and optionally max length, initial value, width.
//Parameters: (name[string], optional max_len[int], optional size[int], optional maxlength[int], optional value[float], optional label[float]).
{
    print "\n<label>$label<input type='text' name='$name' id='$name' maxlength='$max_len' value='$value' size='$size' /></label />";
}

function sTA($name, $cols="50", $rows="6", $label="", $init_value="")
//Create a text area. Set name and optionally max length, initial value, width.
//Parameters: (name[string], optional cols[int], optional rows[int], optional initial value[float]).
{
    print "\n<label>$label<textarea name='$name' cols='$cols' rows='$rows'>$init_value</textarea></label />";
}

function sPW($name,  $max_len="", $value="", $size="24", $label="")
//Create a password box. Set name and optionally max length, initial value, width.
//Parameters: (name[string], optional max_len[int], optional size[int], optional maxlength[int], optional value[float], optional label[float]).
{
    print "\n<label>$label<input name='$name' type='password' id='$name' maxlength='$max_len' /></label />";
}

function sSubmit($name, $value)
//Submit button. Set name and label.
//Parameters: (name[string], label[string])
{
    print "\n<input type='submit' name='$name' id='$name' value='$value' />";
}

function sDD($name, &$value, $label="")
//Dropdown menu. Set its' name, length, array containing the values, and optionally a label.
//Parameters: (name[string], length[int], &value[float], optional label[float])
{
    $length = count($value);
    print "\n<label>$label<select name='$name'>"; 
    
    //So that it displays a blank value for the first selection to see if they actually filled out the form.
    print "<option value='' selected='selected'></option>";
    for($indx=0;$indx<$length;$indx++)
    {
        print "\n<option value='$indx'>{$value[$indx]}</option>";
    }
    print "\n</select></label>";
}

function sCB($name, &$value, $label="")
//Checkbox List. Set its' name, length, array containing the values, and optinally a label.
//Parameters: (name[string],  &value[float], optional label[float])
{ 
    $length = count($value);
    
            
    for($indx=0;$indx<$length;$indx++)
    {
        $val = $indx + 1;
        print $value[$indx] . "\n <input type='checkbox' name='$name' value='$val'/>";
    }
    print "\n</select></label>";
}

function sCBMulti($name, &$value, $width="", $label="")
//Checkbox List. Set its' name, length, array containing the values, and optinally a label.
//Parameters: (name[string],  &value[float], optional label[float])
{ 
    $length = count($value);
    
    print "<table border='0'>";
    for($indx=0;$indx<$length;$indx++)
    {
        $val = $indx + 1;
        $cb_width = 75;
        print "<tr>";
        print "<td width='$width' align='left'> " . $value[$indx] . "</td><td align='right'><input type='checkbox' name='{$name}[]' value='$val'/><td width='$cb_width'></td>";
        $indx++;
        $val = $indx + 1;
        if ($indx < $length)
        print "<td width='$width' align='left'> " . $value[$indx] . "</td><td align='right'><input type='checkbox' name='{$name}[]' value='$val'/>";
        
    }
    print "\n</label></table>";
}

function sRadio($name, &$value, $label="", $style=0)
//Radiobutton Group. Set its' name, length, array containing the values, and optionally a label.
//Parameters: (name[string], length[int], &value[float], optional label[float])
{
    $length = count($value);
    print "<label>$label";
    if ($style==2)
    {
        print "<br />\n<table>";
    }
    for($indx=0;$indx<$length;$indx++)
    {
        if ($style==1)
        {
            print "<br />";
        }
        
        print "\n\t<tr><td><input type='radio' name='$name' value='$indx'/>{$value[$indx]}</td></tr>";
    }
    print "\n</label />";
    if ($style==1)
    {
        print "\n<br />";
    }
    elseif($style==2)
    {
        print "\n</table>";
    }
}

function sStates($name)
//Name for the name of the $_POST
{
    print "
    <select name='$name'>
        <option value='' selected='selected'></option>
        <option value='AK'>Alaska</option>
        <option value='AL'>Alabama</option>
        <option value='AS'>American Samoa</option>
        <option value='AZ'>Arizona</option>
        <option value='AR'>Arkansas</option>
        <option value='CA'>California</option>
        <option value='CO'>Colorado</option>
        <option value='CT'>Connecticut</option>
        <option value='DE'>Delaware</option>
        <option value='DC'>District of Columbia</option>
        <option value='FM'>Federated States of Micronesia</option>
        <option value='FL'>Florida</option>
        <option value='GA'>Georgia</option>
        <option value='GU'>Guam</option>
        <option value='HI'>Hawaii</option>
        <option value='ID'>Idaho</option>
        <option value='IL'>Illinois</option>
        <option value='IN'>Indiana</option>
        <option value='IA'>Iowa</option>
        <option value='KS'>Kansas</option>
        <option value='KY'>Kentucky</option>
        <option value='LA'>Louisiana</option>
        <option value='ME'>Maine</option>
        <option value='MH'>Marshall Islands</option>
        <option value='MD'>Maryland</option>
        <option value='MA'>Massachusetts</option>
        <option value='MI'>Michigan</option>
        <option value='MN'>Minnesota</option>
        <option value='MS'>Mississippi</option>
        <option value='MO'>Missouri</option>
        <option value='MT'>Montana</option>
        <option value='NE'>Nebraska</option>
        <option value='NV'>Nevada</option>
        <option value='NH'>New Hampshire</option>
        <option value='NJ'>New Jersey</option>
        <option value='NM'>New Mexico</option>
        <option value='NY'>New York</option>
        <option value='NC'>North Carolina</option>
        <option value='ND'>North Dakota</option>
        <option value='MP'>Northern Mariana Islands</option>
        <option value='OH'>Ohio</option>
        <option value='OK'>Oklahoma</option>
        <option value='OR'>Oregon</option>
        <option value='PW'>Palau</option>
        <option value='PA'>Pennsylvania</option>
        <option value='PR'>Puerto Rico</option>
        <option value='RI'>Rhode Island</option>
        <option value='SC'>South Carolina</option>
        <option value='SD'>South Dakota</option>
        <option value='TN'>Tennessee</option>
        <option value='TX'>Texas</option>
        <option value='UT'>Utah</option>
        <option value='VT'>Vermont</option>
        <option value='VI'>Virgin Islands</option>
        <option value='VA'>Virginia</option>
        <option value='WA'>Washington</option>
        <option value='WV'>West Virginia</option>
        <option value='WI'>Wisconsin</option>
        <option value='WY'>Wyoming</option>
      </select>";
}

function getCompatibilityList($name, &$array, $section)
{
    $a_index = 0; //array index
	
	//get the SPORTS section from compatibility
	$q = mysql_query("SELECT * FROM compatibility WHERE section='$section'");
	
	//Get the selection and assign it to array $sports
	while ($a = mysql_fetch_array($q))
	{
		$array[$a_index] = $a['selection'];
		$a_index++; //increment 
	}
}


function getGameList($name, &$array, $section)
{
    $a_index = 0; //array index
	
	//get the SPORTS section from compatibility
	$q = mysql_query("SELECT * FROM games");
	
	//Get the selection and assign it to array $sports
	while ($a = mysql_fetch_array($q))
	{
		$array[$a_index] = $a['name'];
		$a_index++; //increment 
	}
}

function getSystemsList($name, &$array, $section)
{
    $a_index = 0; //array index
	
	//get the SPORTS section from compatibility
	$q = mysql_query("SELECT * FROM systems");
	
	//Get the selection and assign it to array $sports
	while ($a = mysql_fetch_array($q))
	{
		$array[$a_index] = $a['name'];
		$a_index++; //increment 
	}
}

function getCategoriesList($name, &$array, $section)
{
    $a_index = 0; //array index
	
	//get the SPORTS section from compatibility
	$q = mysql_query("SELECT * FROM categories");
	
	//Get the selection and assign it to array $sports
	while ($a = mysql_fetch_array($q))
	{
		$array[$a_index] = $a['name'];
		$a_index++; //increment 
	}
}

function sHeight($name)
//Displays height from 3 feet up to 7 foot 11
{
     print "
    <select name='$name'>
    <option value='' selected='selected'></option>";
    $k = 0; //for index purposes
    for ($i = 3; $i < 8; $i++)
    {
        for ($j = 0; $j < 12; $j++)
        {
            $k = ($i * 12) + $j;
             print "<option value='$k'>$i' $j\"</option>";
             
        }
    }
    print "</select>";
}

function getAge ($birthday)
{
    //yyyy-mm-dd
    list($year,$month,$day) = explode("-",$birthday);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0)
      $year_diff--;
    return $year_diff;
}

function getMonth($mo)
{
        if ($mo == 1)
            $mo = "January";
        if ($mo == 2)
            $mo = "February";
        if ($mo == 3)
            $mo = "March";
        if ($mo == 4)
            $mo = "April";
        if ($mo == 5)
            $mo = "May";
        if ($mo == 6)
            $mo = "June";
        if ($mo == 7)
            $mo = "July";
        if ($mo == 8)
            $mo = "August";
        if ($mo == 9)
            $mo = "September";
        if ($mo == 10)
            $mo = "October";
        if ($mo == 11)
            $mo = "November";
        if ($mo == 12)
            $mo = "December";
            
        return $mo;
}

function getGender($gender)
{
    if ($gender == 0)
    {
        $gender = "Male";
    }
    else
    {
        $gender = "Female";
    }
    return $gender;
}




function compatibility(&$c_array)
{
    if (isset($_SESSION['id']))
    {
        //set this as 0 as it will be the index for parallel arrays.
        
        $c_index = 0;
        $userid = $_SESSION['id'];
        $q_user = mysql_query("SELECT * FROM user WHERE id='$userid'");
        $user = mysql_fetch_array($q_user);
        
        $categories = explode(", ", $user['categories']);
        $num_categories = sizeof($categories);
        
        $systems = explode(", ", $user['systems']);
        $num_systems = sizeof($systems);
        
        $mmos = explode(", ", $user['mmos']);
        $num_mmos = sizeof($mmos);
        
        $sports = explode(", ", $user['sports']);
        $num_sports = sizeof($sports);
        
        $exercise2 = explode(", ", $user['exercise2']);
        $num_exercise2 = sizeof($exercise2);
        
        $artistic = explode(", ", $user['artistic']);
        $num_artistic = sizeof($artistic);
        
        $relationship_types = explode(", ", $user['relationship_types']);
        $num_relationship_types = sizeof($relationship_types);
        
        $looking_for = $user['looking_for'];
        $gender = $user['gender'];
        
        if ($gender == 0 && $looking_for == 1)
        {
            $o_gender = 1;
            $o_lf = 0;
        }
        elseif(($gender == 1) && ($looking_for == 0))
        {
            $o_gender = 0;
            $o_lf = 1;
        }
        elseif(($gender == 1) && ($looking_for == 1))
        {
            $o_gender = 1;
            $o_lf = 1;
        }
        elseif(($gender == 0) && ($looking_for == 0))
        {
            $o_gender = 0;
            $o_lf = 0;
        }
        elseif(($gender == 0) && ($looking_for == 3))
        {
            $o_gender = "gender";
            $o_lf = 3;
        }
        elseif(($gender == 1) && ($looking_for == 3))
        {
            $o_gender = "gender";
            $o_lf = 3;
        }
        
            $user_compatibility = 0;
            
            
            
        $q_users = mysql_query("SELECT * FROM user WHERE gender='$o_gender' AND looking_for='$o_lf' ORDER BY id ASC");
        while ($o = mysql_fetch_array($q_users))
        {
            
            //get categories of requesting user and compare with own user's
            for ($i = 0; $i < $num_categories; $i++)
            {
                //Assigns the current category to $cur_category
                $cur_category = $categories[$i];
                //Now assign the requested user's categories and also get the length of the array
                $o_categories = explode(", ", $o['categories']);
                $o_num_categories = sizeof($categories);
                //Now use a while loop to compare the contents of the users array to the requested array
                for ($j = 0; $j < $o_num_categories; $j++)
                {
                    //see if the array exists in the first place
                    if (isset($o_categories[$j]))
                    {
                        //if so, assign it properly
                        $o_cur_category = $o_categories[$j];
                        if ($cur_category == $o_cur_category)
                        {
                            //if any of the categories match up, add 1 to compatibility
                            $user_compatibility++;
                        }
                    }
                    
                }
            }
            
            //now get the systems they play and compare it to people.
            for ($i = 0; $i < $num_systems; $i++)
            {
                //Assigns the current systems to $cur_systems
                $cur_systems = $systems[$i];
                //Now assign the requested user's systems and also get the length of the array
                $o_systems = explode(", ", $o['systems']);
                $o_num_systems = sizeof($systems);
                //Now use a while loop to compare the contents of the users array to the requested array
                for ($j = 0; $j < $o_num_systems; $j++)
                {
                    if (isset($o_systems[$j]))
                    {
                        //does hte array even exist?
                        $o_cur_systems = $o_systems[$j];
                        //if so, assign correctly
                        if ($cur_systems == $o_cur_systems)
                        {
                            //if any of the systems match up, add 1 to compatibility
                            $user_compatibility++;
                        }
                    }
                    
                }
            }
            
            //now get the mmos they play and compare it to people.
            for ($i = 0; $i < $num_mmos; $i++)
            {
                //Assigns the current mmos to $cur_mmos
                $cur_mmos = $mmos[$i];
                //Now assign the requested user's mmos and also get the length of the array
                $o_mmos = explode(", ", $o['mmos']);
                $o_num_mmos = sizeof($mmos);
                //Now use a while loop to compare the contents of the users array to the requested array
                for ($j = 0; $j < $o_num_mmos; $j++)
                {
                    if (isset($o_mmos[$j]))
                    {
                        $o_cur_mmos = $o_mmos[$j];
                        if ($cur_mmos == $o_cur_mmos)
                        {
                            //if any of the mmos match up, add 1 to compatibility
                            $user_compatibility++;
                        }
                    }
                }
            }
            
            //now get the sports they play and compare it to people.
            for ($i = 0; $i < $num_sports; $i++)
            {
                //Assigns the current sports to $cur_sports
                $cur_sports = $sports[$i];
                //Now assign the requested user's sports and also get the length of the array
                $o_sports = explode(", ", $o['sports']);
                $o_num_sports = sizeof($sports);
                //Now use a while loop to compare the contents of the users array to the requested array
                for ($j = 0; $j < $o_num_sports; $j++)
                {
                    if (isset($o_sports[$j]))
                    {
                        $o_cur_sports = $o_sports[$j];
                        if ($cur_sports == $o_cur_sports)
                        {
                            //if any of the sports match up, add 1 to compatibility
                            $user_compatibility++;
                        }
                    }
                }
            }
            
            
            //now get the exercise2 they play and compare it to people.
            for ($i = 0; $i < $num_exercise2; $i++)
            {
                //Assigns the current exercise2 to $cur_exercise2
                $cur_exercise2 = $exercise2[$i];
                //Now assign the requested user's exercise2 and also get the length of the array
                $o_exercise2 = explode(", ", $o['exercise2']);
                $o_num_exercise2 = sizeof($exercise2);
                //Now use a while loop to compare the contents of the users array to the requested array
                for ($j = 0; $j < $o_num_exercise2; $j++)
                {
                    if (isset($o_exercise2[$j]))
                    {
                        $o_cur_exercise2 = $o_exercise2[$j];
                        if ($cur_exercise2 == $o_cur_exercise2)
                        {
                            //if any of the exercise2 match up, add 1 to compatibility
                            $user_compatibility++;
                        }
                    }
                }
            }
            
            
            
            
            //now get the exercise2 they play and compare it to people.
            for ($i = 0; $i < $num_artistic; $i++)
            {
                //Assigns the current artistic to $cur_artistic
                $cur_artistic = $artistic[$i];
                //Now assign the requested user's artistic and also get the length of the array
                $o_artistic = explode(", ", $o['artistic']);
                $o_num_artistic = sizeof($artistic);
                //Now use a while loop to compare the contents of the users array to the requested array
                for ($j = 0; $j < $o_num_artistic; $j++)
                {
                    if (isset($o_artistic[$j]))
                    {
                        $o_cur_artistic = $o_artistic[$j];
                        if ($cur_artistic == $o_cur_artistic)
                        {
                            //if any of the artistic match up, add 1 to compatibility
                            $user_compatibility++;
                        }
                    }
                }
            }
            
            
            
            
            
            
            if (isset($o['exercise']))
            {
                if ($o['exercise'] == $user['exercise'])
                {
                    $user_compatibility++;
                } 
            }
            
            if (isset($o['ethnicity']))
            {
                if ($o['ethnicity'] == $user['ethnicity'])
                {
                    $user_compatibility++;
                } 
            }
           
           
           if (isset($o['education']))
            {
                if ($o['education'] == $user['education'])
                {
                    $user_compatibility++;
                } 
            }
            
            if (isset($o['time']))
            {
                if ($o['time'] == $user['time'])
                {
                    $user_compatibility++;
                } 
            }
        
        
            //create a parallel array to include the ID and the other includes the compatibility rating
            
            //id of the other person 
            $c_array[$c_index] = $o['id'];
            $o_rating[$c_index] = $user_compatibility;
            $c_index++;
            
        
            
            $user_compatibility = 0;
        }
        
        //Sort them now.
            for($x = 0; $x > sizeof($c_array); $x++) {
          for($y = 0; $y > sizeof($c_array); $y++) {
            if($o_rating[$x] > $o_rating[$y]) {
              $hold = $o_rating[$x];
              $hold2 = $c_array[$x];
              
              $o_rating[$x] = $o_rating[$y];
              $c_array[$x] = $c_array[$y];
              
              $o_rating[$y] = $hold;
              $c_array[$y] = $hold2;
            }
          }
        }
        
        for ($i = 0; $i < sizeof($c_array); $i++)
        {
            //get the id of the ranked user
            $r_id = $c_array[$i];
            $r_account = get_account($r_id);
            
            $img = $r_account['images'];
            $r_name = ucwords($r_account['firstname'] . " " . $r_account['lastname']);
            $r_location = ucwords($r_account['city'] . ", " . $r_account['state']);
            
            
            
            if ($r_account['images'] != '')
            {
                    $friend_image = $r_account['images'];
                    $xy = shrinkImage($friend_image, 150, 150);
                    $x = $xy[0]; $y = $xy[1];
            }
            
        }
    }
}







function sEnd()
//End the form.
{
    print "\n</form /></label>";
}

function checkForMail($id)
//Check for mail from ID (number of mails)
{
    $i = 0;
    
    $query = mysql_query("SELECT * FROM messages ORDER BY id ASC");
    while ( $messages = mysql_fetch_array($query) )
    {
        if ($messages['to'] == $id)
        $i++;
    }
    return $i;
}

function checkForFlirts($id)
//Check for flirts by ID
{
    $i = 0;
    
    $query = mysql_query("SELECT * FROM flirts ORDER BY id ASC");
    while ( $flirts = mysql_fetch_array($query) )
    {
        if ($flirts['to'] == $id)
        $i++;
    }
    return $i;

}

function checkForFriendRequests($id)
{
    $i = 0;
    
    $query = mysql_query("SELECT * FROM friendrequest ORDER BY id ASC");
    while ( $friendrequest = mysql_fetch_array($query) )
    {
        if ($friendrequest['to'] == $id)
        $i++;
    }
    return $i;
}

function shrinkImage(&$image, $xmax = 250, $ymax = 250)
{
    $info = getimagesize($image);
    //resize image to fit
    $x = $info[0];
    $y = $info[1];
    while ($x > $xmax && $y > $ymax)
    {
          $x /= 2;
          $y /= 2;
    }
    
    $xy = array($x, $y);
    return $xy;
}

function scaleImage($image, $xmax = 250, $ymax = 250)
{
    //better than shrinkImage
    
    $info = getimagesize($image); //Get the height and width
    
    //resize image to fit
    $x = $info[0];
    $y = $info[1];
    
    while ($x > $xmax && $y > $ymax)
    {
          $x /= 1.25;
          $y /= 1.25;
    }
    
    $xy = array($x, $y);
    return $xy;
}



function horizontalAd()
{
    print "<script type='text/javascript'><!--
            google_ad_client = 'pub-6319405523385665';
            /* 468x60, created 12/30/09 */
            google_ad_slot = '1294008844';
            google_ad_width = 468;
            google_ad_height = 60;
            //-->
            </script>
            <script type='text/javascript'
            src='http://pagead2.googlesyndication.com/pagead/show_ads.js'>
            </script>";
}

function verticalAd($type=1)
{
    if ($type == 1)
    {
        print"<script type='text/javascript'><!--
            google_ad_client = 'pub-6319405523385665';
            /* 120x600, created 12/30/09 */
            google_ad_slot = '5842399880';
            google_ad_width = 120;
            google_ad_height = 600;
            //-->
            </script>
            <script type='text/javascript'
            src='http://pagead2.googlesyndication.com/pagead/show_ads.js'>
            </script>";
    }
    else
    {
            print"
            <script type='text/javascript'><!--
            google_ad_client = 'pub-6319405523385665';
            /* 120x240, created 12/30/09 */
            google_ad_slot = '0772073900';
            google_ad_width = 120;
            google_ad_height = 240;
            //-->
            </script>
            <script type='text/javascript'
            src='http://pagead2.googlesyndication.com/pagead/show_ads.js'>
            </script>";
    }
}
function br($num_of_spaces="1")
//Parameter is for a specified amount of <br />'s
{
    for ($i = 1; $i <= $num_of_spaces; $i++)
    {
        print "\n<br />";
    }
}

function get_account($userid="", $username="", $email="")
//Gets the array of the account from obtaining the userid, username, or email. whichever is specified
{
    if ($userid != "")
    {
        //print "Debug Message: Used UserID to get your information.<br /><br />";
        $account_query = mysql_query("SELECT * FROM user WHERE id = '$userid'");
        $array_account = mysql_fetch_array($account_query);
    }
    elseif ($username != "")
    {
        print "Debug Message: Used Username to get your information.<br /><br />";
        $account_query = mysql_query("SELECT * FROM users WHERE name = '$username'");
        $array_account = mysql_fetch_array($account_query);
    }
    elseif ($email != "")
    {
        print "Debug Message: Used Email to get your information.<br /><br />";
        $account_query = mysql_query("SELECT * FROM users WHERE email = '$email'");
        $array_account = mysql_fetch_array($account_query);
    }
    return $array_account;
}

function get_forum_type($id)
//Get the name type of forum in the table threadtype
{
    $query = mysql_query("SELECT * FROM threadtype WHERE id=$id");
    $fetch_array = mysql_fetch_array($query);
    $name = $fetch_array['name'];
    return $name;
}

function get_highest_thread_id()
//Gets the highest thread ID so that a new post can be made with the correct thread id.
{
    $max_id = mysql_query("SELECT max(id) FROM threads");
    $r_max_id = mysql_fetch_array($max_id);
    $thread_id = $r_max_id[0];
    return $thread_id;
}

function get_last_post()
//Gets the array of the last post posted.
{
    $get_new_thread = mysql_query("SELECT * FROM posts ORDER by time DESC");
    $threads = mysql_fetch_array($get_new_thread);
    return $threads;
}

function get_thread($threadid)
{
    $query_thread = mysql_query("SELECT * FROM threads WHERE id=$threadid");
    $thread = mysql_fetch_array($query_thread);
    return $thread;
}



function fix_time($timestamp, &$time, &$date)
{
    $time_array = explode(" ", $timestamp);
    $date = $time_array[0];
    $time = $time_array[1];
    $date_array = explode("-", $date);
    $date = $date_array[1] . "/" . $date_array[2] . "/" . $date_array[0];
    
    $PM = "AM";
    
    $times = explode(":", $time);
    if ($times[0] > 13)
    {
        $hour = $times[0] - 12;
        $PM = "PM";
    }
    else
    {
        $hour = $times[0];
    }
    
    $time = "$hour:{$times[1]}:{$times[2]} $PM";
}

function view_thread($user, $title, $timestamp, $forum_type, $text, $edit, $post, $thread, $updated="")
{
    //Use author, title, timestamp, forum_type, and text
    $author = $user['name'];
    $post_count =0;
    $post_counts = mysql_query("SELECT * FROM posts WHERE userid={$user['id']}");
    
    //Gets the last post from a specific user.
    $last_post = mysql_query("SELECT * FROM posts WHERE userid={$user['id']} ORDER by time DESC");
    $last_post = mysql_fetch_array($last_post);
    fix_time($last_post['time'], $lp_time, $lp_date);
    
    while ($array_count = mysql_fetch_array($post_counts))
           {
                $post_count += 1;
           }
           
    $posts = $user['posts'];
    fix_time($timestamp, $the_time, $date);
    if (isset($updated) == 1 && $updated != "0000-00-00 00:00:00" && $updated != "")
    {
        fix_time($updated, $up_time, $up_date);
        $update_message = "Last Edited at $up_time on $up_date <br />";
    }
    else
    {
        $update_message = "";
    }
    print "
    <table id='connect_tables' width='70%' border='1'>
  <tr>
    <th width='123' rowspan='3' scope='col'><p class='username'>$author</p><br /><h5>$post_count Posts<br />Last post at $lp_time on $lp_date</h5></th>
    <th height='23' scope='col'>$title</th>
    <th colspan='2' rowspan='2' scope='col'>&nbsp;</th>
    <th scope='col'>$date</th>
  </tr>
  <tr>
    <th class='caps' width='378' height='20' scope='col'>$forum_type</th>
    <th width='237' scope='col'>$the_time";
    if (isset($edit)==1 && $edit == 1)
    {
        print "   <a href='edit_post.php?thread=$thread&post=$post'>Edit</a>";
    }
    print "
    </th>
  </tr>
  <tr>
    <td height='100' colspan='4'><p id='edit'>$update_message <h5 id='body_text'>$text</h5></p></td>
  </tr>
</table>";
}

function add_quickpost($title, $forum_type)
{
    $id = $_GET['id'];
    sForm("add_post", "view_threads.php", "id=$id&quickpost=1");
    
    print"
    <table width='70%' border='1'>
  <tr>
    <th width='123' rowspan='3' scope='col'><p class='username'>Quick Post</p></th>
    <th height='23' scope='col'>$title</th>
    <th colspan='2' rowspan='2' scope='col'>&nbsp;</th>
    <th scope='col'></th>
  </tr>
  <tr>
    <th width='378' height='20' scope='col'>$forum_type</th>
    <th width='237' scope='col'></th>
  </tr>
  <tr>
    <td height='1' colspan='4'><p>"; sTA("body", "85", "9", "", "Type Here");print "</p></td>
  </tr></td></tr id='hide'><tr><th colspan='5'><p align='right'>";
    sSubmit("post", "Quick Post");
print"</p></th></tr></table>";
sEnd();
}

function add_post($thread_id, $text, $userid)
{
    
    $text = ereg_replace("'", "\'", $text);
    mysql_query("INSERT INTO posts SET userid=$userid, threadid=$thread_id, text='$text'") or die(mysql_error());
    mysql_query("UPDATE threads SET lastpost=CURRENT_TIMESTAMP WHERE id=$thread_id");
    mysql_query("UPDATE users SET posts=posts+1 WHERE id=$userid") or die(mysql_error());
}

function get_post($postid)
{
    $post = mysql_query("SELECT * FROM posts WHERE postid=$postid");
    $post = mysql_fetch_array($post);
    return $post;
}
function edit_post($post, $thread)
{
    sForm("edit_post", "edit_post.php", "post={$post['postid']}&thread={$post['threadid']}&edit=1");
    sTA("body", "50", "6", '' , $post['text']);
    sSubmit("submit", "Edit");
    sEnd();
}

function login_screen()
{
    sForm("login", "login.php", "login=1", "Login");
    sTB("username", "", "", 28, "Username: ");
    br();
    sPW("password", 30, "", "", "Password: ");
    br();
    sSubmit("log_in", "Log In");
    br();
    sEnd();
}

function mini_login_screen()
{
    br();
    sForm("login", "login.php", "login=1", "");
    print "Login: ";
    sTB("username", "", "", 28, "Username: ");
    sPW("password", 30, "", "", "Password: ");
    sSubmit("log_in", "Log In");
    br();
    sEnd();
}

function upload_form()
{
    echo <<<END
    <form action="uploader.php" method="post"
    enctype="multipart/form-data">
    <label for="file">Filename:</label>
    <input type="file" name="file" id="file" /> 
    <br />
    <input type="submit" name="submit" value="Submit" />
    </form>
END;
}

function navigation()
{
    print "<table id='linklist'>
    <td><a href='view_threads.php'>View Threads</a></td>
    <td><a href='create_thread.php'>Create Thread</a></td>
    <td><a href='add_forum_type.php'>Add Forum Type</a></td>
    <td><a href='login.php'>Login</a></td>
    <td><a href='register.php'>Register</a></td>
    <td><a href='edit_post.php'>Edit Post</a></td>
    </table>";
}

?>
