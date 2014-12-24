<?php
/* Mailer with Attachments */

$action = $_REQUEST['action'];
global $action;

function showForm() {
?>

  <form enctype="multipart/form-data" name="send" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table>
<tr>
<td>
  <input type="hidden" name="action" value="send" /> </td>
<td>
  <input type="hidden" name="MAX_FILE_SIZE" value="10000000" /></td>
</tr>
<tr>
    <td>Recipient Email: </td><td><input name="to_email" size="50" /></td>
   </tr><tr><td> From Name:  </td><td><input name="from_name" size="50" /></td></tr>
<tr><td>
    From Email:</td><td>  <input name="from_email" size="50" /></td></tr>
<tr><td>
    Subject:</td><td>  <input name="subject" size="50" /></td></tr><tr>
    <td>Message: </td><td><textarea name="body" rows="10" cols="50"></textarea></td></tr>
    <tr><td>Attachment: </td><td><input type="file" name="attachment" size="50" /></td></tr>
<tr><td>
    <input type="submit" value="Send Email" /></td></td>&nbsp;</td</tr>
</table>
  
<?php
}

function sendMail() {
  if (!isset ($_POST['to_email'])) { //Oops, forgot your email addy!
    die ("<p>Oops!  You forgot to fill out the email address! Click on the back arrow to go back</p>");
  }
  else {
    $to_name = stripslashes($_POST['to_name']);
    $from_name = stripslashes($_POST['from_name']);
    $subject = stripslashes($_POST['subject']);
    $body = stripslashes($_POST['body']);
    $to_email = $_POST['to_email'];
    $attachment = $_FILES['attachment']['tmp_name'];
    $attachment_name = $_FILES['attachment']['name']; 
    $attachment_type = $_FILES['attachment']['type'];
    $attachment_size = $_FILES['attachment']['size'];
    if (is_uploaded_file($attachment)) { //Do we have a file uploaded?
      $fp = fopen($attachment, "rb"); //Open it
      $data = fread($fp, filesize($attachment)); //Read it
      $data = chunk_split(base64_encode($data)); //Chunk it up and encode it as base64 so it can emailed
        fclose($fp);
    }
	$num = md5(time());
    //Let's start our headers
    $headers = "From: $from_name<" . $_POST['from_email'] . ">\n";
    $headers .= "Reply-To: <" . $_POST['from_email'] . ">\n"; 
    $headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; ";
$headers .= "boundary=".$num."\r\n";
$headers .= "--$num\r\n";
// This two steps to help avoid spam 
// $headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">\r\n";
//$headers .= "X-Mailer: PHP v".phpversion()."\r\n"; 

// With message
$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "".$body."\n";
$headers .= "--".$num."\n"; 
// Attachment headers
$headers .= "Content-Type:".$attachment_type." ";
$headers .= "name=\"". $attachment_name."\"r\n";
$headers .= "Content-Transfer-Encoding: base64\r\n";
$headers .= "Content-Disposition: attachment; ";
$headers .= "filename=\"". $attachment_name."\"\r\n\n";
$headers .= "".$data."\r\n";
$headers .= "--".$num."--";
if(empty($attachment_type)){
$message= ''."$body".'';
 $headers = "From: $from_name<" . $_POST['from_email'] . ">\n";
    $headers .= "Reply-To: <" . $_POST['from_email'] . ">\n"; 
    $headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
}
    // send the message
    mail("$to_name<$to_email>", $subject, $message, $headers); 
    print "Mail sent.  Thank you for using the Spoofmail Mailer.";
  }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
<title>Spoof Mail</title>
<body bgcolor="gray">
    <http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <style="css" type="text/css">
      <!--
      body {
        margin: 0px;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
      }
      a {color: #0000ff}
      -->
    </style>
  </head>
  <body>

<?php
switch ($action) {
  case "send":
    sendMail();
    showForm();
    break;
  default:
    showForm();
}
?>

  </body>
</html>
