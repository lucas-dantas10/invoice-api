<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class InvoiceResource extends JsonResource
{

    private array $types = ['C' => 'Cartão', 'B' => 'Boleto', 'P' => 'Pix'];
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $paid = $this->paid;
        return [
            'user' => [
                'firstName' => $this->user->first_name,
                'lastName' => $this->user->last_name,
                'fullName' => $this->user->first_name . ' ' . $this->user->last_name,
                'email' => $this->user->email,
            ],
            'type' => $this->types[$this->type],
            'value' => str_replace("R$", "R$ ", Number::currency($this->value, "BRL")),
            'paid' => $paid ? 'Pago' : 'Não Pago',
            'paymentDate' => $paid ? Carbon::parse($this->payment_date)->format('d/m/Y H:i:s') : NULL,
            'paymentSince' => $paid ? Carbon::parse($this->payment_date)->diffForHumans() : NULL,
        ];
    }
}


