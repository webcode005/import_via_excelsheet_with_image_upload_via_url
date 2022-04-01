<?php
// Set timezone
date_default_timezone_set('Asia/Kolkata');
require('excel-library/php-excel-reader/excel_reader2.php');
require('excel-library/SpreadsheetReader.php');

require'connection.php';


if(isset($_POST['importSubmit'])){

  

  $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$mimes))
  {

    $uploadFilePath = 'uploads/excel/'.date('d-m-y-h-i-s-a').'_'.basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

    $Reader = new SpreadsheetReader($uploadFilePath);

    $totalSheet = count($Reader->sheets());

    //echo "You have total ".$totalSheet." sheets".

    $nsheet=$totalSheet-2;

    // $html="<table border='1'>";
    // $html.="<tr>
    //               <th>Title</th>
    //               <th>Url</th>
    //               <th>Image1</th>
    //               <th>Image2</th>
    //               <th>Image3</th>
    //               <th>Image4</th>
    //           </tr>";

    /* For Loop for all sheets */
    for($i=0;$i<$nsheet;$i++){

      $Reader->ChangeSheet($i);

      foreach ($Reader as $Row)
      {

        if ($i++ == 0) continue;
       
        // $title = isset($Row[1]) ? $Row[1] : '';

        // $description = isset($Row[2]) ? $Row[2] : '';

        $name =  isset($Row[1]) ? $Row[1] : ''; 
        $url_key = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/","-",strtolower(trim($name))));

        $image1 =  isset($Row[2]) ? $Row[2] : '';
        $image2 =  isset($Row[3]) ? $Row[3] : '';
        $image3 =  isset($Row[4]) ? $Row[4] : '';
        $image4 =  isset($Row[5]) ? $Row[5] : '';


    // image1
    
                if(!empty($image1))
                {
                    
                     // for url image download
                        
                        $img1="img1_".$last_id.'_'.'.webp';
                
                        $imagePath="uploads/".$img1;
                        file_put_contents($imagePath, file_get_contents($image1));
                        
                        $quality = 70;
                        
                        //Create the webp image.
                        imagewebp($img1, $imagePath, $quality);
                        
                        $image1=$img1;
                       
                        
                }
                
    //for image2 
    
        if(!empty($image2))
                {
                        $img2="img2_".$last_id.'_'.'.webp';
                
                        $imagePath="uploads/".$img2;
                        file_put_contents($imagePath, file_get_contents($image2));
                        
                        $quality = 70;
                        
                        //Create the webp image.
                        imagewebp($img2, $imagePath, $quality);
                        
                        $image2=$img2;
                       
                        
                }
                
                
    // for image3 
         
        if(!empty($image3))
                {
                        $img3="img3_".$last_id.'_'.'.webp';
                
                        $imagePath="uploads/".$img3;
                        file_put_contents($imagePath, file_get_contents($image3));
                        
                        $quality = 70;
                        
                        //Create the webp image.
                        imagewebp($img3, $imagePath, $quality);
                        
                        $image3=$img3;
                     
                        
                }
    // for image4 
             
        if(!empty($image4))
                {
                         
                        $img4="img4_".$last_id.'_'.'.webp';
                
                        $imagePath="uploads/".$img4;
                        file_put_contents($imagePath, file_get_contents($image4));
                        
                        $quality = 70;
                        
                        //Create the webp image.
                        imagewebp($img4, $imagePath, $quality);
                        
                        $image4=$img4;
                        
                }
        
        
        $sql="INSERT INTO `import` ( `name`, `url_key`, `image1`, `image2`, `image3`, `image4`) 
        VALUES ( '$name', '$url_key' , '$image1', '$image2', '$image3', '$image4')";
         
         
         if($conn->query($sql) == TRUE)
         {
          $last_id = $conn->insert_id;
             
                 echo'<script>alert("Successfully inserted.");window.location.href="index.php";</script>';
             
         }
         else
         {
             echo "Error: " . $sql . "<br>" . $conn->error;
         }





       }
    }
    // $html.="</table>";
    // echo $html;
    echo "<br />Data Inserted in dababase";
  }else { 
    die("<br/>Sorry, File type is not allowed. Only Excel file."); 
  }
}
?>