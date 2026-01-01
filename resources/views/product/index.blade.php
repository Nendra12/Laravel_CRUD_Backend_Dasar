<x-app-layout>
    <div class="max-w-7xl mx-auto mt-4 sm:px-6 lg:px-8 px-2">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl">List Product</h2>
            <button class="bg-gray-200 px-10 py-2 rounded-sm font-semibold" onclick="window.location.href='{{ route('product.create') }}'">Tambah Product</button>
        </div>
        <div class="grid grid-cols-1 mt-4 gap-6 md:grid-cols-3">
            @foreach ( $products as $product )
                <div>
                    <img src="{{ url('storage/' . $product->foto) }}" alt="foto">
                    <div class="my-2">
                        <p class="text-xl font-light">{{ $product->nama }}</p>
                        <p class="font-semibold text-gray-400">Rp. {{ number_format($product->harga) }}</p>
                    </div>
                    <button class="bg-gray-200 px-10 py-2 rounded-sm w-full font-semibold">Edit</button>
                </div>
                
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
