<?php

namespace App\Http\Controllers;

use App\Imports\TraitsImport;
use App\Models\TraitsModel;
use App\Services\Response;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class TraitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $model = TraitsModel::get();
        if($model)
        return Response::success('Succes Get Data',$model);
        else
        return Response::badRequestError('Failed Get Data');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function import_excel(Request $request){
        $post = request()->all();
        $validate = Validator::make($post, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        if ($validate->fails()) {
            return Response::badRequestError('Bad Request', $validate->errors());
        }
        $check = Excel::toArray(new TraitsImport, $request->file('file'));
        $i = $count = 0;
        if(count($check[0]) > 0){
            foreach($check[0] as $k => $v){
                if($k == 0)
                continue;

                $set_data[$i] = $v;
                $i++;
            }

            DB::beginTransaction();
            $insert = [];
            foreach($set_data as $k => $v){
                $data_ins['traits'] = $v[0];
                $data_ins['notes'] = $v[1];

                //check exist
                $exist = DB::table('traits')
                ->whereRaw("LOWER(TRIM(traits))=?",strtolower(trim($v[0])))
                ->first();

                if($exist){
                    continue;
                }
                else{
                    $insert[] = TraitsModel::create($data_ins);
                }
            }

            if(count($insert) > 0){
                DB::commit();
                return Response::success('Success Insert Data',$insert);
            }
            else{
                return Response::badRequestError('Failed Insert Data',$insert);
            }
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
