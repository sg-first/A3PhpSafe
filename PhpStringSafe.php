<?
/*
处理原理：将指定输入或所有post与get中的特殊字符全部过滤（默认使用PHP过滤器，允许自定义非法字符（本身已经定义SQL命令））
使用方法：在接受输入时调用本类的方法进行过滤
*/
class PhpStringSafe{

//要过滤的非法字符
protected $ArrFiltrate=array("update","union","select","insert","delete","into",
							"load_file","OR");

//过滤传入的字符串，返回过滤后数据
public function Validation($StrFiltrate,$uesFilter)
{
	if($uesFilter==true)
	{
		$StrFiltrate=var_dump(filter_var($StrFiltrate,FILTER_SANITIZE_STRING));
		$StrFiltrate=var_dump(filter_var($StrFiltrate,FILTER_SANITIZE_SPECIAL_CHARS)); 
	}
	foreach ($ArrFiltrate as $key=>$value)
	{
		$StrFiltrate=str_replace($value,"",$StrFiltrate);
	}
	return $StrFiltrate;
}

//过滤所有输入
public function AllValidation()
{
	foreach(MergeInput() as $key=>$value)
	{$value=Validation($value,true);}//默认使用过滤器进行过滤
}

//添加一个过滤项
public function AddFiltrate($filtrate)
{$ArrFiltrate[]=$filtrate;}

//删除一个过滤项
public function DeleteFiltrate($filtrate)
{array_splice($ArrFiltrate,key($filtrate),1);}

//合并$_POST 和 $_GET
protected function MergeInput()
{
	$ArrPostAndGet=0;
	
	foreach($HTTP_POST_VARS as $key=>$value)
	{$ArrPostAndGet[]=$value;}
	foreach($HTTP_GET_VARS as $key=>$value)
	{$ArrPostAndGet[]=$value;}

	return ArrPostAndGet;
}

}

$StringSafe=new PhpStringSafe;
?>