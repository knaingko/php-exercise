<?php

	function csv_to_array($filename = "", $delimiter = ",")
	{
		if(!file_exists($filename)  || !is_readable($filename))
			return FALSE;

		$header = NULL;
		$data = array();
		if(($handle = fopen($filename, 'r')) !== FALSE)
		{
			while(($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				if(!$header)
					$header = $row;
				else
					$data[] = array_combine($header, $row);
			}
			fclose($handle);
		}
		return $data;
	}

	/*echo '<pre>';
		
		print_r($result);
	echo '</pre>';*/
	$result = csv_to_array('./data/test.csv');
	echo '<table border="1">';
	echo '<tr><th>id</th><th>name</th><th>email</th><th>phone</th><th>Message</th><th>Gender</th></tr>';

	foreach($result as $row){

	echo '<tr>';
	echo ('<td>' . $row['id'] . '</td>');
	echo ('<td>' . $row['name'] . '</td>');
	echo ('<td>' . $row['email'] . '</td>');
	echo ('<td>' . $row['phone'] . '</td>');
	echo ('<td>' . $row['message'] . '</td>');
	echo ('<td>' . $row['gender'] . '</td>');
	echo '</tr>';

	}
	echo '</table>';

	/*echo '<pre>';
		$result = csv_to_array('test.csv');
		
		print_r (each($result));
	echo '</pre>';*/

?>

