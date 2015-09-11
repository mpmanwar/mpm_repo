<div class="select_con1">
	<div class="selec_seclf2">
	    <span class="slct_con"><strong>Average Deal Age : </strong></span>
	    <div style="width: 25%!important; margin:6px 0 0 5px; float:left;"><input type="text" value="{{ $avg_age }}" style="width:40px; height:25px; padding:5px" id="avg_age"></div>
	</div>
	<div class="selec_seclf3" >
        <span class="slct_con"><strong>conversion rate : </strong></span>
        <div style="width: 25%!important; margin:6px 0 0 5px; float:left;"><input type="text" value="{{ $converson_rate }}" style="width:40px; height:25px; padding:5px" id="converson_rate"></div>
  	</div>
  	<div class="clr"></div>
</div>

<table class="table table-bordered" style="margin-top:20px;">

<tr>
<td align="left" >
<table class="" width="100%" >
<tr>
	<td width="25%" align="left">Deal Owner </td>
	<td width="30%" align="left">Prospect Name</td>
	<td width="15%" align="left">Date</td>
	<td width="10%" align="left">Age</td>
	<td width="10%" align="left">Status</td>
	<td width="10%" align="left">Amount</td>
</tr>
</table>
</td>
</tr>

<tr>
<td align="left">
<table width="100%" >
<tr>
<td width="100%" align="left">
	<table width="100%" align="left">
@if(isset($details) && count($details) >0)
	@foreach($details as $key=>$value)
		<tr>
			<td width="25%" align="left">{{ $value['deal_owner_fname'] or "" }} {{ $value['deal_owner_lname'] or "" }}</td>
			<td width="30%" align="left">{{ $value['prospect_name'] or "" }}</td>
			<td width="15%" align="left">{{ $value['date'] or "" }}</td>
			<td width="10%" align="left">{{ $value['age'] or "" }}</td>
			<td width="10%" align="left">{{ $value['tab_name'] or "" }}</td>
			<td width="10%" align="left">{{ $value['quoted_value'] or "" }}</td>
		</tr>
	@endforeach
@endif


	 
	</table>

</td>
</tr>
</table>
</td>
</tr>





<tr>
<td align="center">
<table width="100%" align="center" >
<tr>
<td width="20%" align="center">&nbsp;</td>
<td width="80%" align="center">
<table width="100%">
<tr>
<td width="25%" align="center">&nbsp;</td>
<td width="15%" align="center">&nbsp;</td>
<td width="40%" align="center">&nbsp;</td>
<td width="20%" align="left"><b>Total&nbsp;:&nbsp; {{ $total_amount }} </b> </td>


</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>


 <tr>
<td align="center">
<table width="100%" align="center" >
<tr>
<td width="20%" align="center">&nbsp;</td>
<td width="80%" align="center">
<table width="100%">
<tr>
<td width="25%" align="center">&nbsp;</td>
<td width="15%" align="center">&nbsp;</td>
<td width="30%" align="center">&nbsp;</td>
<td width="25%" align="left"><b>Grand Total&nbsp;:&nbsp; {{ $total_amount }}</b> </td>


</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
