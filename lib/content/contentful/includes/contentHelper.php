<?php
/**
 * This class contains helpers for the Contentful API. 
 */
class ContentHelper {

    private $api = null;
    private $app;
    private $preview;
    public $linkResolver;

    public function __construct($app){
        $this->app = $app;
        $this->preview = (isset($_GET) && isset($_GET["env"])) ? true : false;
        $this->token = (isset($_GET) && isset($_GET["env"])) ? CONTENT_PREVIEW : CONTENT_TOKEN;
        $this->defaultLanguage = "en-US";
        $this->currentLanguage = (isset($_GET) && isset($_GET["lang"])) ? $_GET["lang"] : substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 5);
    }

    public function get_api(){
        
        $container = $this->app->getContainer();
        $url = CONTENT_URL;
        $options = \Contentful\Delivery\ClientOptions::create();
        $fileTime = 0;
        $localeFile = FILE_CACHE . "locales.json";

        /* --- Grab locale reference --- */
        if(file_exists($localeFile)){

            $fileTime = filemtime($localeFile);
            $supportedLanguages = json_decode(file_get_contents($localeFile));
        }

        /* --- Set our language --- */
        $setLanguage = (isset($supportedLanguages) && in_array($this->currentLanguage, $supportedLanguages)) ? $this->currentLanguage : $this->defaultLanguage;
        $options->withDefaultLocale($setLanguage);

        if($this->preview === true){
            $options->usingPreviewApi();
        }

        if($this->api == null){
            $this->api = new \Contentful\Delivery\Client($this->token, $url, "master", $options);
        }

        /* --- Let's get our locales and setup a cache --- */
        if(!file_exists($localeFile) || time() - $fileTime > 24 * 3600){

            $environment = $this->api->getEnvironment();
            $locales = $environment->getLocales();
            $supportedLanguages = array();

            foreach($locales as $locale){

                $code = $locale->getCode();

                if(!file_exists(FILE_CACHE . "content/" . strtolower($code) . "/")){
                    mkdir(FILE_CACHE . "content/" . strtolower($code) . "/", 775);
                    chmod(FILE_CACHE . "content/" . strtolower($code) . "/", 0775);
                }

                array_push($supportedLanguages, $code);
            }

            /* --- Cache if not empty --- */
            if(!empty($supportedLanguages)){

                /* --- Write Cache file --- */
                file_put_contents($localeFile, json_encode($supportedLanguages));
                chmod($localeFile, 0664);
            }
        }

        return $this->api;
    }

    public function returnLocales(){

        $localeFile = FILE_CACHE . "locales.json";
        $supportedLanguages = array();

        /* --- Grab locale reference --- */
        if(file_exists($localeFile)){
            $supportedLanguages = json_decode(file_get_contents($localeFile));
        }

        return $supportedLanguages;
    }
}
?>