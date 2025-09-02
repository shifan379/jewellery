@forelse ($data as $dat)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>


        <td><span class="text-gray-9">{{ $dat->customer->first_name }}</span></td>
        <td>{{ $dat->created_at->format('d.m.Y h:i A') }}</td>
        <td>@if ($dat->order) {{ $dat->order->invoice_no }}
            @else ''
        @endif</td>

        <td>
             <span class="badge table-badge  {{ $dat->type == 'CR' ? 'bg-info' : ($dat->type == 'Paid' ? 'bg-success' : 'bg-danger') }} fw-medium fs-10">
                {{ $dat->type == 'CR' ?  'Advance' : ($dat->type == 'Paid' ? 'Paid' : 'Due') }}
            </span>
        </td>
        <td class="text-end">
            <span class="text-gray-9">{{ number_format(abs($dat->amount), 2) }}</span>
        </td>
        <td class="action-table-data">
            <div class="edit-delete-action">
                <a class="me-2 p-2 edit-category-btn" href="javascript:void(0);" data-id="{{ $dat->id }}"
                    data-customerID="{{ $dat->customer->id }}" data-type="{{ $dat->type }}" data-date="{{ $dat->created_at->format('Y-m-d') }}"
                    data-amount="{{ $dat->amount }}" data-bs-toggle="modal" data-bs-target ="#edit-category">
                    <i data-feather="edit" class="feather-edit"></i>
                </a>
                <a data-bs-toggle="modal" class="delete-advance-btn" data-id="{{ $dat->id }}"
                    data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                </a>
            </div>

        </td>
    </tr>
@empty

@endforelse
