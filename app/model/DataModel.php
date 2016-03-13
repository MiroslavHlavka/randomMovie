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

    private function curl($url){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => $url,
        ));

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));

        $output = curl_exec($curl);
        curl_close($curl);

        return json_decode($output);

    }

    public function search($search, $page){

        $query = 'http://api.themoviedb.org/3/search/movie?query='.$search.'&page='.$page.'&api_key=6983b1d914369f1fcc8b56b90ce9e2cc';
        $results = $this->curl($query);

        foreach($results->results as $key=>$result){
            if(strlen($result->overview) > 180) {
                $result->overview = substr($result->overview, 0, 180) . "...";
            }

            $year = explode('-',$result->release_date);
            $result->release_date = $year[0];

        }

        return $results;


    }

    public function lucky(){

        $valid = false;

        $result = null;
        while($valid == false){

            $id = rand(1,30000);
            $query = 'http://api.themoviedb.org/3/movie/'.$id.'?api_key=6983b1d914369f1fcc8b56b90ce9e2cc';
            $result = $this->curl($query);

            if(!isset($result->status_code)){
                break;
            }
        }

        if(strlen($result->overview) > 180) {
            $result->overview = substr($result->overview, 0, 180) . "...";
        }

        $year = explode('-',$result->release_date);
        $result->release_date = $year[0];

        return $result;


    }



    public function discover(array $genres, $year, $sort, $page=1){
        $genreBuilder = '';
        $yearBuilder = '';
        foreach($genres as $genre){
            if ($genre === end($genres)){
                $genreBuilder .= $genre;
            }else{
                $genreBuilder .= $genre.',';
            }

        }

        if($year != null){
            $yearBuilder = '&primary_release_year='.$year;
        }

        $query = 'http://api.themoviedb.org/3/discover/movie?with_genres='.$genreBuilder.''.$yearBuilder.'&sort_by='.$sort.'&page='.$page.'&api_key=6983b1d914369f1fcc8b56b90ce9e2cc';
        $data = $this->curl($query);

        foreach($data->results as $key=>$result){
            if(strlen($result->overview) > 180) {
                $result->overview = substr($result->overview, 0, 180) . "...";
            }

            $year = explode('-',$result->release_date);
            $result->release_date = $year[0];
        }



        return  $data;
    }

}