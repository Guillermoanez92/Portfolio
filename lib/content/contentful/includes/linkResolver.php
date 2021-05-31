<?php
use Contentful\RichText\NodeRenderer\NodeRendererInterface;
use Contentful\RichText\Node\AssetHyperlink;
use Contentful\RichText\Node\EntryHyperlink;
use Contentful\RichText\Node\Hyperlink;
use Contentful\RichText\Node\NodeInterface;
use Contentful\RichText\RendererInterface;

class EntryLinkHandler implements NodeRendererInterface {

	public function __construct(){}

	public function supports(NodeInterface $node): bool {
		return (!$node instanceof EntryHyperlink) ? false : true;
	}

	public function render(RendererInterface $renderer, NodeInterface $node, array $context = []): string {

		$entry = $node->getEntry();
		$type = $entry->getContentType()->getId();

		$slug = "/" . $entry->getUid() . "/";

		switch($type){

			case "home":

				$slug = "/";

				break;

			case "product_categories":

				$slug = "/products" . $slug;

				break;

			/* --- Passthroughs --- */
			case "page":

				break;

			default:

				$slug = "/" . $type . $slug;

				break;
		}

		return \sprintf("<a href='%s'>%s</a>", $slug, $renderer->renderCollection($node->getContent()));
	}
}

class ExternalLinkHandler implements NodeRendererInterface {

	public function __construct(){}

	public function supports(NodeInterface $node): bool {
		return (!$node instanceof Hyperlink) ? false : true;
	}

	public function render(RendererInterface $renderer, NodeInterface $node, array $context = []): string {

		$url = $node->getUri();
		$string = "<a href='%s' target='_blank' rel='noopener'>%s</a>";

		/* --- Whoops, this is on our domain --- */
		if(strpos($url, "domain.com") !== false){

			/* --- Make these links relative --- */
			$url = str_replace("https://staging.domain.com", "", $url);
			$url = str_replace("https://www.domain.com", "", $url);
			$url = str_replace("https://domain.com", "", $url);

			$string = "<a href='%s'>%s</a>";
		}

		return \sprintf($string, $url, $renderer->renderCollection($node->getContent()));
	}
}

class AssetLinkHandler implements NodeRendererInterface {

	public function __construct(){}

	public function supports(NodeInterface $node): bool {
		return (!$node instanceof AssetHyperlink) ? false : true;
	}

	public function render(RendererInterface $renderer, NodeInterface $node, array $context = []): string {

		$asset = $node->getAsset();
		$file = $asset->getFile()->getUrl();

		return \sprintf("<a href='%s' target='_blank' rel='noopener'>%s</a>", $file, $renderer->renderCollection($node->getContent()));
	}
}
?>