<?php
/**
 * �Զ������tag
 *
 * @version        $ v2.0 2019-12-27 by ���ø�֯��ģ����$
 * @link           https://www.lol9.cn  qq:3149518909
 */
require_once(dirname(__FILE__).'/config.php');
CheckPurview('sys_Keyword');
require_once(DEDEINC.'/datalistcp.class.php');
$timestamp = time();
if(empty($tag)) $tag = '';

if(empty($action)){
	if(!isset($cfg_tags_maxnumber)) $cfg_tags_maxnumber=3;
	if($type=='tagsx'){
		$query = "select b.d_id,b.title,b.addtime,b.typeid,b.daytime,b.number,t.id,t.typename from #@__diy_tags b,#@__arctype t where b.typeid=t.id and b.number>='$cfg_tags_maxnumber' order by d_id desc";
	}
	else{
    	$query = "select b.d_id,b.title,b.addtime,b.typeid,b.daytime,b.number,t.id,t.typename from #@__diy_tags b,#@__arctype t where b.typeid=t.id and b.number<'$cfg_tags_maxnumber' order by d_id desc";
	}
	if($type=='checkid'){
		$query = "select b.d_id,b.title,b.addtime,b.typeid,b.daytime,b.number,t.id,t.typename from #@__diy_tags b,#@__arctype t where b.typeid=t.id and b.typeid='$flid' and b.number<'$cfg_tags_maxnumber' order by d_id desc";
	}
    $dlist = new DataListCP();
    $dlist->pageSize = 20;
    if($type=='tagsx'){
    	$dsql->SetQuery($query); 
		$dsql->Execute();
		while($row = $dsql->GetArray()) 
	{
		$rowid[].=$row['id'];
	}
    	$dlist->pageSize = count($rowid);
    }
    //����get
    $dlist->SetParameter('flid',$flid);
    $dlist->SetParameter('type',$type);
    $dlist->SetTemplet(DEDEADMIN."/templets/diy_tags.htm");
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
    $query = "DELETE FROM `#@__diy_tags` WHERE d_id IN ($stringids)";
    if($dsql->ExecuteNoneQuery($query))
    {
        $query = "DELETE FROM `#@__diy_tags` WHERE d_id IN ($stringids)";
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
    // var_dump($arr);exit;
    
    foreach ($arr as $key => $value) {
    	$value=str_replace(array("\r\n", "\r", "\n"),"",rtrim($value));
        $key = $dsql->GetOne("SELECT * FROM #@__diy_tags WHERE typeid='$typeid' and title = '$value' ");
        if(!empty($key)){
            ShowMsg("���ʧ�� '".$value."'�ùؼ����Ѿ�����", $get_url,0,6000);
        }else{
            $sql=$dsql->ExecuteNoneQuery("INSERT INTO #@__diy_tags (title,addtime,typeid,daytime,number) VALUES ( '$value','$addtime','$typeid','0','0')");
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
    $sql = $dsql->ExecuteNoneQuery("UPDATE `#@__diy_tags` SET typeid = '$typeid' where  typeid = '$yuanid'");
    if(!empty($sql)){
       ShowMsg("�޸ĳɹ�", $get_url); 
    }
}else if($action == 'diy_tags_save'){//function fetch()
    $d_id = $_GET['ids'];
    $dlist = new DataListCP();
    $dlist->SetTemplet(DEDEADMIN."/templets/diy_tags_save.htm");
    $dlist->Display();
    exit();
}else if($action == 'update'){
	$get_url=$_SERVER['HTTP_REFERER'];//��ǰ�ύ������url��ַ
    $d_id = $_POST['d_id'];
    $title = $_POST['title'];
    if($title == ""){
        ShowMsg("���ݲ���Ϊ��", $get_url);
        exit();
    } 
    $sql = $dsql->ExecuteNoneQuery("UPDATE `#@__diy_tags` SET title = '$title' where d_id = '$d_id'");
    if(!empty($sql)){
       ShowMsg("�޸ĳɹ�", $get_url); 
    }

}else if($action == 'reset'){
	$get_url=$_SERVER['HTTP_REFERER'];//��ǰ�ύ������url��ַ
	$czid = $_GET['czid'];
	$sql = $dsql->ExecuteNoneQuery("UPDATE `#@__diy_tags` SET number = 0 where d_id = '$czid'");
    if(!empty($sql)){
	ShowMsg("����{$czid}�ɹ�", "diy_tags.php?type=tagsx");
    }
	exit;
}else if($action == 'yjcz'){
	$tjczid = trim($_GET['yjczid'],",");
	if(empty($tjczid)){
		ShowMsg("��ѡ��Ҫ���õĹؼ���","diy_tags.php?type=titlesx");
		exit;
	}
	
	
	$query ="UPDATE `#@__diy_tags` SET `number`=0 WHERE d_id IN($tjczid)";
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



