<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Number_formatter {

    public function set_number($value)
    {
    	if($value>0)
    	{
    		echo "<font color='blue'>".number_format($value,2)."</font>";
    	}
    	else
    	{
    		echo "<font color='red'>".number_format($value,2)."</font>";
    	}
    }
}

/* End of file Number_format.php */