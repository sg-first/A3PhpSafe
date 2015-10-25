A3PhpSafe
=======================
This is an experimental Lightweight PHP security library.


CharacterValidation
--------------
[readme](https://github.com/sg-first/A3PhpSafe/blob/master/CharacterValidation/readmemd)


CheckPHP
-------------
You should registered all the legally PHP file from the project to the module before you use it. It can run  to check illegal PHP file(by manually call) that appears in the website and remove it (it can prevents your website be attached by trojan horse)

```PHP
	<?
	require_once dirname(__FILE__).'/CheckPHP.php';
	CheckPHP::$PathMode=false;//默认为使用相对路径标示php文件
	//向列表中添加所有可信的php路径（网站中用到的任何）
	CheckPHP::AddPHP("/ConfigCheckPHP");//注意，不用写后缀
	//检查的方法是：CheckPHP::Check();
```


FileValidation
-------------
This module can clear PHP code in a picture very precise. It can also be used to check file type by checking file header.


IoScrutineering
--------------------------
Checking and formatting operations on IO.