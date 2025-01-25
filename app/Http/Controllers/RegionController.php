<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    //
    public function index(){
        $regions = Region::all();
        return $regions;
    }
    public function add(Request $request){
        $region = Region::where('name', $request->name)->first();
        if ($region) {
            return [
                'message' => 'Region Already Exist',
            ];
        }
        $region = new Region();
        $region->name = $request->name;
        $region->save();
        return [
            'message' => 'Region Added Successfully',
            'region' => $region
        ];
    }

}
