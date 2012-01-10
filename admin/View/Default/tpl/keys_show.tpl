<div class="content">
  <div class="synonyms">
    <br />
    <h3 align="center">SYNONYMS</h3>
    <br />
    <div class="left floater">  
      <form class="findclassifications" method="post" action="{$view}">
        <div>
          <label for="keyword"> Keyword</label>
          <select name="keyword" id="keyword">
            {foreach from=$keywords item=key}
              {if $selectedKeyword eq $key.keyword}
                <option selected="1">{$key.keyword}</option>		  
			    {else}
    			  <option>{$key.keyword}</option>
              {/if}		
	        {/foreach}
	      </select>  
        </div>
	    <div class="buttons">
          <input type="submit" value="Find Classifications">
	    </div>
      </form>	
  
      <div class="keywordoutput">  
	    <ul class="synonym_output">	  
          {foreach from=$classiByKeyword item=classi}
            <li>{$classi.localclassification_name}</li>
          {/foreach}
		</ul>
      </div>
    </div>	
  
    <div class="right floater">
      <form class="findkeywords" method="post" action="{$view}">  
        <div>
          <label for="classification"> Classification</label>
          <select name="classification" id="classification">
            {foreach from=$classifications item=key}
              {if $selectedClassification eq $key.localclassification_id}
                <option selected="1" value="{$key.localclassification_id}">{$key.localclassification_name}</option>			
	            {else}
                  <option value="{$key.localclassification_id}">{$key.localclassification_name}</option>
              {/if}				
	        {/foreach}
          </select>  
        </div>  
	    <div class="buttons">
          <input type="submit" value="Find Keywords">
	    </div>	
      </form	
  
      <div class="classificationoutput">  
	    <ul class="synonym_output">
          {foreach from=$keywordByClassi item=keyword}
            <li>{if $isAdmin} <a href="#" onmouseover="toolTip('DELETE {$keyword.keyword}', 250)"  onmouseout="toolTip()" onmousedown="del('{$keyword.keyword}', '{$delete}&ID={$keyword.id}')"> <font color="red"><b>X</b></font></a> &nbsp;{/if} {$keyword.keyword}</li>
          {/foreach}
		</ul>
      </div>  
	</div>
  </div>  
</div>
{literal}
<script language="javascript">
// Delete Confirmation
function del(keyword, val)
{
	var answer = confirm  ("Are you sure you want to delete the keyword " + keyword + "?");
	if (answer)
	 window.location.href=val;
	else
		{;}

}
function editList(ID)
{
	document.getElementById("C_"+ID).removeAttribute("readonly");
	document.getElementById("B_"+ID).innerHTML="save";
	document.getElementById("A_"+ID).setAttribute("onclick", "saveList("+ID+")");
	document.getElementById("C_"+ID).setAttribute("class", "editinput");	
}
function saveList(ID)
{
    SaveKeys(ID, $F('C_'+ID));
	document.getElementById("C_"+ID).setAttribute("readonly", "true");
	document.getElementById("B_"+ID).innerHTML="edit";
	document.getElementById("A_"+ID).setAttribute("onclick", "editList("+ID+")");
	document.getElementById("C_"+ID).setAttribute("class", "saveinput");
}
</script>
{/literal}
