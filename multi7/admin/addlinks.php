<?php
session_start();
	
$weblogin=$_SESSION["weblogin"];
$webpassword=$_SESSION["webpassword"];	

include "include/include.php";

$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
$rights=mysql_num_rows($login);
if(!$rights){header("location:index.php");}



//-=-=- file upload

$uploaddir = '/home/www/q1/member/logo/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$filename = basename($_FILES['userfile']['name']);
//echo "<p>";

move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)
/*if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
 {
  echo "File is valid, and was successfully uploaded.\n";
} else {
   echo "Upload failed";
}*/

/*echo "</p>";
echo '<pre>';
echo 'Here is some more debugging info:';
print_r($_FILES);
print "</pre>";*/
?>
<html>
<link rel="stylesheet" href="style.css" type="text/css" />
<link href="upload/ajaxfileupload.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="upload/jquery.js"></script>
	<script type="text/javascript" src="upload/ajaxfileupload.js"></script>
	<script type="text/javascript">
	function ajaxFileUpload()
	{
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'upload/doajaxfileupload.php',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							alert(data.msg);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	}
	</script>	
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr><td align="center" colspan="3"><span class="maintitle">Link Management</span></td></tr>
	<tr><td align="left"><a href='addlinks.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td></tr>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center" class="stats">
	<tr ><td class="hed"><span class="bn13text"><b>#</b></span></td>
	<td class="hed"><span class="bn13text"><b>Site Name</b></span></td>
	<td class="hed"><span class="bn13text"><b>Title1</b></span></td>
	<td class="hed"><span class="bn13text"><b>Link1</b></span></td>
		<td class="hed"><span class="bn13text"><b>Title2</b></span></td>
	<td class="hed"><span class="bn13text"><b>Link2</b></span></td>
	<td class="hed"><span class="bn13text"><b>Image</b></span></td><td class="hed"><span class="bn13text"><b>Action</b></span></td></tr>
<?php
		$action=$_GET[action];
		$sitename=$_POST[sitename];
		$linkname1=$_POST[linkname1];
		$linkadd1=$_POST[linkadd1];
		$linkname2=$_POST[linkname2];
		$linkadd2=$_POST[linkadd2];
		$fileToUpload=$_POST[fileToUpload];
		$webdatetime=date("Y-m-d H:i:s");
		$id=$_GET[id];
/*		echo $action . "<br>";
		echo $linkname . "<br>";
		echo $linkadd . "<br>";
		echo $image . "<br>";
		echo $webdatetime . "<br>";*/
		
		switch($action){
		case "added":
		{
		mysql_query("INSERT INTO linklist (ref, sitename, linkname1, linkadd1, linkname2, linkadd2, image, entriesdate) VALUES('', '$sitename ', '$linkname1', '$linkadd1', '$linkname2', '$linkadd2', '$filename', '$webdatetime')") or die(mysql_error());
		echo "<SCRIPT language=\"JavaScript\">alert('Link Added!');</SCRIPT>";
		break;
		}
		case "delete":
		mysql_query("DELETE FROM linklist WHERE ref = '$id'");
		echo "<SCRIPT language=\"JavaScript\">alert('Link Deleted!');</SCRIPT>";
		break;
		case "update":
		if ($filename<>"")
		mysql_query("UPDATE linklist SET sitename='$sitename', linkname1='$linkname1', linkadd1='$linkadd1', linkname2='$linkname2', linkadd2='$linkadd2', image='$filename', entriesdate='$webdatetime' WHERE ref='$id'");
		else
		mysql_query("UPDATE linklist SET sitename='$sitename', linkname1='$linkname1', linkadd1='$linkadd1', linkname2='$linkname2', linkadd2='$linkadd2', entriesdate='$webdatetime' WHERE ref='$id'");
		
		echo "<SCRIPT language=\"JavaScript\">alert('Link Updated!');</SCRIPT>";
		break;
		}


		$linksql=mysql_query("SELECT * FROM linklist ORDER BY ref ASC");
		$linkrow=mysql_num_rows($linksql);
		for($count=0; $count<$linkrow; $count++)
		{
		$ref=mysql_result($linksql,$count,"ref");
		if(($action=='edit')&&($id==$ref)){echo"<form action='addlinks.php?action=update&id=$ref' method='post' style='margin-bottom:0;' enctype='multipart/form-data'>";}
		if($count%2)
					{echo"<tr bgcolor='#dddddd'>";}
				else
					{echo"<tr>";}
		$serial++;
		echo "<td align='center'><span class='bn12text'>$ref</span></td>";
		$sitename=mysql_result($linksql,$count,"sitename");
		if(($action=='edit')&&($id==$ref)){echo "<td align='center'><input type='text' name='sitename' size='8' maxlength='10' value='$sitename'></td>";}
		else{echo "<td align='center'><span class='bn12text'>$sitename</span></td>";}
		$linkname1=mysql_result($linksql,$count,"linkname1");
		$linkadd1=mysql_result($linksql,$count,"linkadd1");
		$linkname2=mysql_result($linksql,$count,"linkname2");
		$linkadd2=mysql_result($linksql,$count,"linkadd2");
		
		if(($action=='edit')&&($id==$ref)){echo "<td align='center'><input type='text' name='linkname1' size='20' maxlength='30' value='$linkname1'></td>";}
		else{echo "<td align='center'><span class='bn12text'><b>$linkname1</b></span></td>";}
		if(($action=='edit')&&($id==$ref)){echo "<td align='center'><input type='text' name='linkadd1' size='20' maxlength='30' value='$linkadd1'></td>";}
		else{echo "<td align='center'><span class='bn12text'><b>$linkadd1</b></span></td>";}
		if(($action=='edit')&&($id==$ref)){echo "<td align='center'><input type='text' name='linkname2' size='20' maxlength='30' value='$linkname2'></td>";}
		else{echo "<td align='center'><span class='bn12text'><b>$linkname2</b></span></td>";}
		if(($action=='edit')&&($id==$ref)){echo "<td align='center'><input type='text' name='linkadd2' size='20' maxlength='30' value='$linkadd2'></td>";}
		else{echo "<td align='center'><span class='bn12text'><b>$linkadd2</b></span></td>";}
		
//		$linkadd=mysql_result($linksql,$count,"linkadd");
//		if(($action=='edit')&&($id==$ref)){echo "<td align='center'><input type='text' name='linkadd' size='20' maxlength='30' value='$linkadd'></td>";}
//		else{echo "<td align='center'><span class='bn12text'><b>$linkadd</b></span></td>";}
		
		
		$image=mysql_result($linksql,$count,"image");
		if(($action=='edit')&&($id==$ref)){echo "<td align='center'>
		<input type='hidden' name='MAX_FILE_SIZE' value='512000' />
   <input name='userfile' type='file' /></td>";}
		else{
		if ($image<>"")
		echo "<td align='center'><span class='bn12text'><img src='../member/logo/$image' /> </span></td>";
		else
		echo "<td align='center'><span class='bn12text'><img src='../member/logo/no-photo.jpg' /> </span></td>";
		}		
		
if(($action=='edit')&&($id==$ref)){echo "<td align='center'><a href='addlinks.php' target='_self'><img src='images/undo.gif' border='0' title='Undo'></a>&nbsp;&nbsp;<input type='image' src='images/save.gif' title='Save'></td>";}
else{echo "<td align='center'><a href='addlinks.php?action=edit&id=$ref' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a>&nbsp;&nbsp;<a href='addlinks.php?action=delete&id=$ref' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></td>";}
		
		echo "</tr>";
		if(($action=='edit')&&($id==$ref)){echo"</form>";}
		}
?>

<?php
if($action=='add'){echo "<form action='addlinks.php?action=added' method='post' enctype='multipart/form-data'><tr><td align='center'><span class='bn13text'>#</span></td><td align='center'><input type='text' name='sitename' size='10' maxlength='15' value='' /></td><td align='center'><span class='bn13text'><input type='text' name='linkname1' size='20' maxlength='30'/></span></td><td align='center'><span class='bn13text'><input type='text' name='linkadd1' size='20' maxlength='30'/></span></td>
<td align='center'><span class='bn13text'><input type='text' name='linkname2' size='20' maxlength='30'/></span></td><td align='center'><span class='bn13text'><input type='text' name='linkadd2' size='20' maxlength='30'/></span></td>
<td align='center'><span class='bn13text'>
    <input type='hidden' name='MAX_FILE_SIZE' value='512000' />
   <input name='userfile' type='file' />
   
</span></td>
<td align='center'><a href='addlinks.php' target='_self'><img src='images/cancel.gif' border='0' title='Cancel'></a>&nbsp;&nbsp;<input type='image' src='images/save.gif' title='Save'></td></tr>";}

?>
</form>
</table>
</body>
</html>