<?php
/**
 * Routing
 *	- These serve in the order they're set and
 *	  the order matters
 */

/* --- Check if Content is enabled --- */
if(isset($BUILDINFO->lib->content_management)){
	/* --- /preview/ --- */
	include __DIR__ . "/routes/route-preview.php";
}

/* --- Index Routes --- */
include __DIR__ . "/routes/route-index.php";

/* --- Webhook Routes --- */
include __DIR__ . "/routes/route-webhooks.php";

/* --- API Endpoint Routes --- */
include __DIR__ . "/routes/route-endpoints.php";

/* --- / --- */
include __DIR__ . "/routes/route-home.php";


/* --- Does this project support a blog? --- */
if(defined("BLOG_ENABLED") && BLOG_ENABLED === true){

	/* --- /category/post/ --- */
	include __DIR__ . "/routes/route-blog.php";
}

/* --- Custom Routes --- */
include __DIR__ . "/routes/route-custom.php";

/* --- Catch All Routes --- */
include __DIR__ . "/routes/route-default.php";
?>
