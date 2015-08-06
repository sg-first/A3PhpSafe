<?
/*
处理原理：在网站运行前先注册所有可信任的PHP文件，并在接受上传文件后进行手动检查，清除未认证的PHP文件
使用方法：配置ConfigCheckPHP后，在接受上传文件并进行基本处理后调用本类方法check进行过滤
*/
class CheckPHP{

protected static $AllPHP=array(dirname(__FILE__)."/PhpStringSafe");//目前所有的PHP程序，不用写后缀
public static $PathMode=false;//真为绝对，假为相对
protected static $Recursiving=false;//是否正在递归

public static function AddPHP($path)//相对路径需要用/开头
{
	if($PathMode==false)
	{$AllPHP[]=dirname(__FILE__).$path;}
	else
	{$AllPHP[]=$path;}
}

public static function Check($directory)//相对路径需要用/开头
{
	//如果是相对路径，连接前面绝对的部分
	if($PathMode==false)
	{
		if($Recursiving==false)
		{$directory=dirname(__FILE__).$directory;}
	}
	
	$mydir = dir($directory);
	while($file = $mydir->read())
	{
		if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!=".."))
		{
			//发现目录则递归
			$Recursiving=true;
			Check("$directory/$file");
		}
		else
		{
			//提取后缀名
			$filearr = split(".",$file);
			$filetype = end($filearr);
			//检查后缀名是否是要检测的文件
			if($filetype=="php")
			{
				foreach($AllPHP as $key=>$value)//在所有注册过的文件中遍历查找是否存在同名
				{
					if("$directory/$file"==$value.".php")//注意，php必须都是小写
					{continue;}//找到了就继续
				}
				unlink("$directory/$file");//找不到对应的就删
			}
		}

	}
	$mydir->close();
}

}