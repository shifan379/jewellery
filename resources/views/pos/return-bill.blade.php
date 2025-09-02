<div class="product-order-list">
    <div class="order-head bg-light d-flex align-items-center justify-content-between w-100">
        <div>
            <h3>Order List</h3>
            <span>Invoice ID : {{ $orders->invoice_no  }}</span><br>
            <span>Customer Name: {{ $orders->customer->first_name ?? 'Walk on Customer'  }}</span> <br>
            <span>Issue Date: {{ \Carbon\Carbon::parse($orders->created_at)->format('d.m.Y h.i A') }} </span>
        </div>
    </div>
</div>
<hr>
<div class="product-added block-section">
    <div class="head-text d-flex align-items-center justify-content-between">
        <h5 class="d-flex align-items-center mb-0">Product List</h5>

    </div>
    <div class="product-wrap">
        <div id="product-list">
            <div class="product-list align-items-center justify-content-between">
                <div class="table-responsive" style="width: 100%; ">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="align-items-center ">
                                <th class="bg-transparent fw-bold">#</th>
                                <th class="bg-transparent fw-bold">Product</th>
                                <th class="bg-transparent fw-bold">QTY</th>
                                <th class="bg-transparent fw-bold">Dis</th>
                                <th class="bg-transparent fw-bold">Net</th>
                                <th class="bg-transparent fw-bold">Price</th>
                                <th class="bg-transparent fw-bold text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders->items as $cart)
                                <tr class="align-items-center return-row">
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" class="row-checkbox" checked>
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center mb-1 product-info">
                                            <input type="hidden" name="order_id[]" class="orderItemID"
                                                value="{{ $cart->id }}">
                                            <h6 class="fs-16 fw-medium"><a
                                                    href="#">{{ $cart->product->product_name }}</a></h6>

                                        </div>
                                        <div class="info">
                                            <span>{{ $cart->product->item_code }}</span>
                                            <p class="fw-bold text-teal">Rs. {{ $cart->product->selling_price }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="qty-item d-flex align-items-center justify-content-center position-relative"
                                            style="width: 120px; height: 45px; background: #f4f6f8; border-radius: 8px;">
                                            {{-- Decrease Button --}}
                                            <a href="javascript:void(0);"
                                                class="btn btn-light btn-sm d-flex align-items-center justify-content-center decrease"
                                                style="width: 32px; height: 32px; border-radius: 50%; position: absolute; left: 5px; top: 50%; transform: translateY(-50%);">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 448 512" fill="#092C4C">
                                                    <path
                                                        d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z" />
                                                </svg>
                                            </a>
                                            {{-- Quantity Input --}}
                                            <input type="text" name="qty[]" class=" text-center border-0 fw-bold"
                                                style="width: 50px; background: transparent; font-size: 20px; color: #212B36;"
                                                value="{{ $cart->qty }}" readonly>
                                            {{-- Increase Button --}}
                                            <a href="javascript:void(0);"
                                                class="btn btn-light btn-sm d-flex align-items-center justify-content-center increase"
                                                style="width: 32px; height: 32px; border-radius: 50%; position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 448 512" fill="#092C4C">
                                                    <path
                                                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-teal">
                                          Rs. {{ $cart->discount }}
                                    </td>
                                    <td class="info">
                                        <p class="fw-bold text-teal">{{ $cart->net_price }}</p>
                                    </td>
                                    <td class="info">
                                        <p class="fw-bold text-teal">{{ $cart->total }}</p>
                                    </td>
                                    <td class="text-end  align-items-center action">

                                        <a class="btn-icon delete-icon removewithBill" href="javascript:void(0);"
                                           >
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
