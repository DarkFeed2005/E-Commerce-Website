@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl">
                    Welcome to E-Commerce
                </h1>
                <p class="mt-3 max-w-md mx-auto text-xl text-blue-100">
                    Your one-stop marketplace for quality products from trusted vendors.
                </p>
                <div class="mt-8 flex justify-center space-x-4">
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800">
                            Get Started
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-gray-50">
                            Sign In
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800">
                            Browse Products
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-8">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($featuredProducts ?? [])
                @foreach ($featuredProducts as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        @if ($product->getMainImage())
                            <img src="{{ Storage::url($product->getMainImage()) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $product->category->name }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <div>
                                    @if ($product->discount_price)
                                        <span class="text-lg font-bold text-green-600">${{ number_format($product->getFinalPrice(), 2) }}</span>
                                        <span class="text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 01-.504.657l-3.193.233c-.658.047-1.296.745-1.264 1.402l.874 3.193a1 1 0 001.663.416l3.193-.874c.657-.182 1.355-.606 1.402-1.264l-.233-3.193a1 1 0 00-.657-.504L9.049 2.927z"/>
                                        <path d="M10 13.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"/>
                                    </svg>
                                    <span class="ml-1 text-sm text-gray-600">{{ number_format($product->rating, 1) }}</span>
                                </div>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="block w-full mt-4 bg-blue-600 text-white text-center py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">No featured products available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Categories -->
    <div class="bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-8">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse ($categories ?? [])
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}" class="group bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-300">
                            <div class="text-center">
                                @if ($category->image)
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="mx-auto h-12 w-12 text-gray-400 group-hover:text-gray-500">
                                @else
                                    <div class="mx-auto h-12 w-12 rounded-lg bg-gray-300 group-hover:bg-gray-400"></div>
                                @endif
                                <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $category->products_count }} products</p>
                            </div>
                        </a>
                    @endforeach
                @empty
                    <div class="col-span-4 text-center py-8">
                        <p class="text-gray-500">No categories available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Why Shop With Us?</h2>
            <p class="text-lg text-gray-600">We offer the best shopping experience with trusted vendors.</p>
        </div>
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Fast Shipping</h3>
                <p class="mt-2 text-gray-600">Get your orders delivered quickly and safely.</p>
            </div>
            <div class="text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zm0 8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v4m0 4h.01M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Secure Payment</h3>
                <p class="mt-2 text-gray-600">Your payment information is always secure.</p>
            </div>
            <div class="text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-7.682 7.682z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Best Quality</h3>
                <p class="mt-2 text-gray-600">We ensure all products meet quality standards.</p>
            </div>
        </div>
    </div>
</div>
@endsection