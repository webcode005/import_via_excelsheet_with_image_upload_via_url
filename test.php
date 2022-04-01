<?php
// Load the database configuration file
require'connection.php';


if(isset($_POST['importSubmit']))
{
        // print_r($_FILES['file']['name']);
        // print_r($_FILES['file']['type']);
     
        
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    

    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes))
    {
           
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
                $excel_file=date('Y_m_d').$_FILES['file']['name'];
                
          move_uploaded_file($_FILES['file']['tmp_name'],'excel/'.$excel_file);
          
          
          
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($csv = fgetcsv($csvFile)) !== FALSE){
                // Get row data

 
                $name =  isset($csv[1]) ? $csv[1] : ''; 
                $url_key = str_replace("---","-",preg_replace("/[^-a-zA-Z0-9s]/","-",strtolower(trim($name))));

                $image1 =  isset($csv[2]) ? $csv[2] : '';
                $image2 =  isset($csv[3]) ? $csv[3] : '';
                $image3 =  isset($csv[4]) ? $csv[4] : '';
                $image4 =  isset($csv[5]) ? $csv[5] : '';
 
 
            // image1
            
                        if(!empty($image1))
                        {
                            
                             // for url image download
                                
                                $img1=date('Y_m_d_h_i_s').'_'.'.webp';
                        
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
                                $img2=date('Y_m_d_h_i_s').'_'.'.webp';
                        
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
                                $img3=date('Y_m_d_h_i_s').'_'.'.webp';
                        
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
                                 
                                $img4=date('Y_m_d_h_i_s').'_'.'.webp';
                        
                                $imagePath="uploads/".$img4;
                                file_put_contents($imagePath, file_get_contents($image4));
                                
                                $quality = 70;
                                
                                //Create the webp image.
                                imagewebp($img4, $imagePath, $quality);
                                
                                $image4=$img4;
                                
                        }
                        
           
                        
                        
                        
                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT url_key FROM import WHERE url_key = '$url_key'";
                $prevResult = $conn->query($prevQuery);
                
                if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $conn->query("UPDATE  import SET name='$name', image1='$image1', image2='$image2', image3='$image3', image4='$image4',url_key='$url_key' WHERE url_key = '$url_key'");
                }
                else
                {
                    // Insert member data in the database
                 
                 
                   $sql="INSERT INTO `import` ( `name`, `url_key`, `image1`, `image2`, `image3`, `image4`) 
                   VALUES ( '$name', '$url_key' , '$image1', '$image2', '$image3', '$image4')";
                    
                    
                    if($conn->query($sql) == TRUE)
                    {
                        
                            echo'<script>alert("Successfully inserted.");window.location.href="excel.php";</script>';
                        
                    }
                    else
                    {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    
                    
                }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }
    else
    {
        $qstring = '?status=invalid_file';
    }
}

else 
{
        echo "form not submitted";
}

// Redirect to the listing page
//header("Location: index.php".$qstring);[09-Mar-2022 08:52:16 Europe/Berlin] Hello, errors!
