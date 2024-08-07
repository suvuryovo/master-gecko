<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Response;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const is_dev = true;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //validate
        $post = request()->all();

        //cek required
        $validate = Validator::make($post, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',

        ]);
        if ($validate->fails()) {
            return Response::badRequestError('Bad Request', $validate->errors());
        }

        try{
            $post['password'] = bcrypt($post['password']);
            if($model = User::create($post)){
                return Response::success('Success Create User',$model);
            }
            else{
                return Response::badRequestError('Failed Create User');
            }
        }
        catch (Exception $exc) {
            if(!self::is_dev)
            return Response::badRequestError("Something Error, Please Contact Administrator");
            else
            return Response::internalServerError("file: " . $exc->getFile() . "line: " . $exc->getLine() , $exc->getMessage());
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
