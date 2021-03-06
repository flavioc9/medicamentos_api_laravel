<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * @group Gestão de medicamentos
 *
 * APIs para gerir medicamentos
 */
class MedicineController extends Controller
{
    /**
     * Retorna uma lista de medicamentos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Medicine::all(), Response::HTTP_OK);
    }

    /**
     * Criar um medicamento
     *
     * @bodyParam brand string required Marca do farmaco. Example: Ben-u-ron
     * @bodyParam drug string required Farmaco. Example: paracetamol
     * @bodyParam dose string required Concentração do farmaco. Example: 1000mg
     *
     * @response scenario=success status=201 {
     *   "brand": "Ben-n-uron",
     *   "drug": "paracetamol",
     *   "dose": "1000mg",
     *   "updated_at": "2021-06-14T20:00:18.000000Z",
     *   "created_at": "2021-06-14T20:00:18.000000Z",
     *   "id": 7
     * }
     * @response scenario="bad request" status=400 {
     *    "error" : "error description"
     * }
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
     * Retorna um medicamento
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function show(Medicine $medicine)
    {
        return response()->json($medicine, Response::HTTP_OK);
    }

    /**
     * Atualiza um medicamento.
     *
     * @urlParam id integer required O id do medicamento a atualizar. Example: 1.
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
     * Apaga um medicamento da base de dados.
     *
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
