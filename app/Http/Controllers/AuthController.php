<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Response;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    //
    public function login(Request $request){
        $post = request()->all();
        $data_set = array();
        $validate = Validator::make(request()->only('email', 'password'), [
            'email' => 'required',
            'password' => 'required',
        ], [
            'required' => ':attribute harus diisi'
        ]);
        if ($validate->fails()) {
            return Response::badRequestError('Bad Request', $validate->errors());
        }
        if($token = JWT::attempt($post)){
            $user = Auth::user();
            
            $model = DB::table('users')
            ->select(
                'users.*',
                'table_role_master.role'
            )
            ->join('table_role_master', 'users.role', '=', 'table_role_master.id')
            ->where('users.id',$user->id)
            ->first();

            if($model){
                $return['user'] = $model;
                // dd($token->original);
                $return['token'] = $token->original['data'];
                return Response::success('Success Login',$return);
            }
            else{
                return Response::badRequestError('Email Or Password Wrong');
            }
        }
        return Response::badRequestError('Email Or Password Wrong');
    }

    public function create_admin(Request $request){
        $post = request()->all();
        $validate = Validator::make(request()->only('name', 'email','password'), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ], [
            'required' => ':attribute harus diisi'
        ]);
        if ($validate->fails()) {
            return Response::badRequestError('Bad Request', $validate->errors());
        }

        $create['name'] = $post['name'];
        $create['email'] = $post['email'];
        $create['password'] = bcrypt($post['password']);
        $create['role'] = $post['role'];
        // dd($create);
        if(User::create($create)){
            return Response::success('Admin berhasil dibuat');
        }
        else{
            return Response::badRequestError('Failed Create Data');
        }

    }
}
