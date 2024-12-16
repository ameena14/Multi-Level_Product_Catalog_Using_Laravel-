<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Category;
use App\Models\Product;

class UserController extends Controller
{
    // Display all departments
    public function showDepartments()
    {
        $departments = Department::all();
        return view('user.departments', compact('departments'));
    }

    // Display categories under a department
    public function showCategories($id)
    {
        $department = Department::findOrFail($id);
        $categories = $department->categories;
        return view('user.categories', compact('department', 'categories'));
    }

    // Display products under a category
    public function showProducts($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products;
        return view('user.products', compact('category', 'products'));
    }
}
