<x-sales-layout>
    @section('title', 'Dashboard')

    @push('css')
        <style>
            html,
            body {
                height: auto !important;
                overflow-y: auto !important;
                overscroll-behavior-y: contain;
            }

            body.modal-open {
                overflow-y: auto !important;
                padding-right: 0 !important;
            }

            .content,
            .page-wrapper,
            .pos-pg-wrapper {
                overflow-y: visible !important;
                height: auto !important;
            }

            html {
                scroll-behavior: smooth;
            }

            .discount-group {
                gap: 0.5rem;
            }

            .discount-input {
                display: flex;
                align-items: center;
                border: 1px solid #ccc;
                border-radius: 6px;
                overflow: hidden;
                background: #fff;
            }

            .discount-input input {
                border: none;
                outline: none;
                padding: 6px 10px;
                width: 80px;
                font-size: 14px;
            }

            .discount-input span {
                padding: 6px 10px;
                background: #f5f5f5;
                font-size: 14px;
                color: #333;
                border-left: 1px solid #ccc;
            }

            #phone_suggestions {
                border: 1px solid #ccc;
                background: white;
                width: 100%;
                max-height: 150px;
                overflow-y: auto;
            }

            .suggestion-item {
                padding: 5px 10px;
                cursor: pointer;
            }

            .suggestion-item:hover {
                background-color: #f0f0f0;
            }

            .return-mode-banner {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 9999;
                padding: 10px;
                text-align: center;
                font-weight: bold;
                font-size: 16px;
                border-bottom: 2px solid darkred;
                animation: blinkBanner 1s infinite;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .return-mode-banner i {
                font-size: 18px;
            }

            .keypad-grid {
                display: grid;
                grid-template-columns: repeat(4, 60px);
                grid-template-rows: repeat(4, 60px);
                gap: 10px;
                justify-content: center;
                margin-top: 10px;
            }

            .keypad-btn {
                background: #111;
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 1.5rem;
                font-weight: bold;
                width: 60px;
                height: 60px;
                transition: background 0.2s;
                display: flex;
                align-items: center;
                justify-content: center;
                outline: none;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            }

            .keypad-btn:active {
                background: #333;
            }

            .keypad-clear {
                background: #888 !important;
                color: #fff !important;
            }

            .keypad-ent {
                background: #3EB780 !important;
                color: #fff !important;
            }

            .keypad-barcode {
                background: #7cd4e4 !important;
                color: #fff !important;
                font-size: 1.3rem;
            }

            .keypad-btn[disabled],
            .keypad-btn[style*="visibility: hidden"] {
                background: transparent !important;
                border: none;
                box-shadow: none;
            }

            .page-header-todayRate {
                background: #111;
                /* Dark background */
                color: #fff;
                overflow: hidden;
                white-space: nowrap;
                padding: 10px 0;
                border-radius: 8px;
            }

            .marquee {
                display: inline-block;
                padding-left: 100%;
                /* Push text off screen */
                animation: marquee 30s linear infinite;
            }

            .marquee p {
                display: inline-block;
                font-size: 18px;
                font-weight: bold;
                color: #ffcc00;
                /* Promo color */
                margin: 0;
            }

            @keyframes marquee {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-100%);
                }
            }
        </style>


        <style media="print">
            #receipt-content,
            #receipt-content * {
                visibility: visible;
            }

            #receipt-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        </style>
        <style>
        </style>
    @endpush

    @php
        $returnMode = session()->has('returnEnable');
    @endphp

    @section('content')
        <div class="page-wrapper pos-pg-wrapper ms-0">
            <div class="content pos-design p-0">
                <div class="page-header-todayRate">
                    <div class="marquee">
                        @if ($todayRate->isNotEmpty())
                            <p>💰 Today Gold Rate:
                                @foreach ($todayRate as $rate)
                                    <span>{{ $rate->category->category }} - LKR {{ $rate->rate }} per gram | </span>
                                @endforeach

                                💰 Stay Updated with Latest Rates!
                            </p>
                        @else
                            <p style="color: red">⚠️ Gold Rate data is missing. Please update with the latest values to avoid
                                using outdated rates in billing.</p>
                        @endif

                    </div>
                </div>
                <div class="content">

                    <br>
                    <div class="page-header">

                        <div class="product-order-list">
                            <div class="order-head bg-light d-flex align-items-center justify-content-between w-100">
                                <div>
                                    <h3>Order List</h3>
                                    <span>Transaction ID : {{ $orderId ?? $edit_order->id }}</span>
                                </div>
                            </div>
                        </div>

                        <ul class="table-top-head">
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                                        class="ti ti-refresh"></i></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                        class="ti ti-chevron-up"></i></a>
                            </li>
                            <li>
                                <a href="{{ url()->previous() }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Back">
                                    <i class="ti ti-arrow-left"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form  method="POST" action="{{ route('save.onlineOrder') }}">
                        @csrf
                        <div class="card border-0">
                            <div class="card-body pb-0">
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="barcodeInput" class="form-label">Product <span
                                                class="text-danger ms-1">*</span></label>
                                        <div class="card pos-button">
                                            <div class="d-flex align-items-center ">

                                                <div style="width: 200%;"
                                                    class="input-icon-start search-pos position-relative mb-2 me-3">
                                                    <span class="input-icon-addon">
                                                        <i class="ti ti-search"></i>
                                                    </span>
                                                    <input type="hidden" id="orderID" value="{{ $orderId  ?? $edit_order->id }}">
                                                    <input type="text" class="form-control barcodeInput"
                                                        id="barcodeInput" placeholder="Scan Item or Search Product"
                                                        onfocus="lastFocusedInput = this;" />
                                                </div>
                                                <a href="javascript:void(0);" id="scan-barcode-btn"
                                                    class="btn btn-md btn-indigo"><i class="ti ti-scan me-1"></i>Scan</a>
                                            </div>
                                            <div class="search-info search-productsList d-none">
                                                <ul class="customers" id="productData">
                                                    @forelse ($products as $product)
                                                        <li>
                                                            <a class="add-product" data-code="{{ $product['mark'] }}">
                                                                {{ $product['product_name'] }}-{{ $product['unit'] }}
                                                                ({{ $product['weight'] }}g)
                                                            </a>
                                                        </li>
                                                    @empty
                                                        <li><a class="add-product">No products found</a></li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <!-- Customer Phone -->
                                    <div class="col-lg-3 col-sm-3 col-12 position-relative">
                                        <div class="mb-3">
                                            <label class="form-label" for="phone_number">Customer Number <span
                                                    class="text-danger ms-1">*</span></label>

                                            <input type="number" class="form-control" id="phone_number"
                                                            @if (!empty($edit_order))
                                                                value="{{ $edit_order->customer->phone ?? '' }}"
                                                            @endif
                                                name="phone_number">

                                            <div id="phone_suggestions" class="dropdown-menu show d-none"
                                                style="position: absolute; top: 100%; z-index: 999;"></div>
                                        </div>
                                    </div>

                                    <!-- Customer Name -->
                                    <div class="col-lg-3 col-sm-3 col-12 position-relative">
                                        <div class="mb-3">
                                            <label class="form-label" for="first_name">Customer Name <span
                                                    class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" id="customer_name"
                                                @if (!empty($edit_order))
                                                    value="{{ $edit_order->customer->first_name ?? '' }}"
                                                @endif
                                                name="customer_name">
                                            <div id="name_suggestions" class="dropdown-menu show d-none"
                                                style="position: absolute; top: 100%; z-index: 999;"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-3 col-12 position-relative">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Address <span
                                                    class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" id="address"
                                                @if (!empty($edit_order))
                                                    value="{{ $edit_order->customer->address ?? '' }}"
                                                @endif
                                                name="address">
                                        </div>
                                    </div>
                                    <!-- Customer NIC -->
                                    <div class="customerNIC col-lg-3 col-sm-3 col-12 position-relative @if(!empty($edit_order) && !empty($edit_order->customer->customer_nic))  @else d-none @endif">
                                        <div class="mb-3">
                                            <label class="form-label" for="customer_nic">Customer NIC <span
                                                    class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control" id="customer_nic"
                                            @if (!empty($edit_order))
                                                 value="{{ $edit_order->customer->customer_nic ?? '' }}"
                                             @endif name="customer_nic">

                                            <div id="nic_suggestions" class="dropdown-menu show d-none"
                                                style="position: absolute; top: 100%; z-index: 999;"></div>
                                        </div>
                                    </div>
                                    <!-- Product table -->
                                    <div id="product-list" class="table-responsive no-pagination mb-3">
                                        <div class="product-list align-items-center justify-content-between">
                                            <div class="head-text d-flex align-items-center justify-content-between">
                                                <h5 class="d-flex align-items-center mb-0">Product Added</h5>
                                                <a href="javascript:void(0);"
                                                    class="d-flex align-items-center link-danger voidCart"><span
                                                        class="me-2"><i data-feather="x"
                                                            class="feather-16"></i></span>Clear
                                                    all</a>
                                            </div>
                                            <br>
                                            <table class="table datanew" id="cart-table">
                                                <thead>
                                                    <tr>
                                                        <th>Item Name</th>
                                                        <th>Qty</th>
                                                        <th>Weight</th>
                                                        <th>Discount($)</th>
                                                        <th>Net Price($)</th>
                                                        <th>Total Cost(%)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cart-body2">

                                                    @include('online_orders.card')

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="block-section">
                                        <div class="col-lg-6 ms-auto">
                                            <div class="total-order w-100 max-widthauto m-auto mb-4">
                                                <ul class="border-1 rounded-2 customer-sheet d-none"
                                                    style="border-color: red;">
                                                    <li style="border-color: red;" class="border-bottom ">
                                                        <h4 class="border-end text-danger customer-sheet-heading"></h4>
                                                        <h5 class="text-danger" id="TotalCustBalance"></h5>
                                                        <input type="hidden" class="typeCust" name="typeCust">
                                                        <input type="hidden" class="custAmount" name="custAmount">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Summary -->
                                    <div class="row block-section" id="amount">
                                        @include('online_orders.amount')

                                    </div>
                                    <!-- Order Inputs -->
                                    <div class="row">
                                        <div class="col-6">

                                        </div>
                                        <div class="col-6">
                                            <div class=" btn-row d-sm-flex align-items-center justify-content-between">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-cyan d-flex align-items-center justify-content-center flex-fill payment-cash"><i
                                                        class="ti ti-cash-banknote  me-2"></i>Cash</a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-success d-flex align-items-center justify-content-center flex-fill payment-card"><i
                                                        class="ti ti-credit-card me-2"></i>Debit Card</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Buttons Footer -->
                                <div class="card-footer bg-white border-0 pt-0">
                                    <div class="text-center">
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#payIN"
                                            class="btn btn-indigo d-inline-flex align-items-center justify-content-center"><i
                                                class="ti ti-cash-banknote  me-2"></i>Pay In</a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-purple d-inline-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#payout"><i
                                                class="ti ti-cash-banknote  me-2"></i>Pay
                                            Out</a>
                                        <button type="button" class="btn btn-danger me-2"
                                            onclick="window.open(window.location.href, '_blank');">
                                            <i class="ti ti-player-pause"></i> Hold
                                        </button>

                                        <a href="javascript:void(0);"
                                            class="btn btn-teal d-inline-flex align-items-center justify-content-center applyDiscount"><i
                                                class="ti ti-percentage me-2"></i>Discount</a>

                                        <a href="javascript:void(0);" onclick="returnModel()"
                                            class="btn btn-pink d-inline-flex align-items-center justify-content-center  ">
                                            <i class="ti ti-truck-return me-2"></i>
                                            Old Gold
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- pay in -->
        <div class="modal fade modal-default" id="payIN">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pay In</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div>
                        <div class="modal-body pb-1">
                            <div class="row align-items-start pos-wrapper">
                                <div class="col-md-12 col-lg-6 col-xl-6">
                                    <div class="row" style="text-align: center">
                                        <h4>Welcome, {{ Auth::user()->name ?? 'Cashier' }}!</h4>
                                        <p>Please enter your Pay-In amount to begin.</p>
                                    </div>


                                    <input type="hidden" name="user_name"
                                        value="{{ Auth::user()->name ?? 'Cashier' }}">


                                    <div class="mb-3">
                                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                                        <div class="input-icon-start position-relative">
                                            <span class="input-icon-addon text-gray-9">
                                                Rs.
                                            </span>
                                            <input type="number" class="form-control" id="payin" name="payin">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="summer-description-box">
                                            <label class="form-label">Reason</label>
                                            <textarea name="reason" id="summernote2"></textarea>
                                            <p class="fs-14 mt-1">Maximum 60 Words</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-6 ps-0 theiaStickySidebar">
                                    <div class="keypad mb-3 align-items-center justify-content-between flex-wrap">
                                        <p class="text-muted">Use keypad below to enter amount</p>
                                        <div class="keypad-grid">
                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('7')">7</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('8')">8</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('9')">9</button>
                                            <button type="button" class="keypad-btn" disabled></button>

                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('4')">4</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('5')">5</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('6')">6</button>
                                            <button type="button" class="keypad-btn" disabled></button>

                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('1')">1</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('2')">2</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('3')">3</button>
                                            <button type="button" class="keypad-btn" disabled></button>

                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('0')">0</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payINAmount('.')">.</button>
                                            <button type="button" class="keypad-btn keypad-clear"
                                                onclick="payINclearAmount()">CLR</button>
                                            <button class="keypad-btn" disabled></button>

                                            <button type="button" style="width: 335%" onclick="savePayIn()"
                                                class="keypad-btn  keypad-ent ">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer d-flex justify-content-end flex-wrap gap-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pay in -->

        <!-- pay out -->
        <div class="modal fade modal-default" id="payout">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pay Out</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div>
                        <div class="modal-body pb-1">
                            <div class="row align-items-start pos-wrapper">
                                <div class="col-md-12 col-lg-6 col-xl-6">
                                    <div class="row" style="text-align: center">
                                        <h4>Welcome, {{ Auth::user()->name ?? 'Cashier' }}!</h4>
                                        <p>Please enter your Pay-Out amount to begin.</p>
                                    </div>


                                    <input type="hidden" name="user_name"
                                        value="{{ Auth::user()->name ?? 'Cashier' }}">


                                    <div class="mb-3">
                                        <label class="form-label">Amount <span class="text-danger">*</span></label>
                                        <div class="input-icon-start position-relative">
                                            <span class="input-icon-addon text-gray-9">
                                                Rs.
                                            </span>
                                            <input type="number" class="form-control" id="payoutamount" name="payin">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="summer-description-box">
                                            <label class="form-label">Reason</label>
                                            <textarea name="reason" id="summernote3"></textarea>
                                            <p class="fs-14 mt-1">Maximum 60 Words</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-6 ps-0 theiaStickySidebar">

                                    <div class="keypad mb-3 align-items-center justify-content-between flex-wrap">
                                        <p class="text-muted">Use keypad below to enter amount</p>

                                        <div class="keypad-grid">
                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('7')">7</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('8')">8</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('9')">9</button>
                                            <button type="button" class="keypad-btn" disabled></button>

                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('4')">4</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('5')">5</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('6')">6</button>
                                            <button type="button" class="keypad-btn" disabled></button>

                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('1')">1</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('2')">2</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('3')">3</button>
                                            <button type="button" class="keypad-btn" disabled></button>

                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('0')">0</button>
                                            <button type="button" class="keypad-btn"
                                                onclick="payOutAmount('.')">.</button>
                                            <button type="button" class="keypad-btn keypad-clear"
                                                onclick="payOutclearAmount()">CLR</button>
                                            <button class="keypad-btn" disabled></button>

                                            <button type="button" style="width: 335%" onclick="savePayOut()"
                                                class="keypad-btn  keypad-ent ">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer d-flex justify-content-end flex-wrap gap-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pay out -->
        <!-- Discount -->

        <div class="modal fade modal-default" id="showdiscount">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Discount </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="discountForm" onsubmit="return submitDiscount();">
                        <div class="modal-body pb-1">
                            <div class="mb-3">
                                <div class="discount-wrapper d-flex align-items-center mb-3">
                                    <div class="discount-group d-inline-flex align-items-center">
                                        <label class="me-2">Order Discount</label>
                                        <input type="hidden" name="rowId" id="subtotal">
                                        <div class="discount-input me-2">
                                            <input type="number" name="discount"
                                                class="discount_percent_total form-control" min="0" step="0.01"
                                                placeholder="%">
                                            <span>%</span>
                                        </div>

                                        <div class="discount-input">
                                            <input type="number" name="discount_total"
                                                class="discount_amount_total form-control" min="0"
                                                placeholder="Rs" step="0.01">
                                            <span>Rs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end flex-wrap gap-2">
                            <button type="button" class="btn btn-md btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-md btn-primary">Apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Discount -->

        <!-- Cash Checkout Modal -->
        <!-- Payment Cash -->
        <div class="modal fade modal-default" id="payment-cash">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cash Book</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="saveOrder" action="{{ route('save.onlineOrder') }}" method="POST">
                        @csrf
                        <div class="modal-body pb-1">
                            <div class="row">
                                <div class="quick-cash payment-content bg-light  mb-3">
                                    <div class="d-flex align-items-center flex-wra gap-4">
                                        <h5 class="text-nowrap">Quick Cash</h5>
                                        <div class="d-flex align-items-center flex-wrap gap-3">
                                            <div class="form-check">
                                                <input type="radio" class="btn-check" name="cash" id="cash20">
                                                <label class="btn btn-white" onclick="quickCashBook('50')"
                                                    for="cash20">50</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="btn-check" name="cash" id="cash21">
                                                <label class="btn btn-white" onclick="quickCashBook('100')"
                                                    for="cash21">100</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="btn-check" name="cash" id="cash22">
                                                <label class="btn btn-white" onclick="quickCashBook('500')"
                                                    for="cash22">500</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="btn-check" name="cash" id="cash23">
                                                <label class="btn btn-white" onclick="quickCashBook('1000')"
                                                    for="cash23">1000</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="btn-check" name="cash" id="cash24">
                                                <label class="btn btn-white" onclick="quickCashBook('5000')"
                                                    for="cash24">5000</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-start pos-wrapper">
                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                        <div class="row">
                                            {{-- Hidden Values --}}
                                            <input type="hidden" class="valueCustomer" name="phone_number"
                                                id="modal_phone_number">
                                            <input type="hidden" name="customer_name" id="modal_customer_name">
                                            <input type="hidden"  name="customer_nic"
                                                id="modal_customer_nic">
                                                <input type="hidden"  name="address"
                                                id="modal_address">

                                            <input type="hidden" name="orderID" value="{{ $orderId ?? $edit_order->id }}">



                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Payment Type <span
                                                            class="text-danger">*</span></label>
                                                    <select name="payment_type" class="select select-payment">
                                                        <option value="credit">Credit Card</option>
                                                        <option value="cash">Cash</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Total Amount <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-icon-start position-relative">
                                                        <span class="input-icon-addon text-gray-9">
                                                            Rs.
                                                        </span>
                                                        <input type="text" name="total_amount"
                                                            class="form-control  total_amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 TotalwithBalance ">
                                                <div class="mb-3">
                                                    <label class="form-label">Total with Balance <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-icon-start position-relative">
                                                        <span class="input-icon-addon text-gray-9">
                                                            Rs.
                                                        </span>
                                                        <input type="text" name="total_with_balance"
                                                            class="form-control  total_with_balance" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 received_div d-none">
                                            <label class="form-label">Received Amount <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-icon-start position-relative">
                                                <span class="input-icon-addon text-gray-9">
                                                    Rs.
                                                </span>
                                                <input type="number" name="received_amount" id="received_amount"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="mb-3 card_div ">
                                            <label class="form-label">Credit Card Number(Last 3) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="credit_card_number" id="credit_card_number"
                                                class="form-control" />
                                        </div>

                                        <div class="row ">
                                            <div class="col-6">
                                                <div class="mb-3 change_div">
                                                    <label class="form-label">Change <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-icon-start position-relative">
                                                        <span class="input-icon-addon text-gray-9">
                                                            Rs.
                                                        </span>
                                                        <input type="text" class="form-control change_amount"
                                                            id="change_amount" name="change_amount">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 balance_div d-none">
                                                <div class="mb-3">
                                                    <label class="form-label">Balance <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-icon-start position-relative">
                                                        <span class="input-icon-addon text-gray-9">Rs.</span>
                                                        <input type="text" class="form-control balance" id="balance"
                                                            name="balance">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6  advance_payment d-none">
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input is-invalid" type="checkbox"
                                                            name="advance_payment" id="invalidCheck3">
                                                        <label class="form-check-label changeLable" for="invalidCheck3">
                                                            Take this to Advance Payment
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h4 class="text-danger show-error"></h4>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 payment-completed">Save
                                            Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end flex-wrap gap-2">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Payment Cash  -->

        <!-- Return -->
        <div class="modal fade modal-default" id="return">
            <div class="modal-dialog modal-fullscreen modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Return Items</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div>
                        <div class="modal-body pb-1">
                            <div class="row">
                                <div class="pos-categories tabs_wrapper pb-0">

                                    <div class="card pos-button">
                                        <div class="d-flex align-items-center ">

                                            <div style="width: 200%;"
                                                class="input-icon-start search-pos position-relative mb-2 me-3">
                                                <span class="input-icon-addon">
                                                    <i class="ti ti-search"></i>
                                                </span>
                                                <input type="text" class="form-control scan_bill"
                                                    placeholder="Scan Bill">
                                            </div>
                                            <a href="javascript:void(0);" class="btn btn-md btn-indigo"><i
                                                    class="ti ti-scan me-1"></i>Scan</a>
                                        </div>
                                    </div>

                                    <div class="pos-products">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4></h4>
                                            <div class="input-icon-start  position-relative mb-3 ">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-md btn-danger confirm-return"><i
                                                        class="ti ti-layout-grid-add me-1"></i>Confirm Return</a>
                                            </div>
                                        </div>
                                        <div class="tabs_container">
                                            <div class="tab_content active" data-tab="all">
                                                <div class="row show-bill">


                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end flex-wrap gap-2">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Completed -->
        <div class="modal fade modal-default" id="payment-completed" aria-labelledby="payment-completed">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="success-wrap text-center">
                            <form action="{{ route('sales.print') }}" method="POST">
                                @csrf
                                <div class="icon-success bg-success text-white mb-2">
                                    <i class="ti ti-check"></i>
                                </div>
                                <input type="hidden" id="completedOrderID" name="order_id">
                                <h3 class="mb-2">Payment Completed</h3>
                                <p class="mb-3">Do you want to Print Receipt for the Completed Order</p>
                                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <button type="submit" class="btn btn-md btn-secondary">Print Receipt<i
                                            class="feather-arrow-right-circle icon-me-5"></i></button>
                                    <a href="{{ url()->current() }}" class="btn btn-md btn-primary">Next
                                        Order</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Payment Completed -->


        <!-- Barcode -->
        <div class="modal fade modal-default" id="barcode">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Product List</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div>
                        <div class="modal-body pb-1">
                            <div class="row">
                                <div class="pos-categories tabs_wrapper pb-0">

                                    <div class="card pos-button">
                                        <div class="d-flex align-items-center ">

                                            <div style="width: 200%;"
                                                class="input-icon-start search-pos position-relative mb-2 me-3">
                                                <span class="input-icon-addon">
                                                    <i class="ti ti-search"></i>
                                                </span>
                                                <input type="text" class="form-control search_items"
                                                    placeholder="Search items">
                                            </div>
                                            <a href="javascript:void(0);" class="btn btn-md btn-indigo"><i
                                                    class="ti ti-scan me-1"></i>Search</a>
                                        </div>
                                    </div>

                                    <div class="pos-products">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-3">Products</h4>
                                            <div class="input-icon-start pos-search position-relative mb-3">
                                                <span class="input-icon-addon">
                                                    <i class="ti ti-search"></i>
                                                </span>
                                                <input type="text" class="form-control search_by_mark"
                                                    placeholder="Search code">
                                            </div>
                                        </div>
                                        <div class="tabs_container">
                                            <div class="tab_content active" data-tab="all">
                                                <div class="row model-row">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end flex-wrap gap-2">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Barcode -->

        <!-- Reset -->
        <div class="modal fade modal-default" id="reset" aria-labelledby="reset">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="success-wrap text-center">
                            <form id="restCartForm">
                                @csrf
                                <div class="icon-success bg-purple-transparent text-purple mb-2">
                                    <i class="ti ti-transition-top"></i>
                                </div>
                                <input type="hidden" name="orderId" id="voidorderId">
                                <h3 class="mb-2">Confirm Your Action</h3>
                                <p class="fs-16 mb-3">The current order will be cleared. But not deleted
                                    if it's persistent. Would you like to proceed ?</p>
                                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">No,
                                        Cancel</button>
                                    <button type="submit" class="btn btn-md btn-primary">Yes,
                                        Proceed</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Reset -->

        <!-- Edit Product -->
        <div class="modal fade modal-default pos-modal" id="edit-product" aria-labelledby="edit-product">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Product</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="edit-cart-form" action="{{ route('edit.salesCard') }}" method="POST">
                        @csrf
                        <div class="modal-body pb-1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" name="orderId">
                                    <input type="hidden" name="productId">
                                    <div class="mb-3">
                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" name="product_name" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Product Price <span class="text-danger">*</span></label>
                                        <div class="input-icon-start position-relative">
                                            <span class="input-icon-addon text-gray-9">
                                                Rs
                                            </span>
                                            <input type="text" class="form-control" name="product_price">
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">QTY <span class="text-danger">*</span></label>
                                        <div class="input-icon-start position-relative">
                                            <input type="number" class="form-control" name="qty" min="1">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Discount Type </label>
                                        <select name="discount_type" class="form-select">
                                            <option value="" disabled>Select</option>
                                            <option value="Flat" selected>Flat</option>
                                            <option value="Percentage">Percentage</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Discount <span class="text-danger">*</span></label>
                                        <input type="number" name="discount" class="form-control" min="0"
                                            step="0.00">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end flex-wrap gap-2">
                            <button type="button" class="btn btn-md btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-md btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Edit Product -->

        <!-- Delete Product -->
        <div class="modal fade modal-default" id="deleteCartModal" aria-labelledby="delete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="success-wrap text-center">
                            <form id="deleteCartForm" action="{{ route('delete.sales.cart.product') }}" method="POST">
                                @csrf
                                <input type="hidden" name="orderId" id="deleteOrderId">
                                <input type="hidden" name="productId" id="deleteProductId">
                                <div class="icon-success bg-danger-transparent text-danger mb-2">
                                    <i class="ti ti-trash"></i>
                                </div>
                                <h3 class="mb-2">Are you Sure!</h3>
                                <p class="fs-16 mb-3">The current order will be deleted as no payment
                                    has been made so far.
                                </p>
                                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">No,
                                        Cancel</button>
                                    <button type="submit" class="btn btn-md btn-primary">Yes,
                                        Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Product -->


    @endsection



    @push('js')
        <audio id="successBeep" src="{{ asset('assets/mp3/Voicy_apply pay success.mp3') }}"></audio>
        <audio id="click" src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg"></audio>

        <script>
            let lastFocusedInput = null;


            // Routes
            const routes = {
                scan: @json(route('sales.scan')),
                addProductById: @json(route('sales.addById')),
                payin: @json(route('pos.payin')),
                increase: @json(route('sales.qty.increase')),
                decrease: @json(route('sales.qty.decrease')),
                void: @json(route('sales.void.cart')),
                discount: @json(route('sales.main.discount')),
                billTake: @json(route('sales.bill.take')),
                delete: @json(route('delete.sales.cart.product')),
                returnSalesCart: @json(route('sales.return.add.Cart')),
                returnSalesSave: @json(route('sales.return.save')),
            };
            // CSRF
            const csrfToken = '{{ csrf_token() }}';

            function speakSuccess(message) {
                const speech = new SpeechSynthesisUtterance(message);
                speech.lang = 'en-US';
                window.speechSynthesis.speak(speech);
            }

            // Main Request Send function
            function sendPostRequest(url, data, onSuccess, onError) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (typeof onSuccess === 'function') {
                            onSuccess(response);
                        }
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON?.message || 'Something went wrong.';
                        toastr.error(message);
                        console.error('AJAX error:', xhr.responseText);
                        if (typeof onError === 'function') {
                            onError(xhr);
                        }
                    }
                });
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('received_amount');

                if (input) {
                    input.addEventListener('input', function() {
                        changeAmount(this.value);
                    });
                }
            });

            function focusBarcodeInput() {
                setTimeout(function() {
                    $('#barcodeInput').trigger('focus');
                }, 300); // delay to ensure DOM is ready
            }

            // Use globally
            $(document).ready(focusBarcodeInput);
            // Example usage after modals
            $('#payment-cash').on('hidden.bs.modal', focusBarcodeInput);
            $('#payment-card').on('hidden.bs.modal', focusBarcodeInput);
            $('#edit-product').on('hidden.bs.modal', focusBarcodeInput);
            $('#discount').on('hidden.bs.modal', focusBarcodeInput);
            $('#payIN').on('hidden.bs.modal', focusBarcodeInput);
            $('#payout').on('hidden.bs.modal', focusBarcodeInput);
            $('#return').on('hidden.bs.modal', focusBarcodeInput);
        </script>


        <script>
            function showPaymentComplete() {
                // Hide any open checkout modals
                const cashModal = bootstrap.Modal.getInstance(document.getElementById('cashCheckoutModal'));
                const cardModal = bootstrap.Modal.getInstance(document.getElementById('cardCheckoutModal'));

                if (cashModal) cashModal.hide();
                if (cardModal) cardModal.hide();

                // Show the payment complete modal
                const completeModal = new bootstrap.Modal(document.getElementById('paymentCompleteModal'));
                completeModal.show();
            }

            function printReceipt() {
                document.getElementById("receipt-section").style.display = "block";
                window.print();
                document.getElementById("receipt-section").style.display = "none";

                const completeModal = bootstrap.Modal.getInstance(document.getElementById('paymentCompleteModal'));
                if (completeModal) completeModal.hide();

                let printContents = document.getElementById("receipt-content").innerHTML;
                let originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
                location.reload();
            }


            function calculateChange() {
                const total = parseFloat(document.getElementById("totalAmount").value) || 0;
                const received = parseFloat(document.getElementById("amountReceived").value) || 0;
                const change = received - total;
                document.getElementById("changeAmount").value = change >= 0 ? change.toFixed(2) : '0.00';
            }

            document.getElementById("submitOrder").addEventListener("click", function(e) {
                e.preventDefault();
                const method = document.getElementById("payment_method").value;

                if (method === "Cash") {
                    const cashModal = new bootstrap.Modal(document.getElementById('cashCheckoutModal'));
                    cashModal.show();
                } else if (method === "Card") {
                    const cardModal = new bootstrap.Modal(document.getElementById('cardCheckoutModal'));
                    cardModal.show();
                } else {
                    alert("Please select a payment method.");
                }
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#phone_number').on('keyup', function() {
                    let phone = $(this).val();
                    if (phone.length >= 0) {
                        $.ajax({
                            url: '{{ route('customer.lookup') }}',
                            method: 'GET',
                            data: {
                                phone: phone
                            },
                            success: function(customers) {
                                let suggestionBox = $('#phone_suggestions');
                                suggestionBox.empty();

                                if (customers.length > 0) {
                                    customers.forEach(customer => {
                                        suggestionBox.append(`
                                    <div class="dropdown-item suggestion-item" data-nic="${customer.customer_nic}" data-address="${customer.address}" data-phone="${customer.phone}" data-pay="${customer.summer_sum_amount}" data-name="${customer.first_name}">
                                        ${customer.phone} - ${customer.first_name}
                                    </div>
                                `);
                                    });
                                    suggestionBox.removeClass('d-none');
                                } else {
                                    suggestionBox.addClass('d-none');
                                }
                            }
                        });
                    } else {
                        $('#phone_suggestions').addClass('d-none');
                    }
                });

                // Select from dropdown
                $(document).on('click', '.suggestion-item', function() {
                    const phone = $(this).data('phone');
                    const name = $(this).data('name');
                    const nic = $(this).data('nic') || '';
                    const address = $(this).data('address') || '';
                    const pay = parseFloat($(this).data('pay'));

                    if (!isNaN(pay) && pay !== 0) {
                        $('.customer-sheet').removeClass('d-none');
                        $('.customer-sheet-heading').html(pay > 0 ? 'CR Amount' : 'Due');
                        $('#TotalCustBalance').html('Rs. ' + Math.abs(pay));
                        $('.typeCust').val(pay > 0 ? 'CR Amount' : 'DR Amount');
                        $('.custAmount').val(Math.abs(pay));
                    } else {
                        $('.customer-sheet').addClass('d-none');
                        $('.typeCust').val('');
                        $('.custAmount').val(0);
                    }
                    $('#phone_number').val(phone);
                    $('#customer_name').val(name);
                    $('#customer_nic').val(nic);
                    $('#address').val(address);
                    toastr.info('Customer Selected.');
                    $('#phone_suggestions').addClass('d-none');
                });

                $('#phone_number').on('blur', function() {
                    setTimeout(() => {
                        $('#phone_suggestions').addClass('d-none');
                    }, 150);
                });

                /// select by name
                $('#customer_name').on('keyup', function() {
                    let name = $(this).val();
                    if (name.length >= 0) {
                        $.ajax({
                            url: '{{ route('customer.lookupByName') }}',
                            method: 'GET',
                            data: {
                                name: name
                            },
                            success: function(customers) {
                                let suggestionBox = $('#name_suggestions');
                                suggestionBox.empty();

                                if (customers.length > 0) {
                                    customers.forEach(customer => {
                                        suggestionBox.append(`
                                    <div class="dropdown-item suggestion-item" data-nic="${customer.customer_nic}" data-address="${customer.address}" data-phone="${customer.phone}" data-pay="${customer.summer_sum_amount}" data-name="${customer.first_name}">
                                        ${customer.phone} - ${customer.first_name}
                                    </div>
                                `);
                                    });
                                    suggestionBox.removeClass('d-none');
                                } else {
                                    suggestionBox.addClass('d-none');
                                }
                            }
                        });
                    } else {
                        $('#phone_suggestions').addClass('d-none');
                    }
                });

            });

            document.querySelector('.payment-completed').addEventListener('click', function() {
                document.querySelector('#saveOrder input[name="phone_number"]').value = document.querySelector(
                    '#phone_number').value;
                document.querySelector('#saveOrder input[name="customer_name"]').value = document.querySelector(
                    '#customer_name').value;
            });

            document.body.style.overflowY = 'auto';
            document.documentElement.style.overflowY = 'auto';
            document.body.classList.remove('modal-open');
        </script>





        <script src="{{ asset('assets/sales/sales.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>
    @endpush
</x-sales-layout>
