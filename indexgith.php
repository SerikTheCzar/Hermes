
<?php

//start php code 

session_start();


function getIPAddress() {
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip = $_SERVER['HTTP_CLIENT_IP']; //this works
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //does this work
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR']; //store address into ip
	}
	return $ip;
} //get the ip address
$ip = getIPAddress();
//echo 'user real ip address is - '.$ip;
 

if(isset($_GET['logout'])){     //check if the person has logged out, if so, take them here

     

    //S

    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat</span><br></div>";

    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);

     //add that message to the log.html, 
//how to push to database?
//store as just message

    session_destroy(); //end

    header("Location:index.php"); //loop

}

 

if(isset($_POST['enter'])){ //if enter button is pressd

    if($_POST['name'] != ""){ //if the name is not empty (basically, if a user has entered ther ename into this

    $username=$_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
//    echo $username;
   // $password = $_SESSION['password'] = stripslashes(htmlspecialchars($_POST['password']));
   // echo $password;
    $dbname = 'Hermes_Global';
//connect to database - schema
    $dbuser = 'dbmasteruser';
//username -
    $dbpass = 'DaytonasStory$123';
//password
    $dbhost = 'ls-303a92f8cfd2da433af284eee07a1052317e9e14.c7xhy47efuuf.ca-central-1.rds.amazonaws.com';
//db link on aws
    

    $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");

    mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");
//handle connection
    $sql = "INSERT INTO user_test (user_name,ip_addr) VALUES(?,?)";
//insert into the usertest table, the values, ip address and username, not in that order   
 $stmt = $link->prepare($sql); //prepare for connenction
$ipstring = strval($ip); //ip address is weird data type, convert to string
    $stmt->bind_param("ss", $username,$ipstring); //push to datbae

    $stmt->execute(); //run
//    if($stmt->execute()) { //giving me errors, FIXED: because execute() runs it again, doubling each entry
//	echo "New record entered successfully";
//	}
//	else {
//	echo $stmt->error;
//	}

    mysqli_close($link); //close link

    }

    else{

        echo '<span class="error">Please type in a name</span>'; //spell error if user has not entered a name

    }

}

 

function loginForm(){

    echo //print it to the screen
//this is still part of php
    '<div id="loginform">
//take them to loginform
    <p>Please enter your a username</p>
//enter username
    <form action="index.php" method="post">

      <label for="name">Username</label>
//username form field
      <input type="text" name="name" id="name" />
//see up top
      <input type="submit" name="enter" id="enter" value="Enter" />

    </form>

   

  </div>';

}

 

?>

 
//
<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8" />

 

        <title>Hermes Chat Application</title>
//title
        <meta name="description" content="Hermes Chat Application" />

        <link rel="stylesheet" href="style.css" />

    </head>

    <body>

    <?php

    if(!isset($_SESSION['name'])){
//if they've HAVEN'T ENTERED A NAME, TAKE THEM to login form
        loginForm();

    }

    else {

    ?>

        <div id="wrapper">

            <div id="menu">
//welcom, shw the username
                <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>

                <p class="logout"><a id="exit" href="#">Exit Chat</a></p>

            </div>

 

            <div id="chatbox">
//chat box is pushed from log.html? not working: edit: working, added correct formating
            <?php

            if(file_exists("log.html") && filesize("log.html") > 0){

                $contents = file_get_contents("log.html");

                echo $contents;
//get the contents from the log.html file, push it to the screen to display messages
            }

            ?>

            </div>

 

            <form name="message" action="">

                <input name="usermsg" type="text" id="usermsg" />
//user messages
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
//submit
            </form>

        </div>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script type="text/javascript">

            // jQuery Document
//submitting to the form
            $(document).ready(function () {

                $("#submitmsg").click(function () {
	//button
                    var clientmsg = $("#usermsg").val();

		 //   console.log(clientmsg);
                    $.post("post.php", { text: clientmsg });
//call the post.php function, which sends message both to the html document and the database
                    $("#usermsg").val("");
		   
                    return false; //exit

                });

 

                function loadLog() {

                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request

 //autoscroll height

                    $.ajax({

                        url: "log.html",

                        cache: false,

                        success: function (html) {

                            $("#chatbox").html(html); //push message to html filev

 //ajax function, 

                            //Auto-scroll           

                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
//yeah this works
                            if(newscrollHeight > oldscrollHeight){

                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div

                            }   

                        }

                    });

                }

 

                setInterval (loadLog, 2500);

 

                $("#exit").click(function () {

                    var exit = confirm("Are you sure you want to end the session?");
//javascript popup
                    if (exit == true) {
//take them to logout 
                    window.location = "index.php?logout=true";
//logout form
                    }

                });

            });

        </script>

    </body>

</html>

<?php

}

?>

