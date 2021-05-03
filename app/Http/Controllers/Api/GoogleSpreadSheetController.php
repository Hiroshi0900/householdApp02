<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $sheets = \App\GoogleSheet::instance();
        $sheet_id = '1SPXuEp4nQJo5qG9DMiIokR6xbqLSUpfKwDwQTiS_gFY';
        $range = 'A1:H1';
        $response = $sheets->spreadsheets_values->get($sheet_id, $range);
        $values = $response->getValues();
echo'<pre>';
var_dump($values);
exit;
        $returnText = response()->json([
            'name' => 'sasuke',
            'gender' => 1,
            'mail' => 'sasuke@test.com'
        ]);
        return $returnText;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

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
