<div class="footer">
	<div class="best_view">
	</div>
	<div class="footer_logo">
	</div>
	<div class="footer_logo2" style="display:none;">
	</div>
	<!--
	<div class="copyright">
	</div>
	-->
</div>
<script>
	$(".footer_logo").mouseover( function() {
	    $(this).removeClass();
	    $(this).addClass("footer_logo2");
	});
	$(".footer_logo").mouseout( function() {
	    $(this).removeClass();
	    $(this).addClass("footer_logo");
	});
	$(".footer_logo").click( function() {
	    window.open("http://parspake.com");
	});
</script>