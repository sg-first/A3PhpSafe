<?
/*
处理原理：在网站运行前先注册所有可信任的PHP文件，并在接受上传文件后进行手动检查，清除未认证的PHP文件
使用方法：配置ConfigCheckPHP后，在接受上传文件并进行基本处理后调用本类方法check进行过滤
*/
class CheckPHP{

protected static $allPHP;//目前所有的PHP程序
public static $PathMode=false;//真为绝对，假为相对
protected static $recursiving=false;//是否正在递归

public static function AddPHP($path)//相对路径需要用/开头
{
    if(empty($allPHP))
    {$allPHP=array(dirname(__FILE__)."/PhpStringSafe.php");}

	if(!CheckPHP::$PathMode)
	{$allPHP[]=dirname(__FILE__).$path.".php";}
	else
	{$allPHP[]=$path.".php";}
}

public static function Check($directory) //相对路径需要用/开头
{
	//如果是相对路径，连接前面绝对的部分
	if(!CheckPHP::$PathMode&&!CheckPHP::$recursiving)
	{$directory=dirname(__FILE__).$directory;}
	
	$mydir = dir($directory);
	while($file = $mydir->read())
	{
		if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!=".."))
		{
            CheckPHP::Check("$directory/$file"); //发现目录则递归
		}
		else
		{
			//提取后缀名
			$filearr = split(".",$file);
			$filetype = end($filearr);
			//检查后缀名是否是要检测的文件
			if($filetype=="php") //注意，php必须都是小写
			{
				foreach(CheckPHP::$allPHP as $key=>$value)//在所有注册过的文件中遍历查找是否存在同名
				{
					if("$directory/$file"==$value)
					{continue;}//找到了就继续
				}
				unlink("$directory/$file");//找不到对应的就删
			}
		}

	}
	$mydir->close();
}

}