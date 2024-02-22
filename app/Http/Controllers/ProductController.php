<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Product;
use TCG\Voyager\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        
        // $products = Product::all();

        if(isset($_GET["category"])){
            $cate= $_GET["category"];  
            $products = Product::where('category',  $cate)->get();

        }else  { $products = Product::all();}

        $categories = Category::all();

        return view('products', compact('products', 'categories'));
    }
    function search(Request $request){
    
            $products = Product::with("category")->where("name", "like", "%".$request->search_string."%")->get();
        

        if($products->count()){
            return response()->json([
                "status" => true
                ,
                "products" => $products
                ,
                "token"  => $request->header("X-CSRF-TOKEN")
            ]);
        } else  return response()->json([
            "status" => false

        ]);
    }
   
    public function productCart()
    {
        return view('cart');
    }
    public function addProducttoCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'product has been added to cart!');
    }
     
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'product added to cart.');
        }
    }
   
    public function deleteProduct(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product successfully deleted.');
        }
    }

    public function checkout(){
        return view('checkout');
    }

    public function total($price, $quntity){
        $total = 0;
        return $total +=  $price * $quntity ;
    }
}