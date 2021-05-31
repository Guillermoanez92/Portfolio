<!DOCTYPE html>
<html class="no-js" lang="en">
<?php
global $GLOBAL;
global $PAGE;

/* ----- Namespace ----- */
$namespace = $PAGE["namespace"];

/* ----- Page Title ----- */
if(isset($PAGE["title"])){
	$title = ucwords($PAGE["title"]) . " | " . SITE_TITLE;
} else if(isset($PAGE["document"]->data->title) && $PAGE["document"]->data->title !== "Home" && $PAGE["document"]->data->title !== "Products" && $PAGE["document"]->data->title !== "Collections"){
	$title = ucwords($PAGE["document"]->data->title) . " | " . SITE_TITLE;
} else if($namespace == "account"){
	$title = "Account" . " | " . SITE_TITLE;
} else {
	$title = SITE_TITLE;
}

/* --- Alt Title --- */
if(isset($PAGE["document"]->data->meta_title) && $PAGE["document"]->data->meta_title !== ""){
	$title = ucwords($PAGE["document"]->data->meta_title) . " | " . SITE_TITLE;
}

/* ----- Description ----- */
if(isset($PAGE["description"]) && $PAGE["description"] != ""){
	$description = $PAGE["description"];
} else if(isset($PAGE["document"]->data->meta_description)){
	$description = $PAGE["document"]->data->meta_description;
} else {
	$description = SITE_DESCRIPTION;
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $title; ?></title>
<style type="text/css"><?php $file = file_get_contents(FILE_CACHE . "../site/assets/code/_init.css"); echo $file; ?></style>
<noscript><link rel="stylesheet" href="<?php echo $ASSETPATH; ?>main.css?v=<?php echo $BUILDINFO->date; ?>" type="text/css" media="all" /></noscript>

<?php include(views_dir() . "/parts/site/site-meta.php"); ?>
<?php include(views_dir() . "/parts/site/site-prefetch.php"); ?>
<?php include(views_dir() . "/parts/site/site-scripts.php"); ?>
</head>
<body>
	<div id="global-mask"></div>
  	<div id="container">
      <div id="vh-measure-el"></div>
      <header id="header">
        <a id="skip-to-content" href="#main">Skip to Content</a>
        <?php include(views_dir() . "/parts/main-navigation.php"); ?>
        <?php include(views_dir() . "/parts/utility-navigation.php"); ?>
      </header>
      <?php include(views_dir() . "/parts/mobile-navigation.php"); ?>
      <main id="main" data-router-wrapper>
			  <div class="view-<?php echo $namespace; ?>" data-router-view="<?php echo $namespace; ?>">
