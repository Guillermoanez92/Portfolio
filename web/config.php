<?php
/****************************************************
 * This is the configuration file,
 * the only necessary Prismic change is the repository
 * URL, other changes are optional
 ****************************************************/

/*
 * Change this for the URL of your repository
 */

/* --- Prismic --- */
define("CONTENT_URL", "https://guille.cdn.prismic.io/api/v2");
define("CONTENT_TOKEN", "MC5ZTFZneWhBQUFDWUF6aVRm.MzYk77-9BiYQTQhA77-9e15Z77-9Ee-_ve-_vXzvv71bWe-_vWMxfEfvv73vv71DVkU");

/*
 * Webhook Secret
 *  - Generate a 32-bit string for this
 *	- go here: https://randomkeygen.com/
 *  - scroll down to "CodeIgniter Encryption Keys", select one
 *  - make sure to add secret to the webhook on prismic
 */
define("CONTENT_WEBHOOK_SECRET", "7e399a601d90edf3cdb743c7a0d50e15");

/*
 * Your site metadata
 */
define("SITE_TITLE", "CMS starter solution");
define("SITE_DESCRIPTION", "");

/*
 * Enable / Disable Blog Template structure
 */
define("BLOG_ENABLED", false);

/*
 * Set to true to display error details
 */
define("DISPLAY_ERROR_DETAILS", true);

/*
 * Cache Settings
 */
define("ENABLE_CACHE", true);
define("FILE_CACHE", __DIR__ . "/cache/");

/*
 * Make Cache Folder
 */
if(!file_exists(FILE_CACHE)){
	mkdir(FILE_CACHE, 775);
	chmod(FILE_CACHE, 0775);
}

/*
 * Protocols
 */
$protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" || $_SERVER["SERVER_PORT"] == 443) ? "https://" : "http://";
define("PROTOCOL", $protocol);
define("HOST", $_SERVER["HTTP_HOST"]);
define("URI", $_SERVER["REQUEST_URI"]);
define("SITE_DOMAIN", PROTOCOL . HOST);

/*
 * Site Salt
 *  - Generate a 32-bit string for this
 *	- go here: https://randomkeygen.com/
 *  - scroll down to "CodeIgniter Encryption Keys", select one
 */
define("SALT", "IHFvQwxTXo6xvZU4mzsYS89wEfga34PT");

