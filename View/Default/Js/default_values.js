/*
var active_color = '#000'; // Colour of user provided text
var inactive_color = '#ccc'; // Colour of default text

$(document).ready(function() {
  $("input#Search2").css("color", inactive_color);
  var default_values = new Array();
  $("input#Search2").focus(function() {
    if (!default_values[this.id]) {
      default_values[this.id] = this.value;
    }
    if (this.value == default_values[this.id]) {
      this.value = '';
      this.style.color = active_color;
    }
    $(this).blur(function() {
      if (this.value == '') {
        this.style.color = inactive_color;
        this.value = default_values[this.id];
      }
    });
  });
});
*/


/*

$(document).ready(function() {
$(function() {
	$("#Search1", "#Search2").watermark(this.value, {className: 'watermark'});
	$("#Search1Focus").click(function() {
		$("#Search1")[0].focus();
	});

	$("#Search2Focus").click(function() {
		$("#Search2")[0].focus();
	});
});
}

*/

/*
$(document).ready(function() {
  $(function() {
	$("#Search1").watermark("boing");
	$("#Search1Focus").click(function() {
		$("#Search1")[0].focus();
	});
  });
}
*/
//$('#Search1').watermark('Required information');







