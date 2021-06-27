<?php

namespace App;

use Google_Client;
use Illuminate\Database\Eloquent\Model;

class GoogleSheet extends Model
{
    public static function instance() {
        // $credentials_path = storage_path('gcp_credential.json');
        $credentialsPath = config_path('gcp_credential.json');
        $client = new \Google_Client();
        // $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setScopes([
            \Google_Service_Sheets::SPREADSHEETS, // スプレッドシート
            \Google_Service_Sheets::DRIVE, // ドライブ
        ]);
        $client->setAuthConfig($credentialsPath);

        // return new \Google_Service_Sheets($client);
        return $client;
    }
    
    public function getSheetsValue(Google_Client $client, string $sheetId,string $range)
    {
        $sheets = new \Google_Service_Sheets($client);
        return $sheets->spreadsheets_values->get($sheetId, $range);

    }
    public function addSheetsValues(Google_Client $client, string $sheetId,string $range,array $values)
    {

        try{
            $sheets = new \Google_Service_Sheets($client);

            //書き込みたい値
            // $range = 'シート1!A2:B7';
            // 更新するデータ
            // $values = [
            //     ["A1", "B1"],
            //     ["2019/1/1", "2020/12/31"],
            //     ["アイウエオ", "かきくけこ"],
            //     [10, 20],
            //     [100, 200],
            //     ['=(A5+A6)', '=(B5+B6)']
            // ];
            
            $requestBody = new \Google_Service_Sheets_ValueRange([
                            'values' => $values,
                           ]);
            
            // データの入力方法
            //USER_ENTERED -> 画面から入力したのと同じようになる（計算式の解釈などが入る）
            //RAW -> そのまま表示されます（計算式の解釈などなし）
            $params = ['valueInputOption' => 'USER_ENTERED'];
            
            $result = $sheets->spreadsheets_values->update(
                $sheetId,
                $range,
                $requestBody,
                $params
            );
return $result;
                // echo'<pre>';
                // var_dump($result);
                // exit;

        } catch (\Google_Exception $e) {
            // $e は json で返ってくる
            $errors = json_decode($e->getMessage(),true);
            $err = "code : ".$errors["error"]["code"]."";
            $err .= "message : ".$errors["error"]["message"];
            echo "Google_Exception".$err;
        }
        // return$result->getUpdatedCells();
    }
    public function addSheets(Google_Client $client)
    {
        // sheet作成 start
        $spreadsheet_service = new \Google_Service_Sheets($client);
        $requestBody = new \Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => '新しいスプレッドシート22'
            ]
        ]);
        $response = $spreadsheet_service->spreadsheets->create($requestBody);
        $spreadsheet_id = $response->spreadsheetId; 
        $email = 'free.sakemin@gmail.com';
        $drive_permission = new \Google_Service_Drive_Permission();
        $drive_permission->setEmailAddress($email);
        $drive_permission->setType('user');
        $drive_permission->setRole('owner');

        $drive_service = new \Google_Service_Drive($client);
        $drive_service->permissions->create($spreadsheet_id, $drive_permission, [
            'transferOwnership' => 'true'   // コピー等の権限あり
        ]);
        // sheet作成 end
        return $spreadsheet_id;
    }
}
