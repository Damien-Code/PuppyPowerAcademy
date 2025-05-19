<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminWebshopController extends Controller
{
    /**
     * @author Damien-Code
     * Show the component and all the products with relation to media.
     * Order the products.
     */
    public function index()
    {
        return Inertia::render('settings/admin/Webshop', [
            'products' => Product::with('media')->orderBy('updated_at', 'desc')->get()
        ]);
    }

    /**
     * @author Damien-Code
     * Validate input and store product.
     * If the request has a file, then add that file to mediacollection.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'media' => 'nullable|file|max:10240'
        ]);

       $product = Product::create($validated);

        if ($request->hasFile('media')) {
            $product->addMedia($request->file('media'))->toMediaCollection();
        }
        return redirect()->route('admin.webshop.index');
    }

    /**
     * @author Damien-Code
     * Validate the incoming request.
     * Update the validated request.
     * Delete the first found mediafile and add its new updated mediafile to collection.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'media' => 'nullable|file|max:10240'
        ]);
        $product->update($validated);
        if ($request->hasFile('media')) {
            $product->getFirstMedia()?->delete();
            $product->addMedia($request->file('media'))->toMediaCollection();
        }
        return redirect()->route('admin.webshop.index');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.webshop.index');
    }
}
