<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\GoogleSheet;
use Illuminate\Http\Request;

class SummaryDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function summary()
    {
        // // $client = \App\GoogleSheet::instance();
        $GoogleSheet = new GoogleSheet;
        $client = $GoogleSheet::instance();
        // // $sheets = new \Google_Service_Sheets($client);
        $sheetId = '1SPXuEp4nQJo5qG9DMiIokR6xbqLSUpfKwDwQTiS_gFY';
        $range = 'A1:M2'; // 合計枠
        $response = $GoogleSheet->getSheetsValue($client,$sheetId, $range);
        $values = $response->getValues();
        $formattedData = $this->formatSummaryData($values);
        echo json_encode($formattedData);
        // exit;
    }

    private function formatSummaryData($summaryData)
    {
        $formatData = [];
        $summaryHeaderData = $summaryData[0];
        $summaryBodyData = $summaryData[1];
        foreach ($summaryHeaderData as $key => $sum) {
            if($summaryBodyData[$key] === '') break;
            $formatData[$sum] =$summaryBodyData[$key];
        }

        return $formatData;
    }

    private function getMapSummaryKey()
    {
        return [
            'sum' => 0,
            'toLeave'=> 1,
            'hairLoss'=>2,
            // '',
        ];
    }
}
