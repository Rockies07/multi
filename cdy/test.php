<?PHP
	$data[2] = 1234;
	$data[0] = 3;

$x = 0;
switch($data[0])
{
	case 1:
	case 2:
	case 3:
	case 6:
	case 7: break;
	default: $x = 1;
}

if (strlen($data[2]) != 4 || $x == 1)
{
echo "not listed";
}
echo "bling";
?>
