  <div class="col-lg-6 ms-auto">
      @php
          if (isset($main_sub_total)) {
              $mainSubtotal = $main_sub_total ?? 0.0;
              $mainTotal = $main_total ?? 0.0;
              $mainDiscount = $main_discount ?? 0.0;
              $return_amount = $return_amount ?? 0;
          } else {
              $mainSubtotal = $edit_order->subtotal ?? 0.0;
              $mainTotal = $edit_order->total ?? 0.0;
              $mainDiscount = $edit_order->discount ?? 0;
              $return_amount = 0;
          }

      @endphp

      <div class="total-order w-100 max-widthauto m-auto mb-4">
          <ul class="border-1 rounded-2">

              <li class="border-bottom">
                  <h4 class="border-end">Discount</h4>
                  <h5 id="discount">Rs.{{ number_format($mainDiscount, 2) }}</h5>
                  <input type="hidden" class="main_discount" name="main_discount"
                      value="{{ number_format($mainDiscount, 2) }}">
              </li>
              <li class="border-bottom">
                  <h4 class="border-end">Sub Total</h4>
                  <h5 id="subtotal">Rs.{{ number_format($mainSubtotal, 2) }}</h5>
                  <input type="hidden" class="main_subtotal" name="main_subtotal"
                      value="{{ number_format($mainSubtotal, 2) }}">
              </li>
              @if ($return_amount > 0)
                  <li class="border-bottom">
                      <h4 class="text-danger">Return Amount </h4>
                      <h5 class="text-danger text-end">(-) Rs {{ number_format($return_amount, 2) }}</h5>
                      <input type="hidden" class="main_return_amount" name="main_return_amount"
                          value="{{ number_format($return_amount, 2) }}">
                  </li>
              @endif

              @if ($mainTotal >= 0)
                  <li class="border-bottom">
                      <h4 class="border-end">Grand Total</h4>
                      <h5 id="grandTotal">Rs.{{ number_format($mainTotal, 2) }}</h5>
                      <input type="hidden" class="main_total" name="main_total"
                          value="{{ number_format($mainTotal, 2) }}">
                  </li>
              @else
                  <li class="border-bottom">
                      <h4 class="text-primary">Total Payable Amount</h4>
                      <h5 class="text-end "> Rs {{ number_format(abs($mainTotal), 2) }}</h5>
                  </li>
              @endif




          </ul>
      </div>
      @if ($mainTotal >= 0)
      @else
          <div class="border-top btn-row d-sm-flex align-items-center justify-content-between">
              <a href="javascript:void(0);"
                  class="btn btn-pink d-flex align-items-center justify-content-center flex-fill return-cash"><i
                      class="ti ti-cash-banknote me-2"></i>Return</a>
          </div>
      @endif

  </div>
