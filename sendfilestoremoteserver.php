/* sender */

<form enctype="multipart/form-data" encoding='multipart/form-data' method='post' action="filetransfer.php">
  <input name="uploadedfile" type="file" value="choose">
  <input type="submit" value="Upload">
</form>



<?php
if ( isset($_FILES['uploadedfile']) ) {
 $filename    = $_FILES['uploadedfile']['tmp_name'];
 $target_file = basename($_FILES["uploadedfile"]["name"]);
 $handle    = fopen($filename, "r");
 $data      = fread($handle, filesize($filename));
 $POST_DATA = array(
   'file' => base64_encode($data),
   'name' => $target_file
 );
 $curl = curl_init();
 curl_setopt($curl, CURLOPT_URL, 'http://uniquefitness.net/handler.php');
 curl_setopt($curl, CURLOPT_TIMEOUT, 30);
 curl_setopt($curl, CURLOPT_POST, 1);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);
 $response = curl_exec($curl);
 curl_close ($curl);
 
 var_dump($response);
 
}
?>

/* handler */

<?php


if( isset($_POST) ) {
    
    
    $encoded_file = $_POST['file'];
    $decoded_file = base64_decode($encoded_file);
    $file_name = "images/" . $_POST['name'];
    
    
    /* Now you can copy the uploaded file to your server. */
    file_put_contents($file_name, $decoded_file);
    
}