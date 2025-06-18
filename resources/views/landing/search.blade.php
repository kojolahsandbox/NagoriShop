@section('title', 'Selamat Datang')

@extends('layout_landing.app')

@section('content')

    <!-- Search Info -->
    <div class="search-info">
        <div class="search-query">Hasil pencarian untuk "{{ request()->segment(1) }}"</div>
    </div>

    <!-- Filter Section -->
    {{-- <div class="filter-section">
        <div class="filter-buttons">
            <a href="#" class="filter-button active">
                <i class="fa-solid fa-filter"></i>
                Filter
            </a>
            <a href="#" class="filter-button">
                <i class="fa-solid fa-location-dot"></i>
                Lokasi
            </a>
            <a href="#" class="filter-button">
                COD
            </a>
        </div>
        <a href="#" class="sort-button">
            <i class="fa-solid fa-sort"></i>
            Urutkan
        </a>
    </div> --}}

    <!-- Products Grid -->
    <div class="product-grid">
        <!-- Product -->
        @foreach ($products as $item)
            @php
                $sellerSlug = Str::slug($item->seller->name);
                $productSlug = Str::slug($item->name);
                $productUrl = url("/$sellerSlug/$productSlug");
                $imagePath = $item->image
                    ? asset('storage/products/' . $item->image)
                    : asset('images/default-product.png');
            @endphp
            <div class="product-card">
                <a href="{{ $productUrl }}">
                    <img src="{{ $imagePath }}" alt="Telur Ayam Kampung" class="product-image" />
                    {{-- <div class="discount-tag">-15%</div> --}}
                    <div class="product-details">
                        <h3 class="product-title">{{ $item->name }}</h3>
                        <div class="price-info">
                            <div>
                                <span class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                {{-- <span class="original-price">Rp32.000</span> --}}
                            </div>
                            {{-- <div class="rating">★ 4.9</div> --}}
                        </div>
                        {{-- <div class="sales-info">1,2RB Terjual</div>
                        <div>
                            <span class="tag tag-red">COD</span>
                            <span class="tag tag-outline">GRATIS ONGKIR</span>
                        </div>
                        <div class="location-tag">
                            <i class="fa-solid fa-location-dot"></i>
                            Padang
                        </div> --}}
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@endsection

@section('script')


@endsection
