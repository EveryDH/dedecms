<?php
require_once(dirname(__FILE__)."/../config.php");
CheckPurview('sys_MakeHtml');
set_time_limit(0);

if(empty($typeid)) $typeid = 0;

if (!isset($do) && $do != '1' && $typeid == '0') 
{ 
    if(empty($typeid)) $typeid = 0;
    if(empty($maxpagesize)) $maxpagesize = 50;
    //ɸѡ��Ҫ���ɵ�TAGS    
    $sword = trim($sword);
    $stype = intval($stype);
    $addsql = '';
    if (!empty($sword)) {
        if ($stype == 0) {
            $addsql = " where `tag` like '%{$sword}%' ";
        } else {
            $addsql = " where `tag` like '{$sword}' ";
        }
    }
       
    $all_id = array();
    $new_id = array();
    
    $sql="select id,maketime from `#@__tagindex` {$addsql} order by tag desc"; 
    $dsql->Execute('al',$sql);
    while($row=$dsql->GetArray('al')){       
        if ($row['maketime'] == 0) {
            $new_id[] = $row['id'];
        } else {
            $sql="select a.senddate from #@__taglist l left join #@__archives a on l.aid=a.id  where a.arcrank<>-1 and l.tid=".$row['id']."  order by a.senddate desc"; 
            $row2=$dsql->GetOne($sql);
            if ($row2['senddate'] > $row['maketime']) {
                $new_id[] = $row['id'];
            }
        }
        $all_id[] = $row['id'];
    } 
    

    $all_total = count($all_id);
    $new_total = count($new_id);
    if (($all=='1' && $all_total == 0) || ($all=='0' && $new_total == 0)) {
         ShowMsg("û����Ҫ���ɾ�̬ҳ��TAG��ǩ��","javascript:;");
         exit();
    }
    
    $make_cache_file = DEDEDATA . '/maketag.cache.php';
    $fp = fopen($make_cache_file,"wb") or die("��ָ�����ļ��������⣬�޷������ļ�");
    flock($fp,3);
    fwrite($fp,"<"."?php\r\n");
    fwrite($fp,"\$all_ids = '".implode(',',$all_id)."';\r\n");
    fwrite($fp,"\$new_ids = '".implode(',',$new_id)."';\r\n");
	fclose($fp);  
    
    $task_total = $all == '0' ? $new_total : $all_total;
    $gourl = "makehtml_tag_action_list.php?typeid={$typeid}&all={$all}&maxpagesize={$maxpagesize}&do=1";
    ShowMsg("����TAG�б�ҳ���ɿ�ʼ����{$task_total}������",$gourl,0,100);    
    exit;
}
else //if ($typeid != '0' || (isset($do) && $do == '1'))
{  
    if(!isset($pageno)) $pageno = 0;
    if(!isset($mkpage)) $mkpage = 1;
    if(!isset($uppage)) $uppage = 0;
    if(empty($maxpagesize)) $maxpagesize = 50;

    $tag_basedir = trim($GLOBALS['cfg_tag_basedir'],'/\ ');
    $tag_basedir = empty($tag_basedir) ? 'tag' : $tag_basedir; 
    $tid = '';
        
    if ($typeid == 0) {
        require(DEDEDATA . '/maketag.cache.php');
        $all_id = explode(',',$all_ids);
        $new_id = explode(',',$new_ids);
        
        //ȷ��tid����Ҫ���ɵģ����ٲ���
        if ($all==0) {
            if (isset($new_id[$pageno])){
                $tid = $new_id[$pageno];
            } 
        } else {
            if (isset($all_id[$pageno])){
                $tid = $all_id[$pageno];
            } 
        }
        if (empty($tid)) {
            $reurl = "../../{$tag_basedir}/index.html"; 
            ShowMsg("�������TAG�б���£�<a href='$reurl' target='_blank'>���tag</a>","javascript:;");
            exit();
        }
    } 
    else {
        $tid = $typeid;
    }
    
    $reurl = '';
    if(!empty($tid))
    {   
        if ($typeid != '0' && $all == '0') {
            if (isset($more) && $more == 1) {
                $nic_make=true;
            } else {
                $sql="select `maketime` from #@__tagindex where id=".$tid; 
                $nic_row=$dsql->GetOne($sql);
                if ($nic_row["maketime"]==0) $nic_make=true;
                else{
                    //��ȡ��ID������һƪ���£��Ƚ�����ʱ��
                    $sql="select a.senddate from #@__taglist l left join #@__archives a on l.aid=a.id  where a.arcrank<>-1 and l.tid=".$tid."  order by a.senddate desc"; 
                    $nic_row2=$dsql->GetOne($sql);
                    if ($nic_row2["senddate"]>$nic_row["maketime"]) $nic_make=true;
                    else { 
                        $nic_make=false;
                        $finishType = true;
                    }                          
                }
            }
        } else {
            $nic_make=true;
        }       
        
        if ($nic_make) {
            require_once("arc.taghtml.class.php");	
            $lv = new TagListView($tid);
            $ntotalpage = isset($totals) ? $totals : $lv->CountRecord();//$lv->TotalPage;	
            //���TAG���ĵ�̫�࣬�ֶ����θ���
            //if($ntotalpage <= $maxpagesize || $lv->TypeLink->TypeInfos['ispart']!=0 || $lv->TypeLink->TypeInfos['isdefault']==-1)
            if($ntotalpage <= $maxpagesize)    
            {
                $reurl = $lv->MakeHtml();
                $finishType = true;
            }
            else
            {
                $reurl = $lv->MakeHtml($mkpage,$maxpagesize);
                $finishType = false;
                $mkpage = $mkpage + $maxpagesize;
                if( $mkpage >= ($ntotalpage+1) ) $finishType = true;
            }
            if ($finishType == true){
              //��¼��TAG�Ĵ˴�����ʱ�䣺
              $rec_sql="update #@__tagindex set maketime=".time()." where id=".$tid; 
              $dsql->Execute('rec',$rec_sql);
            }
        }

    }//!empty

    $nextpage = $pageno+1;

    if ($typeid != '0' && $finishType) {
        $tag_basedir = trim($GLOBALS['cfg_tag_basedir'],'/\ ');
        $tag_basedir = empty($tag_basedir) ? 'tag' : $tag_basedir; 
        $reurl = "../../{$tag_basedir}/index.html"; 
        ShowMsg("�������TAG�б���£�<a href='$reurl' target='_blank'>���tag</a>","javascript:;");
        exit();
    }

    if($finishType)
    {
        $gourl = "makehtml_tag_action_list.php?uppage=1&maxpagesize=$maxpagesize&typeid=$typeid&pageno=$nextpage&all=$all&do=1";
        
        ShowMsg("�ɹ�����TAG��".$tid."���������в�����",$gourl,0,100);
        exit();
    }
    else
    {
        $gourl = "makehtml_tag_action_list.php?uppage=1&mkpage=$mkpage&maxpagesize=$maxpagesize&typeid=$typeid&pageno=$pageno&all=$all&more=1&totals=$ntotalpage&do=1";
        ShowMsg("TAG��".$tid."���������в���...",$gourl,0,100);
        exit();
    }        
}
