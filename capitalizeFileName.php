<?php
	$file=scandir('GradPhoto');
	//echo JSON_encode($file);
	for($t = 0; $t < count($file); $t ++){
		$old = $file[$t];
		$name = strtoupper(basename($old, '.jpg')) . '.jpg';
		rename('GradPhoto/' . $old, 'GradPhoto/' . $name);
		echo $old . ' ==> ' . $name . '<br>';
	}
	//rename("images","pictures");
?>