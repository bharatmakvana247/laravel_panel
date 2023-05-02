<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function create()
    {
        $form_title = "Category";
        return view('backend.pages.category.create', compact('form_title'));
    }

    public function index(Request $request)
    {
        $form_title = "Category";
        if ($request->ajax()) {
            $categories = Category::with('brand')->orderBy('category_id', 'desc');
            return DataTables::of($categories)->addIndexColumn()
                ->addColumn('action', function () {
                    $actionBtn = '-';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->addColumn('action', function (Category $category) {
                    $action  = '';
                    $action .= '<a class="btn btn-warning btn-circle btn-sm" href=' . route('admin.category.edit', [$category->category_id]) . '><i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i></a>';
                    $action .= '<a class="btn btn-danger btn-circle btn-sm m-l-10 ml-1 mr-1" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" data-id=' .  route('admin.category.delete', [$category->category_id]) . ' onclick="deleteAlert(event)"></i></a>';
                    $action .= '<a href="javascript:void(0)" class="btn btn-primary btn-circle btn-sm Showcategories" data-id="' . $category->category_id . '" data-toggle="tooltip" title="Show"><i class="fa fa-eye"></i></a>';
                    return $action;
                })
                ->make(true);
        }
        return view('backend.pages.category.index', compact('form_title'));
    }

    public function store(Request $request)
    {
        $customMessages = [
            'category_name.required' => 'Please Enter Category Name.',
        ];
        $validatedData = Validator::make($request->all(), [
            'category_name'  => 'required'
        ], $customMessages);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        Category::create([
            'category_name' => $request->get('category_name'),
        ]);

        smilify('success', 'Product Added. ⚡️');
        return redirect()->route('admin.category.index');
    }

    public function edit($id)
    {
        $form_title = "Category";
        $category = Category::where('category_id', $id)->first();
        return view('backend.pages.category.edit', compact('category', 'form_title'));
    }

    public function update(Request $request, $id)
    {
        $customMessages = [
            'category_name.required' => 'Please Enter Category Name.',
        ];

        $validatedData = Validator::make($request->all(), [
            'category_name'  => 'required'
        ], $customMessages);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        Category::where('category_id', $id)->update([
            'category_name' => $request->get('category_name'),
        ]);

        smilify('success', 'Category Updated. ⚡️');
        return redirect()->route('admin.category.index');
    }

    public function delete($id)
    {
        $category_dlt = Category::where('category_id', $id)->first();
        $category_dlt->delete();
        smilify('success', 'Category Deleted. ⚡️');
        return redirect()->route('admin.category.index');
    }

    public function show(Request $request)
    {
        $category = Category::where("category_id",$request->id)->first();
        return view('backend.pages.category.show',compact('category'));
        // return redirect()->route('admin.category.show', compact('category'));
    }
}