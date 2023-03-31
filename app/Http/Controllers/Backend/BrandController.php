<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function store(Request $request)
    {
        $brandID = $request->brand_id;
        $request->validate([
            'brand_name' => 'required',
        ]);

        $brand = Brand::updateOrCreate(
            [
                'brand_id' => $brandID
            ],
            [
                'brand_name' => $request->brand_name,
            ]
        );
        return Response()->json($brand);
    }

    public function index(Request $request)
    {
        $form_title = "Brand";
        if ($request->ajax()) {
            $brands = Brand::orderBy('brand_id', 'desc');
            return DataTables::of($brands)->addIndexColumn()
                ->addColumn('action', function () {
                    $actionBtn = '-';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'brand_id'])
                ->addColumn('action', function (Brand $brand) {
                    $action  = '';
                    $action .= '<a href="javascript:void(0)" id="' . $brand->brand_id . '" class="btn btn-warning btn-circle btn-sm editBrand" ><i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i></a>';
                    $action .= '<a href="javascript:void(0)" id="' . $brand->brand_id . '" class="btn btn-danger btn-circle btn-sm ml-1 deleteBrand" ><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></a>';
                    return $action;
                })
                ->make(true);
        }
        return view('backend.pages.brand.index', compact('form_title'));
    }

    public function edit(Request $request)
    {
        $brand_id = Brand::where('brand_id', $request->id)->first();
        return Response()->json($brand_id);
    }

    public function delete(Request $request)
    {
        $brand_dltId = Brand::where('brand_id', $request->id)->first();
        $brand_dltId->delete();
        return Response()->json($brand_dltId);
    }
}
