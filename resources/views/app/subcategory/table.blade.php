@forelse ($subCategories as $subcategory)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td><span class="text-gray-9">{{ $subcategory->subcategory }}</span></td>
        <td>{{ $subcategory->category->category }}</td>

        <td>
             <span class="badge table-badge  {{ $subcategory->status == 1 ? 'bg-success' : 'bg-info' }} fw-medium fs-10">
                {{ $subcategory->status == 1 ? 'Active' : 'Deactivate' }}
            </span>
        </td>
        <td class="action-table-data">
            <div class="edit-delete-action">
                <a class="me-2 p-2 edit-sub-category-btn" href="javascript:void(0);"
                    data-id="{{ $subcategory->id }}"
                    data-name="{{ $subcategory->subcategory }}"
                    data-category-id="{{ $subcategory->category->id }}"
                    data-category-name="{{ $subcategory->category->category }}"
                    data-status="{{ $subcategory->status }}"
                data-bs-toggle="modal" data-bs-target ="#edit-category">
                    <i data-feather="edit" class="feather-edit"></i>
                </a>
                <a data-bs-toggle="modal" class="delete-product-btn" data-id="{{ $subcategory->id }}" data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                </a>
            </div>

        </td>
    </tr>
@empty
@endforelse
