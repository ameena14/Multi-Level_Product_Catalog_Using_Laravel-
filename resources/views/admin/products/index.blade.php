<script src="https://cdn.tailwindcss.com"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200 relative">
                        <!-- Image Section -->
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-md mb-4">

                        <!-- Update and Delete Buttons -->
                        <div class="absolute top-2 right-2">
                            <!-- Update Button (opens modal) -->
                            <button type="button" data-modal-target="updateModal-{{ $product->id }}" data-modal-toggle="updateModal-{{ $product->id }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 inline-flex items-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2v6l6 6-6 6V8l-6-6m0 0L8 2"></path></svg>
                            </button>
                            
                            <!-- Delete Button (direct delete) -->
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 inline-flex items-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                        </div>

                        <!-- Product Details -->
                        <div class="text-center">
                            <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
                            <p class="text-gray-500 mt-2">{{ $product->description }}</p>
                            <p class="mt-4 text-lg font-bold">${{ $product->price }}</p>

                            <div class="mt-4">
                                <p class="text-sm text-gray-600">Department: {{ $product->category->department->name }}</p>
                                <p class="text-sm text-gray-600">Category: {{ $product->category->name }}</p>
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-gray-500 text-sm">Stock: {{ $product->stock }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Update Product -->
                    <div id="updateModal-{{ $product->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                        <div class="relative w-full h-full max-w-2xl md:h-auto">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow-lg">
                                <!-- Modal Header -->
                                <div class="flex items-start justify-between p-4 border-b rounded-t">
                                    <h3 class="text-xl font-semibold">Update Product</h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-close="updateModal-{{ $product->id }}">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.293 4.293a1 1 0 011.414 0L10 6.586l2.293-2.293a1 1 0 111.414 1.414L11.414 8l2.293 2.293a1 1 0 01-1.414 1.414L10 9.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 8 6.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>
                                <!-- Modal Body -->
                                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                            <input type="text" id="name" name="name" value="{{ $product->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>

                                        <div>
                                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                            <input type="text" id="price" name="price" value="{{ $product->price }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>

                                        <div>
                                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ $product->description }}</textarea>
                                        </div>

                                        <div>
                                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                            <input type="file" id="image" name="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>

                                        <div>
                                            <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                            <input type="number" id="stock" name="stock" value="{{ $product->stock }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end p-4 space-x-2 border-t">
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Update</button>
                                        <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md" data-modal-close="updateModal-{{ $product->id }}">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // Toggle modal visibility
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                document.getElementById(modalId).classList.remove('hidden');
            });
        });

        // Close modal
        document.querySelectorAll('[data-modal-close]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-close');
                document.getElementById(modalId).classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
