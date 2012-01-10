<div class='Paginator'>
{if $paging.fr>1 }
	<a href='{$paging.url}&fr={$paging.pre}'>Prev</a>
{/if}
{section name=foo start=$paging.start loop=$paging.end step=1}

{assign var="temp" value="`$smarty.section.foo.index-1`"}
{assign var="p_size" value="`$paging.pagingSize`"}
{assign var="p_no" value="`$p_size*$temp`"}

    {if $paging.fr != $p_no}
		<a href='{$paging.url}&fr={$p_no}'>{$smarty.section.foo.index}</a>
    {else}
		<span class='this-page'>{$smarty.section.foo.index}</span>
    {/if}
    
{/section}

{if $paging.fr < $paging.totalRecords-$paging.pagingSize }
    <a href='{$paging.url}&fr={$paging.next}'>Next</a>
{/if}
</div>