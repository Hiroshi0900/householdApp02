<?php

namespace app\Common;

use App\GoogleSheet;

class books 
{
    public $GoogleSheet;
    public $Client;
    public function __construct()
    {
      $this->GoogleSheet = new GoogleSheet;
      $this->Client = $this->GoogleSheet::instance();
    }

    public function getBook(int $id)
    {
        $sheetId = '1SPXuEp4nQJo5qG9DMiIokR6xbqLSUpfKwDwQTiS_gFY';
        $range = 'A2:C24'; // 合計枠
        $response = $this->GoogleSheet->getSheetsValue($this->Client,$sheetId, $range);
        $values = $response->getValues();
        return $this->findBookData($response, $id);

    }

    // public function getSheet(int $bookId)
    // {
    //     $sheetId = '1SPXuEp4nQJo5qG9DMiIokR6xbqLSUpfKwDwQTiS_gFY';
    //     $range = 'A2:C24'; // 合計枠
    //     $response = $this->GoogleSheet->getSheetsValue($this->Client,$sheetId, $range);
    //     $values = $response->getValues();
    //     return $this->findBookData($response, $id);

    // }

    private function findBookData($data , $findWhereId){
        $findedData = [];
        foreach($data as $row){
            if($row[0] == $findWhereId){
                $findedData = $row;
                break;
            }
        }
        return $findedData;
    }
}