<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/// Model
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index ()
    {
        $query = "
            SELECT DISTINCT province_code, province_name_en, province_name_kh
            FROM address;
        ";

        $cities = DB::select($query);

        return view("index")
            ->with("cities", $cities);
    }

    public function city_fetch (Request $request)
    {
        $code = $request->code;
        // $query = "
        //     SELECT DISTINCT district_code, district_name_en
        //     FROM address
        //     WHERE SUBSTRING(district_code, 1, 2) = ".$code.";
        // ";

        // return response()->json(array("msg" => "It Work !"), 200);
        return response()->json(['success'=>'Data is successfully added']);
        // return $code;
    }
}
