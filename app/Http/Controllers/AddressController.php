<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/// Model
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function index ()
    {
        $district_code = 1212;

        $query = "
            SELECT DISTINCT province_code, province_name_en, province_name_kh
            FROM address;
        ";
        $cities = DB::select($query);

        $add1_city = "19";
        $add1_district = "1906";
        $add1_commune = "190603";

        $add2_city = "07";
        $add2_district = "0702";
        $add2_commune = "070213";

        return view("index")
        // ->with("add1_city", $add1_city)
        // ->with("add1_district", $add1_district)
        // ->with("add1_commune", $add1_commune)
        // ->with("add2_city", $add2_city)
        // ->with("add2_district", $add2_district)
        // ->with("add2_commune", $add2_commune)
        ->with("cities", $cities);
    }

    public function district_fetch (Request $request)
    {
        $code = $request->cityCode;

        $query = "
            SELECT DISTINCT district_code, district_name_en
            FROM address
            WHERE SUBSTRING(district_code, 1, 2) = ?;
        ";

       $district = DB::select($query, [$code]);

       return Response()->json(["district" => $district]);
    }

    public function commune_fetch (Request $request) 
    {
        $code = $request->code;
        $query = "
            SELECT DISTINCT commune_code, commune_name_en
            FROM address
            WHERE SUBSTRING(commune_code, 1, 4) = ?;
        ";
        $commune = DB::select($query, [$code]);

        return Response()->json([
            "commune" => $commune
        ]);
    }
}
