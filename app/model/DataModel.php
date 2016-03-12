<?php
/**
 * Created by PhpStorm.
 * User: Gena
 * Date: 07.02.2016
 * Time: 11:38
 */

namespace app\model;


use Nette\Object;


class DataModel extends Object
{

    public function __construct()
    {
    }

    public function search($search){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => 'http://api.themoviedb.org/3/search/multi?query='.$search.'&api_key=6983b1d914369f1fcc8b56b90ce9e2cc',
        ));

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));

        $output = curl_exec($curl);
        curl_close($curl);

        $results = json_decode($output);

        $return['movie'] = array();
        $return['tv'] = array();

        foreach($results->results as $key=>$result){
            if($result->media_type == 'movie'){
                $result->overview = substr($result->overview,0,180)."...";
                array_push($return['movie'], $result);
            }elseif($result->media_type == 'tv'){
                $result->overview = substr($result->overview,0,180)."...";
                array_push($return['tv'], $result);
            }
        }

        if(empty($return['tv']) AND empty($return['tv'])){
            return null;
        }else{
            return $return;
        }
        return $return;


    }

    public function lucky(){

        $curl = curl_init();
        $id = 561;
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => 'http://api.themoviedb.org/3/tv/id='.$id.'&api_key=6983b1d914369f1fcc8b56b90ce9e2cc',
        ));

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));

        $output = curl_exec($curl);
        curl_close($curl);

        $results = json_decode($output);


        return $return;


    }



    public function discover(){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => 'http://api.themoviedb.org/3/search/multi?query=&api_key=6983b1d914369f1fcc8b56b90ce9e2cc',
        ));

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));

        $output = curl_exec($curl);
        curl_close($curl);

        $results = json_decode($output);
        $results = $results->results;

        return $results;
    }

}