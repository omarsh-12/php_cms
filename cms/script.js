var div_box="<div id='load-screen'><div id='loading'></div></div>";
$("body").prepend(div_box);
$("#load-screan").delay(700).fadeOut(600,function () {
   $(this.remove());
});