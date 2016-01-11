<?
class FileValidation{

/* 
处理原理：对图片类型进行简单的检测，并以原图进行重新生成（重新生成会打乱其中的恶意代码） 
使用方法：用此函数替换move_uploaded_file（仅针对gif png与jpg图片）
参数：$file $_FILES['']获取的值，$path 图片生成的物理路径（包含图片名称） 
返回值：上传成功 true，图片类型异常 -1，上传失败 false
 */  
public static function ImageSave($file, $path) 
{  
    if ($file["type"] == "image/gif") 
	{  
        @$im = imagecreatefromgif($file['tmp_name']);  
        if ($im) 
		{$sign = imagegif($im, $path);} 
		else 
		{return -1;}  
    } 
	elseif ($file["type"] == "image/png" || $file["type"] == "image/x-png") 
	{  
        @$im = imagecreatefrompng($file['tmp_name']);  
        if ($im) 
		{$sign = imagepng($im, $path);} 
		else 
		{return -1;}  
    } 
	else 
	{  
        @$im = imagecreatefromjpeg($file['tmp_name']);  
        if ($im) 
		{$sign = imagejpeg($im, $path, 100);} 
		else 
		{return -1;}  
    }  
    return $sign;  
}

/* 
处理原理：通过读文件头判断文件类型
使用方法：调用Validation函数，返回文件类型
 */ 
protected static function GetTypeCode($filename)
{
    $file = fopen($filename, "rb");  
    $bin = fread($file, 2);//只读2字节  
    fclose($file);  
    $strInfo = @unpack("C2chars", $bin);  
    return intval($strInfo['chars1'].$strInfo['chars2']);  
}

public static function ValidationType($filename)
{
	switch (GetTypeCode($filename)) 
	{
		case 7790: return 'exe';
		case 8297: return 'rar';
		case 255216: return 'jpg';
		case 7173: return 'gif';
		case 6677: return 'bmp';
		case 13780: return 'png';
		default: return 'unknown';
	}
}

}