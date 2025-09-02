

@forelse ($lists as $list)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox" class="row-checkbox" value="{{ $list->id }}">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td>{{ $list->invoice_no ?? 00000 }} </td>

        <td>
            <div class="d-flex align-items-center">
                <a href="javascript:void(0);">@if($list->customer){{ $list->customer->first_name ?? 'Walk on customer' }} @else Walk on customer  @endif</a>
            </div>
        </td>
        <td>{{ \Carbon\Carbon::parse($list->created_at)->format('M d, Y h:i A') }}</td>
        <td>{{ $list->sales_type ?? 'retail' }}</td>
        <td>{{ $list->items->count() ?? 0 }}</td>
        <td>Rs. {{ $list->subtotal ?? 0.0 }}</td>
        <td>Rs. {{ $list->discount ?? 0.0 }}</td>
        <td>Rs. {{ $list->total ?? 0.0 }}</td>
        <td>{{ $list->transaction->payment_status ?? 'pendding' }}</td>
        <td>{{ $list->return_data->count() ?? 0 }}</td>
        @php
                if(!empty($list->cashier)){
                    $cashierImage = $list->cashier->employee->profile_photo ?? asset('assets/img/users/user-30.jpg');
                    $cashierName = $list->cashier->employee->first_name ?? 'Admin';
                }else{
                    $cashierImage =  asset('assets/img/users/user-30.jpg');
                    $cashierName =   'Admin';
                }
        @endphp

        <td>
            <div class="d-flex align-items-center">
                <a href="javascript:void(0);" class="avatar avatar-sm me-2">
                    <img src="{{ $cashierImage }}" alt="product">
                </a>
                <a href="javascript:void(0);">{{ $cashierName }}</a>
            </div>
        </td>

        <td class="action-table-data">
            <div class="edit-delete-action">
                <a class="me-2 edit-icon  p-2" href="{{ route('invoice.show', $list->id) }}">
                    <i data-feather="eye" class="feather-eye"></i>
                </a>
                 <a class="me-2 edit-icon  p-2" href="{{ route('invoice.edit', $list->id) }}">
                    <i data-feather="edit" class="feather-edit"></i>
                </a>
                <a data-id="{{ $list->id }}" data-bs-toggle="modal" data-bs-target="#delete-modal" class="p-2 delete-product-btn" href="javascript:void(0);">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
@endforelse
