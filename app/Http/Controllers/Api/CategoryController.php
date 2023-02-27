<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $categories = Category::with('brand')->get();
        // return response()->json(['status' => 'Success', 'timestamp' => Carbon::now()]);
        return json_encode([$categories, 'status' => 'Success']);
    }
}
