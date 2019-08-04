<?php
function get_var_expload_USER($FNic)
		{
			$Options = explode("_===++||||++===_",@file_get_contents ($FNic));
		if (count($Options)>=3)
		{
			$Options = array('parol'=>$Options{0},'mail'=>$Options{1},'pol'=>$Options{2},'Age'=>$Options{3});
			return $Options;
		}
		 return False;
		}
?>