<?php   if(!defined('DEDEINC')) exit('Request Error!');
require_once(DEDEINC.'/arc.partview.class.php');
function lib_city(&$ctag,&$refObj)
{
    $typeid=$refObj->TypeID;
    global $dsql,$envs,$cfg_basehost,$py,$position,$cid,$makehtml;
    //³ÇÊĞ¸¸ID $cid
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $innertext = trim($ctag->GetInnerText());
    $row = $ctag->GetAtt('row');
    $type=$ctag->GetAtt('type');
    $orderby=$ctag->GetAtt('orderby');
    $sys=$dsql->getone("select * from #@__fenzhan");
    $ctp = new DedeTagParse();
    $ctp->SetNameSpace('field', '[', ']');
    $sql = "Select * From `#@__district` ";
    $urltype=$sys['urltype'];
    if($type=='son'){
        $sql.=" where pid=$cid ";
    }elseif($type=='all'){

    }
    else{
        $sql.=" where pid=$typeid ";
    }
    if($orderby=='rand'){
        $sql.=" order by rand()";
    }
    if(is_numeric($row) && $row>0){
        $sql.=" limit 0,$row";
    }
    $dsql->Execute('me',$sql);
    while($rs = $dsql->GetArray('me'))
    {
        $rs['title']=$rs['district'];

        if($urltype=='1'){
            $rs['arcurl']=$sys['position'].$rs['name'].".html";
        }else{
            $rs['arcurl']=$sys['position'].$rs['name']."/";
        }
        if($makehtml=='m'){
            $rs['arcurl']=$cfg_basehost.'/m'.$rs['arcurl'];
        }else{
            $rs['arcurl']=$cfg_basehost.$rs['arcurl'];
        }
        $ctp->LoadSource($innertext);
        foreach($ctp->CTags as $tagid=>$ctag) {
            if(!empty($rs[strtolower($ctag->GetName())])) {
                $ctp->Assign($tagid,$rs[$ctag->GetName()]);
            }
        }
    $revalue .= $ctp->GetResult();
    }
    return $revalue;
}
