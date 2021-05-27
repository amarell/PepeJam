<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/api/clients/CDNClient.class.php';

$client = new CDNClient();
/*
$url = $client->upload("teslabinaryyoink.mp3",base64_encode(file_get_contents('C:\Users\Intel\Downloads\song.mp3')));

print_r($url);die;

echo '<audio controls="controls" autobuffer="autobuffer" autoplay="autoplay">
        <source src="https://fra1.digitaloceanspaces.com/cdn.pepejam/teslabinaryyoink.mp3" />
      </audio>'; die;
*/
/*
use Aws\S3\S3Client;



$client = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'fra1',
    'endpoint' => 'https://fra1.digitaloceanspaces.com',
    'credentials' => [
        'key'    => "",
        'secret' => "",
    ],
]);



$spaces = $client->listBuckets();
foreach($spaces['Buckets'] as $space){
  echo $space['Name']."\n";
}




$content = file_get_contents('C:\Users\Intel\Downloads\song.mp3');



echo '<audio controls="controls" autobuffer="autobuffer" autoplay="autoplay">
        <source src="data:audio/wav;base64, '.base64_encode($content).'" />
      </audio>';





$response = $client->putObject([
    'Bucket' => 'cdn.pepejam',
    'Key'    => 'Capsize.mp3',
    'Body'   => $content,
    //'ACL'    => 'public-read'
]);


echo '<audio controls="controls" autobuffer="autobuffer" autoplay="autoplay">
        <source src="https://fra1.digitaloceanspaces.com/cdn.pepejam/Capsize.mp3" />
      </audio>'; die;
*/



?>
