{if $facebook_url}
<script type="text/javascript">
fb_iframe = "<iframe src='http://www.facebook.com/plugins/like.php?href={ldelim}{$facebook_url}{rdelim}' scrolling='no' frameborder='0' style='border:none; width:450px; height:80px'></iframe>";
document.write(fb_iframe);
</script>
{else}
<script type="text/javascript">
fb_iframe = "<iframe src='http://www.facebook.com/plugins/like.php?href="+window.location.href+"' scrolling='no' frameborder='0' style='border:none; width:450px; height:80px'></iframe>";
document.write(fb_iframe);
</script>
{/if}


