<?php //echo phpinfo(); 

/*if ( function_exists( 'mail' ) )
{
    echo 'mail() is available';
}
else
{
    echo 'mail() has been disabled';
}  */

error_reporting(E_ALL);

mail("a_masangque26@yahoo.com","Subject","Content");
if (mail)
{
   echo "mail sent...";
}
else
{
   echo "unable to send mail";
}


?>