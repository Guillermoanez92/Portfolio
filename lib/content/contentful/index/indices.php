<?php
/**
 * Storefront Indices definition
 */
class ContentIndex implements ContentIndices {

	public function indexContent($data){

		global $CONTENT;

		/**
		 * Make sure shopify products cache folders exist
		 */
		$cache = FILE_CACHE . "content/";

		if(!file_exists($cache)){
			mkdir($cache, 775);
			chmod($cache, 0775);
		}

		/* --- Reference --- */
		$reference = file_exists(FILE_CACHE . "documents.json") ? json_decode(file_get_contents(FILE_CACHE . "documents.json")) : new stdClass();

		/* --- Do nothing if no UID --- */
		if(empty($data->fields) || empty($data->fields->uid) || empty($data->fields->uid->{"en-US"})) return;

		/* --- Run index --- */
		$filename = base64_encode($data->fields->uid->{"en-US"});
		$contentObject = new stdClass();

		/* --- Normalize --- */
		$contentObject->id = $data->sys->id;
		$contentObject->type = $data->sys->contentType->sys->id;
		$contentObject->uid = $data->fields->uid->{"en-US"};
		$contentObject->first_publication_date = $data->sys->createdAt;
		$contentObject->last_publication_date = $data->sys->updatedAt;
		$contentObject->data = $CONTENT->local->normalizeLinks($data->fields);

		/* --- Write Cache file --- */
		file_put_contents(FILE_CACHE . "content/es-us/" . $filename, json_encode($contentObject));
		chmod(FILE_CACHE . "content/es-us/" . $filename, 0664);

		/* --- Write Reference --- */
		file_put_contents(FILE_CACHE . "documents.json", json_encode($contentReference));
		chmod(FILE_CACHE . "documents.json", 0664);

		/* --- Store Sitemap Raw --- */
		file_put_contents(FILE_CACHE . "sitemap.json", json_encode($sitemap_json));
		chmod(FILE_CACHE . "sitemap.json", 0664);

		/* --- Fire Parallel cURL --- */
		$blankObj = new stdClass();
		execRequest(PROTOCOL . HOST . "/server/sitemap.php", json_encode($blankObj));
	}
}
?>