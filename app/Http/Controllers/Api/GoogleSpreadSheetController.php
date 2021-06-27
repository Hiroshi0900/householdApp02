<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\GoogleSheet;
use App\Common\books;
use Illuminate\Http\Request;

class GoogleSpreadSheetController extends Controller
{
    protected $Books;
    public $GoogleSheet;
    public $Client;
    public $bookData;

    public function __construct(Books $Books)
    {
      $this->Books = $Books;
      $this->GoogleSheet = $this->Books->GoogleSheet;
      $this->Client = $this->Books->Client;
      $this->bookData = $this->Books->getBook(2);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // ブックのマスタデータからIDを取得
        // 今日日付
        $targetMonth = date("Ym");
        if ($request->ym != null) {
            $targetMonth = $request->ym;
        }
        $range = $targetMonth;
        // データ取得
        $range .= '!G3:I120'; // 雑費枠
        $response  = $this->GoogleSheet->getSheetsValue($this->Client,$this->bookData[2], $range);
        $values = $response->getValues();
        // 一度生で返す

        $formattedData = $this->formatMiscellaneousExpenses($values);
        // echo json_encode($formattedData);
        echo json_encode($formattedData);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function summary(Request $request)
    {
        $sheetId = $this->bookData[2];
        $targetMonth = date("Ym");
        if ($request->ym != null) {
            $targetMonth = $request->ym;
        }
        $range = $targetMonth;
        $range .= '!A1:M2'; // 合計枠
        $response = $this->GoogleSheet->getSheetsValue($this->Client,$sheetId, $range);
        $values = $response->getValues();
        $formattedData = $this->formatSummaryData($values);

        echo json_encode($formattedData);
    }

    private function formatMiscellaneousExpenses(array $values)
    {
        // 日付ごとにデータをまとめて返す
        $nowDayName = '';
        $formatData = [];
        
        foreach ($values as $v) {
            if ($nowDayName == '' || ($nowDayName != $v[0] && $v[0]!== '')) {
                $nowDayName = preg_replace('/\A[\x00\s]++|[\x00\s]++\z/u', '', $v[0]);
                if ($nowDayName == '') continue;
                $formatData[$nowDayName][0] = $nowDayName;
            }
            $formatData[$nowDayName][1][] = $v;
        }

        return $formatData;
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

    public function store(Request $request)
    {
        //
        $GoogleSheet = new GoogleSheet;
        $client = $GoogleSheet::instance();
        // $sheets = new \Google_Service_Sheets($client);
        $sheetId = '1SPXuEp4nQJo5qG9DMiIokR6xbqLSUpfKwDwQTiS_gFY';
        //書き込みたい値
        $range = 'シート1!A2:B7';
        // 更新するデータ
        // TODO 書き込み範囲や内容はポストパラメータで設定する
        $values = [
            ["A1", "B1"],
            ["2019/1/1", "2020/12/31"],
            ["アイウエオaaaaaa", "かきくけこxxxx"],
            [10, 20],
            [100, 200],
            ['=(A5+A6)', '=(B5+B6)']
        ];
        
        $t = $GoogleSheet->addSheetsValues($client,$sheetId, $range, $values);
// echo'<pre>';
// var_dump($t);
// exit;
        // $response = $GoogleSheet->addSheetsValues($client,$sheetId, $range, $values);
echo'<pre>';
var_dump('OK');
exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showsample($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
