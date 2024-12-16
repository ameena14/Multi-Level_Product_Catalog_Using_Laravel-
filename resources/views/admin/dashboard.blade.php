<script src="https://cdn.tailwindcss.com"></script>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4>Admin Dashboard Page</h4>

                    <!-- Department Form -->
                    <form method="POST" action="{{ route('admin.departments') }}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="department_name" class="block">Department Name:</label>
                            <input type="text" id="department_name" name="department_name" class="mt-1 block w-full" required />
                        </div>

                        <div class="mt-4">
                            <label for="department_description" class="block">Department Description:</label>
                            <textarea id="department_description" name="department_description" class="mt-1 block w-full" rows="4" required></textarea>
                        </div>

                        <div class="mt-4">
                            <label for="department_image" class="block">Department Image:</label>
                            <input type="file" id="department_image" name="department_image" class="mt-1 block w-full" required />
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create Department</button>
                        </div>
                    </form>

                    <!-- Log Out -->
    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
