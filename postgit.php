<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    $dbname = 'Hermes_Global';

    $dbuser = 'dbmasteruser';

    $dbpass = 'DaytonasStory$123';

    $dbhost = 'ls-303a92f8cfd2da433af284eee07a1052317e9e14.c7xhy47efuuf.ca-central-1.rds.amazonaws.com';

    
   
    $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
//    echo '<script>console.log($text);</script>';
    $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
  //  echo '<script>console.log($text_message);</script>';
    file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
    $MESSAGECONTENT = stripslashes(htmlspecialchars($text));
    $from = $_SESSION['name'];
    date_default_timezone_set("America/New_York");
    $time = date('Y-m-d H:i:s');
    mysqli_select_db($link, $dbname) or die("could not open the db");
    $sql = "INSERT INTO Message_test(message_content, message_sender, time_sent) VALUES (?,?,?)";
    $stmt = $link->prepare($sql);

    $stmt->bind_param('sss', $MESSAGECONTENT, $from, $time);
    $stmt->execute();


}
?>
