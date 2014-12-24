<html>
<head><title>Email spoofer by MyNameIs940 (Riskers original source)</title>
<body bgcolor="black">
<style type="text/css">
body,td,th {
    color: #00CC00;
}
</style>
<div align=center>
<?php if (!isset($_GET['action'])) { ?>
<form action="?action=send" method="post">
Victims Email:<input type="text" name="email" /></br>
Subject:<input type="text" name="subject" /></br>
Who Its From (Name): <input type="text" name="name" /><br />
Who Is it from (email): <input type="text" name="from" /></br>
Message:<textarea name="message" style="width:300px;height:200px"></textarea><input type="submit" />
</form>
<?php } elseif (isset($_GET['action']) && $_GET['action'] == 'send') { 

$to = $_POST["email"];
$name = $_POST["name"];
$subject = $_POST["subject"];
$message = $_POST["message"];
$from = $_POST["from"];
$headers = "From: $name <$from>";
 // mail($to,$subject,$message,$headers);
$mail_sent = @mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed";
  echo "Sent Emails To $to<br />";
}
?>
</div>
</body>
</html>