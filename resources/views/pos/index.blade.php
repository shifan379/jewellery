<x-pos-layout>

    @push('css')
        <style>
            @keyframes blinkBanner {

                0%,
                100% {
                    background-color: red;
                    color: white;
                }

                50% {
                    background-color: white;
                    color: red;
                }
            }


            .pointer-none {
                pointer-events: none;
                opacity: 0.5;
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

            .dispad-grid {
                display: grid;
                grid-template-columns: repeat(4, 45px);
                grid-template-rows: repeat(4, 45px);
                gap: 5px;
                justify-content: center;
                margin-top: 5px;
            }

            .dispad-btn {
                background: #111;
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 1.2rem;
                font-weight: bold;
                width: 45px;
                height: 45px;
                transition: background 0.2s;
                display: grid;
                align-items: center;
                justify-content: center;
                outline: none;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            }

            .bar-btn {
                background: #06AED4;
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 1.2rem;
                font-weight: bold;
                width: 45px;
                height: 45px;
                transition: background 0.2s;
                display: grid;
                align-items: center;
                justify-content: center;
                outline: none;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            }

            .bar-btn:active {
                background: #c2eeea;
            }

            .search-dropdown {
                max-height: calc(4 * 40px);
                /* assuming each <li> is approx. 40px tall */
                overflow-y: auto;
            }

            #productList li {
                padding: 3px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
            }


            .user-btn {
                background: #155EEF;
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 1.2rem;
                font-weight: bold;
                width: 45px;
                height: 45px;
                transition: background 0.2s;
                display: grid;
                align-items: center;
                justify-content: center;
                outline: none;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            }

            .user-btn:active {
                background: #c2eeea;
            }

            .dispad-btn:active {
                background: #afaaaa;
            }

            .dispad-clear {
                background: #888 !important;
                color: #fff !important;
            }

            .dispad-ent {
                background: #3EB780 !important;
                color: #fff !important;
            }

            .dispad-barcode {
                background: #7cd4e4 !important;
                color: #fff !important;
                font-size: 1.3rem;
            }

            .dispad-btn[disabled],
            .dispad-btn[style*="visibility: hidden"] {
                background: transparent !important;
                border: none;
                box-shadow: none;
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


            .custom-modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1050;
            }

            .custom-modal {
                background: #fff;
                border-radius: 20px;
                width: 400px;
                text-align: center;
                padding: 30px 25px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                animation: popIn 0.3s ease-in-out;
            }

            @keyframes popIn {
                from {
                    transform: scale(0.9);
                    opacity: 0;
                }

                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .user-img {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid #0d6efd;
                margin-bottom: 15px;
            }

            .custom-modal h4 {
                margin-bottom: 8px;
                font-weight: 600;
            }

            .custom-modal p {
                font-size: 14px;
                color: #555;
                margin-bottom: 20px;
            }

            .payin-input {
                border-radius: 8px;
                border: 1px solid #ccc;
                padding: 8px 12px;
                width: 100%;
                margin-bottom: 20px;
            }

            .modal-actions {
                display: flex;
                justify-content: space-between;
                gap: 10px;
            }

            .modal-actions button {
                flex: 1;
                padding: 10px 0;
                border-radius: 8px;
                font-weight: 600;
                border: none;
                cursor: pointer;
            }

            .modal-actions .btn-later {
                background-color: #f2f2f2;
                color: #444;
            }

            .modal-actions .btn-add {
                background-color: #28a745;
                color: white;
            }
        </style>
    @endpush

    @php
        $returnMode = session()->has('returnEnable');
    @endphp
    @section('content')
        <div class="page-wrapper pos-pg-wrapper ms-0">
            <div class="content pos-design p-0">

                <div class="row align-items-start pos-wrapper">
                    <!-- Products -->
                    <div class="col-md-12 col-lg-8 col-xl-8">
                        <div class="pos-categories tabs_wrapper pb-0">
                            <!-- order list -->
                            <div class="product-order-list">
                                <div class="order-head bg-light d-flex align-items-center justify-content-between w-100">
                                    <div>
                                        <h3>Order List</h3>
                                        <span>Transaction ID : {{ $orderId }}</span>
                                        @if ($returnMode)
                                            <div class="return-mode-banner">
                                                <i class="ti ti-alert-triangle me-2"></i> Return Mode Enabled
                                            </div>
                                        @endif

                                    </div>
                                    <div>
                                        <a class="link-danger fs-16" href="javascript:void(0);"><i
                                                class="ti ti-trash-x-filled voidCart"></i></a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="product-added block-section">
                                <div class="head-text d-flex align-items-center justify-content-between">
                                    <h5 class="d-flex align-items-center mb-0">Product Added</h5>
                                    <a href="javascript:void(0);"
                                        class="d-flex align-items-center link-danger voidCart"><span class="me-2"><i
                                                data-feather="x" class="feather-16"></i></span>Clear
                                        all</a>
                                </div>
                                <div class="product-wrap">
                                    <div id="product-list">
                                        <div class="product-list align-items-center justify-content-between">
                                            <div class="table-responsive" style="width: 100%; ">
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr class="align-items-center ">
                                                            {{-- <th class="bg-transparent fw-bold align-items-center">#</th> --}}
                                                            <th class="bg-transparent fw-bold">Product</th>
                                                            <th class="bg-transparent fw-bold">QTY</th>
                                                            <th class="bg-transparent fw-bold">Dis</th>
                                                            <th class="bg-transparent fw-bold">Net</th>
                                                            <th class="bg-transparent fw-bold">Price</th>
                                                            <th class="bg-transparent fw-bold text-end"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="cart-body">
                                                        @include('pos.cart')
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Products -->
                    <!-- Order Details -->
                    <div class="col-md-12 col-lg-4 col-xl-4 ps-0 theiaStickySidebar">
                        <aside class="product-order-list">

                            <div class="card pos-button">
                                <div class="d-flex align-items-center">
                                    <div class="input-icon-start search-pos position-relative mb-2 me-3"
                                        style="width: 200%;">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <input type="hidden" id="orderID" value="{{ $orderId }}">
                                        <input type="text" class="form-control barcodeInput" id="barcodeInput"
                                            placeholder="Scan Item or Search Product" onfocus="lastFocusedInput = this;" />
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-md btn-indigo">
                                        <i class="ti ti-scan me-1"></i>Scan
                                    </a>
                                </div>

                                <div class="search-info search-productsList d-none">
                                    <ul class="customers" id="productData">
                                        @forelse ($products as $product)
                                            <li>
                                                <a class="add-product" data-code="{{ $product['item_code'] }}">
                                                    {{ $product['product_name'] }}-{{ $product['unit'] }}
                                                    ({{ $product['selling_price'] }})
                                                </a>
                                            </li>
                                        @empty
                                            <li><a class="add-product">No products found</a></li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>


                            <div class="customer-info block-section">
                                <h4 class="mb-3">Customer Number</h4>
                                <div class="input-block d-flex align-items-center flex-grow-1">
                                    <div class="dropdown flex-grow-1">
                                        <div class="searchinputs input-group dropdown-toggle " id="dropdownMenuClickable"
                                            data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                            <input type="text" class="form-control customer_number" id="searchInput"
                                                placeholder="Send to WhatsApp or SMS" onfocus="lastFocusedInput = this;" />
                                            <div class="search-addon">
                                                <span><i class="ti ti-search"></i></span>
                                            </div>
                                            <span class="input-group-text"></span>
                                        </div>

                                        <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuClickable">
                                            <div class="search-info">
                                                <ul class="customers" id="productList">
                                                    @forelse ($cust_numbers as $number)
                                                        <li><a class="add-product"
                                                                onclick="addnumber('{{ $number['phone'] }}')">{{ $number['phone'] }}</a>
                                                        </li>
                                                    @empty
                                                        <li><a class="add-product">No customer found</a></li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="block-section">
                                {{-- <div class="col-md-12 col-lg-6 col-xl-6 ps-0 theiaStickySidebar"> --}}
                                <div class="dispad mb-3 align-items-center justify-content-between flex-wrap">
                                    <div class="dispad-grid">
                                        <button type="button" class="dispad-btn" onclick="enterAmount('7')">7</button>
                                        <button type="button" class="dispad-btn" onclick="enterAmount('8')">8</button>
                                        <button type="button" class="dispad-btn" onclick="enterAmount('9')">9</button>
                                        <button type="button" class="bar-btn" style="height: 210%">
                                            <i class="ti ti-barcode"></i>
                                        </button>

                                        <button type="button" class="dispad-btn" onclick="enterAmount('4')">4</button>
                                        <button type="button" class="dispad-btn" onclick="enterAmount('5')">5</button>
                                        <button type="button" class="dispad-btn" onclick="enterAmount('6')">6</button>
                                        <button type="button" class="dispad-btn" disabled></button>

                                        <button type="button" class="dispad-btn" onclick="enterAmount('1')">1</button>
                                        <button type="button" class="dispad-btn" onclick="enterAmount('2')">2</button>
                                        <button type="button" class="dispad-btn" onclick="enterAmount('3')">3</button>
                                        <button type="button" class="user-btn" style="height: 210%">
                                            <i class="ti ti-user"></i>
                                        </button>

                                        <button type="button" class="dispad-btn" onclick="enterAmount('0')">0</button>
                                        <button type="button" class="dispad-btn" onclick="enterAmount('.')">.</button>
                                        <button type="button" class="dispad-btn dispad-clear"
                                            onclick="payINclearAmount()">CLR</button>
                                        <button class="dispad-btn" disabled></button>

                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="block-section" id="amount-section">
                                @include('pos.amount')
                            </div>

                            <div class="border-top btn-row d-sm-flex align-items-center justify-content-between">
                                <a href="javascript:void(0);"
                                    class="btn btn-cyan d-flex align-items-center justify-content-center flex-fill payment-cash"><i
                                        class="ti ti-cash-banknote  me-2"></i>Cash</a>
                                <a href="javascript:void(0);"
                                    class="btn btn-success d-flex align-items-center justify-content-center flex-fill payment-card"><i
                                        class="ti ti-credit-card me-2"></i>Debit Card</a>

                            </div>
                        </aside>
                    </div>
                    <!-- /Order Details -->
                </div>
                <div class="pos-footer bg-white p-3 border-top">
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#payIN"
                            class="btn btn-indigo d-inline-flex align-items-center justify-content-center"><i
                                class="ti ti-cash-banknote  me-2"></i>Pay In</a>
                        <a href="javascript:void(0);"
                            class="btn btn-purple d-inline-flex align-items-center justify-content-center"
                            data-bs-toggle="modal" data-bs-target="#payout"><i class="ti ti-cash-banknote  me-2"></i>Pay
                            Out</a>
                        <a href="{{ url()->current() }}" target="_blank"
                            class="btn btn-orange d-inline-flex align-items-center justify-content-center"><i
                                class="ti ti-player-pause me-2"></i>Hold</a>
                        <a href="javascript:void(0);"
                            class="voidCart btn btn-danger  d-inline-flex align-items-center justify-content-center"><i
                                class="ti ti-trash me-2"></i>Void</a>



                        <a href="javascript:void(0);"
                            class="btn btn-info d-inline-flex align-items-center justify-content-center"
                            data-bs-toggle="modal" data-bs-target="#recents"><i
                                class="ti ti-refresh-dot me-2"></i>Transaction</a>

                        <a href="javascript:void(0);"
                            class="btn btn-teal d-inline-flex align-items-center justify-content-center applyDiscount"><i
                                class="ti ti-percentage me-2"></i>Discount</a>

                        <a href="javascript:void(0);" onclick="returnModel()"
                            class="btn btn-pink d-inline-flex align-items-center justify-content-center  ">
                            <i class="ti ti-truck-return me-2"></i>
                            Return
                        </a>
                        {{-- <a href="javascript:void(0);"
                            class="btn btn-pink d-inline-flex align-items-center justify-content-center"
                            data-bs-toggle="modal" data-bs-target="#shipping-cost"><i
                                class="ti ti-package-import me-2"></i>Shipping</a> --}}

                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('models')
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
                            <div class="quick-cash payment-content bg-light  mb-3">
                                <div class="d-flex align-items-center flex-wra gap-4">
                                    <h5 class="text-nowrap">Quick Cash</h5>
                                    <div class="d-flex align-items-center flex-wrap gap-3">
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash23">
                                            <label class="btn btn-white" for="cash23">50</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash24">
                                            <label class="btn btn-white" for="cash24">100</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash25">
                                            <label class="btn btn-white" for="cash25">500</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash26">
                                            <label class="btn btn-white" for="cash26">1000</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash26">
                                            <label class="btn btn-white" for="cash26">5000</label>
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
                            <div class="quick-cash payment-content bg-light  mb-3">
                                <div class="d-flex align-items-center flex-wra gap-4">
                                    <h5 class="text-nowrap">Quick Cash</h5>
                                    <div class="d-flex align-items-center flex-wrap gap-3">
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash23">
                                            <label class="btn btn-white" for="cash23">50</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash24">
                                            <label class="btn btn-white" for="cash24">100</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash25">
                                            <label class="btn btn-white" for="cash25">500</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash26">
                                            <label class="btn btn-white" for="cash26">1000</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="btn-check" name="cash" id="cash26">
                                            <label class="btn btn-white" for="cash26">5000</label>
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
        <!-- Shipping Cost -->
        <div class="modal fade modal-default" id="shipping-cost">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Shipping Cost</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="https://dreamspos.dreamstechnologies.com/html/template/pos.html">
                        <div class="modal-body pb-1">
                            <div class="mb-3">
                                <label class="form-label">Shipping Cost <span class="text-danger">*</span></label>
                                <input type="text" class="form-control">
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
        <!-- /Shipping Cost -->
        <!-- Payment Completed -->
        <div class="modal fade modal-default" id="payment-completed" aria-labelledby="payment-completed">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="success-wrap text-center">
                            <form action="{{ route('pos.print') }}" method="POST">
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
        <!-- Discount -->

        <div class="modal fade modal-default" id="discount">
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
        <!-- Print Receipt -->
        <div class="modal fade modal-default" id="print-receipt" aria-labelledby="print-receipt">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="icon-head text-center">
                            <a href="javascript:void(0);">
                                <img src="assets/img/logo.svg" width="100" height="30" alt="Receipt Logo">
                            </a>
                        </div>
                        <div class="text-center info text-center">
                            <h6>Dreamguys Technologies Pvt Ltd.,</h6>
                            <p class="mb-0">Phone Number: +1 5656665656</p>
                            <p class="mb-0">Email: <a
                                    href="https://dreamspos.dreamstechnologies.com/cdn-cgi/l/email-protection#74110c1519041811341319151d185a171b19"><span
                                        class="__cf_email__"
                                        data-cfemail="9ffae7fef2eff3fadff8f2fef6f3b1fcf0f2">[email&#160;protected]</span></a>
                            </p>
                        </div>
                        <div class="tax-invoice">
                            <h6 class="text-center">Tax Invoice</h6>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="invoice-user-name"><span>Name: </span>John Doe</div>
                                    <div class="invoice-user-name"><span>Invoice No: </span>CS132453</div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="invoice-user-name"><span>Customer Id: </span>#LL93784</div>
                                    <div class="invoice-user-name"><span>Date: </span>01.07.2022</div>
                                </div>
                            </div>
                        </div>
                        <table class="table-borderless w-100 table-fit">
                            <thead>
                                <tr>
                                    <th># Item</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1. Red Nike Laser</td>
                                    <td>$50</td>
                                    <td>3</td>
                                    <td class="text-end">$150</td>
                                </tr>
                                <tr>
                                    <td>2. Iphone 14</td>
                                    <td>$50</td>
                                    <td>2</td>
                                    <td class="text-end">$100</td>
                                </tr>
                                <tr>
                                    <td>3. Apple Series 8</td>
                                    <td>$50</td>
                                    <td>3</td>
                                    <td class="text-end">$150</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <table class="table-borderless w-100 table-fit">
                                            <tr>
                                                <td class="fw-bold">Sub Total :</td>
                                                <td class="text-end">$700.00</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Discount :</td>
                                                <td class="text-end">-$50.00</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Shipping :</td>
                                                <td class="text-end">0.00</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tax (5%) :</td>
                                                <td class="text-end">$5.00</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Total Bill :</td>
                                                <td class="text-end">$655.00</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Due :</td>
                                                <td class="text-end">$0.00</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Total Payable :</td>
                                                <td class="text-end">$655.00</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center invoice-bar">
                            <div class="border-bottom border-dashed">
                                <p>**VAT against this challan is payable through central registration.
                                    Thank you for your business!</p>
                            </div>
                            <a href="javascript:void(0);">
                                <img src="assets/img/barcode/barcode-03.jpg" alt="Barcode">
                            </a>
                            <p class="text-dark fw-bold">Sale 31</p>
                            <p>Thank You For Shopping With Us. Please Come Again</p>
                            <a href="javascript:void(0);" class="btn btn-md btn-primary">Print
                                Receipt</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Print Receipt -->
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
        <!-- /return -->
        <!-- Products -->
        <div class="modal fade modal-default pos-modal" id="products" aria-labelledby="products">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="me-4">Products</h5>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3">
                                    <span class="badge bg-dark fs-12">Order ID : #45698</span>
                                    <p class="fs-16">Number of Products : 02</p>
                                </div>
                                <div class="product-wrap h-auto">
                                    <div class="product-list bg-white align-items-center justify-content-between">
                                        <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                                            data-bs-target="#products">
                                            <a href="javascript:void(0);" class="pro-img">
                                                <img src="assets/img/products/pos-product-16.png" alt="Products">
                                            </a>
                                            <div class="info">
                                                <h6><a href="javascript:void(0);">Red Nike Laser</a></h6>
                                                <p>Quantity : 04</p>
                                            </div>
                                        </div>
                                        <p class="text-teal fw-bold">$2000</p>
                                    </div>
                                    <div class="product-list bg-white align-items-center justify-content-between">
                                        <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                                            data-bs-target="#products">
                                            <a href="javascript:void(0);" class="pro-img">
                                                <img src="assets/img/products/pos-product-17.png" alt="Products">
                                            </a>
                                            <div class="info">
                                                <h6><a href="javascript:void(0);">Iphone 11S</a></h6>
                                                <p>Quantity : 04</p>
                                            </div>
                                        </div>
                                        <p class="text-teal fw-bold">$3000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Products -->
        <div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="https://dreamspos.dreamstechnologies.com/html/template/pos-2.html">
                        <div class="modal-body pb-1">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end gap-2 flex-wrap">
                            <button type="button" class="btn btn-md btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-md btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Hold -->
        <div class="modal fade modal-default pos-modal" id="hold-order" aria-labelledby="hold-order">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hold order</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="https://dreamspos.dreamstechnologies.com/html/template/pos-2.html">
                        <div class="modal-body">
                            <div class="bg-light br-10 p-4 text-center mb-3">
                                <h2 class="display-1">4500.00</h2>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Order Reference <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value placeholder>
                            </div>
                            <p>The current order will be set on hold. You can retreive this order
                                from the pending order button. Providing a reference to it might help
                                you to identify the order more quickly.</p>
                        </div>
                        <div class="modal-footer d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-md btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-md btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Hold -->
        <!-- Edit Product -->
        <div class="modal fade modal-default pos-modal" id="edit-product" aria-labelledby="edit-product">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="edit-cart-form" action="{{ route('edit.cart') }}" method="POST">
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

                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">QTY <span class="text-danger">*</span></label>
                                        <div class="input-icon-start position-relative">
                                            <input type="number" class="form-control" name="qty" min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Discount Type </label>
                                        <select name="discount_type" class="select">
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
                            <form id="deleteCartForm" action="{{ route('delete.cart.product') }}" method="post">
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
        <!-- Recent Transactions -->
        <div class="modal fade pos-modal" id="recents" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Recent Transactions</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="tabs-sets">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="purchase-tab" data-bs-toggle="tab"
                                        data-bs-target="#purchase" type="button" aria-controls="purchase"
                                        aria-selected="true" role="tab">Purchase</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="return-tab" data-bs-toggle="tab"
                                        data-bs-target="#return" type="button" aria-controls="return"
                                        aria-selected="false" role="tab">Return</button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="purchase" role="tabpanel"
                                    aria-labelledby="purchase-tab">
                                    <div class="card mb-0">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                            <div class="search-set">
                                                <div class="search-input">
                                                    <span class="btn-searchset"><i
                                                            class="ti ti-search fs-14 feather-search"></i></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table datatable border">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Customer</th>
                                                            <th>Reference</th>
                                                            <th>Count</th>
                                                            <th>Time</th>
                                                            <th>Amount </th>
                                                            <th>Recived </th>
                                                            <th>Change</th>

                                                            {{-- <th class="no-sort">Action</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @forelse ($recent_orders as $recent)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <a href="javascript:void(0);"
                                                                            class="avatar avatar-md me-2">
                                                                            <img src="{{ asset('assets/img/users/user-27.jpg') }}"
                                                                                alt="product">
                                                                        </a>
                                                                        <a
                                                                            href="javascript:void(0);">{{ $recent->customer->first_name ?? 'Walk on Customer' }}</a>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $recent->invoice_no }}</td>
                                                                <td>{{ $recent->items->count() ?? 0 }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($recent->created_at)->format('h.i A') }}
                                                                </td>
                                                                <td>Rs. {{ $recent->total }}</td>
                                                                <td>Rs. {{ $recent->transaction->total_recived }}</td>
                                                                <td>Rs. {{ $recent->transaction->change }}</td>
                                                                {{-- <td class="action-table-data">
                                                                    <div class="edit-delete-action">
                                                                        <a class="me-2 edit-icon p-2"
                                                                            href="javascript:void(0);"><i data-feather="eye"
                                                                                class="feather-eye"></i></a>
                                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                                data-feather="edit"
                                                                                class="feather-edit"></i></a>
                                                                        <a class="p-2" href="javascript:void(0);"><i
                                                                                data-feather="trash-2"
                                                                                class="feather-trash-2"></i></a>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                        @empty
                                                        @endforelse


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="payment" role="tabpanel">
                                    <div class="card mb-0">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                            <div class="search-set">
                                                <div class="search-input">
                                                    <span class="btn-searchset"><i
                                                            class="ti ti-search fs-14 feather-search"></i></span>
                                                </div>
                                            </div>
                                            <ul class="table-top-head">
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Pdf"><img src="assets/img/icons/pdf.svg"
                                                            alt="img"></a>
                                                </li>
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Excel"><img src="assets/img/icons/excel.svg"
                                                            alt="img"></a>
                                                </li>
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i
                                                            class="ti ti-printer"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table datatable border">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="no-sort">
                                                                <label class="checkboxs">
                                                                    <input type="checkbox" class="select-all">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </th>
                                                            <th>Customer</th>
                                                            <th>Reference</th>
                                                            <th>Date</th>
                                                            <th>Amount </th>
                                                            <th class="no-sort">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-27.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Carl Evans</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0101</td>
                                                            <td>24 Dec 2024</td>
                                                            <td>$1000</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-02.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Minerva Rameriz</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0102</td>
                                                            <td>10 Dec 2024</td>
                                                            <td>$1500</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-05.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Robert Lamon</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0103</td>
                                                            <td>27 Nov 2024</td>
                                                            <td>$1500</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-22.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Patricia Lewis</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0104</td>
                                                            <td>18 Nov 2024</td>
                                                            <td>$2000</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-03.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Mark Joslyn</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0105</td>
                                                            <td>06 Nov 2024</td>
                                                            <td>$800</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-12.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Marsha Betts</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0106</td>
                                                            <td>25 Oct 2024</td>
                                                            <td>$750</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-06.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Daniel Jude</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0107</td>
                                                            <td>14 Oct 2024</td>
                                                            <td>$1300</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="return" role="tabpanel">
                                    <div class="card mb-0">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                            <div class="search-set">
                                                <div class="search-input">
                                                    <span class="btn-searchset"><i
                                                            class="ti ti-search fs-14 feather-search"></i></span>
                                                </div>
                                            </div>
                                            <ul class="table-top-head">
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Pdf"><img src="assets/img/icons/pdf.svg"
                                                            alt="img"></a>
                                                </li>
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Excel"><img src="assets/img/icons/excel.svg"
                                                            alt="img"></a>
                                                </li>
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Print"><i class="ti ti-printer"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class=" table-responsive">
                                                <table class="table datatable border">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="no-sort">
                                                                <label class="checkboxs">
                                                                    <input type="checkbox" class="select-all">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </th>
                                                            <th>Customer</th>
                                                            <th>Reference</th>
                                                            <th>Date</th>
                                                            <th>Amount </th>
                                                            <th class="no-sort">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-27.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Carl Evans</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0101</td>
                                                            <td>24 Dec 2024</td>
                                                            <td>$1000</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-02.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Minerva Rameriz</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0102</td>
                                                            <td>10 Dec 2024</td>
                                                            <td>$1500</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-05.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Robert Lamon</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0103</td>
                                                            <td>27 Nov 2024</td>
                                                            <td>$1500</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-22.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Patricia Lewis</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0104</td>
                                                            <td>18 Nov 2024</td>
                                                            <td>$2000</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-03.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Mark Joslyn</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0105</td>
                                                            <td>06 Nov 2024</td>
                                                            <td>$800</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-12.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Marsha Betts</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0106</td>
                                                            <td>25 Oct 2024</td>
                                                            <td>$750</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="checkboxs">
                                                                    <input type="checkbox">
                                                                    <span class="checkmarks"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="avatar avatar-md me-2">
                                                                        <img src="assets/img/users/user-06.jpg"
                                                                            alt="product">
                                                                    </a>
                                                                    <a href="javascript:void(0);">Daniel Jude</a>
                                                                </div>
                                                            </td>
                                                            <td>INV/SL0107</td>
                                                            <td>14 Oct 2024</td>
                                                            <td>$1300</td>
                                                            <td class="action-table-data">
                                                                <div class="edit-delete-action">
                                                                    <a class="me-2 edit-icon p-2"
                                                                        href="javascript:void(0);"><i data-feather="eye"
                                                                            class="feather-eye"></i></a>
                                                                    <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                            data-feather="edit"
                                                                            class="feather-edit"></i></a>
                                                                    <a class="p-2" href="javascript:void(0);"><i
                                                                            data-feather="trash-2"
                                                                            class="feather-trash-2"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Recent Transactions -->
        <!-- Orders -->
        <div class="modal fade pos-modal" id="orders" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Orders</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="tabs-sets">
                            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="onhold-tab" data-bs-toggle="tab"
                                        data-bs-target="#onhold" type="button" aria-controls="onhold"
                                        aria-selected="true" role="tab">Onhold</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="unpaid-tab" data-bs-toggle="tab"
                                        data-bs-target="#unpaid" type="button" aria-controls="unpaid"
                                        aria-selected="false" role="tab">Unpaid</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="paid-tab" data-bs-toggle="tab"
                                        data-bs-target="#paid" type="button" aria-controls="paid"
                                        aria-selected="false" role="tab">Paid</button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="onhold" role="tabpanel"
                                    aria-labelledby="onhold-tab">
                                    <div class="input-icon-start pos-search position-relative mb-3">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search Product">
                                    </div>
                                    <div class="order-body">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <span class="badge bg-dark fs-12 mb-2">Order ID : #45698</span>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                        </p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                                :</span> $900</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Customer :</span>
                                                            Botsford</p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                                :</span> 24 Dec 2024 13:39:11</p>
                                                    </div>
                                                </div>
                                                <div class="bg-info-transparent p-1 rounded text-center my-3">
                                                    <p class="text-info fw-medium">Customer need to recheck the product
                                                        once</p>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                                                    <a href="javascript:void(0);" class="btn btn-md btn-orange">Open
                                                        Order</a>
                                                    <a href="javascript:void(0);" class="btn btn-md btn-teal"
                                                        data-bs-dismiss="modal" data-bs-toggle="modal"
                                                        data-bs-target="#products">View Products</a>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-md btn-indigo">Print</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card bg-light mb-0">
                                            <div class="card-body">
                                                <span class="badge bg-dark fs-12 mb-2">Order ID : #666659</span>
                                                <div class="mb-3">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <p class="fs-15 mb-1"><span
                                                                    class="fs-14 fw-bold text-gray-9">Cashier :</span>
                                                                admin</p>
                                                            <p class="fs-15"><span
                                                                    class="fs-14 fw-bold text-gray-9">Total
                                                                    :</span> $900</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="fs-15 mb-1"><span
                                                                    class="fs-14 fw-bold text-gray-9">Customer :</span>
                                                                Botsford</p>
                                                            <p class="fs-15"><span
                                                                    class="fs-14 fw-bold text-gray-9">Date
                                                                    :</span> 24 Dec 2024 13:39:11</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="unpaid" role="tabpanel">
                                    <div class="input-icon-start pos-search position-relative mb-3">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search Product">
                                    </div>
                                    <div class="order-body">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <span class="badge bg-dark fs-12 mb-2">Order ID : #45698</span>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                        </p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                                :</span> $900</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Customer :</span>
                                                            Anastasia</p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                                :</span> 24 Dec 2024 13:39:11</p>
                                                    </div>
                                                </div>
                                                <div class="bg-info-transparent p-1 rounded text-center my-3">
                                                    <p class="text-info fw-medium">Customer need to recheck the product
                                                        once</p>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                                                    <a href="javascript:void(0);" class="btn btn-md btn-orange">Open
                                                        Order</a>
                                                    <a href="javascript:void(0);" class="btn btn-md btn-teal"
                                                        data-bs-dismiss="modal" data-bs-toggle="modal"
                                                        data-bs-target="#products">View Products</a>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-md btn-indigo">Print</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card bg-light mb-0">
                                            <div class="card-body">
                                                <span class="badge bg-dark fs-12 mb-2">Order ID : #666659</span>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                        </p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                                :</span> $900</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Customer :</span> Lucia
                                                        </p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                                :</span> 24 Dec 2024 13:39:11</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="paid" role="tabpanel">
                                    <div class="input-icon-start pos-search position-relative mb-3">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search Product">
                                    </div>
                                    <div class="order-body">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <span class="badge bg-dark fs-12 mb-2">Order ID : #45698</span>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                        </p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                                :</span> $1000</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Customer :</span> Hugo
                                                        </p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                                :</span> 24 Dec 2024 13:39:11</p>
                                                    </div>
                                                </div>
                                                <div class="bg-info-transparent p-1 rounded text-center my-3">
                                                    <p class="text-info fw-medium">Customer need to recheck the product
                                                        once</p>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                                                    <a href="javascript:void(0);" class="btn btn-md btn-orange">Open
                                                        Order</a>
                                                    <a href="javascript:void(0);" class="btn btn-md btn-teal"
                                                        data-bs-dismiss="modal" data-bs-toggle="modal"
                                                        data-bs-target="#products">View Products</a>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-md btn-indigo">Print</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card bg-light mb-0">
                                            <div class="card-body">
                                                <span class="badge bg-dark fs-12 mb-2">Order ID : #666659</span>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                        </p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                                :</span> $9100</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="fs-15 mb-1"><span
                                                                class="fs-14 fw-bold text-gray-9">Customer :</span>
                                                            Antonio</p>
                                                        <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                                :</span> 23 Dec 2024 13:39:11</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Orders -->
        <!-- Scan -->
        <div class="modal fade modal-default" id="scan-payment">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div class="success-wrap scan-wrap text-center">
                            <h5><span class="text-gray-6">Amount to Pay :</span> $150</h5>
                            <div class="scan-img">
                                <img src="assets/img/icons/scan-img.svg" alt="img">
                            </div>
                            <p class="mb-3">Scan your Phone or UPI App to Complete the payment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Scan -->
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
                    <form id="saveOrder" action="{{ route('save.order') }}" method="POST">
                        @csrf
                        <div class="modal-body pb-1">
                            <div class="row">
                                <div class="quick-cash payment-content bg-light  mb-3">
                                    <div class="d-flex align-items-center flex-wra gap-4">
                                        <h5 class="text-nowrap">Quick Cash</h5>
                                        <div class="d-flex align-items-center flex-wrap gap-3">
                                            <div class="form-check">
                                                <input type="radio" class="btn-check" onclick="quickCashBook('50')"
                                                    name="cash" id="cash23">
                                                <label class="btn btn-white" onclick="quickCashBook('50')"
                                                    for="cash23">50</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="btn-check" onclick="quickCashBook('100')"
                                                    name="cash" id="cash24">
                                                <label class="btn btn-white" onclick="quickCashBook('100')"
                                                    for="cash24">100</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="btn-check" onclick="quickCashBook('500')"
                                                    name="cash" id="cash25">
                                                <label class="btn btn-white" onclick="quickCashBook('500')"
                                                    for="cash25">500</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="btn-check"
                                                    onclick="quickCashBook('1000')" name="cash" id="cash26">
                                                <label class="btn btn-white" onclick="quickCashBook('1000')"
                                                    for="cash26">1000</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="btn-check"
                                                    onclick="quickCashBook('5000')" name="cash" id="cash26">
                                                <label class="btn btn-white" onclick="quickCashBook('5000')"
                                                    for="cash26">5000</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-start pos-wrapper">
                                    <div class="col-md-12 col-lg-6 col-xl-6">
                                        <div class="row">
                                            {{-- Hidden Values --}}
                                            <input type="hidden" class="valueCustomer" name="customer_number">
                                            <input type="hidden" name="orderID" value="{{ $orderId }}">

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

                                        <div class="mb-3 change_div">
                                            <label class="form-label">Change <span class="text-danger">*</span></label>
                                            <div class="input-icon-start position-relative">
                                                <span class="input-icon-addon text-gray-9">
                                                    Rs.
                                                </span>
                                                <input type="text" class="form-control change_amount"
                                                    id="change_amount" name="change_amount">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-6 ps-0 theiaStickySidebar">

                                        <div class="keypad mb-3 align-items-center justify-content-between flex-wrap">
                                            <p class="text-muted">Use keypad below to enter amount</p>

                                            <div class="keypad-grid">
                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('7')">7</button>
                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('8')">8</button>
                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('9')">9</button>
                                                <button type="button" class="keypad-btn" disabled></button>

                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('4')">4</button>
                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('5')">5</button>
                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('6')">6</button>
                                                <button type="button" class="keypad-btn" disabled></button>

                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('1')">1</button>
                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('2')">2</button>
                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('3')">3</button>
                                                <button type="button" class="keypad-btn" disabled></button>

                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('0')">0</button>
                                                <button type="button" class="keypad-btn"
                                                    onclick="cashBook('.')">.</button>
                                                <button type="button" class="keypad-btn keypad-clear"
                                                    onclick="clearBook()">CLR</button>
                                                <button type="button" class="keypad-btn" disabled></button>

                                                <button type="submit" style="width: 335%"
                                                    class="keypad-btn   keypad-ent payment-completed">Save</button>
                                            </div>
                                        </div>
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

        <!-- Calculator -->
        <div class="modal fade pos-modal" id="calculator" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="calculator-wrap">
                            <div class="p-3">
                                <div class="d-flex align-items-center">
                                    <h3>Calculator</h3>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div>
                                    <input class="input" type="text" placeholder="0" readonly>
                                </div>
                            </div>
                            <div class="calculator-body d-flex justify-content-between">
                                <div class="text-center">
                                    <button class="btn btn-clear"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; clr()"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->C</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('7')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->7</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('4')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->4</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('1')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->1</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis(',')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->,</button>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-expression"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('https://dreamspos.dreamstechnologies.com/')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->÷</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('8')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->8</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('5')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->5</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('2')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->2</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('00')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->00</button>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-expression"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('%')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->%</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('9')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->9</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('6')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->6</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('3')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->3</button>
                                    <button class="btn btn-number"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('.')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->.</button>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-clear"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; back()"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e-><i
                                            class="ti ti-backspace"></i></button>
                                    <button class="btn btn-expression"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('*')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->x</button>
                                    <button class="btn btn-expression"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('-')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->-</button>
                                    <button class="btn btn-expression"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; dis('+')"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->+</button>
                                    <button class="btn btn-clear"
                                        onclick="if (!window.__cfRLUnblockHandlers) return false; solve()"
                                        data-cf-modified-0d1c8ee9f1d1c5afa5b8c72e->=</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Calculator -->
        <!-- Cash Register Details -->
        <div class="modal fade pos-modal" id="cash-register" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cash Register Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped border">
                                <tr>
                                    <td>Cash in Hand</td>
                                    <td class="text-gray-9 fw-medium text-end">$45689</td>
                                </tr>
                                <tr>
                                    <td>Total Sale Amount</td>
                                    <td class="text-gray-9 fw-medium text-end">$565597.88</td>
                                </tr>
                                <tr>
                                    <td>Total Payment</td>
                                    <td class="text-gray-9 fw-medium text-end">$566867.97</td>
                                </tr>
                                <tr>
                                    <td>Cash Payment</td>
                                    <td class="text-gray-9 fw-medium text-end">$3355.84</td>
                                </tr>
                                <tr>
                                    <td>Total Sale Return</td>
                                    <td class="text-gray-9 fw-medium text-end">$1959</td>
                                </tr>
                                <tr>
                                    <td>Total Expense</td>
                                    <td class="text-gray-9 fw-medium text-end">$0</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-9 fw-bold bg-secondary-transparent">Total
                                        Cash</td>
                                    <td class="text-gray-9 fw-bold text-end bg-secondary-transparent">$587130.97</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-2 flex-wrap">
                        <button type="button" class="btn btn-md btn-primary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Cash Register Details -->
        <!-- Today's Sale -->
        <div class="modal fade pos-modal" id="today-sale" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Today's Sales Summary – This Counter</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped border">
                                <tr>
                                    <td>Total Sale Amount</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs.
                                        {{ number_format($recent_orders->sum('total'), 2) }}</td>
                                </tr>

                                @php
                                    $cashTotal = $recent_orders->sum(function ($order) {
                                        return optional($order->transaction)->payment_method === 'cash'
                                            ? $order->transaction->total
                                            : 0;
                                    });

                                    $cardTotal = $recent_orders->sum(function ($order) {
                                        return optional($order->transaction)->payment_method === 'credit'
                                            ? $order->transaction->total
                                            : 0;
                                    });

                                    $payIN = $paybook->sum(fn($book) => $book->name === 'payin' ? $book->amount : 0);
                                    $payOUT = $paybook->sum(fn($book) => $book->name === 'payout' ? $book->amount : 0);

                                    $return = $recent_orders->sum('return_amount');

                                    $totalCash = $cashTotal + $payIN + $cardTotal;
                                    $cashInCounter = $totalCash - $cardTotal - $return - $payOUT;

                                @endphp

                                <tr>
                                    <td>Cash Payment</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($cashTotal, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>Credit Card Payment</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($cardTotal, 2) }}
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td>Cheque Payment:</td>
                                    <td class="text-gray-9 fw-medium text-end">$0</td>
                                </tr>
                                <tr>
                                    <td>Deposit Payment</td>
                                    <td class="text-gray-9 fw-medium text-end">$565597.88</td>
                                </tr>
                                <tr>
                                    <td>Points Payment</td>
                                    <td class="text-gray-9 fw-medium text-end">$3355.84</td>
                                </tr>
                                <tr>
                                    <td>Gift Card Payment</td>
                                    <td class="text-gray-9 fw-medium text-end">$565597.88</td>
                                </tr>
                                <tr>
                                    <td>Scan & Pay</td>
                                    <td class="text-gray-9 fw-medium text-end">$3355.84</td>
                                </tr>
                                <tr>
                                    <td>Pay Later</td>
                                    <td class="text-gray-9 fw-medium text-end">$3355.84</td>
                                </tr> --}}
                                <tr>
                                    <td>Total Payment(Pay In)</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($payIN, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Sale Return</td>
                                    <td class="text-gray-9 fw-medium text-end text-danger ">- Rs.
                                        {{ number_format($return, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Expense(Pay Out)</td>
                                    <td class="text-gray-9 fw-medium text-end text-danger">- Rs.
                                        {{ number_format($payOUT, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-9 fw-bold bg-secondary-transparent">Total

                                    </td>
                                    <td class="text-gray-9 fw-bold text-end bg-secondary-transparent">Rs.
                                        {{ number_format($totalCash, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-9 fw-bold bg-secondary-transparent">
                                        Cash in Counter</td>
                                    <td class="text-gray-9 fw-bold text-end bg-secondary-transparent">Rs.
                                        {{ number_format($cashInCounter, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-2 flex-wrap">
                        <button type="button" class="btn btn-md btn-primary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Today's Sale -->
        <!-- Today's Profit -->
        <div class="modal fade pos-modal" id="today-profit" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Today's Profit</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @php
                        // use Illuminate\Support\Str;

                        // Total Sales Value
                        $total_sales_value = $total_sales->sum('total');

                        // Total Expense
                        $expense = $paylog->filter(fn($book) => $book->name === 'payout')->sum('amount');

                        // Total Discount
                        $total_discount = $todayItems->sum('discount');

                        // Return Amount
                        $return_amount = $total_sales->sum('return_amount');

                        // Cash In/Out
                        $payin = $paylog->filter(fn($book) => $book->name === 'payin')->sum('amount');
                        $outflow = $return_amount + $expense;
                        $inflow = $total_sales_value + $payin;

                        // Profit
                        $total_profit = $todayProfit - $expense;
                        $net_profit = $total_profit - $total_discount - $return_amount;

                        // Payment breakdown
                        $cashPayment = $total_sales->sum(
                            fn($order) => optional($order->transaction)->payment_method === 'cash'
                                ? $order->transaction->total
                                : 0,
                        );
                        $cardPayment = $total_sales->sum(
                            fn($order) => optional($order->transaction)->payment_method === 'credit'
                                ? $order->transaction->total
                                : 0,
                        );
                        $onlinePayment = $total_sales->sum(
                            fn($order) => optional($order->transaction)->payment_method === 'online'
                                ? $order->transaction->total
                                : 0,
                        );

                        // Gross Margin
                        $grossMargin = $productRevenue > 0 ? ($todayProfit / $productRevenue) * 100 : 0;

                        // Cash on Hand (approximate)
                        $cashInDrawer = $inflow - $outflow - $cardPayment - $onlinePayment;
                    @endphp

                    <div class="modal-body">
                        <div class="row justify-content-center g-3 mb-3">
                            <div class="col-lg-4 col-md-6 d-flex">
                                <div class="border border-success bg-success-transparent br-8 p-3 flex-fill">
                                    <p class="fs-16 text-gray-9 mb-1">Total Sale</p>
                                    <h3 class="text-success">Rs. {{ number_format($total_sales_value, 2) }}</h3>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 d-flex">
                                <div class="border border-danger bg-danger-transparent br-8 p-3 flex-fill">
                                    <p class="fs-16 text-gray-9 mb-1">Expense</p>
                                    <h3 class="text-danger">Rs. {{ number_format($expense, 2) }}</h3>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 d-flex">
                                <div class="border border-info bg-info-transparent br-8 p-3 flex-fill">
                                    <p class="fs-16 text-gray-9 mb-1">Total Profit </p>
                                    <h3 class="text-info">Rs. {{ number_format($total_profit, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center g-3 mb-3">
                            <div class="col-lg-6 col-md-6 d-flex">
                                <div class="border border-warning bg-warning-transparent br-8 p-3 flex-fill">
                                    <p class="fs-16 text-gray-9 mb-1">Sales Comparison</p>
                                    <h5 class="text-warning">Yesterday: Rs. {{ number_format($yesterday_sales, 2) }}</h5>
                                    <h5 class="text-warning">Today: Rs. {{ number_format($productRevenue, 2) }}</h5>
                                    <h5 class="text-warning">Change: {{ number_format($sales_change_percent, 2) }}%</h5>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 d-flex">
                                <div class="border border-info bg-info-transparent br-8 p-3 flex-fill">
                                    <p class="fs-16 text-gray-9 mb-1">Profit Comparison</p>
                                    <h5 class="text-info">Yesterday: Rs. {{ number_format($yesterday_profit, 2) }}</h5>
                                    <h5 class="text-info">Today: Rs. {{ number_format($todayProfit, 2) }}</h5>
                                    <h5 class="text-info">Change: {{ number_format($profit_change_percent, 2) }}%</h5>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped border">
                                <tr>
                                    <td>Gross Margin</td>
                                    <td class="text-end">{{ number_format($grossMargin, 2) }}%</td>
                                </tr>
                                <tr>
                                    <td>Net Profit</td>
                                    <td class="text-end">Rs. {{ number_format($net_profit, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Cash Payment</td>
                                    <td class="text-end">Rs. {{ number_format($cashPayment, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Card Payment</td>
                                    <td class="text-end">Rs. {{ number_format($cardPayment, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Online Payment</td>
                                    <td class="text-end">Rs. {{ number_format($onlinePayment, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Product Revenue</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs.
                                        {{ number_format($productRevenue, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Product Cost</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($productCost, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Product Profit</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($todayProfit, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Pay-In</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($payin, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Pay-Out</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($expense, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Sell Discount</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs.
                                        {{ number_format($total_discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Sale Return</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($return_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Return Items Value</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs.
                                        {{ number_format($total_return->sum('total'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Cash Outflow</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($outflow, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Cash Inflow</td>
                                    <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($inflow, 2) }}</td>
                                </tr>

                                <tr>
                                    <td class="text-gray-9 fw-bold bg-secondary-transparent">Total Cash in Drawer</td>
                                    <td class="text-gray-9 fw-bold text-end bg-secondary-transparent">Rs.
                                        {{ number_format($cashInDrawer, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="mt-4">
                            <h5>Top 3 Selling Products Today</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity Sold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topProducts as $item)
                                        <tr>
                                            <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                                            <td>{{ $item->total_qty }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">No sales today</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-2 flex-wrap">
                        <button type="button" class="btn btn-md btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <a href="{{ route('print.todayProfit') }}" class="btn btn-md btn-info">Print</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Today's Profit -->
    @endsection


    @push('js')
        <audio id="successBeep" src="{{ asset('assets/mp3/Voicy_apply pay success.mp3') }}"></audio>
        <audio id="click" src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg"></audio>

        <script>
            let lastFocusedInput = null;


            // Routes
            const routes = {
                scan: @json(route('pos.scan')),
                addProductById: @json(route('pos.addById')),
                increase: @json(route('pos.qty.increase')),
                decrease: @json(route('pos.qty.decrease')),
                void: @json(route('void.cart')),
                discount: @json(route('main.discount')),
                payin: @json(route('pos.payin')),
                delete: @json(route('delete.cart.product')),
                billTake: @json(route('pos.bill.take')),
                returnCart: @json(route('return.add.Cart')),
                returnSave: @json(route('return.save')),
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

        <!-- pos script -->
        <script src="{{ asset('assets/pos/pos.js') }}"></script>
    @endpush


</x-pos-layout>
