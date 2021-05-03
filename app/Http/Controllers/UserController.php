<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
// use Illuminate\Http\JsonResponse;
use App\Model\User;
use App\Model\Wallets;

class UserController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(15);
        return UserResource::collection($users);
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
        $request->validated();

        $user = $this->user;
        $user->name = $request->name;
        $user->id_user_category = $request->id_user_category;
        $user->document = $request->document;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $lastInsertIdUser = $user->id_user;

        $wallet = new Wallet();
        $wallet->id_user = $lastInsertIdUser;
        $wallet->amount = 0;
        $wallet->save();

        return response()->json(['success' => 'Registrado com sucesso.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user::find($idUser);

        if ( empty($user) ) {
            throw ValidationException::withMessages(['user_not_exists' => 'usuário não existe.']);
        }

        if ( $user->id_user != Auth::user()->id_user ) {
            throw ValidationException::withMessages(['user_not_found' => 'Acesso ao usuário negado!']);
        }

        if ( !$user ) {
            throw ValidationException::withMessages(['not_found' => 'Usuário informado não encontrado.']);
        }

        return new UserResource($user);
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
        $data = $this->user->find($idUser);

        if ( empty($data) ) {
            throw ValidationException::withMessages(['user_not_exists' => 'usuário não existe.']);
        }

        if ( $data->id_user != Auth::user()->id_user ) {
            throw ValidationException::withMessages(['user_acess_forbidden' => 'Acesso ao usuário negado.']);
        }

        $request->validated();
        $data->update($request->all());

        return new UserResource($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( !$data = $this->user->find($idUser) ) {
            return response()->json(['error' => 'Usuário informado não encontrado.'], 404);
        }

        if ( $data->id_user != Auth::user()->id_user ) {
            throw ValidationException::withMessages(['user_acess_forbidden' => 'Acesso ao usuário negado!']);
        }

        if ($data->flag_excluido == 1) {
            throw ValidationException::withMessages(['user_deleted' => 'Usuário já deletado.']);
        }

        $data->flag_excluido = 1;

        if ( !$delete = $data->save() ) {
            return response()->json(['error' => 'Não foi possível deletar o usuário informado.', 500]);
        }

        return response()->json(['response' => $delete], 200);
    }
}
