<?php

$error = isset($_FILES['file']['error'])? $_FILES['file']['error'] : 4;
$fileType = isset($_FILES['file']['type']) ? $_FILES['file']['type']: "";
$userFile = isset($_FILES['file']['name']) ? $_FILES['file']['name']: "";
$tmpFile = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : "";
if ($error > 0) {
    switch ($error)
        {
          case 1:  
              echo 'File exceeded upload_max_filesize'; 
              break;
          case 2:
              echo 'File exceeded max_file_size';
              break;
          case 3: 
              echo 'File only partially uploaded'; 
              break;
          case 4: 
              echo 'No file uploaded. try again';
              break;
        }
    exit;
}

//call user function

//get array from csv
$array = importCsv($tmpFile);

//create files from array
ArrayCsvToFile($array);

//ArrayCsvToFile(importCsv("Z:\\home\\source-it.me\\www\\task5\\products.csv"));
//$newArray = readProductsFromCatalog(1, 2);
//sortByPrice($newArray, 1);
//
//echo "<pre>";
//print_r($newArray);
//echo "</pre>";

/*
 * function importCsv($fileCsv) does upload csv file 
 * @param string $fileCsv patch to file csv
 * @return array $arrayCsv[][]    field => values
 */
function importCsv($fileCsv){
    
    $contents = file($fileCsv);
    if ($contents === FALSE)  {
        print "cann't read from file";
        exit;
    }
    
    $i=0;//iterator for array $arrayCsv
    foreach ($contents as $key=>$value) {
           
        //create  array with name of fields (first string)
        if ($key == 0) {
            $fieldCsv = explode(';', trim($value));    
        }
         //create  array $arrayCsv[][] with data from csv
        
        else{
           
           $arrayStringsCsv = explode(";", trim($value));
           for ($a=0;$a<=count($fieldCsv)-1;$a++){
               //get single string from csv file with format field=>value
               $arrayCsv[$i]["$fieldCsv[$a]"]=$arrayStringsCsv[$a];
           }
           $i++;
        }
        
    }
    return $arrayCsv;
 }
 
/*
 * function ArrayCsvToFile($array) give array and create files in folder /products/enabled and /products/disabled
 * @param array $array with csv data
 * @return files in folder /products/enabled and /products/disabled
 */
 
 function ArrayCsvToFile($array){
    
    foreach ($array as $value) {
        $string="";
        $skuForUrl="";
        $colorIdForUrl="";
        $isEnabled="";
        foreach ($value as $key => $value2) {
            $key = strtolower($key);
            $key = str_replace(" ", "_", $key);
            if ($key == "price") {
                $value2=  str_replace(",", ".", $value2);
            }
            if ($key == "special_price") {
                $value2=  str_replace(",", ".", $value2);
            }
            if ($key == "sku") {
                $skuForUrl= str_replace(" ", "-", $value2);  
            }
            if ($key == "color_id") {
                $colorIdForUrl=  $value2;                
            } 
            if ($key == "is_enabled?") {
                $isEnabled=  $value2;                
            }
            $string.= $key.":".$value2."\r\n";
        }
        $string.="image_url:"."http://cdn.richandroyal.de/media/external/D/".$skuForUrl."_"."$colorIdForUrl"."_1_455.jpg";
       if ($isEnabled == "yes") {
           if (file_put_contents(__DIR__."\\products\\enabled\\".$skuForUrl.".txt", $string)!==0){
               echo "file $skuForUrl.txt created <br>"; 
           }
           else {
               echo "<b>file $skuForUrl.txt not created</b><br>";
           }
        }
        else {
           if (file_put_contents(__DIR__."\\products\\disabled\\".$skuForUrl.".txt", $string)!==0 ) {
               echo "file $skuForUrl.txt created<br>";
           }
           else {
               echo "<b>file $skuForUrl.txt not created</b><br>";
           }
        }

        
    }
}
