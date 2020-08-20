<?php
/**
 * 自定义添加副标题
 *
 * @version        $ v2.0 2019-11-10 by 六久阁织梦模板网
 * @link           https://www.lol9.cn  qq:3149518909
 */
require_once(dirname(__FILE__).'/config.php');
CheckPurview('sys_Keyword');
require_once(DEDEINC.'/datalistcp.class.php');
$timestamp = time();
if(empty($tag)) $tag = '';

if(empty($action)){
	
	if(!isset($cfg_fbt_maxnumber)) $cfg_fbt_maxnumber=3;
	if($type=='tagsx'){
		$query = "select f.fid,f.title,f.addtime,f.typeid,f.daytime,f.number,t.id,t.typename from #@__fubiaoti f,#@__arctype t where f.typeid=t.id and f.number>='$cfg_fbt_maxnumber' order by fid desc";
	}else{
    	$query = "select f.fid,f.title,f.addtime,f.typeid,f.daytime,f.number,t.id,t.typename from #@__fubiaoti f,#@__arctype t where f.typeid=t.id and f.number<'$cfg_fbt_maxnumber' order by fid desc";
	}
    if($type=='checkid'){
		$query = "select f.fid,f.title,f.addtime,f.typeid,f.daytime,f.number,t.id,t.typename from #@__fubiaoti f,#@__arctype t where f.typeid=t.id and f.typeid='$flid' and f.number<'$cfg_fbt_maxnumber' order by fid desc";
	}
    
    
    
    $dlist = new DataListCP();
    $dlist->pageSize = 20;
    if($type=='tagsx'){
    	$dsql->SetQuery($query); 
		$dsql->Execute();
		while($row = $dsql->GetArray()) 
	{
		$rowid[].=$row['fid'];
	}
    	$dlist->pageSize = count($rowid);
    }    
    
    
    //接收get
    $dlist->SetParameter('flid',$flid);
    $dlist->SetParameter('type',$type);
    $dlist->SetTemplet(DEDEADMIN."/templets/fubiaoti.htm");
    $dlist->SetSource($query);

    //var_dump($dlist->SetSource($query));exit;
    $dlist->Display();
    exit();

}else if($action == 'delete'){//function delete()
	$get_url=$_SERVER['HTTP_REFERER'];//当前提交过来的url地址
    if(@is_array($ids))
    {
        $stringids = implode(',', $ids);
    }
    else if(!empty($ids))
    {
        $stringids = $ids;
    }
    else
    {
        ShowMsg('没有选择要删除的关键词',$get_url);
        exit();
    }
    // var_dump($stringids);exit;
    $query = "DELETE FROM `#@__fubiaoti` WHERE fid IN ($stringids)";
    if($dsql->ExecuteNoneQuery($query))
    {
        $query = "DELETE FROM `#@__fubiaoti` WHERE fid IN ($stringids)";
        $dsql->ExecuteNoneQuery($query);
        ShowMsg("删除成功", $get_url);
    }
    else
    {
        ShowMsg("删除失败", $get_url);
    }
    exit();

}else if($action == 'addto'){//function fetch()
	$get_url=$_SERVER['HTTP_REFERER'];//当前提交过来的url地址
    $addtime = time();
    $title=$_POST['title'];
    $typeid=$_POST['typeid'];
    // var_dump($typeid);exit;
    if($title == ""){
        ShowMsg("请输入关键字", $get_url);
        exit();
    }
    $arr = explode(PHP_EOL, "$title");    
    $arr = array_filter($arr);
    
    foreach ($arr as $key => $value) {
    	$value=str_replace(array("\r\n", "\r", "\n"),"",rtrim($value));
        $key = $dsql->GetOne("SELECT * FROM #@__fubiaoti WHERE typeid='$typeid' and title = '$value' ");
        if(!empty($key)){
            ShowMsg("添加失败 '".$value."'该关键词已经有了", $get_url,0,6000);
        }else{
            $sql=$dsql->ExecuteNoneQuery("INSERT INTO #@__fubiaoti (title,addtime,typeid,daytime,number) VALUES ('$value','$addtime','$typeid','0','0')");
        }
          
    }
    if(!empty($sql)){
       ShowMsg("添加成功", $get_url); 
    }else{
       ShowMsg("添加失败", $get_url); 
    }
    exit();
}else if($action == "updateid"){
	$get_url=$_SERVER['HTTP_REFERER'];//当前提交过来的url地址
    $yuanid=$_POST['yuanid'];
    $typeid=$_POST['typeid'];
    // print_r($yuanid);die;
    $sql = $dsql->ExecuteNoneQuery("UPDATE `#@__fubiaoti` SET typeid = '$typeid' where  typeid = '$yuanid'");
    if(!empty($sql)){
       ShowMsg("修改成功", 'fubiaoti.php'); 
    }
}else if($action == 'fubiaoti_save'){//function fetch()
    $fid = $_GET['ids'];
    $dlist = new DataListCP();
    $dlist->SetTemplet(DEDEADMIN."/templets/fubiaoti_save.htm");
    $dlist->Display();
    exit();
}else if($action == 'update'){
	$get_url=$_SERVER['HTTP_REFERER'];//当前提交过来的url地址
    $fid = $_POST['fid'];
    $title = $_POST['title'];
    if($title == ""){
        ShowMsg("内容不能为空",$get_url);
        exit();
    } 
    $sql = $dsql->ExecuteNoneQuery("UPDATE `#@__fubiaoti` SET title = '$title' where fid = '$fid'");
    if(!empty($sql)){
       ShowMsg("修改成功", $get_url); 
    }

}else if($action == 'reset'){
	$get_url=$_SERVER['HTTP_REFERER'];//当前提交过来的url地址
	$czid = $_GET['czid'];
	$sql = $dsql->ExecuteNoneQuery("UPDATE `#@__fubiaoti` SET number = 0 where fid = '$czid'");
    if(!empty($sql)){
	ShowMsg("重置{$czid}成功", $get_url);
    }
	exit;
}else if($action == 'yjcz'){
	$tjczid = trim($_GET['yjczid'],",");
	if(empty($tjczid)){
		ShowMsg("请选择要重置的关键词","fubiaoti.php?type=titlesx");
		exit;
	}
	
	
	$query ="UPDATE `#@__fubiaoti` SET `number`=0 WHERE fid IN($tjczid)";
	$zcsql=$dsql->ExecuteNoneQuery($query);
    if(!empty($zcsql))
    {
        ShowMsg("一键重置成功", 'fubiaoti.php?type=tagsx');
    }
    else
    {
        ShowMsg("一键重置失败", 'fubiaoti.php?type=tagsx');
    }
	
	exit;
}