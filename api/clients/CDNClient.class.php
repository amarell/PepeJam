<?php

require_once dirname(__FILE__).'/../config.php';
require_once dirname(__FILE__).'/../../vendor/autoload.php';


use Aws\S3\S3Client;

class CDNClient {
  private $client;
  public function __construct()
  {
    $this->client = new Aws\S3\S3Client([
        'version' => 'latest',
        'region'  => Config::CDN_REGION(),
        'endpoint' => Config::CDN_BASE_URL(),
        'credentials' => [
            'key'    => Config::CDN_KEY(),
            'secret' => Config::CDN_SECRET()
        ],
    ]);
  }

  /**
  * Upload file to CDN and return URL back
  * @param filename - the name of the file
  * @param content - base64 encoded file content
  */
  public function upload($filename, $content){
    $response = $this->client->putObject([
        'Bucket' => Config::CDN_SPACE(),
        'Key'    => $filename,
        'Body'   => base64_decode($content),
        'ACL'    => 'public-read'
    ]);

    return $response->get("ObjectURL");
  }
}

?>
