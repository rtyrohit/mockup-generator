
<?php
/**
 * @Author: rtyrohit
 * @Date:   2017-04-05 01:59:04
 * @Last Modified by:   rtyrohit
 * @Last Modified time: 2017-04-05 11:44:00
 */

$output = [
    "code" => null,
    "message" => null
];
function getExtension($str) {
    $i=strrpos($str,".");
    if(!$i){
        return "";
    }
    $l=strlen($str)-$i;
    $ext=substr($str,$i+1,$l);
    return $ext;
}
$formats = array("jpg", "png", "jpeg", "PNG", "JPG", "JPEG");

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	$name = $_FILES['file']['name'];
	$size = $_FILES['file']['size'];
 	$tmp  = $_FILES['file']['tmp_name'];
 	if(strlen($name)){
  		$ext = getExtension($name);
		if(in_array($ext,$formats)){
   			if($size<(1024*1024)){
    			$imgn = time().".".$ext;
    			if(move_uploaded_file($tmp, "./uploads/".$imgn)){
                    $output["code"] = 0;
                    $output["message"] = "./uploads/".$imgn;
                } else{
     				$output["code"] = 0;
                    $output["message"] = "Uploading Failed";
    			}
   			} else {
    			$output["code"] = -1;
                $output["message"] = "Image size should be less than 1MB";
   			}
  		} else {
			$output["code"] = -2;
            $output["message"] = "Image should be of png/jpg format.";
		}
 	} else {
  		$output["code"] = -3;
        $output["message"] = "Please select an image";
	}
} else {
    $output["code"] = 0;
    $output["message"] = "Invalid Method";
}
echo json_encode($output)
?>