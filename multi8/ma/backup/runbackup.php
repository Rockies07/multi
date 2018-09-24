<?php
// Create the mysql backup file
// edit this section
/*$dbhost = "localhost"; // usually localhost
$dbuser = "henrynew_daccoun";
$dbpass = "4rfv5tgb";
$dbname = "henrynew_mymerz";
$sendto = "Webmaster <asher.anng@yahoo.com>";
$sendfrom = "Automated Backup <asher.anng@yahoo.com>";
$sendsubject = "Daily Mysql Backup";
$bodyofemail = "Here is the daily backup.";*/
$dbhost = "localhost"; // usually localhost
$dbuser = "4d";
$dbpass = "goodluck199";
$dbname = "billbase";
$sendto = "Webmaster <amasangque26@gmail.com>";
$sendfrom = "Automated Backup <webmasterandro@yahoo.com>";
$sendsubject = "Daily Mysql Backup";
$bodyofemail = "Here is the daily backup.";

// don't need to edit below this section
$backupfile = $dbname . date("Y-m-d") . '.sql';
$backupzip = $backupfile . '.tar.gz';
system("mysqldump -h $dbhost -u $dbuser -p$dbpass $dbname > $backupfile");
system("tar -czvf $backupzip $backupfile");

// Mail the file

  /*  include('Mail.php');
    include('Mail/mime.php');

	$message = new Mail_mime();
	$text = "$bodyofemail";
	$message->setTXTBody($text);
	$message->AddAttachment($backupzip);
    	$body = $message->get();
        $extraheaders = array("From"=>"$sendfrom", "Subject"=>"$sendsubject");
        $headers = $message->headers($extraheaders);
    $mail = Mail::factory("mail");
    $mail->send("$sendto", $headers, $body);*/
	

$to = 'amasangque26@gmail.com'; 
//define the subject of the email 
$subject = 'Daily Mysql Backup'; 
//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash 
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n 
$headers = "From: webmaster@example.com\r\nReply-To: webmaster@example.com"; 
//add boundary string and mime type specification 
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
$attachment = chunk_split(base64_encode(file_get_contents('$backupzip'))); 
//define the body of the message. 
ob_start(); //Turn on output buffering 
?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Hello World!!! 
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h2>Hello World!</h2> 
<p>This is something with <b>HTML</b> formatting.</p> 

--PHP-alt-<?php echo $random_hash; ?>-- 

--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: application/zip; name="$backupzip"  
Content-Transfer-Encoding: base64  
Content-Disposition: attachment  

<?php echo $attachment; ?> 
--PHP-mixed-<?php echo $random_hash; ?>-- 

<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 
//send the email 
$mail_sent = @mail( $to, $subject, $message, $headers ); 
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed"; 

// Delete the file from your server
unlink($backupfile);
?>
