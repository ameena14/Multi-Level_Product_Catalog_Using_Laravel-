<script src="https://cdn.tailwindcss.com"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4>All Categories</h4>

                    <table class="table-auto border-collapse border border-gray-300 w-full mt-4">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">ID</th>
                                <th class="border border-gray-300 px-4 py-2">Image</th>
                                <th class="border border-gray-300 px-4 py-2">Name</th>
                                <th class="border border-gray-300 px-4 py-2">Description</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                                <th class="border border-gray-300 px-4 py-2">Create Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">

                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $category->id }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-20 h-20 object-cover mx-auto">
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $category->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $category->description }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a href="javascript:void(0)" onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a class="text-green-500 hover:underline" onclick="openModal('addProductModal', {{ $category->id }})">Add Product</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <form method="POST" action="{{ route('categories.update', ['id' => '__ID__']) }}" id="editCategoryForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div>
                    <label for="editCategoryName" class="block">Category Name:</label>
                    <input type="text" id="editCategoryName" name="name" class="w-full mt-1 p-2 border rounded" required>
                </div>

                <div class="mt-4">
                    <label for="editCategoryDescription" class="block">Description:</label>
                    <textarea id="editCategoryDescription" name="description" class="w-full mt-1 p-2 border rounded"></textarea>
                </div>

                <div class="mt-4">
                    <label for="editCategoryImage" class="block">Image:</label>
                    <input type="file" id="editCategoryImage" name="image" class="w-full mt-1 p-2 border rounded">
                </div>

                <div class="mt-4 flex justify-end">
                    <button type="button" class="mr-4 bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal('editCategoryModal')">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>


      <!-- Add Product Modal -->
      <div id="addProductModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="addProductCategoryId" name="category_id">

                <div>
                    <label for="productName" class="block">Product Name:</label>
                    <input type="text" id="productName" name="name" class="w-full mt-1 p-2 border rounded" required>
                </div>

                <div class="mt-4">
                    <label for="productDescription" class="block">Description:</label>
                    <textarea id="productDescription" name="description" class="w-full mt-1 p-2 border rounded"></textarea>
                </div>

                <div class="mt-4">
                    <label for="productPrice" class="block">Price:</label>
                    <input type="number" id="productPrice" name="price" class="w-full mt-1 p-2 border rounded" required>
                </div>

                <div class="mt-4">
                    <label for="productStock" class="block">Stock:</label>
                    <input type="number" id="productStock" name="stock" class="w-full mt-1 p-2 border rounded" required>
                </div>

                <div class="mt-4">
                    <label for="productImage" class="block">Image:</label>
                    <input type="file" id="productImage" name="image" class="w-full mt-1 p-2 border rounded">
                </div>

                <div class="mt-4 flex justify-end">
                    <button type="button" class="mr-4 bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal('addProductModal')">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openEditModal(id, name, description) {
            const modal = document.getElementById('editCategoryModal');
            document.getElementById('editCategoryName').value = name;
            document.getElementById('editCategoryDescription').value = description;

            // Update the form action with the correct ID
            const form = document.getElementById('editCategoryForm');
            form.action = `categories/${id}`;

            modal.classList.remove('hidden');
        }

        function openModal(modalId, categoryId) {
            document.getElementById('addProductCategoryId').value = categoryId;
            document.getElementById(modalId).classList.remove('hidden');
        }
    </script>
</x-app-layout>
