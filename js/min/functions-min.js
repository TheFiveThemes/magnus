function bigImageClass(){$(".entry-content img.size-full").each(function(){var a=$(this),t=$(this).closest("figure"),s=new Image;s.src=a.attr("src"),$(s).load(function(){var e=s.width;e>=1088&&$(a).addClass("size-big"),t.hasClass("wp-caption")&&e>=1088&&(t.addClass("caption-big"),t.removeAttr("style"))})})}$(document).ready(function(){$("#fullpage").fullpage()});