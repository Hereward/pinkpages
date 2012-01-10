<div class="navigation">
<ul class="navbar">
    <li><a href="#"><b>Refine Your Search</b></a></li>
    <li><a href="#">Looking for</a>
     <ul class="submenu">
	 {section name=i loop=$refineDisplay}
        	<li><a href="main.php?do=Listing&action=keyCategorySearch&Search1={$searchValue1}&Search2={$searchValue2}&clasId={$refineDisplay[i].localclassification_id}&SearchOption={$SearchOption}">{$refineDisplay[i].localclassification_name} ({$refineDisplay[i].cnt})</a></li>
	 {/section}
      </ul>
      
    
    </li>
    <li>
    <a href="#">Sort By</a>
    	
        <ul class="submenu">
        	<li><input name="sortby" type="radio" value="Details" onclick="{$detail_search}" {if $sortby eq 'Details'} checked="checked"{/if} /><label>Details</label></li>
            <li><input name="sortby" type="radio" value="Name" onclick="{$detail_search}" {if $sortby eq 'Name'} checked="checked"{/if} /><label>Name</label></li>
            <li><input name="sortby" type="radio" value="Distance" onclick="{$detail_search}" {if $sortby eq 'Distance'} checked="checked"{/if}/><label>Distance from me</label></li>
        </ul>
      
    </li>  
      
      
       <li>
    <a href="#">Refine By location</a>
    	
          <ul class="submenu">
        	<li><b>states</b></li>
            <li> <label><select name="" onchange="{$state_change}">
			<option>Select one</option>
			{section name=i loop=$locationRes}
			<option value="{$locationRes[i].localstate_id}__{$locationRes[i].localstate_name}" {if $state eq $locationRes[i].localstate_id} selected="selected"{/if}>{$locationRes[i].localstate_name}</option>
			  {/section}
            </select></label></li>
            
            <li><b>Shire Name</b></li>
            <li> <label><select name="" size="1" onchange="{$region_change}">
			<option>Select one</option>
			{section name=i loop=$shirenameRes}
              <option value="{$shirenameRes[i].shirename_id}__{$shirenameRes[i].shirename_shirename}" {if $shirename eq $shirenameRes[i].shirename_id} selected="selected"{/if}>{$shirenameRes[i].shirename_shirename}</option>
			  {/section}
            </select></label></li>
            
            <li><b>Shire Town</b></li>
            <li> <label><select name="" size="1" onchange="{$suburb_change}">
			<option>Select one</option>
			{section name=i loop=$shiretown}
              <option value="{$shiretown[i].shiretown_id}__{$shiretown[i].shiretown_townname}" {if $shiretownval eq $shiretown[i].shiretown_id} selected="selected"{/if}>{$shiretown[i].shiretown_townname}</option>
			  {/section}
            </select></label></li>
         </ul>
      
      </li>  
      
        
         <li>
    <a href="#">Include Businesses</a>
    	
        <ul class="submenu">
        	<li><input name="checkbox1" type="checkbox" value="checkbox1" /><label>Servicing the area (2) </label></li>
          <li><input name="checkbox1" type="checkbox" value="checkbox1" /><label>In nearby area (2)</label></li>
            
        </ul>
      
      </li>  
      
      
       <li>
    <a href="#">Refine By</a>
    	
        <ul class="submenu">
        	<li><b>Cuisine</b></li>
            <li> <label><select name="" size="1">
              <option>All Cuisine</option>
            </select></label></li>
            
            <li><b>Meal</b></li>
            <li> <label><select name="" size="1">
              <option>All Meal</option>
            </select></label></li>
            
            <li><b>Hour of operation</b></li>
          <li> <label><select name="" size="1">
              <option>All 24 Hours</option>
          </select></label></li>
            
            <li><b>Facility</b></li>
            <li> <label><select name="" size="1">
              <option>All Facility</option>
            </select></label></li>
            
             <li><b>Function</b></li>
            <li> <label><select name="" size="1">
              <option>Function</option>
            </select></label></li>
            <li><label> <input type="button" value="Search" />
            </label></li>
         </ul>
      
    </li>  
   
    
</ul>

           
            
            
</div>