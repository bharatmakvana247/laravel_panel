<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function create()
    {
        $form_title = "Product";
        $category_list = Category::pluck('category_name', 'category_id');
        $brands_list = Brand::pluck('brand_name', 'brand_id');
        return view('backend.pages.product.create', compact('form_title', 'brands_list', 'category_list'));
    }

    public function index(Request $request)
    {
        $category_list = Category::pluck('category_name', 'category_id');
        $brands_list = Brand::pluck('brand_name', 'brand_id');
        $form_title = "Product";
        if ($request->ajax()) {
            $products = Product::orderBy('product_id', 'desc');
            return DataTables::of($products)->addIndexColumn()
                ->addColumn('category_id', function (Product $products) {
                    if (!empty($products->category->category_name)) {
                        return $products->category->category_name; //Product->Category->CategoryName
                    } else {
                        return 'N/A';
                    }
                })
                ->addColumn('brand_id', function (Product $products) {
                    if (!empty($products->brand->brand_name)) {
                        return $products->brand->brand_name;
                    } else {
                        return 'N/A';
                    }
                })
                ->addColumn('productDetails', function (Product $products) {
                    // return $products->product_details;
                    return  Str::limit($products->product_details, 50);
                })
                ->addColumn('productimage', function (Product $products) {
                    if (!empty($products->product_image)) {
                        return '<center><img src=' . url("storage/productImage/$products->product_image") . ' class="img-thumbnail" align="center" style="height: 100px; width: 100px;"/></center>';
                    } else {
                        return '<center><img src=' . url("storage/productImage/default.png") . ' class="img-thumbnail" align="center" style="height: 100px; width: 100px;"/> </center>';
                    }
                })
                ->addColumn('action', function (Product $product) {
                    $action  = '';
                    // <a type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-block-normal"><i
                    // class="fa fa-fw fa-plus me-1"></i>Add Product</a>
                    $action .= '<a href="javascript:void(0)" class="btn btn-primary btn-circle btn-sm editProduct" data-id="' . $product->product_id . '" data-toggle="tooltip" title="Show"><i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i></a>';
                    $action .= '<a class="btn btn-danger btn-circle btn-sm m-l-10 ml-1 mr-1" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" data-id=' .  route('admin.product.delete', [$product->product_id]) . ' onclick="deleteAlert(event)"></i></a>';
                    $action .= '<a href="javascript:void(0)" class="btn btn-primary btn-circle btn-sm Showpromo" data-id="' . '' . '" data-toggle="tooltip" title="Show"><i class="fa fa-eye"></i></a>';
                    return $action;
                })
                ->rawColumns(['action', 'category_id', 'brand_id', 'productimage', 'productDetails'])
                ->make(true);
        }
        return view('backend.pages.product.index', compact('form_title', 'brands_list', 'category_list'));
    }

    public function store(Request $request)
    {
        $customMessages = [
            'product_name.required' => 'Please Enter Product name.',
            'product_details.required' => 'Please Enter product Details.',
            'product_price.required' => 'Please Enter product Price.',
            'product_qty.required' => 'Please Enter product Qty.',
        ];
        $validatedData = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_details' => 'required',
            'product_price' => 'required',
            'product_qty' => 'required',
            'brand_id' =>  'required',
            'category_name' => 'required',
            'product_image' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'error' => "error_validtion",
                'product_name' => $validatedData->errors()->first('product_name'),
                'product_details' => $validatedData->errors()->first('product_details'),
                'product_price' => $validatedData->errors()->first('product_price'),
                'product_qty' => $validatedData->errors()->first('product_qty'),
                'brand_id' => $validatedData->errors()->first('brand_id'),
                'category_name' => $validatedData->errors()->first('category_name'),
                'product_image' => $validatedData->errors()->first('product_image'),
            ]);
        }
        try {
            if ($request->hasFile('product_image')) {
                $imageName = time() . $request->product_image->getClientOriginalName();
                $request->product_image->move(public_path('/storage/productImage'), $imageName);
            }

            Product::create([
                'product_name' => $request->get('product_name'),
                'category_name' => $request->get('category_name'),
                'brand_id' => $request->get('brand_id'),
                'product_details' => $request->get('product_details'),
                'product_price' => $request->get('product_price'),
                'product_qty' => $request->get('product_qty'),
                'product_image' => $imageName,
            ]);

            smilify('success', 'Product Added. ⚡️');
            return response()->json(['success' => 'Record saved successfully.', 'statusCode' => 200]);
            // return redirect()->route('admin.product.index');
        } catch (Exception $e) {
            smilify('error', 'Sorry Product was not Added.');
            return json_encode(array(
                "statusCode" => 400
            ));
            // return redirect()->back();
        }
    }

    function edit($id, Request $request)
    {
        try {
            $form_title = "Product";
            $product = Product::where('product_id', $id)->first();
            $category_name = Category::pluck('category_name', 'category_id');
            $brand_name = Brand::pluck('brand_name', 'brand_id');
            // return response()->json([$form_title, $product, $category_name, $brand_name, 'success' => 'Product updated successfully.', 'statusCode' => 200]);
            return view('backend.pages.product.edit', compact('form_title', 'product', 'category_name', 'brand_name'));
        } catch (\Throwable $th) {
            dd($th);
            smilify('error', 'error');
        }
    }


    function update(Request $request, $id)
    {
        dd($id);
        dd($request->all());
        $customMessages = [
            'product_name.required' => 'Please Enter Product name.',
            'product_details.required' => 'Please Enter product_details.',
            'product_price.required' => 'Please Enter product_price.',
            'product_qty.required' => 'Please Enter product_qty.',
            // 'product_image.required' => 'Please Enter Image.'
        ];
        $validatedData = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_details' => 'required',
            'product_price' => 'required',
            'product_qty' => 'required',
            // 'product_image' => 'required',
            'brand_id' => 'required',
            'category_name'  => 'required'
        ], $customMessages);

        if ($validatedData->fails()) {
            // return redirect()->back()->withErrors($validatedData)->withInput();
            return response()->json([
                'error' => "error_validtion",
                'product_name' => $validatedData->errors()->first('product_name'),
                'product_details' => $validatedData->errors()->first('product_details'),
                'product_price' => $validatedData->errors()->first('product_price'),
                'product_qty' => $validatedData->errors()->first('product_qty'),
                'brand_id' => $validatedData->errors()->first('brand_id'),
                'category_name' => $validatedData->errors()->first('category_name'),
            ]);
        }

        try {
            $oldDetails = Product::where('product_id', $id)->first();
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $filename = $file->getClientOriginalName();
                $filesystem = Storage::disk('public');
                $filesystem->putFileAs('productImage', $file, $filename);
            } else {
                if (!empty($oldDetails->product_image)) {
                    $filename = $oldDetails->product_image;
                } else {
                    $filename = 'default.png';
                }
            }
            Product::where('product_id', $id)->update([
                'product_name' => $request->get('product_name'),
                'category_name' => $request->get('category_name'),
                'brand_id' => $request->get('brand_id'),
                'product_details' => $request->get('product_details'),
                'product_price' => $request->get('product_price'),
                'product_qty' => $request->get('product_qty'),
                'product_image' => $filename,
            ]);
            smilify('success', 'Product Updated. ⚡️');
            return redirect()->route('admin.product.index');
            // return response()->json(['success' => 'Product updated successfully.', 'statusCode' => 200]);
        } catch (Exception $e) {
            smilify('error', 'Sorry Product was not Updated.');
            return json_encode(array(
                "statusCode" => 400
            ));
            // return redirect()->back();
        }
    }

    function delete($id)
    {
        try {
            $product_dlt = Product::where('product_id', $id)->first();
            // Product Image also delete in storage file
            // $data = Product::find($id);
            // $image_path = public_path() . '/storage/productImage/' . $data->product_image;
            // unlink($image_path);
            // $data->delete();
            $product_dlt->delete();
            smilify('success', 'Product Deleted. ⚡️');
            return redirect()->route('admin.product.index');
        } catch (\Throwable $th) {
            smilify('error', 'Sorry Product was not deleted.');
            return json_encode(array(
                "statusCode" => 400
            ));
        }
    }
}