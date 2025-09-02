@forelse ($carts as $cart)
    <tr data-order-id="{{ $cart->order_id }}" data-product-id="{{ $cart->product_id }}"
        data-product-name="{{ $cart->product->product_name }}" data-product-price="{{ $cart->product->selling_price }}"
        data-discount="{{ $cart->discount }}" data-net-price="{{ $cart->net_price }}" data-qty= "{{ $cart->quantity }}"
        data-discount-type="{{ $cart->discount_type }}">
        {{-- <td>

            <div class="d-flex align-items-center mb-1 product-info" style="max-width: 50%; max-height: 50%;">
                <a href="javascript:void(0);" class="pro-img">
                    <img src="assets/img/products/pos-product-04.png" alt="Products">
                </a>
            </div>
        </td> --}}
        <td>
            <div class="d-flex align-items-center mb-1 product-info">
                <input type="hidden" name="order_id" class="classorderID" value="{{ $cart->order_id }}">
                <h6 class="fs-16 fw-medium"><a href="#">{{ $cart->product->product_name }}</a></h6>
                <a href="#" class="ms-2 edit-icon editCart" data-bs-toggle="modal"
                    data-bs-target="#edit-product"><i class="ti ti-edit"></i></a>

            </div>
            <div class="info">
                @if ($cart->return == 1)
                    <span class="badge bg-danger text-dark ms-1">Return</span>
                @endif
                <span>{{ $cart->product->item_code }}</span>
                <div class="fw-bold text-teal">{{ $cart->product->unit }}</div>
                <p class="fw-bold text-teal"> Rs. {{ $cart->product->selling_price }}</p>
            </div>
        </td>
        <td>
            <div class="qty-item d-flex align-items-center justify-content-center position-relative"
                style="width: 140px; height: 45px; background: #f4f6f8; border-radius: 8px;">

                @php
                    $unit = strtolower($cart->product->unit); // e.g., pcs, g, kg
                    $isWeightBased = in_array($unit, ['g', 'kg','l','ml']);
                @endphp

                {{-- Decrease Button (disable for g/kg) --}}
                <a href="javascript:void(0);"
                    class="btn btn-light btn-sm d-flex align-items-center justify-content-center decrease {{ $isWeightBased ? 'disabled pointer-none' : '' }}"
                    style="width: 32px; height: 32px; border-radius: 50%; position: absolute; left: 5px; top: 50%; transform: translateY(-50%);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 448 512"
                        fill="#092C4C">
                        <path
                            d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z" />
                    </svg>
                </a>
                <form action="{{ route('unitCart.update') }}" method="post" class="qty-form">
                    @csrf
                    {{-- Quantity Input --}}
                    <input type="text" name="qty"
                        data-unit="{{ $cart->product->unit }}"
                        class="text-center border-0 fw-bold cart-qty-input {{ $unit == 'pcs' ? 'No-remove-text' : 'remove-text' }}"
                        style="width: 70px; background: transparent; font-size: 16px; color: #212B36;"
                        value="{{ $cart->quantity }}" step="{{ $unit == 'kg' ? '0.001' : ($unit == 'g' ? '1' : '1') }}"
                        min="0" {{ $isWeightBased ? '' : 'readonly' }}>
                    <input type="hidden" name="product_id" value="{{ $cart->product_id }}">
                    <input type="hidden" name="order_id" value="{{ $cart->order_id }}">
                    <button type="submit" hidden></button>
                </form>
                {{-- Increase Button (disable for g/kg) --}}
                <a href="javascript:void(0);"
                    class="btn btn-light btn-sm d-flex align-items-center justify-content-center increase {{ $isWeightBased ? 'disabled pointer-none' : '' }}"
                    style="width: 32px; height: 32px; border-radius: 50%; position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 448 512"
                        fill="#092C4C">
                        <path
                            d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                    </svg>
                </a>
            </div>
            {{-- <div class="text-center fw-semibold" style="font-size: 13px;">
                {{ strtoupper($cart->product->unit) }}
            </div> --}}
        </td>

        <td class="fw-bold text-teal">
            @if ($cart->discount_type == 'Flat')
                Rs. {{ $cart->discount }}

            @elseif($cart->discount_type == 'Percentage')
                {{ $cart->discount }}%

            @else
                {{ $cart->discount }}Rs
            @endif
        </td>
        <td class="info">
            <p class="fw-bold text-teal">{{ $cart->net_price }}</p>
        </td>
        <td class="info">
            <p class="fw-bold text-teal">{{ $cart->total }}</p>
        </td>
        <td class="text-end  align-items-center action">
            <a class="btn-icon delete-icon editCart" href="javascript:void(0);" data-bs-toggle="modal"
                data-bs-target="#edit-product">
                <i class="ti ti-edit" style="font-size: 200%;"></i>
            </a>
            <a class="btn-icon delete-icon deleteCart" href="javascript:void(0);" data-bs-toggle="modal"
                data-bs-target="#delete">
                <i class="ti ti-trash" style="font-size: 200%;"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="10" class="text-center">
            <div class="mb-1">
                <img src="{{ asset('assets/img/icons/empty-cart.svg') }}" alt="img">
            </div>
            <p class="fw-bold">No Products Selected</p>
        </td>
    </tr>
@endforelse
