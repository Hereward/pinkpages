{literal}
<script type="text/javascript" src="../Js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// Example word content CSS (should be your site CSS) this one removes paragraph margins
	content_css : "css/word.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});
</script>
{/literal}
<div class="content">
<h3 align="left" class="h4reversed">Edit Content Page</h3>
<form action="{$action}={$values2[0].id}" method="post">
<ul class="textfieldlist">
<li>
   <label>Metadescription: </label>
<input type="text" name="metadescription" value="{$values2[0].meta_description}" />
</li>

<input type="hidden" name="ID" value="{$values2[0].id}" />

<li>
   <label>Metatag:</label>
<input type="text" name="metatag" value="{$values2[0].meta_tag}" />
</li>
<li>
   <label>Title-Tag:</label>
<input type="text" name="title-tag" value="{$values2[0].title_tag}" />
</li>
<li>
   <label>Page-Title:</label>
<input type="text" name="page-title" value="{$values2[0].page_title}" />
</li>
<li>
   <label>Page Url:<font color="#FF0000">*</font></label>
{$SITE_PATH}<input type="text" name="peramlink" value="{$values2[0].peramlink}" />
</li>
<li>
   <label>pagecontent:<font color="#FF0000">*</font></label></li>
<textarea id="pagecontent" name="pagecontent" rows="15" cols="80" style="width: 80%" >{$values2[0].page_content}</textarea> 
<ul><br /></ul>
 <ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Save" class="controlgrey"  />
<a href="{$cancel}" style="text-decoration:none"><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a>
</div>
</ul>
</form>
</div>