jQuery(document).ready(function() {
	jQuery("input:[type=text], input:[type=password]").focus(function () {
		jQuery(this).addClass("highLightInput");	
	});
	jQuery("input:[type=text], input:[type=password]").blur(function () {
		jQuery(this).removeClass("highLightInput");
	});
});