<?php if (!defined('THINK_PATH')) exit();?><style type='text/css'>
*,h2,h3,body{padding:0;margin:0;}

</style>

<body>
<h2>日期：<?=date('Y-m-d');?></h2>
<p>尊敬的资邦财盈贵宾 &nbsp;<b>程慧丽</b> &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
<b>女士/先生</b> 您好：</p>
<p>感谢您选择资邦财富公司的服务，您目前出借的款项所产生的收益情况如下:(货币单位:人民币元整)</p>
 
<table border="1px" cellspacing="0" cellpadding="2">
<?php if(is_array($data)): $i = 0; $__LIST__ = array_slice($data,$times,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
<td width="13%">报告周期</td>
<td colspan="9" align="center"><?php echo ($vo["zhouqistartday"]); ?>至<?php echo ($vo["zhouqiendday"]); ?></td>
</tr>
	<tr>
		<td width="13%">出借编号</td>
		<td >资金出借及回收方式</td>	
		<td width="11%">出借日期</td>	
		<td width="12%">到期日/封闭期结束日</td>	
		<td width="11%">初始出借金额</td>	
		<td width="8%">本次报告期数</td>	
		<td width="11%">截至本报告期末资产总值</td>	
		<td>出借预期年化收益</td>	
		<td>本期现金派息额</td>	
		<td width="7%">每月出账单报告日</td>
	</tr>

	<tr>
		<td width="13%"><?php echo ($ivsData["0"]["otc_code"]); ?></td>
		<td><?php echo ($ivsData["0"]["periodname"]); ?></td>	
		<td width="11%"><?php echo ($data["1"]["zhouqistartday"]); ?></td>	
		<td width="12%"><?=end($data)['zhouqiendday'];?></td>	
		<td width="11%"><?php echo ($vo["touzibenjin"]); ?></td>
		<td width="8%"><?php echo ($vo["touziyuefen"]); ?></td>	 
		<td width="11%"><?php echo ($vo["benxiheji"]); ?></td>
		<td><?php echo ($vo["zlilv"]); ?></td>	
		<td><?php echo ($vo["dangyueshouyi"]); ?></td>	
		<td width="7%"><?php echo ($vo["reportday"]); ?></td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>

</table>
	
<p>
温馨提示：资邦财富竭诚为您提供高效优质的服务，有任何问题请联系我们为您专门指定的客户经理，或请致电4006780088【资邦财富贵宾服务部】</p>



<p align="right">
见证人：资邦（上海）投资咨询有限公司</p>
<p align="right">
盖章：&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
</p>

<p>&nbsp;&nbsp;</p>
<p>&nbsp;&nbsp;</p>
<p>&nbsp;&nbsp;</p>

<p vertical-algin='middle'>
	<img src="cnb.jpg" alt="财富热线:4006780088"/>

</p>
<p align="right" > <b><font color="red">全国免费咨询热线：4006780088</font></b>  </p>
   </body>