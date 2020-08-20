<?php
/**
 * �Զ�����Ӹ�����
 *
 * @version        $ v2.0 2019-11-10 by ���ø�֯��ģ����
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
    
    
    //����get
    $dlist->SetParameter('flid',$flid);
    $dlist->SetParameter('type',$type);
    $dlist->SetTemplet(DEDEADMIN."/templets/fubiaoti.htm");
    $dlist->SetSource($query);

    //var_dump($dlist->SetSource($query));exit;
    $dlist->Display();
    exit();

}else if($action == 'delete'){//function delete()
	$get_url=$_SERVER['HTTP_REFERER'];//��ǰ�ύ������url��ַ
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
        ShowMsg('û��ѡ��Ҫɾ���Ĺؼ���',$get_url);
        exit();
    }
    // var_dump($stringids);exit;
    $query = "DELETE FROM `#@__fubiaoti` WHERE fid IN ($stringids)";
    if($dsql->ExecuteNoneQuery($query))
    {
        $query = "DELETE FROM `#@__fubiaoti` WHERE fid IN ($stringids)";
        $dsql->ExecuteNoneQuery($query);
        ShowMsg("ɾ���ɹ�", $get_url);
    }
    else
    {
        ShowMsg("ɾ��ʧ��", $get_url);
    }
    exit();

}else if($action == 'addto'){//function fetch()
	$get_url=$_SERVER['HTTP_REFERER'];//��ǰ�ύ������url��ַ
    $addtime = time();
    $title=$_POST['title'];
    $typeid=$_POST['typeid'];
    // var_dump($typeid);exit;
    if($title == ""){
        ShowMsg("������ؼ���", $get_url);
        exit();
    }
    $arr = explode(PHP_EOL, "$title");    
    $arr = array_filter($arr);
    
    foreach ($arr as $key => $value) {
    	$value=str_replace(array("\r\n", "\r", "\n"),"",rtrim($value));
        $key = $dsql->GetOne("SELECT * FROM #@__fubiaoti WHERE typeid='$typeid' and title = '$value' ");
        if(!empty($key)){
            ShowMsg("���ʧ�� '".$value."'�ùؼ����Ѿ�����", $get_url,0,6000);
        }else{
            $sql=$dsql->ExecuteNoneQuery("INSERT INTO #@__fubiaoti (title,addtime,typeid,daytime,number) VALUES ('$value','$addtime','$typeid','0','0')");
        }
          
    }
    if(!empty($sql)){
       ShowMsg("��ӳɹ�", $get_url); 
    }else{
       ShowMsg("���ʧ��", $get_url); 
    }
    exit();
}else if($action == "updateid"){
	$get_url=$_SERVER['HTTP_REFERER'];//��ǰ�ύ������url��ַ
    $yuanid=$_POST['yuanid'];
    $typeid=$_POST['typeid'];
    // print_r($yuanid);die;
    $sql = $dsql->ExecuteNoneQuery("UPDATE `#@__fubiaoti` SET typeid = '$typeid' where  typeid = '$yuanid'");
    if(!empty($sql)){
       ShowMsg("�޸ĳɹ�", 'fubiaoti.php'); 
    }
}else if($action == 'fubiaoti_save'){//function fetch()
    $fid = $_GET['ids'];
    $dlist = new DataListCP();
    $dlist->SetTemplet(DEDEADMIN."/templets/fubiaoti_save.htm");
    $dlist->Display();
    exit();
}else if($action == 'update'){
	$get_url=$_SERVER['HTTP_REFERER'];//��ǰ�ύ������url��ַ
    $fid = $_POST['fid'];
    $title = $_POST['title'];
    if($title == ""){
        ShowMsg("���ݲ���Ϊ��",$get_url);
        exit();
    } 
    $sql = $dsql->ExecuteNoneQuery("UPDATE `#@__fubiaoti` SET title = '$title' where fid = '$fid'");
    if(!empty($sql)){
       ShowMsg("�޸ĳɹ�", $get_url); 
    }

}else if($action == 'reset'){
	$get_url=$_SERVER['HTTP_REFERER'];//��ǰ�ύ������url��ַ
	$czid = $_GET['czid'];
	$sql = $dsql->ExecuteNoneQuery("UPDATE `#@__fubiaoti` SET number = 0 where fid = '$czid'");
    if(!empty($sql)){
	ShowMsg("����{$czid}�ɹ�", $get_url);
    }
	exit;
}else if($action == 'yjcz'){
	$tjczid = trim($_GET['yjczid'],",");
	if(empty($tjczid)){
		ShowMsg("��ѡ��Ҫ���õĹؼ���","fubiaoti.php?type=titlesx");
		exit;
	}
	
	
	$query ="UPDATE `#@__fubiaoti` SET `number`=0 WHERE fid IN($tjczid)";
	$zcsql=$dsql->ExecuteNoneQuery($query);
    if(!empty($zcsql))
    {
        ShowMsg("һ�����óɹ�", 'fubiaoti.php?type=tagsx');
    }
    else
    {
        ShowMsg("һ������ʧ��", 'fubiaoti.php?type=tagsx');
    }
	
	exit;
}