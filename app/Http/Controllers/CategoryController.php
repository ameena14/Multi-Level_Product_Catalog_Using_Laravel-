<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show the list of categories
    public function index()
    {
        $categories = Category::all(); // Retrieve all categories from the database
        return view('admin.categories.index', compact('categories')); // Pass categories to the view
    }

    // Show the form for creating a new category (optional)
    public function create()
    {
        return view('admin.categories.create');
    }

    // Store a newly created category
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $category->image = $request->file('image')->store('categories', 'public'); // Store in public disk
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id); // Retrieve the category to edit
        return view('admin.categories.edit', compact('category')); // Pass category data to the view
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id); // Find the category to update
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $category->image = $request->file('image')->store('categories', 'public'); // Store in public disk
        }

        $category->save(); // Save the updated category

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    // Remove the specified category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}
