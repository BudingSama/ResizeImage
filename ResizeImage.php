<?php
//imagecreatefromgif()：创建一块画布，并从 GIF 文件或 URL 地址载入一副图像
//imagecreatefromjpeg()：创建一块画布，并从 JPEG 文件或 URL 地址载入一副图像
//imagecreatefrompng()：创建一块画布，并从 PNG 文件或 URL 地址载入一副图像
//imagecreatefromwbmp()：创建一块画布，并从 WBMP 文件或 URL 地址载入一副图像
//imagecreatefromstring()：创建一块画布，并从字符串中的图像流新建一副图像
  //压缩图片
  //形参说明  图片url 目标宽度 
function ResizeImage($uploadfile,$target){
	//获得原图扩展名
	$ImageType = explode(".", $uploadfile)[count(explode(".", $uploadfile))-1];
	//获取原图的大小	
	$imageSize = getimagesize($uploadfile);
    //目标图片大小 取得缩放的比例
    $i =$target/$imageSize[0];
	//取得缩略图的宽高
	$targetWidth =  $target;
	$targetHeight = $i*$imageSize[1];
	//根据扩展名实例化图片
	switch($ImageType){
		case "png":
			$src = imagecreatefrompng($uploadfile);
			break;
		case "jpeg":
			$src = imagecreatefromjpeg($uploadfile);
			break;
		case "jpg":
			$src = imagecreatefromjpeg($uploadfile);
			break;
		case "gif":
			$src = imagecreatefromgif($uploadfile);
			break;
		default:
			return false;
			break;
	}
		//兼容性适配
        if(function_exists("imagecopyresampled")){
            $uploaddir_resize = imagecreatetruecolor($targetWidth, $targetHeight);
            imagecopyresampled($uploaddir_resize, $src, 0, 0, 0, 0, $targetWidth, $targetHeight, $imageSize[0], $imageSize[1]);
        }
        else{
            $uploaddir_resize = imagecreate($targetWidth, $targetHeight);
            imagecopyresized($uploaddir_resize, $src_im, 0, 0, 0, 0, $targetWidth, $targetHeight, $imageSize[0], $imageSize[1]);
        }
		//生成随机名字
		$name = randName(8,"jpeg");
       $res = ImageJpeg($uploaddir_resize,$name);
        ImageDestroy ($uploaddir_resize);
		return $name;
}

//随机名字
function randName($num,$type){
	$str = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$targetstr = "";
	for($i=0;$i<$num;$i++){
		$targetstr.=$str[rand(0,strlen($str)-1)];
	}
	$targetstr.=time();
	$targetstr.=".".$type;
	return $targetstr;
}
?>