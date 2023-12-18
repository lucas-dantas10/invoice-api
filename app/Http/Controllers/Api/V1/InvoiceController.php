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

    public function __construct()
    {
        $this->middleware(["auth:sanctum"])->only(["store", "update", "destroy"]);
    }


    /**
     * @OA\Get(
     *     tags={"invoices"},
     *     summary="List of Invoices",
     *     description="Returns a list of invoice",
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
     *     security={ {"bearerAuth": {} }},
     *     description="Create a invoice",
     *     path="/api/v1/invoices",
     *     @OA\Response(response="200", description="Invoice created", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Invoice not created", @OA\JsonContent()),
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
     *     summary="Returns a invoice",
     *     description="Returns a specific invoice",
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


    /**
     * @OA\Put(
     *     tags={"invoices"},
     *     summary="Update invoice",
     *     security={ {"bearerAuth": {} }},
     *     description="Update a specific invoice",
     *     path="/api/v1/invoices/{invoice_id}",
     *     @OA\Parameter(
     *         name="invoice_id",
     *         in= "path",
     *         required=true,
     *     ), 
     *     @OA\RequestBody(
 *          description="Pass what will be updated on the invoice",
 *          required=true,
 *          @OA\JsonContent(
 *              required={"user_id", "type", "paid", "value"},
 *              @OA\Property(property="user_id", type="integer", example="1"),
 *              @OA\Property(property="type", type="string", example="P", description="P pix, C cartao, B boleto"),
 *              @OA\Property(property="paid", type="boolean", example="0"),
 *              @OA\Property(property="value", type="number", example="12000"),
 *              @OA\Property(property="payment_date", type="string", format="date", example=null, description="2023-12-11 00:00:00"),
 *          )
     *    ),
     *     @OA\Response(response="200", description="Invoice updated", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Invoice not updated", @OA\JsonContent()),
     * ),
    */
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

    /**
     * @OA\Delete(
     *     tags={"invoices"},
     *     summary="Delete invoice",
     *     security={ {"bearerAuth": {} }},
     *     description="Delete a specific invoice",
     *     path="/api/v1/invoices/{invoice_id}",
     *     @OA\Parameter(
     *         name="invoice_id",
     *         in= "path",
     *         required=true,
     *     ), 
     *     @OA\Response(response="200", description="Invoice deleted", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Invoice not deleted", @OA\JsonContent()),
     * ),
    */
    public function destroy(Invoice $invoice)
    {
        $deleted = $invoice->delete();

        if ($deleted) {
            return $this->response('Invoice deleted', 200);
        }

        return $this->error("Invoice not deleted", 400);
    }
}
