<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto py-8">
    <h1 class="text-center text-3xl font-bold mb-6">Departments</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($departments as $department)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $department->image) }}" alt="{{ $department->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h5 class="text-lg font-semibold mb-2">{{ $department->name }}</h5>
                    <p class="text-gray-700 text-sm mb-4">{{ $department->description }}</p>
                    <a href="{{ route('user.categories', $department->id) }}" class="inline-block bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded hover:bg-blue-600">
                        View Categories
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
