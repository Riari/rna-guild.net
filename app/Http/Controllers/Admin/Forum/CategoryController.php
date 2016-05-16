<?php namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Admin\Controller;
use App\Models\Forum\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display an index of forum categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.forum.category.index', [
            'categories' => Category::orderBy('weight', 'desc')->get()
        ]);
    }
}
