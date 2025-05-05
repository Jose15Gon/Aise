<?php

/**
 * Controller to handle CRUD operations for products.
 *
 * This file contains the controller that manages the creation, viewing, 
 * updating, deletion, and listing of products. It uses the 
 * 'Product' model to interact with the database and corresponding views 
 * to display the data in the user interface.
 *
 * @package   App\Http\Controllers
 * @author    José González <jose@bitgenio.com>
 * @copyright 2025 Bitgenio DevOps SLU
 * @since 26/03/2025
 * @version 1.0.0
 */

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
    }


     /**
     * Display a list of all the products that a user has.
     *
     * This method retrieves all products that a user has from the database and returns a 
     * view displaying a list of these products.
     *
     * @access public
     * @author José González <jose@bitgenio.com>
     * @since 26/03/2025
     * @return view View displaying all products that a user has.
     */
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->get();
        return view('products.index', compact('products'));
    }

      /**
     * Show the form for creating a new product.
     *
     * This method returns a view containing the form to create a new product.
     *
     * @access public
     * @author José González <jose@bitgenio.com>
     * @since 26/03/2025
     * @return view View with the product creation form.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in the database.
     *
     * This method validates the request data, creates a new product record, 
     * and redirects the user back to the product list with a success message.
     *
     * @access public
     * @author José González <jose@bitgenio.com>
     * @since 26/03/2025
     * @param ProductRequest $request The request containing product data.
     * @return redirect Redirects to the products index with a success message.
     */
    public function store(ProductRequest $request)
    {

        
        Product::create([

            'title' => $request->input('title'),
            'description'=> $request->input('description'),
            'price'=> $request->input('price'),
            'image' => $request->file('image')->store('product_images', 'public'),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('products.index')->with('success','Anuncio creado correctamente');
    }

    /**
     * Display the details of a specific product.
     *
     * This method retrieves a specific product and returns a view displaying its details.
     *
     * @access public
     * @author José González <jose@bitgenio.com>
     * @since 26/03/2025
     * @param string $id The ID of the product to be displayed.
     * @return view View displaying the product details.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

     /**
     * Show the form for editing a specific product.
     *
     * This method retrieves a specific product and returns a view with 
     * the form to edit its details.
     *
     * @access public
     * @author José González <jose@bitgenio.com>
     * @since 26/03/2025
     * @param string $id The ID of the product to be edited.
     * @return view View displaying the product edit form.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== Auth::id()){

            return redirect()->route('products.index')->with('error','No tienes permiso para editar este anuncio');
        }

        return view('products.edit', compact('product'));
    }

    /**
     * Update an existing product in the database.
     *
     * This method validates the request data, updates the specified product, 
     * and redirects back to the product list with a success message.
     *
     * @access public
     * @author José González <jose@bitgenio.com>
     * @since 26/03/2025
     * @param ProductRequest $request The request containing updated product data.
     * @param string $id The ID of the product to be updated
     * @return redirect Redirects to the products index with a success message.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== Auth::id()){
            return redirect()->route('products.index')->with('error','No tienes permiso para editar este anuncio');
        }

        $product->update([
            'title'=> $request->input('title'),
            'description'=> $request->input('description'),
            'price'=> $request->input('price'),
            'image'=> $request->file('image')->store('product_images', 'public'),
        ]);

        return redirect()->route('products.index')->with('success','Anuncio actualizado correctamente');
    }

    /**
     * Remove a product from the database.
     *
     * This method deletes the specified product and redirects back to 
     * the product list with a success message.
     *
     * @access public
     * @author José González <jose@bitgenio.com>
     * @since 26/03/2025
     * @param string $id The ID of the product to be deleted.
     * @return redirect Redirects to the products index with a success message.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== Auth::id()){
            return redirect()->route('products.index')->with('error','No tienes permiso para eliminar este anuncio');
        }

        if ($product->image){
            
            Storage::delete('public/'.$product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success','Producto eliminado correctamente');
    }

}
