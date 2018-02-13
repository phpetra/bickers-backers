<?php declare(strict_types=1);

namespace Leones\Sparql;

use EasyRdf_Sparql_Client;

class AdamLinkSparql {

    private $endpoint = 'https://api.data.adamlink.nl/datasets/AdamNet/all/services/endpoint/sparql';

    private $client;

    public function __construct()
    {
        $this->client = new EasyRdf_Sparql_Client($this->endpoint);
    }

    public function getPortraitsForPersonIdentifiedByWikiId(string $wikiId) : array
    {
        $result = $this->client->query("
        PREFIX schema: <http://schema.org/>
        PREFIX dc: <http://purl.org/dc/elements/1.1/>
        PREFIX void: <http://rdfs.org/ns/void#>
        PREFIX owl: <http://www.w3.org/2002/07/owl#>
        PREFIX wd: <http://www.wikidata.org/entity/>
        PREFIX foaf: <http://xmlns.com/foaf/0.1/>
        PREFIX edm: <http://www.europeana.eu/schemas/edm/> 
        SELECT ?url (SAMPLE(?image) AS ?img) (SAMPLE(?titel) AS ?title) WHERE {
        {
          ?url dc:subject wd:{$wikiId} .
          ?url foaf:depiction ?image .
          ?url dc:title ?titel .
        }
        UNION
        {
          ?url dc:subject ?person .
          ?person owl:sameAs wd:{$wikiId} .
          ?url foaf:depiction ?image .
          ?url dc:title ?titel .
        } 
        UNION
        {
          wd:{$wikiId} owl:sameAs ?RMperson .
          FILTER regex(?RMperson, \"RM0001\") . 
          SERVICE <http://rijksmuseum.sealinc.eculture.labs.vu.nl/sparql/>
          { ?cho dc:subject ?RMperson .
            ?cho dc:identifier ?url .    
            FILTER regex(?url, \"hdl.handle.net\") . 
            ?cho dc:title ?titel .
            ?aggregation edm:aggregatedCHO ?cho .
            ?aggregation edm:isShownBy ?image .
          }
        }  
        }
        GROUP BY ?url
         "
        );

        return $this->mapResults($result);
    }


    public function getPortraitsForPersonIdentifiedByWikiIdWithoutSlowRijksmuseum(string $wikiId) : array
    {
        $result = $this->client->query("
        PREFIX schema: <http://schema.org/>
        PREFIX dc: <http://purl.org/dc/elements/1.1/>
        PREFIX void: <http://rdfs.org/ns/void#>
        PREFIX owl: <http://www.w3.org/2002/07/owl#>
        PREFIX wd: <http://www.wikidata.org/entity/>
        PREFIX foaf: <http://xmlns.com/foaf/0.1/>
        PREFIX edm: <http://www.europeana.eu/schemas/edm/> 
        SELECT ?url (SAMPLE(?image) AS ?img) (SAMPLE(?titel) AS ?title) 
        WHERE 
        {
            {
              ?url dc:subject wd:{$wikiId} .
              ?url foaf:depiction ?image .
              ?url dc:title ?titel .
            }
            UNION
            {
              ?url dc:subject ?person .
              ?person owl:sameAs wd:{$wikiId} .
              ?url foaf:depiction ?image .
              ?url dc:title ?titel .
            } 
             
        }
        GROUP BY ?url
         "
        );

        return $this->mapResults($result);
    }

    public function getPortraitsForPersonIdentifiedByWikiIdVersion1(string $wikiId) : array
    {
        $result = $this->client->query("
        PREFIX schema: <http://schema.org/>
        PREFIX dc: <http://purl.org/dc/elements/1.1/>
        PREFIX void: <http://rdfs.org/ns/void#>
        PREFIX owl: <http://www.w3.org/2002/07/owl#>
        PREFIX wd: <http://www.wikidata.org/entity/>
        PREFIX foaf: <http://xmlns.com/foaf/0.1/>
        PREFIX edm: <http://www.europeana.eu/schemas/edm/> 
        SELECT ?url ?img WHERE {
        {
          ?url dc:subject wd:{$wikiId} .
          ?url dc:identifier ?id .
          ?url foaf:depiction ?img .
        }
        UNION
        {
          ?url dc:subject ?person .
          ?person owl:sameAs wd:{$wikiId} .
          ?url dc:identifier ?id .
          ?url foaf:depiction ?img .
        } 
        UNION
        {
          wd:{$wikiId} owl:sameAs ?RMperson .
          FILTER regex(?RMperson, \"RM0001\") . 
          SERVICE <http://rijksmuseum.sealinc.eculture.labs.vu.nl/sparql/>
          { ?cho dc:subject ?RMperson .
            ?cho dc:identifier ?url .
            FILTER regex(?url, \"hdl.handle.net\") . 
            ?aggregation edm:aggregatedCHO ?cho .
            ?aggregation edm:isShownBy ?img .
          }
        }  
        }
            "
        );

        $output = [];
        foreach ($result as $row) {
            $output[] = [
                'url' => (string) $row->url,
                'img' => (string) $row->img
            ];
        }
        return $output;
    }

    /**
     *
     * @param $result
     * @return array
     */
    private function mapResults($result): array
    {
        $output = [];
        foreach ($result as $row) {
            $output[] = [
                'url'   => (string)$row->url,
                'img'   => (string)$row->img,
                'title' => (string)$row->title,
            ];
        }

        return $output;
    }

}