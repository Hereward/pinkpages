{literal}
<script language="javascript">
function goURL() {
	var to_date = document.getElementById('to_date').value;
	var do_ = document.getElementById('do').value;
//	var action = document.getElementById('action').value;
	var action = 'report';
	var business_id = document.getElementById('business_id').value;
	var duration = document.getElementById('period').value;
	var page_size = document.getElementById('page_size').value;
	var url = 'main.php?do='+do_+'&action='+action+'&to_date='+to_date+'&business_id='+business_id+'&period=' + duration + '&page_size=' + page_size;
	window.location = url;
}
</script>
{/literal}
<div class="content">
	<input type="hidden" id="do" name="do" value="{$do}" />
	<input type="hidden" id="action" name="action" value="{$action}" />
	<input type="hidden" id="business_id" name="business_id" value="{$business_id}" />
	<input type="hidden" id="to_date" name="to_date" value="{$to_date}" />
	
	<table width="100%" border="0">
	<tr>
	<td align="center">
	<div>
		Results per page
		<select id="page_size" width="50">
			<option {if $page_size eq '10'}selected{/if} value="10">10</option>
			<option {if $page_size eq '25'}selected{/if} value="25">25</option>
			<option {if $page_size eq '50'}selected{/if} value="50">50</option>
			<option {if $page_size eq '100'}selected{/if} value="100">100</option>
		</select>
		<select id="period">
			<option {if $period eq 'Daily'}selected{/if} value="Daily">Daily</option>
			<option {if $period eq 'Weekly'}selected{/if} value="Weekly">Weekly</option>
			<option {if $period eq 'Monthly'}selected{/if} value="Monthly">Monthly</option>
			<option {if $period eq 'Yearly'}selected{/if} value="Yearly">Yearly</option>
		</select>
		<input type="button" value="Refresh" onclick="javascript:goURL();">
	</div>
	</td>
	</tr>
	</table>
	<h3 align="left">Business Listings Report ( {$business_name} )</h3>
	<h6 align="right" style="padding-right:30px;"><a href="{$reportMail}&to_date={$to_date}&business_id={$business_id}&period={$period}&page_size={$page_size}">Send  an email to client</a></h6>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="datatable">

		<tr><td height="4"></td></tr>
		<tr>
			<td width="100%" align="center">
				<div align="center"> {include file="pagination.tpl"}</div>
			</td>
		</tr>
		<tr><td height="4"></td></tr>
		<tr>
			<td width="100%" align="center">
				<table id="inbox_table" width="90%" style="" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="h4reversed">Date</th>
						{if $period eq 'Daily'}
						<td class="h4reversed">Day</th>
						{/if}
						<td class="h4reversed">View Count</th>
					</tr>
					{foreach from=$all_data_arr key=span item=data }
					<tr class="{cycle values="odd,"}">
						<td align="left" nowrap>{$span}</td>
						{if $period eq 'Daily'}
						<td align="left">{$data.day}</td>
						{/if}
						<td align="left">{$data.views}</td>
					</tr>
					{/foreach}
				</table>
			</td>
		</tr>
		<tr><td height="4"></td></tr>
	
		<tr>
			<td width="100%" align="center">
				<div align="center"> {include file="pagination.tpl"}</div>
			</td>
		</tr>
	</table>
</div>