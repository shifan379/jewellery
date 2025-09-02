<div class="order-total d-flex align-items-center justify-content-between">
    <table class="table table-responsive table-borderless">

        @php
            if (isset($main_sub_total)) {
                $mainSubtotal = $main_sub_total ?? 0.0;
                $mainTotal = $main_total ?? 0.0;
                $mainDiscount = $main_discount ?? 0.0;
                $return_amount  = $return_amount ?? 0;
            } else {
                $mainSubtotal = 0.0;
                $mainTotal = 0.0;
                $mainDiscount = 0;
                $return_amount = 0;

            }

        @endphp
        <!-- <tr>
                                                        <td>Sub Total</td>
                                                        <td class="text-end">$60,454</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Shipping</td>
                                                        <td class="text-end">$40.21</td>
                                                    </tr> -->
        <tr>
            <td>Sub Total</td>

            <td class="text-end">Rs {{ number_format($mainSubtotal, 2) }}</td>
            <input type="hidden" class="main_subtotal" name="main_subtotal" value="{{ number_format($mainSubtotal, 2) }}">
        </tr>
        <tr>
            <td class="text-danger">Discount </td>
            <td class="text-danger text-end">(-) Rs {{ number_format($mainDiscount, 2) }}</td>
            <input type="hidden" class="main_discount" name="main_discount" value="{{ number_format($mainDiscount, 2) }}">
        </tr>
        @if ($return_amount > 0)
            <tr>
                <td class="text-danger">Return Amount </td>
                <td class="text-danger text-end">(-) Rs {{ number_format($return_amount, 2) }}</td>
                <input type="hidden" class="main_return_amount" name="main_return_amount" value="{{ number_format($return_amount, 2) }}">
            </tr>
        @endif
        @if($mainTotal>=0)
            <tr>
                <td>Total</td>
                <td class="text-end">Rs {{ number_format($mainTotal, 2) }}</td>
                <input type="hidden" class="main_total" name="main_total" value="{{ number_format($mainTotal, 2) }}">
            </tr>

        @else
            <tr>
                <td class="text-primary">Total Payable Amount</td>
                <td class="text-end "> Rs {{ number_format(abs($mainTotal), 2) }}</td>
            </tr>
        @endif
    </table>
</div>

 @if($mainTotal>=0)

 @else
    <div class="border-top btn-row d-sm-flex align-items-center justify-content-between">
        <a href="javascript:void(0);"
        class="btn btn-pink d-flex align-items-center justify-content-center flex-fill return-cash"><i
        class="ti ti-cash-banknote me-2"></i>Return</a>
    </div>
 @endif

