<?php

namespace App\Models;

use App\Filters\InvoiceFilter;
use App\Http\Resources\V1\InvoiceResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'paid',
        'payment_date',
        'value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filter(Request $request)
    {
        $queryFilter = (new InvoiceFilter)->filter($request);

        if (empty($queryFilter)) {
            return InvoiceResource::collection(Invoice::with('user')->get());
        }

        $data = Invoice::with('user');

        if (!empty($queryFilter["whereIn"])) {
            dd($queryFilter['whereIn']);
        }
    }

}
