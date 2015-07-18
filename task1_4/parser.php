<?php
	
	$error = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];
	$userFile = ($_FILES['file']['name']);
	$tmpFile = $_FILES['file']['tmp_name'];
	if ($error > 0) {
	    switch ($error)
	        {
	          case 1:  
	              echo 'The uploaded file exceeds the upload_max_filesize directive in php.ini'; 
	              break;
	          case 2:
	              echo 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
	              break;
	          case 3: 
	              echo 'The uploaded file was only partially uploaded'; 
	              break;
	          case 4: 
	              echo 'No file uploaded. try again';
				  break;
			  case 7: 
	              echo 'Failed to write file to disk. ';
				  break;
	        }
	    exit;
	}
	
	if ($fileType != 'text/plain')
	  {
	    echo 'Error: file is not a plain text';
	    exit;
	  }    
	
	 $upfile = __DIR__."\\upload\\".$userFile;
	
	  if (is_uploaded_file($tmpFile)) 
	  {
	     if (!move_uploaded_file($tmpFile, $upfile))
	     {
	        echo 'File uploaded, but could not move to destination directory';
	        exit;
	     }
	  } 
	  
	  //call user function
	  $str = fileToString($upfile);
	  $arr = stringToArray($str);
	  usort($arr, "sortBySourceField");
	  echo "<table border=1>";
	  foreach ($arr as $key=>$value)
	  {
		  
		  foreach ($value as $key2=>$value2)
		  {
			 
			  echo "<tr><td>$key2</td>";
			  echo "<td>$value2</td>";
			 
		  }
	  }
	  echo "</table>";  
	
          //define user's functions
          
          function fileToString($filePatch)
	{
	    $handle = fopen($filePatch,'r');
	    if (!$handle)
	    {
	        echo "Error. Can't read file";
	    }
	    $contents="";
	    $contents = fread($handle,  filesize($filePatch));
	    fclose($handle);
	    return $contents;
	        
	}

	
	function stringToArray($content)
	{
	  
	     while (strpos($content,"  ")!==false )
	        {
	          $content = str_replace("  "," ",$content);
	        } 
	        
	        $array = explode("\r\n", trim($content));
	     
	    $i=0;
	     foreach ($array as $key => $value) {
	        $i++;
	         $arString = explode(" ", trim($value));
	         $resultArray[$i]["source"] = $arString[0];
	         $resultArray[$i]["dest"] = $arString[1];
	     }
	        return $resultArray;
	}
	
	
        function sortBySourceField($a, $b) 
{ 
	return strcasecmp($a['source'], $b['source']); 
}
