		<script src="<?php echo $pathToRoot ?>js/vendor/jquery.js" type="text/javascript" language="javascript"></script>
		<script src="<?php echo $pathToRoot ?>js/foundation.min.js" type="text/javascript" language="javascript"></script>
		<script>
		    $(document).foundation();
		</script>
	</body>
</html>
<?php
	global $lokaldb;
	$lokaldb->close();
?>