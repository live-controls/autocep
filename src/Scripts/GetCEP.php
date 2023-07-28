<?php 

namespace LiveControls\AutoCep\Scripts;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use LiveControls\Utils\Utils;

class GetCEP{

    public static function get(int $cep): array
    {
        if(Utils::countNumber($cep) != 8)
        {
            return ["statusText" => "invalid"];
        }

        $client = new Client();
        try{
            $response = $client->request('GET', 'https://www.cepaberto.com/api/v3/cep?cep='.$cep, [
                'headers' => [
                    'Authorization' => 'Token token='.env('CEPABERTO_TOKEN'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);
        }catch(GuzzleException $ex)
        {
            Log::warning("Couldn\'t fetch CEP, server said: ".$ex->getMessage());
            return ["statusText" => "connection_error"];
        }catch(Exception $ex)
        {
            Log::warning("Couldn't fetch CEP due to an internal error, server said: ".$ex->getMessage());
            return ["statusText" => "internal_error"];
        }

        if($response->getStatusCode() != 200)
        {
            Log::warning("Couldn't fetch CEP due to a HTTP error, errorcode was: ".$response->getStatusCode());
            return ["statusText" => "http_error"];
        }


        $json = json_decode($response->getBody(),true);
        if(!array_key_exists("cidade", $json)){
            return ["statusText" => "invalid"];
        }
        return array_merge($json, ["statusText" => "ok"]);
    }
}