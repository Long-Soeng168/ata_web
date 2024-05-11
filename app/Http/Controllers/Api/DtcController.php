<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dtc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DtcController extends Controller
{
    public function index()
    {
        $dtcs = Dtc::paginate(10);
        return response()->json($dtcs);
    }

    public function show($dtc_code)
    {
        $dtc = Dtc::where('dtc_code', $dtc_code)->first();
        return response()->json($dtc);
    }
 
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'dtc_code' => 'required|string|max:255',
            'description_en' => 'required',
            'description_kh' => 'required',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Validation passed, proceed with storing data
        $data = $request->only(['dtc_code', 'description_en', 'description_kh']);
        $created = Dtc::insertGetId($data);
        $dtc = Dtc::where('id', $created)->first();
        return response()->json($dtc, 201);
    }

    public function update(Request $request, $id)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'dtc_code' => 'required|string|max:255',
            'description_en' => 'required',
            'description_kh' => 'required',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Validation passed, proceed with updating data
        $data = $request->only(['dtc_code', 'description_en', 'description_kh']);
        Dtc::where('id', $id)->update($data);
        $dtc = Dtc::where('id', $id)->first();
        return response()->json($dtc, 200);
    }
    
    public function destroy($id)
    {
        Dtc::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
