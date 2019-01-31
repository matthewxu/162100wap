<?php
$num=array();
$num[0]=array(array(0,1,1,0),array(1,0,0,1),array(1,0,0,1),array(1,0,0,1),array(1,0,0,1),array(1,0,0,1),array(0,1,1,0));
$num[1]=array(array(0,0,1,0),array(0,1,1,0),array(0,0,1,0),array(0,0,1,0),array(0,0,1,0),array(0,0,1,0),array(0,0,1,0));
$num[2]=array(array(0,1,1,0),array(1,0,0,1),array(0,0,0,1),array(0,0,1,0),array(0,1,0,0),array(1,0,0,0),array(1,1,1,1));
$num[3]=array(array(0,1,1,0),array(1,0,0,1),array(0,0,0,1),array(0,0,1,0),array(0,0,0,1),array(1,0,0,1),array(0,1,1,0));
$num[4]=array(array(0,0,1,0),array(0,1,1,0),array(1,0,1,0),array(1,0,1,0),array(1,1,1,1),array(0,0,1,0),array(0,0,1,0));
$num[5]=array(array(1,1,1,1),array(1,0,0,0),array(1,0,0,0),array(1,1,1,0),array(0,0,0,1),array(0,0,0,1),array(1,1,1,0));
$num[6]=array(array(0,1,1,1),array(1,0,0,0),array(1,0,0,0),array(1,1,1,0),array(1,0,0,1),array(1,0,0,1),array(0,1,1,0));
$num[7]=array(array(1,1,1,1),array(1,0,0,1),array(0,0,0,1),array(0,0,1,0),array(0,0,1,0),array(0,0,1,0),array(0,0,1,0));
$num[8]=array(array(0,1,1,0),array(1,0,0,1),array(1,0,0,1),array(0,1,1,0),array(1,0,0,1),array(1,0,0,1),array(0,1,1,0));
$num[9]=array(array(0,1,1,0),array(1,0,0,1),array(1,0,0,1),array(0,1,1,1),array(0,0,0,1),array(0,0,0,1),array(0,1,1,0));

$color=array();
//前景色
$color[0]='AB0123456789';
//背景色
$color[1]='CDEF';

//取色函数
function getColor($str) {
  $rand = '#';
  $n = strlen($str) - 1;
  for ($i = 0; $i < 6; $i++) {
    $rand .= $str[mt_rand(0, $n)];
  }
  return $rand;
}



//单独数字阵营函数
function get_chk_numbercode($num_arr){
  global $color;
  $cf=mt_rand(0, 10)%2;
  $cb=$cf==0?1:0;
  $text='<div class="imtable_162100">';
  for($i=-1;$i<8;$i++){
    for($j=-1;$j<5;$j++){
      if($i==-1 || $i==7 || $j==-1 || $j==4){
        $text.='<div style="background-color:'.getColor($color[$cb]).'">&nbsp;</div>';
      }else{
        $text.='<div style="background-color:'.($num_arr[$i][$j] == 1 ? getColor($color[$cf]) : getColor($color[$cb])).'">&nbsp;</div>';
      }
    }
  }
  $text.='</div>';
  return $text;
}

//生成全部数字阵营函数
  $step=4; //位数
  $numC=(string)mt_rand(str_pad(1,$step,0), str_pad(9,$step,9));
  $n=strlen($numC);
  $imcode='<style type="text/css">
<!--
#imtable_162100_bg { width:75px; height:18px; float:left; /* vertical-align:middle; display:inline-block !important; display:inline; zoom:1;*/ overflow:hidden; }
.imtable_162100 { float:left; display:inline; /*display:inline-block !important; display:inline; zoom:1;*/ width:12px; height:18px; font-size:1px; line-height:1px; overflow:hidden; }
.imtable_162100 div { float:left; width:2px; height:2px; font-size:1px; padding:0; overflow:hidden; }
-->
</style>
<div id="imtable_162100_bg">';
  for($i=0;$i<$n;$i++){
    $imcode.=get_chk_numbercode($num[$numC[$i]]);
  }
  $imcode.='</div>';
  //生成cookie
  setcookie('regimcode', $numC, 0);



?>