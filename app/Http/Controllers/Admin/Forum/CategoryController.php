<?php namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Admin\Controller;
use App\Models\Forum\Category;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notification;
use Riari\Forum\API\Dispatcher;
use Riari\Forum\Contracts\API\ReceiverContract;

class CategoryController extends Controller implements ReceiverContract
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create an admin forum category controller instance.
     */
    public function __construct()
    {
        $this->dispatcher = new Dispatcher($this);
    }

    /**
     * Return a prepared API dispatcher instance.
     *
     * @param  string  $route
     * @param  array  $parameters
     * @return Dispatcher
     */
    protected function api($route, $parameters = [])
    {
        return $this->dispatcher->route("forum.api.{$route}", $parameters);
    }

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
        return $this->edit(new Category);
    }

    /**
     * Store a new category.
     *
     * @return Response
     */
    public function store()
    {
        $category = $this->api('category.store')->parameters($request->all())->post();

        Notification::success("Forum category created");

        return redirect('admin/forum/category');
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

    /**
     * Handle a response from the dispatcher for the given request.
     *
     * @param  Request  $request
     * @param  Response  $response
     * @return Response|mixed
     */
    public function handleResponse(Request $request, Response $response)
    {
        if ($response->getStatusCode() == 422) {
            $errors = $response->getOriginalContent()['validation_errors'];
            throw new HttpResponseException(
                redirect()->back()->withInput($request->input())->withErrors($errors)
            );
        }

        return $response->isNotFound() ? abort(404) : $response->getOriginalContent();
    }
}
