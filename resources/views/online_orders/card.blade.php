 @forelse ($carts as $cart)
     @php
         $priceToShow = $cart->net_price; // default retail

     @endphp
     <tr class="align-items-center" data-order-id="{{ $cart->order_id }}" data-product-id="{{ $cart->product_id }}"
         data-product-name="{{ $cart->product->product_name }}" data-product-price="{{ $priceToShow }}"
         data-discount="{{ $cart->discount }}" data-net-price="{{ $cart->net_price }}" data-qty= "{{ $cart->quantity }}"
         data-discount-type="{{ $cart->discount_type }}">
         {{-- Product Name --}}

         <td>
             <div class="d-flex align-items-center mb-1 product-info">
                 <input type="hidden" name="order_id" class="classorderID" value="{{ $cart->order_id }}">
                 <h6 class="fs-16 fw-medium"><a href="#">{{ $cart->product->product_name }}</a></h6>
                 <a href="#" class="ms-2 edit-icon editCart" data-bs-toggle="modal"
                     data-bs-target="#edit-product"><i class="ti ti-edit"></i></a>
             </div>
             <div class="info">
                 {{-- @if ($cart->return == 1)
                     <span class="badge bg-danger text-dark ms-1">Return</span>
                 @endif --}}
                 <span>{{ $cart->product->mark }}</span>
                 <p class="fw-bold text-teal">{{ $cart->product->cate->category }}</p>
             </div>
         </td>

         {{-- Quantity --}}
         <td>
             <div class="qty-item d-flex align-items-center justify-content-center position-relative"
                 style="width: 120px; height: 45px; background: #f4f6f8; border-radius: 8px;">
                 {{-- Decrease Button --}}

                 {{-- Quantity Input --}}
                 <input type="text" name="qty[]" class=" text-center border-0 fw-bold"
                     style=" background: transparent; font-size: 20px; color: #212B36;"
                     value="{{ $cart->quantity }}" readonly>
                 {{-- Increase Button --}}

             </div>
         </td>


         {{-- Item Weight --}}
         <td class="info">
             <p class="fw-bold text-teal">{{ $cart->weight }}</p>
         </td>

         {{-- Discount --}}
         <td>
             @if ($cart->discount_type == 'Flat')
                 Rs. {{ $cart->discount }}
             @elseif($cart->discount_type == 'Percentage')
                 {{ $cart->discount }}%
             @else
                 Rs. {{ $cart->discount }}
             @endif
         </td>
         {{-- Net Price --}}
         <td class="info">
             <p class="fw-bold text-teal">{{ $cart->net_price }}</p>
         </td>
         {{-- Total --}}
         <td class="info">
             <p class="fw-bold text-teal">{{ $cart->total }}</p>
         </td>
         {{-- Action --}}
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
