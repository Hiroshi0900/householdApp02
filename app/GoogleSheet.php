<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoogleSheet extends Model
{
    public static function instance() {

        $credentials_path = storage_path('gcp_credential.json');
        $client = new \Google_Client();
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentials_path);
        return new \Google_Service_Sheets($client);

    }
}
