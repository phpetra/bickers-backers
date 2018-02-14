<?php
// VERY simple implementation of an API

use Leones\Sparql\AdamLinkSparql;

require __DIR__ . '/vendor/autoload.php';

$wikiId = $_GET['uri'] ?? 'Q434290'; // Andries Bicker

/** @var AdamLinkSparql $sparqler */
$sparqler = new AdamLinkSparql();
$data = [
    //'records' => $sparqler->getPortraitsForPersonIdentifiedByWikiIdWithoutSlowRijksmuseum($wikiId)
    'records' => $sparqler->getPortraitsForPersonIdentifiedByWikiId($wikiId)
];

header('Content-Type: application/json');
print json_encode($data);
