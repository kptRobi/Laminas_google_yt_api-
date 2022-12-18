<?php

namespace Maps\Model;

use Laminas\Db\Adapter as DbAdapter;
use Laminas\Db\Sql\Sql;
use Laminas\Http\Client;
use Laminas\Json\Json;

class Lokalizacje implements DbAdapter\AdapterAwareInterface
{
    use DbAdapter\AdapterAwareTrait;

    public function pobierzLokalizacje(){
        $dbAdapter = $this->adapter;
        $sql = new Sql($dbAdapter);
        $select = $sql->select();
        $select->from('lokalizacje');
        $selectString = $sql->buildSqlString($select);
        return $dbAdapter->query($selectString, $dbAdapter::QUERY_MODE_EXECUTE);
    }

    public function dodaj($dane){
        $coords = $this->geokoduj($dane->adres);
        if($coords["status"] == "NOK"){
            return "NOK";
        }
        $dbAdapter = $this->adapter;
        $sql = new Sql($dbAdapter);
        $insert = $sql->insert('lokalizacje');
        $insert->values([
            "dlugosc"=>$coords["lng"],
            "szerokosc"=>$coords["lat"],
            "adres"=>$dane->adres,
            "opis"=>$dane->opis,
        ]);
        $insertString = $sql->buildSqlString($insert);
        return $dbAdapter->query($insertString, $dbAdapter::QUERY_MODE_EXECUTE);
    }

    public function geokoduj($adres){
        $adres = urlencode($adres);
        $client = new Client("https://maps.googleapis.com/maps/api/geocode/json?address=$adres&key=AIzaSyApBAwOqKsC5Je6Po90hTulOqadeHsQnBI");
        $client->setHeaders(['Accept-Encoding' => 'identity']);
        $response = $client->send();
        $json = Json::decode($response->getBody());
        if($json->status != "OK"){
            return(["status" => "NOK"]);
        }
        $lat = $json->results[0]->geometry->location->lat;
        $lng = $json->results[0]->geometry->location->lng;
        return(["lat" => $lat, "lng" => $lng, "status" => "OK"]);
    }

}