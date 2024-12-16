<script src="https://cdn.tailwindcss.com"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4>All Departments</h4>

                    <table class="table-auto border-collapse border border-gray-300 w-full mt-4">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">ID</th>
                                <th class="border border-gray-300 px-4 py-2">Image</th>
                                <th class="border border-gray-300 px-4 py-2">Name</th>
                                <th class="border border-gray-300 px-4 py-2">Description</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <!-- Use department ID directly -->
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $department->id }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <img src="{{ Storage::url($department->image) }}" alt="{{ $department->name }}" class="w-20 h-20 object-cover mx-auto">
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $department->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $department->description }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <!-- Update Button -->
                                    <a href="#" 
                                       class="text-blue-500 hover:underline" 
                                       onclick="openModal('updateModal', {{ $department->id }}, '{{ $department->name }}', '{{ $department->description }}')">
                                        Update
                                    </a>
                                    |
                                    <!-- Add Category Button -->
                                    <a href="#" 
                                       class="text-green-500 hover:underline" 
                                       onclick="openModal('addCategoryModal', {{ $department->id }})">
                                        Add Category
                                    </a>
                                    |
                                    <!-- Delete Button -->
                                    <form action="{{ route('deleteDepartment', $department->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div id="updateModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <form method="POST" action="{{ route('updateDepartment') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="updateDepartmentId" name="department_id">
    
                <div>
                    <label for="updateName" class="block">Name:</label>
                    <input type="text" id="updateName" name="name" class="w-full mt-1 p-2 border rounded" required>
                </div>
    
                <div class="mt-4">
                    <label for="updateDescription" class="block">Description:</label>
                    <textarea id="updateDescription" name="description" class="w-full mt-1 p-2 border rounded" required></textarea>
                </div>
    
                <!-- Existing Image Preview -->
                <div class="mt-4">
                    <label class="block">Current Image:</label>
                    <img id="currentImage" src="" alt="Current Image" class="w-20 h-20 object-cover border mt-2">
                </div>
    
                <!-- File Input for New Image -->
                <div class="mt-4">
                    <label for="updateImage" class="block">Upload New Image:</label>
                    <input type="file" id="updateImage" name="image" class="w-full mt-1 p-2 border rounded">
                </div>
    
                <div class="mt-4 flex justify-end">
                    <button type="button" class="mr-4 bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal('updateModal')">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
    

    <!-- Add Category Modal -->
    <!-- Add Category Modal -->
        <div id="addCategoryModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <form method="POST" action="{{ route('addCategory') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="addCategoryDepartmentId" name="department_id" value="{{ $department->id }}">
                    <div>
                        <label for="categoryName" class="block">Category Name:</label>
                        <input type="text" id="categoryName" name="category_name" class="w-full mt-1 p-2 border rounded" required>
                    </div>
                    <div class="mt-4">
                        <label for="categoryDescription" class="block">Description:</label>
                        <textarea id="categoryDescription" name="description" class="w-full mt-1 p-2 border rounded"></textarea>
                    </div>
                    <div class="mt-4">
                        <label for="categoryImage" class="block">Image:</label>
                        <input type="file" id="categoryImage" name="image" class="w-full mt-1 p-2 border rounded">
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" class="mr-4 bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal('addCategoryModal')">Cancel</button>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add</button>
                    </div>
                </form>
            </div>
        </div>


    <script>
        function openModal(modalId, id, name, description, imageUrl) {
            // Populate fields in the modal
            document.getElementById('updateDepartmentId').value = id;
            document.getElementById('updateName').value = name;
            document.getElementById('updateDescription').value = description;

            // Set the current image URL (use the storage URL helper)
            const currentImage = document.getElementById('currentImage');
            currentImage.src = imageUrl ? `{{ Storage::url('${imageUrl}') }}` : '';
            currentImage.alt = name ? `Current image of ${name}` : 'No image available';


            // Show the modal
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
        }

        function openAddCategoryModal(departmentId) {
            document.getElementById('addCategoryDepartmentId').value = departmentId;
            document.getElementById('addCategoryModal').classList.remove('hidden');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

    </script>
</x-app-layout>
