<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Wallets;
use App\Http\Resources\WalletResource;

class WalletsController extends Controller
{
    protected $user;
    protected $wallets;

    public function __construct()
    {
        $this->user = new User();
        $this->wallets = new Wallets();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->find(Auth::user()->id);
        // $user = $this->user->find($id);

        if ( !$user ) {
            throw ValidationException::withMessages(['error' => 'Usuário não encontrado, tente novamente.']);
        }

        $wallet = $this->wallets->where('id_user', '=', $user->id)->first();

        if ( !$wallet ) {
            throw ValidationException::withMessages(['error' => 'Não encontramos a carteira do usuário, tente novamente.']);
        }

        return new WalletResource($wallet);
    }




}
