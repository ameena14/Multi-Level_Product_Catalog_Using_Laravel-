<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto py-8">
    <h1 class="text-center text-3xl font-bold mb-6">{{ $category->name }} - Products</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h5 class="text-lg font-semibold mb-2">{{ $product->name }}</h5>
                    <p class="text-gray-700 text-sm mb-4">{{ $product->description }}</p>
                    <p class="text-gray-900 font-bold mb-2">Price: ${{ $product->price }}</p>
                    <p class="text-gray-700 text-sm mb-4">Stock: {{ $product->stock }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
