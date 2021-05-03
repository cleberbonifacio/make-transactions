<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id_transaction' => $this->id_transaction,
            'amount'   => $this->amount,
            'payer'  => $this->payer,
            'payee' => $this->payee
        ];
    }
}
