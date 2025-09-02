@forelse ($rate as $today)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td><span class="text-gray-9">{{ $today->created_at->format('M j, Y g:i A') }}</span></td>
        <td><span class="text-gray-9">{{ $today->category->category }}</span></td>
        <td>Rs: {{ $today->rate }}</td>

        <td>
             {{ $today->user ? $today->user->name : 'Admin' }}
        </td>
        <td class="action-table-data">
            <div class="edit-delete-action">
                <a class="me-2 p-2 edit-sub-category-btn" href="javascript:void(0);"
                    data-id="{{ $today->id }}"
                    data-name="{{ $today->rate }}"
                    data-category-id="{{ $today->categoryID }}"
                    data-category-name="{{ $today->category->category }}"

                data-bs-toggle="modal" data-bs-target ="#edit-category">
                    <i data-feather="edit" class="feather-edit"></i>
                </a>
                <a data-bs-toggle="modal" class="delete-product-btn" data-id="{{ $today->id }}" data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                </a>
            </div>

        </td>
    </tr>
@empty
@endforelse
