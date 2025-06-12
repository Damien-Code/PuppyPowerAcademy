<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cart_Product;
use App\Models\Cart_Training;
use App\Models\Category_Order;
use App\Models\Product;
use App\Models\Training;
use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Order_Training;
use App\Models\TrainingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

/**
 * @author MischaSasse
 * 
 */
class CartController extends Controller
{
    /**
     * @author MischaSasse
     * 
     * gets all trainings and products from users cart, adds the tax (which is currently a hardcoded percentage) and returns it for the viewer to see
     */
    public function index()
    {
        $productTaxPercentage  = 18;
        $trainingTaxPercentage = 18;
        // get products
        $products = Product::join("cart_products", function($join){
        	$join->on(['products.id' => 'cart_products.product_id']);
        })
        ->join("carts", function($join){
        	$join->on(['carts.user_id' => 'cart_products.cart_id']);
        })
        ->select("products.*", "cart_products.amount as amount")
        ->where(['user_id'=>Auth::user()->id])
        ->get();

        $subtotal = 0;
        $taxProduct = 0;
        $taxTraining = 0;

        foreach($products as $product){
            $subtotal += ($product->price * $product->amount);
            $taxProduct += ($product->price * $product->amount * ($productTaxPercentage/100));
        }
        //get trainings
        $trainings = TrainingCategory::join("cart_trainings", function($join){
        	$join->on("trainingcategories.id", "=", "cart_trainings.trainingcategory_id");
        })->join("carts", function($join){
        	$join->on("carts.user_id", "=", "cart_trainings.cart_id");
        })->where(['user_id'=>Auth::user()->id])->get();

        foreach($trainings as $training){
            $subtotal += ($training->price);
            $taxTraining += ($training->price * ($trainingTaxPercentage/100));
        }

        return Inertia::render('webshop/Cart',[
        'products' => $products,
        'trainings' => $trainings,
        'subtotalPrice' => $subtotal,
        'taxProduct' => $taxProduct,
        'taxTraining' => $taxTraining
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @author MischaSasse
     * 
     * Creates an order for the user after they hit order on the cart page
     */
    public function store(Request $request)
    {
        //format price to not be xx.xx0000005 but to be of format xx.xx
        $request->totalPrice = number_format($request->totalPrice, 2, '.',"");

        //add user_id to request for query
        $request->request->add(['user_id' => Auth::user()->id]);

        //add to orders
        $validatedOrder = $request->validate([
            'user_id' => 'required|integer|gt:0',
            'postal_code' => 'required|string|max:7|min:1',
            'country' => 'required|string|max:255|min:1',
            'city' => 'required|string|max:255|min:1',
            'street' => 'required|string|max:255|min:1',
            'house_number' => 'required|integer|gt:0',
            'total_price' => 'required|numeric|gt:0',
        ]);

        //create order
        Order::create($validatedOrder);

        //get latest order_id
        $order_id = Order::where(['user_id' => Auth::user()->id])->orderBy('id', 'desc')->first()->id;

        //insert into order_products
        if(count($request->products)>0){
            foreach ($request->products as $product) {
                $currrentProduct = Product::find($product['id']);
                $currrentProduct->stock = $currrentProduct->stock - $product['amount'];
                Order_Product::create(['order_id' => $order_id, 'product_id' => $product['id'], 'amount' => $product['amount']]);
            }
        }

        //insert into order_trainings
        if(count($request->trainings)>0){
            foreach ($request->trainings as $training) {
                Category_Order::create(['order_id' => $order_id, 'trainingcategory_id' => $training['trainingcategory_id']]);
            }
        }

        //remove products/trainings from cart
        $this->removeItemsFromCart();

        return redirect()->route('webshop.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * @author MischaSasse
     * 
     * calls remove method and returns user to webshop
     */
    public function destroy()
    {
        $this->removeItemsFromCart();
        return redirect()->route('webshop.index');
    }
    
    /**
     * @author MischaSasse
     * 
     * removes all items from cart
     */
    private function removeItemsFromCart()
    {
        Cart_Product::where(['cart_id' => Auth::user()->id])->delete();
        Cart_Training::where(['cart_id'=> Auth::user()->id])->delete();
    }
}
