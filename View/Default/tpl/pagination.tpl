{if $paging}
<div class='Paginator'>
{if $paging.start>1 }
	<a href='{$paging.url}/pnum/1/fr/0'>First</a>
{/if}
{if $paging.fr>1 }
	<a href='{$paging.url}/pnum/{$smarty.get.pnum-1}/fr/{$paging.pre}'>Prev</a>
{/if}
{section name=foo start=$paging.start loop=$paging.end step=1}

{assign var="temp" value="`$smarty.section.foo.index-1`"}
{assign var="p_size" value="`$paging.pagingSize`"}
{assign var="p_no" value="`$p_size*$temp`"}

    {if $paging.fr != $p_no}
		<a href='{$paging.url}/pnum/{$smarty.section.foo.index}/fr/{$p_no}'>{$smarty.section.foo.index}</a>
    {else}
		<span class='this-page'>{$smarty.section.foo.index}</span>
    {/if}
    
{/section}
{if $paging.fr-$paging.diff < $paging.last }
    <a href='{$paging.url}/pnum/{$smarty.get.pnum+1}/fr/{$paging.next}'>Next</a>
{/if}
{if $paging.end <= $paging.totalPages-1 }
    <a href='{$paging.url}/pnum/{$paging.totalPages}/fr/{$paging.last}'>Last</a>
{/if}
</div>
{/if}