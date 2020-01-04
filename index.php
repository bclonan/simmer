<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>SimmerMe Carousel</title>
    <link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" />
    <link rel="stylesheet" media="screen" type="text/css" href="css/spacegallery.css" />
    <link rel="stylesheet" media="screen" type="text/css" href="css/custom.css" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/eye.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>
    <script type="text/javascript" src="js/spacegallery.js"></script>
    <script type="text/javascript" src="js/layout.js"></script>
</head>





<body>
    

    
    <div class="wrapper">
       
        <ul class="navigationTabs">
            <li><a href="#about" rel="about"></a></li>
            
        </ul>
        
               
	    <div id="myGallery" class="spacegallery">
		
	    
		<?php
		    include_once "sql_connect.php";
		    include_once "functions.php";
		    if (isset($_GET['id']))
		    {
			$userid=$_GET['id'];
		    }
		    elseif(isset($_SESSION['id']))
		    {
			$userid = $_SESSION['id'];
			$pageid = $_SESSION['id'];
		    }
		    else
		    {
			die("PLEASE ENTER SOMEONES ID");
		    }
		    
		    
		    
		    
		    $q = mysql_query("SELECT * FROM photos");
		    while ($photos = mysql_fetch_array($q))
		    {
			$photoURL = $photos['photo'];
			
			//Resize the image in case it is humongous
			$imageSpecs = scaleImage($photoURL, 100, 100);
			
			$x = $imageSpecs[0];
			$y = $imageSpecs[1];
			
			print "X: $x, Y: $y";
			////Carry on.
			
			if ($photos['userid'] == $userid)
			{
			    print "<img src='$photoURL' width='100' height='100' alt=''>";
			}
			
		    }
		?>
	    </div>
            
    </div>
    <?php
    
    //Must reorganize inside the DIV because its not working right when we put it in the div.
    //Fix the text colors inside the CSS as well because it fails.
    
    //Check if they asked a question, if so, add to database
    if (isset($_POST['question']))
    {
	$question = $_POST['question'];
	if (!isset($_SESSION['id']))
	{
	    $sentfrom = -1;
	}
	else
	{
	    $sentfrom = $_SESSION['id'];
	}
	
	if (isset($_POST['anonymous']))
	{
	    $sentfrom = -1;
	}
	
	if (!isset($_GET['id']))
	{
	    die();
	}
	else
	{
	    $sentto = $_GET['id'];
	}
	
	if ($_GET['id'] == $_SESSION['id'])
	{
	    die();
	}
	print "<font color='red'>" . $_POST['question'];
	mysql_query("INSERT INTO questions (sentfrom, sentto, question) VALUES('$sentfrom', '$sentto', '$question')") or die("ERROR");
    }
    
    
    ///If the user decides to answer a question!!!
    if (isset($_POST['answer']))
    {
	$answer = $_POST['answer'];
	
	
	
	//If they are hacking or some shit just kill the script so they dont fuck this up.
	if (!isset($_GET['answer']))
	{
	    die("<font color='red'>Failed at answer");
	}
	
	if (!isset($_GET['id']))
	{
	    die("<font color='red'>Failed at ID");
	}
	//Yes.
	
	//This whole thing below is to see if they are answering their own question.
	$question_id = $_GET['answer'];
	
	$userid = $_SESSION['id'];
	
	$q = mysql_query("SELECT * FROM questions WHERE id='$question_id'") or die("Failed at query");
	
	while ($question = mysql_fetch_array($q))
	{
	    $my_id = $question['sentto'];
	}
	
	
	//
	if ($userid != $my_id)
	{
	    die("<font color='red'>Failed @ id");
	}
	//End here.
	
	
	$update = false;
	
	
	
	$q_check_answer = mysql_query("SELECT * FROM answers WHERE answerid='$question_id'") or die("<font color='red'>Failed at check answer");
	$answers = mysql_fetch_array($q_check_answer);
	
	
	$number = $answers[0];
	
	if (!isset($_POST['ignore']))
	{
	    if (isset($number))
	    {
		
		mysql_query("UPDATE answers SET answer='$answer' WHERE answerid='$question_id'") or die("<font color='red'>Failed at update answer");
	    }
	    else
	    {
		print "<font color='pink'>$answer, $question_id</font>";
		mysql_query("INSERT INTO `question`.`answers` (`id`, `answer`, `answerid`) VALUES (NULL, '$answer', '$question_id')") or die("<font color='red'>Failed at insert answer");
	    }
	}
	else
	{
	    mysql_query("DELETE FROM questions WHERE id='$question_id'");
	    mysql_query("DELETE FROM answers WHERE answerid='$question_id'");
	}
	
	
	
	
	//ENTER TO DB
	while ($question = mysql_fetch_array($q_check_answer))
	{
	    print "<font color='red'>LOOP<br></font>";
	    if (!isset($question))
	    {
		
		$update = false;
		break;
	    }
	    else
	    {
		$update = true;
	    }
	    
	}
	
	
	
	
    }
    //End answer question
    
    
    if (!isset($_GET['id']))
    {
	$id = -1;
    }
    else
    {
	$id = $_GET['id'];
    }
    //Display Questionaire
    if (($_SESSION['id'] != $id && $_SESSION['id'] != $id) || !isset($_SESSION['id']) )
    {
	$an[0] = "";
	
	sForm("ask", "index.php?id=$id&");
	print "<table><tr><td>";
	sTA("question", "50", "6", "", "Ask a question!"); print "</td><td></td></tr>
	<tr><td><font color='red'>Anonymous</font>:"; sCB("anonymous",$an);  print "</td><td align='right'>"; sSubmit("submit", "Submit");print "</table>";
    }
    
    if (($_SESSION['id'] == $id) || !isset($_GET['id']))
    {
	$i = 0;
	$userid = $_SESSION['id'];
	$q = mysql_query("SELECT * FROM questions");
	while ($questions = mysql_fetch_array($q))
	{
	    if ($questions['sentto'] == $userid)
	    {
		$question = $questions['question']; //Gets the question text
		$q_id = $questions['id']; //Gets the ID from the question so we can answer it.
		$from = $questions['sentfrom']; //Gets who its' from.
		
		$i++;
		
		if ($from == -1)
		{
		    $name = "Anonymous";
		}
		else
		{
		    $qb = mysql_query("SELECT * FROM registration WHERE id='$from'");
		    while($users = mysql_fetch_array($qb))
		    {
			$name = $users['username'];
		    }
		}
		
		$ignore_question[0] = "Ignore";
		
		print "<font color='red'>$question FROM $name</font><br/>";
		
		
		//Display the answer if the person answered already to self.
		$ans_check = mysql_query("SELECT * FROM answers WHERE answerid='$q_id'");
		$ans_check = mysql_fetch_array($ans_check);
		
		if (isset($ans_check[0]))
		{
		    $answer = $ans_check['answer'];
		    print "<br /><font color='blue'>$answer</font><br />";
		}
		
		
		
		
		
		
		
		sForm("answer$i", "index.php?id=$userid&answer=$q_id&");
		sTA("answer", "50", "4", "", "Answer the question");
		br();
		
		print "<table align='center'><tr><td>";
		sSubmit("submit", "Submit");
		print "</td><td width='150'>";
		
		sCB("ignore", $ignore_question);
		print" <font color='red'>Ignore Question</font></td></tr></table>";
		
		br();
		print "<hr>";
		sEnd();
	    }
	}
    }
    elseif(isset($_GET['id']))
    {
	//get the id from the user
	$getid = $_GET['id'];
	$q_user = mysql_query("SELECT * FROM questions WHERE sentto='$getid'");
	$numrows = mysql_num_rows($q_user);
	
	//Check if this person has questions asked to him
	if ($numrows != 0)
	{
	    while ($questions = mysql_fetch_array($q_user))
	    {
		//Grab the question id then proceed to check if there is an answer.
		$q_id = $questions['id'];
		
		//Proceed to check now.
		$q_answer = mysql_query("SELECT * FROM answers WHERE answerid='$q_id'");
		$exist = mysql_num_rows($q_answer);
		if ($exist > 0)
		{
		    //Get teh text of the question.
		    $the_question = $questions['question'];
		    //fetch the answer
		    $answer = mysql_fetch_array($q_answer);
		    $the_answer = $answer['answer'];
		    
		    print "<font color='black'><br />
		    $the_question<br />
		    $the_answer<br /></font>";
		}
		
	    }
	}
    }
    
    
    ?>
</body>
</html>