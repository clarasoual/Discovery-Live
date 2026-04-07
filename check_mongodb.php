<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->discovery_live->contacts;

$documents = $collection->find();

foreach ($documents as $doc) {
    echo "<pre>";
    print_r($doc);
    echo "</pre>";
}
?>