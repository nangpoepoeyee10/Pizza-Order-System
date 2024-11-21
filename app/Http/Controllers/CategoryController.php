<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function createPage()
    {
        return view('admin.category.create');
    }
    public function create(Request $request)
    {
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list');
    }
    public function list()
    {
        $categories = Category::when(request('key'), function ($query) {
            $query->where('name', 'like', '%' . request('key') . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(3);
        $categories->appends(request()->all());
        return view('admin.category.list', compact('categories'));
    }
    public function delete($id)
    {
        Category::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'delete success']);
    }
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }
    public function update(Request $request)
    {
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::where('id', $request->categoryId)->update($data);
        return redirect()->route('category#list');
    }
    private function categoryValidationCheck($request)
    {
        Validator::make($request->all(), [
            'categoryName' => 'required|unique:categories,name,' . $request->categoryId //can update by self
        ])->validate();
    }
    private function requestCategoryData($request)
    {
        return [
            'name' => $request->categoryName
        ];
    }
}
