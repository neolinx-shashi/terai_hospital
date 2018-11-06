<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Department;

class NewsController extends Controller
{
    public function __construct() {
        $this->today = date("Y-m-d");
    }
    
    public function index() {
        $title = 'Daily Report';
        $page = 1;
        $per_page = 20;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        $list = News::orderBy('news_date', 'desc')->paginate($per_page);
        
        return view('reception.newslist', compact('list', 'page', 'per_page'));
    }
    
    public function create() {
        $date = $this->today;
        $id = '';
        $news_arr = array();
        $departments = Department::orderBy('name', 'asc')->get();
        
        return view('reception.addnews', compact('date', 'departments', 'id', 'news_arr'));
    }
    
    public function store(Request $request) {
        $input = $request->all();
        
        $insert = News::create($input);
        
        if ($insert) {
            $message = 'Data Successfully Added.';
        } else {
            $message = 'Data did not add successfully. Please Try Again.';
        }
        $request->session()->flash('message', $message);
        return redirect('/news');
    }
    
    public function edit($id) {
        $news = News::find($id);
        $date = $news->news_date;
        $news_department = rtrim($news->news_department, '-');
        $news_arr = explode('-', $news_department);
        $departments = Department::orderBy('name', 'asc')->get();
        
        return view('reception.addnews', compact('departments', 'id', 'date', 'news', 'news_arr'));
    }
    
    public function update(Request $request, $id) {
        $input = $request->all();
        
        $data = News::find($id);
        $update = $data->fill($input)->save();
        
        if ($update)
            $message = 'Data Updated Successfully.';
        else
            $message = 'Data Update Failed. Please Try Again.';
        
        $request->session()->flash('message', $message);
        return redirect('/news');
    }
    
    public function destroy(Request $request, $id) {
        $delete = News::destroy($id);
        
        if ($delete)
            $message = 'Data has be deleted successfully.';
        else
            $message = 'Data can not be deleted. Pleasy Try Again.';
        
        $request->session()->flash('message', $message);
        return redirect('/news');
    }
}
