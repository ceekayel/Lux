<?php 
/*
 * delete uploaded image from submit form.
 */
require("../../../../wp-load.php");
if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'delete')
{
   wp_delete_attachment($_REQUEST['pid']);
   
   $wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'];
	$url = $wp_upload_dir['url'];
	  $destination_path = $path."/";
      if (!file_exists($destination_path)){
      $imagepatharr = explode('/',str_replace(ABSPATH,'', $destination_path));
	   $year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
   $uploaddir = $destination_path;
   $image_name = $_REQUEST["name"];
   $path_info = pathinfo($image_name);
   $file_extension = $path_info["extension"];
   $image_name = basename($image_name,".".$file_extension);
   /*$expImg = strlen(end(explode("-",$image_name)));*/
   /*$finalImg = substr($image_name,0,-($expImg + 1));*/
   @unlink($uploaddir.$image_name.".".$file_extension);
}

if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'delete')
{
	/* remove from folder too*/
	$uploaddir = TEMPLATEPATH."/images/tmp/";
	$image_name = $_REQUEST["name"];
	$path_info = pathinfo($image_name);
	$file_extension = $path_info["extension"];
	$image_name = basename($image_name,".".$file_extension);
	@unlink($uploaddir.$image_name.".".$file_extension);
 	@unlink($uploaddir.$image_name."-60X60.".$file_extension);
	echo 'deleted';
}
exit;
?>