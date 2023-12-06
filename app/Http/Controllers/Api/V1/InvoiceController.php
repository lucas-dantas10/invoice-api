<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    use HttpResponses;


    /**
     * @OA\Get(
     *     tags={"invoices"},
     *     summary="Returns a list of invoices",
     *     description="Returns a object of invoice",
     *     path="/api/v1/invoices",
     *     @OA\Response(response="200", description="A list with invoices"),
     * ),
    */
    public function index(Request $request)
    {
        return (new Invoice())->filter($request);
    }

    /**
     * @OA\Post(
     *     tags={"invoices"},
     *     summary="Store invoice ",
     *     description="Create invoice",
     *     path="/api/v1/invoices",
     *     @OA\Response(response="200", description="Create invoice"),
     * ),
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1|in:' . \implode(",", ['B', 'C', 'P']),
            'paid' => 'required|numeric|between:0,1',
            'value' => 'required|numeric|between:1,9999.99',
            'payment_date' => 'nullable',
        ]);

        if ($validator->fails()) {
            return $this->error("Data Invalid", 422, $validator->errors());
        }

        $created = Invoice::create($validator->validated());

        if ($created) {
            return $this->response("Invoice created", 200, new InvoiceResource($created->load('user')));
        }
        return $this->error("Invoice not created", 400);        
    }


    /**
     * @OA\Get(
     *     tags={"invoices"},
     *     summary="Returns a invoice especific",
     *     description="Returns a object of invoice",
     *     path="/api/v1/invoices/{invoice_id}",
     *     @OA\Response(response="200", description="A invoice especific"),
     *     @OA\Parameter(
     *         name="invoice_id",
     *         in= "path",
     *         required=true,
     *     ),
     * ),
    */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1|in:' . \implode(",", ['B', 'C', 'P']),
            'paid' => 'required|numeric|between:0,1',
            'value' => 'required|numeric',
            'payment_date' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed', 422, $validator->errors());
        }

        $validated = $validator->validated();

        $updated = $invoice->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'paid' => $validated['paid'],
            'value' => $validated['value'],
            'payment_date' => $validated['paid'] ? $validated['payment_date'] : null,
        ]);

        if ($updated) {
            return $this->response('Invoice updated', 200, new InvoiceResource($invoice->load('user')));
        }

        return $this->error('Invoice not updated', 400);
    }

    public function destroy(Invoice $invoice)
    {
        $deleted = $invoice->delete();

        if ($deleted) {
            return $this->response('Invoice deleted', 200);
        }

        return $this->error("Invoice not deleted", 400);
    }
}
