<html>
   <head>
        <title>File parser</title>    
    </head>
    
    <body>
        <h2>Import CSV</h2>
        <form action="csv.php" method="POST" enctype="multipart/form-data">
            <label>
                <input type="file" name="file">
            </label>
                      
            <br>
            <br>
            <input type="submit" name="submit"> 
        </form>
        
        <hr>
        
         <h2>View products</h2>
        <form action="view.php" method="get">
             <label>Sort by name
                 <select name="name">
                     <option value="0">-</option>";
                     <option value="1">ASC</option>";
                     <option value="2">DESC</option>";
                 </select>
             </label>
             <label>Sort by price
                 <select name="price">
                     <option value="1">ASC</option>";
                     <option value="2">DESC</option>";
                 </select>
            </label>         
            <br>
            <br>
            <input type="submit" name="view"> 
        </form>
    </body> 
    
    
</html>
    

    
    

   
   
   


