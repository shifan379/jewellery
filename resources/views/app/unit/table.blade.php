@forelse ($units as $unit)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td><span class="text-gray-9">{{ $unit->name }}</span></td>
        <td><span class="text-gray-9">{{ $unit->product_count->count() }}</span></td>
        <td>{{ $unit->created_at->format('F j, Y') }}</td>
        <td>
             <span class="badge table-badge  {{ $unit->status == 1 ? 'bg-success' : 'bg-info' }} fw-medium fs-10">
                {{ $unit->status == 1 ? 'Active' : 'Deactivate' }}
            </span>
        </td>
        <td class="action-table-data">
            <div class="edit-delete-action">
                <a class="me-2 p-2 edit-unit-btn" href="javascript:void(0);"
                    data-id="{{ $unit->id }}"
                    data-name="{{ $unit->name }}"
                    data-status="{{ $unit->status }}"
                data-bs-toggle="modal" data-bs-target ="#edit-units">
                    <i data-feather="edit" class="feather-edit"></i>
                </a>
                <a data-bs-toggle="modal" class="delete-product-btn" data-id="{{ $unit->id }}" data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                </a>
            </div>

        </td>
    </tr>
@empty
@endforelse
