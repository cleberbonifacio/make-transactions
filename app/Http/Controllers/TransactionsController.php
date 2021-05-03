<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallets as Wallets;
use App\Models\Transactions as Transactions;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
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
        //Get authenticated user
        $user = Auth::user();

        //Verify user authenticated
        if(!$user){
            return response()->json(['error' => 'Operação não permitida.'], 401);
        }

        //Verify user type
        //only type == 1 can transactions
        if($user->id_type == 2){
            return response()->json(['error' => 'Operação não permitida. Lojistas podem apenas receber pagamentos.'], 401);
        }

        //Get Values Request
        $valueTransaction = $request->input('valor');
        $payeeDocument = $request->input('documento');

        //Verify if payee and payer same person
        if($user->document === $payeeDocument){
            return response()->json(['error' => 'Operação não permitida. Não é permitido realizar a transação para você mesmo.'], 401);
        }

        //Find Wallet payer
        $payerWallet = User::find($user->id)->userWallet;


        //Verify balance
        if(!$payerWallet || (int)$payerWallet->amount < (int)$valueTransaction){
            return response()->json(['error' => 'Operação não permitida. Saldo insuficiente para realizar o pagamento.'], 401);
        }

        //Find payee
        $payee = User::where('document', $payeeDocument)->first();

        //Verify payee
        if(!$payee){
            return response()->json(['error' => 'Operação não permitida. Beneficiário não encontrado.'], 401);
        }

        $payeeWallet = Wallets::find($payee->id);

        //consult an external authorizing service
        $permitTransaction = $this::permitTransaction();


        if ($permitTransaction || $permitTransaction['message'] === 'Autorizado') {

            try {

                //Try save new amount after transaction to Payer
                $dataPayer = [
                    'amount' => (int)$payerWallet->amount - (int)$valueTransaction,
                    'updated_at' => now()
                ];
                $payment = Wallets::where('id_user', $user->id)->update($dataPayer);

                //Send Notification Payer
                $sendNotifyPayer = $this::sendNotification();

                //Try save new amount after transaction to Payee
                $dataPayee = [
                    'amount' => (int)$payeeWallet->amount + (int)$valueTransaction ,
                    'updated_at' => now()
                ];

                $Received = Wallets::where('id_user', $payee->id)->update($dataPayee);

                //Send Notification Payee
                $sendNotifyPayee = $this::sendNotification();

                //Create user
                $dataTransaction = [
                    'amount' => (int)$valueTransaction,
                    'payer' => $user->id,
                    'payee' => $payee->id,
                ];
                $transactionSave = Transactions::create($dataTransaction);

            } catch (\Throwable $th) {
               return response()->json(['error' => 'Algo deu errado, tente novamente'], 401);
            }

        }

        return response()->json(['success' =>  $transactionSave], 200);
    }

    //consult an external authorizing service
    public function permitTransaction(){
        $urlService = "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6";
        $responseJson = json_decode(file_get_contents($urlService), true);
        return $responseJson;
    }

    //Send Notification
    public function sendNotification(){
        $urlService = "https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04";
        $responseJson = json_decode(file_get_contents($urlService), true);
        return $responseJson;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        return response()->json($user->id, 200);
    }

}
