@extends('layouts.web')
@section('title', isset($category) ? $category->name . ' - Products' : 'Products')
@section('meta_description', 'Browse our complete range of solar products including panels, inverters, batteries and mounting systems.')
@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-orange-500 to-amber-500 py-16 text-white">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold">{{ isset($category) ? $category->name : 'Our Products' }}</h1>
        <p class="text-orange-100 mt-3 text-lg">{{ isset($category) ? $category->description : 'Explore our complete range of premium solar products' }}</p>
        <nav class="mt-4 text-orange-100 text-sm">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products') }}" class="hover:text-white">Products</a>
            @isset($category)<span class="mx-2">/</span><span class="text-white font-medium">{{ $category->name }}</span>@endisset
        </nav>
    </div>
</section>

<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Sidebar Categories -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Categories</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('products') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ !isset($category) && !request('category') ? 'bg-orange-50 text-orange-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                <span><i class="fas fa-th-large mr-2"></i>All Products</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        @php $isActive = (isset($category) && $category->id === $cat->id) || request('category') === $cat->slug; @endphp
                        <li>
                            <a href="{{ route('products.category', $cat->slug) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ $isActive ? 'bg-orange-50 text-orange-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                <span><i class="{{ $cat->icon ?? 'fas fa-solar-panel' }} mr-2"></i>{{ $cat->name }}</span>
                                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $cat->products_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="card-hover bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-br from-orange-50 to-amber-50 h-48 flex items-center justify-center">
                            @if($product->image)
                            <img src="/storage/{{ $product->image }}" alt="{{ $product->name }}" class="h-40 object-contain">
                            @else
                            <i class="fas fa-solar-panel text-6xl text-orange-300"></i>
                            @endif
                        </div>
                        <div class="p-5">
                            @if($product->productCategory)
                            <span class="text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">{{ $product->productCategory->name }}</span>
                            @endif
                            <h3 class="font-bold text-gray-800 mt-2">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-xs mt-1">{{ $product->brand }}</p>
                            @if($product->description)
                            <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $product->description }}</p>
                            @endif
                            <div class="flex items-center justify-between mt-4">
                                <div>
                                    <p class="text-2xl font-bold text-orange-600">₹{{ number_format($product->selling_price) }}</p>
                                    <p class="text-gray-400 text-xs">per {{ $product->unit }}</p>
                                </div>
                                @if($product->warranty_months)
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-lg">
                                    <i class="fas fa-shield-alt mr-1"></i>{{ $product->warranty_months >= 12 ? floor($product->warranty_months/12).'yr' : $product->warranty_months.'mo' }} warranty
                                </span>
                                @endif
                            </div>
                            <a href="{{ route('get.quote') }}" class="mt-4 block text-center bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded-xl font-semibold transition-colors text-sm">Get Quote</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-10">{{ $products->links() }}</div>
                @else
                <div class="text-center py-20">
                    <i class="fas fa-solar-panel text-6xl text-gray-200 mb-4 block"></i>
                    <h3 class="text-xl font-semibold text-gray-500">No products found in this category</h3>
                    <a href="{{ route('products') }}" class="mt-4 inline-block text-orange-500 hover:underline">Browse all products</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
