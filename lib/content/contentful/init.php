<?php
require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/includes/contentHelper.php";
require_once __DIR__ . "/includes/linkResolver.php";

/**
 * Storefront Core definition
 */
class Content implements ContentCore {

	/**
	 * Start our content connection
	 */
	public function initFramework(){

		global $GLOBAL;
		global $CONTENT;

		$CONTENT->framework = new ContentHelper($GLOBAL->app);
		$CONTENT->client = $CONTENT->framework->get_api();
		$CONTENT->locales = $CONTENT->framework->returnLocales();
		$CONTENT->linkResolver = new Contentful\Delivery\LinkResolver($CONTENT->client, $CONTENT->client->getResourcePool());
		$CONTENT->parser = new Contentful\RichText\Parser($CONTENT->linkResolver);

		/* --- Richtext Renderer --- */
		$CONTENT->richtext = new Contentful\RichText\Renderer();
		$CONTENT->richtext->pushNodeRenderer(new AssetLinkHandler());
		$CONTENT->richtext->pushNodeRenderer(new EntryLinkHandler());
		$CONTENT->richtext->pushNodeRenderer(new ExternalLinkHandler());
		$CONTENT->richtext->appendNodeRenderer(new Contentful\RichText\NodeRenderer\CatchAll());
	}

	/**
	 * Start our content connection
	 */
	public function previewHandler($request){

		global $CONTENT;

		$token = $request->getParam("token");
		$url = $CONTENT->framework->get_api()->previewSession($token, $CONTENT->framework->linkResolver, "/");

		/* --- Store Token In Cookie --- */
		setcookie(Prismic\PREVIEW_COOKIE, $token, time() + 1800, "/", null, false, false);

		return $url;
	}

	/**
	 * get content
	 */
	public function getContent($uid, $type){

		global $CONTENT;

		/* --- Set our language folder for content --- */
		$defaultLanguage = "en-US";
        $currentLanguage = (isset($_GET) && isset($_GET["lang"])) ? $_GET["lang"] : substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 5);
        $setLanguage = ($defaultLanguage !== $currentLanguage && in_array($currentLanguage, $CONTENT->locales)) ? $currentLanguage : $defaultLanguage;

		/* --- Make Sure Cache Exists --- */
		$cache = FILE_CACHE . "content/" . strtolower($setLanguage) . "/";
		$filename = base64_encode($uid);

		if(file_exists(FILE_CACHE . "documents.json")){
			$reference = json_decode(file_get_contents(FILE_CACHE . "documents.json"));
		}

		/* --- No Reference? No Problem --- */
		if(!isset($reference)){
			$contentReference = new stdClass();
		} else {
			$contentReference = $reference;
		}

		/* --- Check for cached file --- */
		$fileExists = file_exists($cache . $filename);
		$fileTime = ($fileExists) ? filemtime($cache . $filename) : null;
		
		/* --- Length of time to backup cache --- */
		$hours = 24;

		/* --- Check for cached file or expired file--- */
		if($CONTENT->client->isPreviewApi() || !$fileExists || $fileExists && time() - $fileTime > $hours * 3600){

			/* --- Connect our API --- */
			$query = new \Contentful\Delivery\Query;
			$query->setContentType($type);
			$query->where("fields.uid", $uid);

			try {

				$entries = $CONTENT->client->getEntries($query);

				/* --- Normalize Document --- */
				$normalize = json_decode(json_encode($entries[0]));

				$document = new stdClass();
				$document->id = $normalize->sys->id;
				$document->type = $normalize->sys->contentType->sys->id;
				$document->uid = $normalize->fields->uid;
				$document->first_publication_date = $normalize->sys->createdAt;
				$document->last_publication_date = $normalize->sys->updatedAt;
				$document->data = self::normalizeLinks($normalize->fields);

				if(defined("ENABLE_CACHE") && ENABLE_CACHE === true && $CONTENT->client->isDeliveryApi()){

					$filename = base64_encode($document->uid);

					/* --- Write Cache file --- */
					file_put_contents($cache . $filename, json_encode($document));
					chmod($cache . $filename, 0664);
				}

			} catch(\Contentful\Core\Exception\NotFoundException $exception){
				error_log($exception->getMessage());
			}

		} else {
			$document = json_decode(file_get_contents($cache . $filename));
		}

		return $document;
	}

	/**
	 * normalize our linked content
	 */
	public function normalizeLinks($object){

		global $CONTENT;

		if(empty($object)) return $object;

		/* --- Start our loop --- */
		foreach($object as $key => $field){

			switch(gettype($field)){

				case "object":

					/* --- Richtext field --- */
					if(isset($field->content)){

						/* --- Convert this to associative array --- */
						$fields = json_decode(json_encode($field->content), true);
						$nodes = $CONTENT->parser->parseCollection($fields);
						$object->{$key} = $CONTENT->richtext->renderCollection($nodes);
					}

					/* --- File Link --- */
					if(isset($field->sys) && isset($field->sys->linkType) && $field->sys->linkType == "Asset"){

						$asset = $CONTENT->client->getAsset($field->sys->id);

						$object->{$key} = new stdClass();
						$object->{$key}->url = $asset->getFile()->getUrl();
						$object->{$key}->title = $asset->getTitle();
						$object->{$key}->description = $asset->getDescription();
					}

					if(isset($field->sys) && isset($field->sys->linkType) && $field->sys->linkType == "Entry"){

						$entry = $CONTENT->client->getEntry($field->sys->id);

						$normalize = json_decode(json_encode($entry));

						$document = new stdClass();
						$document->id = $normalize->sys->id;
						$document->type = $normalize->sys->contentType->sys->id;
						$document->uid = $normalize->fields->uid;

						$object->{$key} = $document;
					}

					break;

				case "array":

					foreach($field as $index => $item){

						if(isset($item->sys) && isset($item->sys->linkType) && $item->sys->linkType == "Asset"){

							$asset = $CONTENT->client->getAsset($item->sys->id);

							$object->{$key}[$index] = new stdClass();
							$object->{$key}[$index]->url = $asset->getFile()->getUrl();
							$object->{$key}[$index]->title = $asset->getTitle();
							$object->{$key}[$index]->description = $asset->getDescription();
						}

						if(isset($item->sys) && isset($item->sys->linkType) && $item->sys->linkType == "Entry"){

							$entry = $CONTENT->client->getEntry($item->sys->id);

							$normalize = json_decode(json_encode($entry));

							$document = new stdClass();
							$document->id = $normalize->sys->id;
							$document->type = $normalize->sys->contentType->sys->id;
							$document->uid = $normalize->fields->uid;

							$object->{$key}[$index] = $document;
						}
					}

					break;

				default:
					break;
			}
		}

		return $object;
	}
}
?>