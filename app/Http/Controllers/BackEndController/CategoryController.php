<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Doctor;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->middleware('auth');
        $this->category = $category;
    }

    /***
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageCategory()
    {
        $categories = $this->category
            ->where('level', 1)
            ->where('status', 'Active')
            ->orderBy('title', 'asc')
            ->get();
        $allCategories = $this->category->get();
        return view('backendview.treeview.categoryTreeView', compact('categories', 'allCategories'));
    }

    public function manageSubcategory($catId, Request $request)
    {
        $subcategories = $this->category
            ->where('level', 2)
            ->where('status', 'Active')
            ->where('parent_id', $catId)->orderBy('title', 'asc')
            ->get();
        return $subcategories;
    }

    public function manageTests($sid, Request $request)
    {
        $tests = $this->category
            ->where('level', 3)
            ->where('status', 'Active')
            ->where('parent_id', $sid)
            ->orderBy('title', 'asc')
            ->get();
        return $tests;
    }

    public function getConsultingDoctor($id)
    {
        $category = $this->category->findOrFail($id)->title;
        //dd($category);

        $doctors = Doctor::Join('departments', 'doctors.department_id', '=', 'departments.id')
            ->select('doctors.id',
                'doctors.first_name',
                'doctors.middle_name',
                'doctors.last_name',
                'doctors.status'

            )
            ->where('departments.name', '=', 'Ultrasound')
            ->where('doctors.status', '=', 'Active')
            ->get();

        return $doctors;
    }

    public function getSubcategoryWithTests($catId, Request $request)
    {
        $subcategories = $this->category
            ->where('level', 2)
            ->where('status', 'Active')
            ->where('parent_id', $catId)
            ->orderBy('title', 'asc')
            ->get();

        foreach ($subcategories as $key => $val) {
            $sId = $val->id;
            $tests = $this->category
                ->where('level', 3)
                ->where('status', 'Active')
                ->where('parent_id', $sId)
                ->orderBy('title', 'asc')
                ->get();
            $subcategories[$key]->test_list = $tests;
        }
        return $subcategories;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $input = $request->all();
        $input['level'] = 1;
        $input['parent_id'] = 0;
        $input['price'] = 0;

        Category::create($input);
        return back()->with('success', 'New Category added successfully.');
    }

    /**
     * @param $id
     * @return string
     */
    public function CategoryCheck($id, $officeId)
    {
        $id = (int)$id;
        $category = $this->category->findOrFail($id);

        if (count($category->childs)) {

            $price = '<div id="price">';

            $price .= '<input type="text" id="price" name="price" value="parent" onchange="changeData()"> ';

            $price .= '</div>';
            return $price;
        } else {
            $price = '<input type="text" id="price" name="price" value="child" onchange="changeData()"> ';
            return $price;
        }
    }


    /* subcategory */
    public function addSubCategory(Request $request)
    {
        $this->validate($request, [
            'subcat_title' => 'required',
        ]);
        $input = $request->all();
        $input['level'] = 2;
        $input['title'] = $request->get('subcat_title');
        $input['parent_id'] = $request->get('category');
        $input['price'] = 0;

        Category::create($input);
        return back()->with('success', 'New Sub Category added successfully.');
    }

    public function getSubDetail($sId, Request $request)
    {
        $detail = $this->category->where('id', $sId)->first();
        return $detail;
    }

    public function updateSubcategory(Request $request)
    {
        $input = $request->all();
        $input['price'] = 0;
        $input['parent_id'] = $request->get('category');
        $input['title'] = $request->get('subcat_title');
        $id = $request->get('id');

        $data = Category::find($id);
        $update = $data->fill($input)->save();

        return back()->with('success', 'Sub Category updated successfully.');
    }

    /* test */
    public function addTest(Request $request)
    {
        $this->validate($request, [
            'test_title' => 'required',
        ]);
        $input = $request->all();
        $input['level'] = 3;
        $input['title'] = $request->get('test_title');
        $input['parent_id'] = $request->get('subcategory');

        Category::create($input);
        return back()->with('success', 'New Test added successfully.');
    }

    public function getTestDetail($tid, Request $request)
    {
        $detail = $this->category->where('id', $tid)->first();

        $parent_id = $detail->parent_id;
        $parent_detail = $this->category->where('id', $parent_id)->first();
        $pId = $parent_detail->parent_id;

        $detail->pId = $pId;

        //dd($detail);

        return $detail;
    }

    public function updateTest(Request $request)
    {
        $input = $request->all();
        $input['parent_id'] = $request->get('subcategory');
        $input['title'] = $request->get('test_title');
        $input['level'] = 3;
        $id = $request->get('id');

        $data = Category::find($id);
        $update = $data->fill($input)->save();

        return back()->with('success', 'Test updated successfully.');
    }

    /* edit category */
    public function editCategory(Request $request)
    {
        $categories = $this->category->where('level', 1)->orderBy('title', 'asc')->get();
        foreach ($categories as $val) {
            $id = $val->id;
            $input['title'] = $request->get($id);

            $data = Category::find($id);
            $update = $data->fill($input)->save();

        }
        return back()->with('success', 'Department updated successfully.');
    }

    public function deleteCategory($id)
    {

    }

}
