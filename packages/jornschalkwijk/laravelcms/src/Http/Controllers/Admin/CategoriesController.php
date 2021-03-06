<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use JornSchalkwijk\LaravelCMS\Models\Category;
use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CategoriesController extends Controller
{
    use ControllerActionsTrait;

    public function index(Request $r)
    {
        if (isset($r['search'])) {
            $this->validate($r, [
                'search' => 'min:3',
            ]);
            $categories = Category::search($r['search'])->get();
        } else {
            $categories = Category::with('user')->where('categories.trashed',0)->orderBy('category_id', 'desc')->get();
        }
        return view('JornSchalkwijk\LaravelCMS::admin.categories.categories')->with(['template'=>$this->adminTemplate(),'categories' => $categories,'trashed' => 0]);
    }

    public function show(Category $category)
    {
        return view('JornSchalkwijk\LaravelCMS::admin.categories.category')->with(['template'=>$this->adminTemplate(),'category' => $category ]);
    }

    public function deleted(){
        $categories = Category::with('user')->where('categories.trashed',0)->orderBy('category_id', 'desc')->get();
        return view('JornSchalkwijk\LaravelCMS::admin.categories.categories')->with(['template'=>$this->adminTemplate(),'categories' => $categories,'trashed' => 0]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('JornSchalkwijk\LaravelCMS::admin.categories.create')->with(['categories' => $categories,'template' => $this->adminTemplate()]);
    }
    public function store(Request $r)
    {
        $this->validate($r,[
            'title' => 'required|min:3'
        ]);

        $category = new Category($r->all());
        $category->user_id = Auth::user()->user_id;
        $category->type = 'category';
        $category->save();
        return redirect()->action('Admin\CategoriesController@index');
    }
    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('JornSchalkwijk\LaravelCMS::admin.categories.edit')->with(['category' => $category,'categories' => $categories, 'template' => $this->adminTemplate()]);
    }

    public function update(Request $r, Category $category)
    {
        if ($r['confirm']) {
            $this->validate($r, [
                'title' => 'required|min:3'
            ]);

            $category->user_id = Auth::user()->user_id;
            $category->update($r->all());
            return back();
        }
    }
}
