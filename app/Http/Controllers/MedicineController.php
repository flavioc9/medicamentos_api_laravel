<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Medicine::all(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = $this->validateInputs($input);

        if($validator->fails()){
            return response()->json(["errors" => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $medicine = new Medicine();
        $medicine->brand = $input['brand'];
        $medicine->drug = $input['drug'];
        $medicine->dose = $input['dose'];

        try{
            $medicine->save();
            return response()->json($medicine, Response::HTTP_CREATED);
        }catch(\Exception $e){
            return response()->json(["errors" => "Ocorreu um erro ao tentar guardar o medicamento"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function show(Medicine $medicine)
    {
        return response()->json($medicine, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medicine $medicine)
    {
        $input = $request->all();
        $validator = $this->validateInputs($input);

        if($validator->fails()){
            return response()->json(["errors" => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $medicine->brand = $input['brand'];
        $medicine->drug = $input['drug'];
        $medicine->dose = $input['dose'];

        try{
            $medicine->save();
            return response()->json($medicine, Response::HTTP_OK);
        }catch(\Exception $e){
            return response()->json(["errors" => "Ocorreu um erro ao tentar guardar o medicamento"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicine $medicine)
    {
        Medicine::destroy($medicine->id);
        return response()->json(["success" => "Medicine successfully deleted!"], Response::HTTP_OK);
    }

    private function validateInputs($input){

        $rules = [
            'brand' => 'required',
            'drug' => 'required',
            'dose' => 'required',
        ];

        return Validator::make($input, $rules);
    }
}
