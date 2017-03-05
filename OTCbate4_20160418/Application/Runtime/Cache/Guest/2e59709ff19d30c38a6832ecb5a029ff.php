<?php if (!defined('THINK_PATH')) exit();?><style>
*{line-height:15px;}
</style>
<p style="font-size:16px;text-align:center;font-weight:bold"></p>
<table border="1" cellspacing="0" cellpadding="2"> 

	<tr >
		<td colspan="4"  >基础资产基本信息</td> 
	</tr>
	<tr>
		<td width="20%">债务人姓名（名称）：</td>
		<td width="80%" colspan="3"><?php echo $zcount==1?$data['z_borrower']:"详见清单"?></td> 
	</tr> 
	<tr>
		<td>证件号码：</td>
		<td colspan="3"><?php echo $zcount==1?$data['z_cod_card_no']:"详见清单"?></td> 
	</tr> 
	<tr>
		<td>借款总额：</td>
		<td colspan="3"><?php echo $zcount==1?($data['z_amt_cf_inv_price']."元"):"详见清单"?></td> 
	</tr> 
	<tr>
		<td>借款期限：</td>
		<td colspan="3"><?php echo $zcount==1?($data['z_period']."个月"):"详见清单"?></td> 
	</tr> 
	<tr >
		<td colspan="4" >转让债权基本信息</td> 
	</tr>
	<tr>
		<td width="20%">转让人</td>
		<td width="30%">LP</td>
		<td width="20%">受让人</td>
		<td width="30%"><?php echo ($data["k_nam_cust_real"]); ?></td>
	</tr>
	<tr>
		<td>转让债权本金：</td>
		<td>
		人民币<span style="color:white">空</span>：<?php echo $data['amt_int_total']?>元<br/>
		（大写）：<?php echo cny($data['amt_int_total'])?>整</td>
		<td>预期年化收益率：<br/>（利息收益）</td>
		<td><?php echo ($data["rat_cf_inv_min"]); ?>%</td>
	</tr> 
	
	<tr>
		<td>转让起始日：</td>
		<td><?php echo $startday=date("Y-m-d",strtotime($data['dat_modify']))?></td>
		<td>转让到期日：</td>
		<td><?php  $amt_time = $data['amt_time']?>
		<?php echo date("Y-m-d",strtotime("+ ".$amt_time." month - 1 day",strtotime($startday)))?></td>
	</tr>
	<tr>
		<td>收益转付日<br/>（到期日）</td>
		<td colspan="3">
		备注： 
		<br/>1. 上述币种均指人民币；
		<br/>2. 转让起始日：受让人投资购买成功<br/>（以信息服务方平台发送的确认数据为准）。
		<br/>3. 本清单所指年度为365个自然日；
		<br/>4. 本要素表为《债权资产权益转让协议》不可或缺的一部分，与《债权资产权益转让协议》具有同等效力；
		<br/>5. 预期年化收益率仅为收益计算方便而设，并不代表转让方、信息服务方或其他任何第三方对收益的承诺或保证。

		</td> 
	</tr>
</table> 


<?php if($zcount>1){?>
<br/>
<p>债券清单：</p>
<br/>
<table border="1" cellspacing="0" cellpadding="2"> 
<tr>
	<td>债务人姓名（名称）</td>
	<td>证件号码</td>
	<td>借款总额</td>
	<td>借款期限</td>
</tr>
	<?php foreach($ivsData as $k=>$v){?>
	<tr>
		<td ><?php echo $v['z_borrower']?></td> 
		<td ><?php echo $v['z_cod_card_no']?></td> 
		<td ><?php echo ($v['z_amt_cf_inv_price']."元")?></td> 
		<td ><?php echo ($v['z_period']."个月")?></td> 
	</tr>
	<?php }?>

</table> 
<?php }?>