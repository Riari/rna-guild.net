<?php namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Admin\Controller;
use App\Models\Forum\Category;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notification;

class CategoryController extends Controller
{
    /**
     * Display an index of forum categories.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.forum.category.index', [
            'categories' => Category::where('category_id', 0)->orderBy('weight', 'asc')->get()
        ]);
    }

    /**
     * Display a category creation page.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::where('category_id', 0)->orderBy('weight', 'asc')->get();
        return view('admin.forum.category.create', compact('categories'));
    }

    /**
     * Handle a category reordering request.
     *
     * @param  Request  $request
     * @return Response
     */
    public function reorder(Request $request)
    {
        $this->validate($request, ['categories' => ['required', 'array']]);

        $weight = 0;

        $categories = Category::whereIn('id', array_keys($request->input('categories')))->get();

        foreach ($request->input('categories') as $id => $parentId) {
            $categories->find($id)->update([
                'weight' => $weight,
                'category_id' => $parentId
            ]);

            $weight++;
        }

        Notification::success("Forum structure updated");

        return redirect('admin/forum/category');
    }
}
