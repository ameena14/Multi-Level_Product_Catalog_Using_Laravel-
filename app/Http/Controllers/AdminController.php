<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
        public function storeDepartment(Request $request)
        {
            // Validate the request
            $request->validate([
                'department_name' => 'required|string|max:255',
                'department_description' => 'required|string',
                'department_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Store the image
            $imagePath = $request->file('department_image')->store('department_images', 'public');

            // Create a new department record
            Department::create([
                'name' => $request->department_name,
                'description' => $request->department_description,
                'image' => $imagePath,
            ]);

            // Redirect to the departments page or dashboard
            return redirect()->route('admin.departments')->with('success', 'Department created successfully!');
        }



        public function showDepartments()
        {
            $departments = Department::all();
            // dd($departments);  // Add this to check if data is being fetched
            return view('admin.departments', compact('departments'));
        }


    public function updateDepartment(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Find the department
        $department = Department::findOrFail($request->department_id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($department->image) {
                Storage::disk('public')->delete($department->image);
            }

            // Store the new image in the 'public' disk
            $imagePath = $request->file('image')->store('departments', 'public');
            $department->image = $imagePath;
        }

        // Update department details
        $department->name = $request->name;
        $department->description = $request->description;

        // Save the department
        $department->save();

        // Redirect with success message
        return redirect()->route('admin.departments')->with('success', 'Department updated successfully.');
    }




        public function addCategory(Request $request)
        {
            // Validate the request
            $request->validate([
                'category_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'department_id' => 'required|exists:departments,id', // Validate department ID
            ]);

            // Store the category image if present
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('categories', 'public');
            }

            // Create the category
            $category = new Category();
            $category->name = $request->category_name;
            $category->description = $request->description;
            $category->image = $imagePath;
            $category->department_id = $request->department_id;
            $category->save();

            // Redirect or return a response
            return redirect()->route('admin.categories.index')->with('success', 'Category added successfully.');

        }



        public function deleteDepartment($id)
        {
            $department = Department::findOrFail($id);

            // Delete associated categories and image
            if ($department->image) {
                Storage::delete($department->image);
            }

            $department->categories()->delete(); // Delete related categories
            $department->delete();

            return redirect()->back()->with('success', 'Department deleted successfully.');
        }



        public function showCategories()
        {
            $categories = Category::all();
            return view('admin.categories.index', compact('categories'));
        }




        public function addProduct(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'image' => 'nullable|image|max:2048',
                'category_id' => 'required|exists:categories,id',
            ]);

            // Store the product image if present
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }

            // Create the product
            Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $imagePath,
                'category_id' => $request->category_id,
            ]);

            return redirect()->back()->with('success', 'Product added successfully.');
        }


    

    
}
