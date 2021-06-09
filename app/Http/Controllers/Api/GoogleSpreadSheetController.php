<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\GoogleSheet;
use Illuminate\Http\Request;

class GoogleSpreadSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $client = \App\GoogleSheet::instance();
        $GoogleSheet = new GoogleSheet;
        $client = $GoogleSheet::instance();
        // $sheets = new \Google_Service_Sheets($client);
        $sheetId = '1SPXuEp4nQJo5qG9DMiIokR6xbqLSUpfKwDwQTiS_gFY';
        $range = 'G3:I120'; // 雑費枠
        $response = $GoogleSheet->getSheetsValue($client,$sheetId, $range);
        $values = $response->getValues();
        // 一度生で返す
        // $formattedData = $this->formatMiscellaneousExpenses($values);
        // echo json_encode($formattedData);
        echo json_encode($values);
        // $returnText = response()->json([
        //     'name' => 'sasuke',
        //     'gender' => 1,
        //     'mail' => 'sasuke@test.com'
        // ]);
        // return $returnText;
    }
    private function formatMiscellaneousExpenses(array $values)
    {
        // 日付ごとにデータをまとめて返す
        $nowDayName = '';
        $formatData = [];
        foreach ($values as $v) {
            if ($nowDayName === '' || ($nowDayName !== $v[0] && $v[0]!== '')) {
                $nowDayName =$v[0];
            }
            $formatData[$nowDayName][] = $v;
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
