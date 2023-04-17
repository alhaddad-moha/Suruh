<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ResponseHandler;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{
    use ResponseHandler;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $carts = CartResource::collection(Cart::with('product')->get());
        return $this->response($carts, "Got All Estates Successfully", 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $basic  = new \Vonage\Client\Credentials\Basic("fa102733", "giJOtfJfvJZPp4Mz");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("967779783627", "Vonage APIs", 'A text message sent using the Nexmo SMS API')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }


        try {
            $carts = $request->cart;
            $bill_no = $this->generateBillNumber();
            $isSaved = false;

            foreach ($carts as $cart) {

                $validator = Validator::make($cart, [
                    'product_id' => 'required|max:255',
                    'quantity' => 'required|max:255',
                ]);

                if ($validator->fails()) {
                    return $this->response(null, "Error: " . $validator->errors()->toJson(), 400);
                }
            }

            $order = Order::create([
                'bill_no' => $bill_no,
                'customer_id' => $request->customer_id,
                'user_id' => 1,
                'order_date' => Carbon::now(),
                'status' => 0,
                'created_at' => Carbon::now(),
            ]);

            if ($order) {

                foreach ($carts as $cart) {
                    $purchase = new Cart();
                    $purchase->quantity = $cart['quantity'];
                    $purchase->product_id = $cart['product_id'];
                    $purchase->order_id = $order->id;
                    $purchase->bill_no = $bill_no;
                    $purchase->created_at = Carbon::now();
                    $purchase->save();
                }
            }

            if ($order) {



                return $this->response(null, "Inserted Successfully", 201);
            } else {
                return $this->response(null, "Error", 400);
            }

        }
        catch (QueryException $ex){
            return $this->response("Error: ".$ex->getMessage(), "Error Successfully", 501);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cart = Cart::with('unit')->find($id);
        if (!$cart) {
            return $this->response(null, "Not found", 400);

        }
        $cart = new CartResource($cart);
        return $this->response($cart, "Got category Successfully", 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return $this->response(null, "Error: " . $validator->errors()->toJson(), 400);
        }
        $cart = Cart::find($id);

        if (!$cart) {
            return $this->response(null, "Not found", 400);
        }
        $cart->update($request->all());
        return $this->response(null, "Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return $this->response(null, "Not found", 400);
        }
        $cart->delete();
        return $this->response(null, "Deleted Successfully", 200);
    }

    public function generateBillNumber()
    {
        $bill_number = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        while (Cart::where('bill_no', $bill_number)->exists()) {
            $bill_number = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        }
        return $bill_number;
    }
}
