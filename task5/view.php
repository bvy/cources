<?php

$sortNameDirection = isset($_GET['name'])? $_GET['name'] : 0; 
$sortPriceDirection = isset($_GET['price'])? $_GET['price'] : 1; 
$catalog= __DIR__."\\products\\enabled\\";

//read files from catalog and create array with content files
$array = readProductsFromCatalog($catalog);

//sort and show

 sortByPrice($array, $sortPriceDirection);



if ($sortNameDirection) {
    sortByName($array,$sortNameDirection);

}

foreach ($array as $value) {
        echo "<div>";
        echo "Product ".$value['name']."<br>";
        if ($value['special_price']!=0) {
             echo "<strike>Price ".$value['price']."</strike> Special price ".$value['special_price']."<br>";
        }
        else {
            echo "Price ".$value['price']."<br>";
        }
        echo "<img src=\"{$value['image_url']}\"><br><br>";
        echo "</div>";
    
}

function readProductsFromCatalog($catalog){
    
    $catalog= __DIR__."\\products\\enabled\\";
    $arrayFiles = scandir($catalog);
    //a=2 because not include catalog "." and ".."
    for ($a=2,$i=0;$a<=count($arrayFiles)-1;$a++, $i++){
        $content = file($catalog.$arrayFiles[$a]);

        $product[$i]['name'] = ltrim(strstr($content[1],":") , ":");
        $product[$i]['price'] = ltrim(strstr($content[6],":") , ":");
        $product[$i]['special_price'] = ltrim(strstr($content[7],":") , ":");
        $product[$i]['image_url'] = ltrim(strstr($content[11],":") , ":");

    }
   
    return $product;
}

/*
 * function sortByName   
 * @param array $array . Source array
 * @param int [$direction] . Valid values 1 - sort ASC, 2 - sort DESC. Default sort ASC
 * $return array 
 * 
 */
function sortByName(&$array, $direction=0){
   
    if ($direction == 2) {
        uasort($array, "sortByNameDesc");
   }
   else{
       uasort($array, "sortByNameAsc");
   }
      
}
function sortByNameAsc($a, $b) 
{ 
    return strcasecmp($a['name'], $b['name']);
    
}

function sortByNameDesc($a, $b) 
{ 
    return -1*strcasecmp($a['name'], $b['name']);

    
}



function sortByPrice(&$array, $direction=0){
   if ($direction == 2){
        uasort($array, "sortByPriceDesc");
   }
   else {
        uasort($array, "sortByPriceAsc");
   }
      
}
function sortByPriceAsc($a, $b) { 
    
    if ((int)$a['price'] == (int)$b['price']) {
        return 0;
    }
    elseif ((int)$a['price']> (int)$b['price']){
        return 1;
    }
    else {
        return -1;
    }
    
}

function sortByPriceDesc($a, $b) { 
    
    return  -1*sortByPriceAsc($a, $b);
    
}


