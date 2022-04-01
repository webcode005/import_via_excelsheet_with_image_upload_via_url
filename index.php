<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="excelUpload.php" method="POST" enctype="multipart/form-data">
         <input type="file" name="file" required/>
         <input type="submit" name="importSubmit"/>
      </form>



      <?php

require'connection.php';


    $html="<table border='1'>";
    $html.="<tr>
                  <th>Title</th>
                  <th>Url</th>
                  <th>Image1</th>
                  <th>Image2</th>
                  <th>Image3</th>
                  <th>Image4</th>
              </tr>";

    /* For Loop for all sheets */

    $Row = array();

        $sd=$conn->query("select * from import order by id desc");

echo"<br><br>";

      while ( $Row = $sd->fetch_array())
      {

        $name =  isset($Row[1]) ? $Row[1] : ''; 
        $url_key = isset($Row[2]) ? $Row[2] : '';

        $image1 =  isset($Row[3]) ? $Row[3] : '';
        $image2 =  isset($Row[4]) ? $Row[4] : '';
        $image3 =  isset($Row[5]) ? $Row[5] : '';
        $image4 =  isset($Row[6]) ? $Row[6] : '';
    
        
        
        
        
        $html.="<td>".$name."</td>";
        $html.="<td>".$url_key."</td>";
        $html.="<td><img src='uploads/".$image1." ' width='360px'></td>";
        $html.="<td><img src='uploads/".$image2." ' width='360px'></td>";        
        $html.="<td><img src='uploads/".$image3." ' width='360px'></td>";
        $html.="<td><img src='uploads/".$image4." ' width='360px'></td>";
        $html.="</tr>";


       }
   
    $html.="</table>";
    echo $html;
   
?>



</body>
</html>