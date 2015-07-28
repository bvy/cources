<?php
include_once 'auth.php';
if (!isAuth()){
    header("location: index.php"); 
    exit();
}

   
if (isset($_GET['sort'])){
    if (isset($_COOKIE['sortDirection'])){
        $sortDirection = $_COOKIE['sortDirection'];
        setcookie('sortDirection', $_GET['sort'],time()+3600);
        $newSortDirection = $_GET['sort'];
    }
    else{
        $sortDirection = $_GET['sort'];
        setcookie('sortDirection', $sortDirection, time()+3600);
    }
} 
else{
    if (isset($_COOKIE['sortDirection'])){
       $sortDirection = $_COOKIE['sortDirection'];
       $_GET['sort']= $_COOKIE['sortDirection'];
    }
    else{
        $sortDirection =1;
    }
}
    
    
if (isset($newSortDirection)){
    $sortDirection = $newSortDirection;
}
    
echo '<br>'.'You are logged to site as: '.  getAuthUser().' <br>';
echo '<form method="post" action="logout.php"><input type="submit" value="Log out"></form>';
?>

<form action="view.php" method="get">
            
             <label>Sort products
                 <select name="sort">
                     <option value="1" <?PHP if(isset($_GET['sort'])){if($_GET['sort']==1) echo ' selected="selected"';}?> >ASC</option>";
                     <option value="2" <?PHP if(isset($_GET['sort'])){if($_GET['sort']==2) echo ' selected="selected"';}?> >DESC</option>";
                     <option value="3" <?PHP if(isset($_GET['sort'])){if($_GET['sort']==3) echo ' selected="selected"';}?> >name</option>"
                 </select>
            </label>         
            <br>
            <br>
            <input type="submit" name="view"> 
</form>

<?php

$catalog= __DIR__."/products/enabled/";

//read files from catalog and create array with content files
$array = readProductsFromCatalog($catalog);

//sort and show
switch ($sortDirection) {
    case 1:
        sortByPrice($array, $sortDirection) ;
        break;
     case 2:
        sortByPrice($array, $sortDirection) ;
        break;
     case 3:
        sortByName($array, $sortDirection) ;
        break;
    default:
        break;
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
    
    $catalog= __DIR__."/products/enabled/";
    $arrayFiles = scandir($catalog);
    //a=2 because not include catalog "." and ".."
    for ($a=2,$i=0;$a<=count($arrayFiles)-1;$a++, $i++){
        $content = file($catalog.$arrayFiles[$a]);

        $product[$i]['name'] = ltrim(strstr($content[1],":") , ":");
        $product[$i]['price'] = ltrim(strstr($content[6],":") , ":");
        if (ltrim(strstr($content[7],":") , ":")==0) {
          $product[$i]['special_price'] =  ltrim(strstr($content[6],":") , ":"); 
        }
        else {
           $product[$i]['special_price'] =  ltrim(strstr($content[7],":") , ":");   
        }
        //$product[$i]['special_price'] = ltrim(strstr($content[7],":") , ":");
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
function sortByName(&$array, $direction){
   
    if ($direction == 3) {
      
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



function sortByPrice(&$array, $direction){
   if ($direction == 1){
        uasort($array, "sortByPriceAsc");
   }
   else {
        uasort($array, "sortByPriceDesc");
   }
      
}
function sortByPriceAsc($a, $b) { 
    
    if ((int)$a['special_price'] == (int)$b['special_price']) {
        return 0;
    }
    elseif ((int)$a['special_price']> (int)$b['special_price']){
        return 1;
    }
    else {
        return -1;
    }
    
}

function sortByPriceDesc($a, $b) { 
    
    return  -1*sortByPriceAsc($a, $b);
    
}


