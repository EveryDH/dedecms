<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>自定义TAG管理</title>

<link href="css/base.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function get_yjczid() {
	var hobbies = document.getElementsByClassName('yjczid');
	var yjczid='';
	for (var index = 0; index < hobbies.length; index++) {
	 if (hobbies[index].checked) {
	     checkedValue = hobbies[index].value;
	     yjczid+=hobbies[index].value + ","
	 }
	}
	location = "diy_tags.php?action=yjcz&yjczid="+yjczid;
	}
function checkall(form, prefix, checkall)
{
  var checkall = checkall ? checkall : 'all';
  for(var i = 0; i < form.elements.length; i++)
  {
    var e = form.elements[i];
    if(e.name && e.name != checkall && (!prefix || (prefix && e.name.match(prefix))))
    {
      e.checked = form.elements[checkall].checked;
    }
  }
}
function DeleteOne(d_id)
{
  location = "diy_tags.php?action=delete&ids="+d_id;
}
function Reset(d_id)
{
  location = "diy_tags.php?action=reset&czid="+d_id;
}
</script>

 <style>
      select{
   
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
   }
   textarea {
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
   div#sz {
    text-align: center;
}
   .xuanze{
   width:100%;
     display:block;
     text-align: center;
   }
   .btn{
    padding: 6px 12px  !important;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    color: #fff;
   background: #5cb85c !important;
    border-color: #4cae4c !important;
   }
    .btns{
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    color: #fff;
    line-height: 20px;
   background: #5cb85c !important;
    border-color: #4cae4c !important;
   }
    .a_case{
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    color: #171b16 !important;
    /* line-height: 20px; */
    padding: 3px 5px;
    margin-right: 10px;
    background: #f0faeb !important;
    border-color: #333 !important;
    display: inline-block;
    margin: 3px;
   }
   .pagelistbox a,.pagelistbox span,.pagelistbox strong {
 
    border: 1px solid transparent;
    border-radius: 4px;
    color: #fff;
    line-height: 20px;
    background: #5cb85c !important;
    border-color: #4cae4c !important;
    padding: 5px 10px !important;
}
.pagelistbox strong{
	background: #638ede !important;
    border-color: #638ede !important;
}
span.indexPage,a.indexPage {
    margin: 5px;
}
   .btn:hover{
   color: #fff;
    background: #449d44  !important;
    border-color: #398439  !important;
   }
   .a_case:hover{
	color: #fff !important;
    background: #449d44  !important;
    border-color: #398439  !important;
   }
   .a_cases{
	color: #fff !important;
    background: #449d44  !important;
    border-color: #398439  !important;
   }
    .btns:hover{
   color: #fff;
    background: #449d44  !important;
    border-color: #398439  !important;
   }
   form{margin-bottom:166px !important;}

   .num_span b{
   		color: red;
   }
  </style>
</head>
<body>
<div class="bodytitle">
  <div class="bodytitleleft"></div>
  <div class="bodytitletxt" id="bodytitletxt" style="padding-left:10px;">
  	<input type="button" class="coolbg np btns" onclick="javascript:location='diy_tags.php';" value="自定义添加Tag管理">&nbsp;
  <input type="button" class="coolbg np btns" onclick="javascript:location='diy_tags.php?type=tagsx';" value="Tag已超过循环次数">
  </div>
</div>
<div class="main">
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#CFCFCF;">
    <tr>
      <td height="auto" colspan="7" background="images/wbg.gif" style="background-size:100% 100%;">
          <div>
          	<strong>自定义添加tag维护</strong>&nbsp;剩余数量：
                  
                <?php
              $dsql->SetQuery("Select id,typename From `#@__arctype`");
              $dsql->Execute();
              while($trow = $dsql->GetObject())
              {
              $tag_name[$trow->id].=$trow->typename;
              }
                foreach($tag_name as $k=>$v){
                $row_id=$dsql->GetOne("SELECT COUNT(typeid) FROM #@__arctype as a left join #@__diy_tags d on a.id = d.typeid and d.number<'$cfg_tags_maxnumber' where typename='$v'");
                if($k==$flid) $a_cases="a_cases";
                else $a_cases="";
                echo "<a class='a_case ".$a_cases."' href='diy_tags.php?type=checkid&flid=".$k."'>".$v."<b style='color:red'>(".$row_id["COUNT(typeid)"].")</b></a>";
               }
              
               
            ?> 
                  
                </div>
      </td>
    </tr>
    <tr align="center" bgcolor="#FBFCE2" height="26">
        <td width="5%">删</td>
        <td width="25%">Tag名称</td>
      <td width="15%">添加时间</td>
      <td width="15%">分类id</td>
      <td width="15%">上次使用时间</td>
      <td width="15%">已循环次数</td>
      <td>操作</td>
    </tr>
  <form name='form3' action="diy_tags.php?action=delete" method="post">
    <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align="center" bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
        <td height="24">
          <input type="checkbox" name="ids[]" value="<?php echo $fields['d_id']; ?>" class='np yjczid' />
        </td>
        <td>
          <?php echo $fields['title']; ?>
        </td>
        <td>
          <?php echo GetDateMK($fields['addtime']); ?>
        </td>
        <td>
          <?php echo $fields['typename']; ?>
        </td>
        <td>
          <?php echo GetDateMK($fields['daytime']); ?>
        </td>
        <td>
          <?php echo $fields['number']; ?>
        </td>
        <td>
          <?php if($fields['number']>=$cfg_tags_maxnumber){echo "<a href='javascript:Reset({$fields['d_id']});'>[重置]</a>";} ?>
          <a href="diy_tags.php?action=diy_tags_save&ids=<?php echo $fields['d_id']; ?>">[修改]</a>
          <a href="javascript:DeleteOne(<?php echo $fields['d_id']; ?>);">[删]</a>
        </td>
    </tr>
    <?php
}
}?>
    <tr bgcolor="#F0FBBD">
      <td align="center" bgcolor="#F8FEE0"  height="28">
        <label>
          <input type="checkbox" onclick="checkall(this.form, 'ids')" name="all" class="np" class='yjczid' />
          <br />全选
        </label>
      </td>
      <td height="28" colspan="7" align="center" bgcolor="#F8FEE0" >
        <?php
$atts = array();
$atts['tagname'] = 'pagelist';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>

        </td>
    </tr>
  </form>
  <tr align="center" bgcolor="#FAFDF0">
    <td height="40" colspan="7">
      <input type='button' onclick="document.form3.submit()" class="np coolbg btns" value='删除所选' />
      <?php if($type=='tagsx') echo '<input type="button" onclick="get_yjczid()" class="np coolbg btns yjcz" value="一键重置" \/>'; ?>
    </td>
  </tr>
  <form name='form1' action="diy_tags.php?action=updateid" method="post">
    <table width="98%" border="0" cellspacing="1" align="center" class="tbtitle">
      <div id="sz">
      <select name='yuanid' id='typeid' style='width:100px;margin: 10px 10px 0px 20px;'>
        <?php
        
              $dsql->SetQuery("Select id,typename From `#@__arctype`");
              $dsql->Execute();
              while($trow = $dsql->GetObject())
              {
          
          echo  "<option name='typeid' value='{$trow->id}'>{$trow->typename}</option>";
              }
        ?>  
          </select>
          <span>原</span>
          
          <select name='typeid' id='typeid' style='width:100px;margin: 10px 10px 0px 20px;'>
        <?php

              $dsql->SetQuery("Select id,typename From `#@__arctype`");
              $dsql->Execute();
              while($trow = $dsql->GetObject())
              {
          
          echo  "<option name='typeid' value='{$trow->id}'>{$trow->typename}</option>";
              }
        ?>  
          </select>
          <span style="padding: 0px 10px;">改</span>
      <input name="submit" type="submit" value="一键修改分类ID" class="np coolbg btn" />
     </div>
    </table>
  </form>
  <form name='form1' action="diy_tags.php?action=addto" method="post" style="margin-bottom:6px;">
    <table width="98%" border="0" cellspacing="1" align="center" class="tbtitle" style="padding-top:50px;">
      
      <tr>
          <td height="30" align="center" bgcolor="#Ffffff" >
          	<span class="num_span">字数:<b id="num">0</b>行数:<b id="num2">0</b></span>
            <textarea style="width:700px;height:150px;" name="title" id="tests"></textarea>
            <select name='typeid' id='typeid' style='width:150px'>
            <?php

                  $dsql->SetQuery("Select id,typename From `#@__arctype`");
                  $dsql->Execute();
                  while($trow = $dsql->GetObject())
                  {
              
              echo  "<option name='typeid' value='{$trow->id}'>{$trow->typename}</option>";
                  }
                ?>
                  
              </select>
          &nbsp;
          <input name="submit" type="submit" value="添加" class="np coolbg btn" />
        </td>
      </tr>
    </table>
  </form>
</table>
</div>
<script>
	// 计算行数 obj1,obj2为ID
	function calc(obj1,obj2){
   	obj1.innerText = obj2.value.split("\n").length;
	}

	// 计算字数
	function countnumbers(obj,countId){
	var maxLen = 0; //初始字数
	if (obj.value.length >= maxLen){ 
	countId.innerText =(obj.value.length);//计算字数
		}
	}	


	function cal_words(){
	  var length = document.getElementById("tests").value.length;
	  document.getElementById("num").innerHTML = length;
	}


	function countLines(ele) {
	 var styles = window.getComputedStyle(ele, null);
	 var lh = parseInt(styles.lineHeight, 10);
	 var h = parseInt(styles.height, 10);
	 var lc = Math.round(h / lh);
	 console.log('line count:', lc, 'line-height:', lh, 'height:', h);
	 return lc;
	}
	// var cons=document.getElementById("cons");
	var num=document.getElementById("num");
	var num2=document.getElementById("num2");
	var cnt = document.getElementById("tests");


	cnt.onkeyup=cnt.onkeydown=function(){
		// alert(123);
		if(cnt.value==''){
			num2.innerHTML='0';
		}else{
			calc(num2,cnt);
		}
			countnumbers(this,num);
	}
</script>
</body>
</html>