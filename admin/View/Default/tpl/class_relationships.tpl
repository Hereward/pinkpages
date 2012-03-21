
<div class="content">
<h3><center><b>Export Classification Relationships</b></center></h3>
<br />
<form action="{$export_class_relationships_action}" id="" name="export_class_relationships" method="post" onsubmit="return validate();">
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

		<tr>
		 <td colspan="2" align="center"><input type="submit" value="Generate Data" class="controlgrey" ></td>
		</tr>
</table>
</form>

</div>

{literal}
<script language="javascript">
function validate()
{
	return true;
}