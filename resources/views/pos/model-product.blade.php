@forelse ($products as $pro)

    <div  class="col-sm-3 col-md-3 col-lg-3 col-xl-3 product-card" style="max-width: 20%;" data-mark="{{ strtolower($pro->mark ?? 0) }}" style="max-width: 20%;" data-name="{{ strtolower($pro->variantion_value) }}">
        <div class="product-info card select-product" data-id="{{ $pro->id }}">
            <a href="javascript:void(0);" class="pro-img">
                @php
                    $images = $pro->images ? json_decode($pro->images, true) : [];
                    $imageUrl = !empty($images) ? $images[0] : asset('assets/img/products/istockphoto.png');
                @endphp
                <img src="{{ $imageUrl }}" alt="Products">

                <span><i class="ti ti-circle-check-filled"></i></span>
            </a>
            <h6 class="cat-name"><a href="javascript:void(0);">{{ $pro->cate->category ?? '' }} </a>
            </h6>
            <h6 class="product-name"><a href="javascript:void(0);">{{ $pro->product_name }} </a></h6>
            <h6 class="product-name"><a href="javascript:void(0);">{{ $pro->variantion_name ?? '' }} : {{ $pro->variantion_value ?? '' }} </a></h6>
            <div class="d-flex align-items-center justify-content-between price">
                <span>{{ $pro->quantity }} {{ $pro->unit ?? 'pcs' }}</span> <br>
                @php
                     $net = $pro->selling_price;
                    if ($pro->discount_amount) {
                        $discount = $pro->discount_amount;
                        $net = $pro->selling_price - $discount;
                    }
                @endphp
                <p>Rs {{ number_format($net, 2) }}</p>
            </div>
        </div>
    </div>

@empty
    <p class="text-center">No products found.</p>
@endforelse
