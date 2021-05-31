		</div>
	</main>
	<footer data-smooth id="footer">
		<?php include(views_dir() . "/parts/footer-content.php"); ?>
	</footer>
	<?php include(views_dir() . "/parts/global-scope.php"); ?>
</div>
<!-- Deferred CSS -->
<script type="text/javascript">
var stylesheet = document.createElement("link");
stylesheet.href = "<?php echo $ASSETPATH; ?>main.css?v=<?php echo $BUILDINFO->date; ?>";
stylesheet.rel = "stylesheet";
stylesheet.type = "text/css";
document.getElementsByTagName("head")[0].appendChild(stylesheet);
</script>
<script type="text/javascript" src="<?php echo $ASSETPATH; ?>main.js?v=<?php echo $BUILDINFO->date; ?>" defer></script>
</body>