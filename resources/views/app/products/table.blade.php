

@forelse ($products as $product)
    <tr data-code="{{ $product->mark }}" data-name="{{ $product->product_name }}" data-weight="{{ $product->weight }}">
        <td>
            <label class="checkboxs">
                <input type="checkbox" class="row-checkbox" value="{{ $product->id }}">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td> {{ $product->mark ?? '-' }} </td>

        <td>
            {{ $product->created_at->diffForHumans() }}
        </td>

        <td>
            <div class="d-flex align-items-center">
                <a href="javascript:void(0);">{{ $product->product_name ?? '' }} </a>
            </div>
        </td>
        <td>{{ !empty($product->cate) ? $product->cate->category : 'no data' }} </td>
        <td>{{ $product->weight  }}g </td>
        <td>{{ $product->unit ?? 'no data' }}</td>
        <td>{{ $product->quantity ?? 0 }}</td>
        @php
            $supply = $product->supply ?? null;
            $supplyImage = $supply->image ?? asset('assets/img/users/user-30.jpg');
            $supplyName = $supply->name ?? 'no data';
        @endphp

        <td>
            <div class="d-flex align-items-center">
                <a href="javascript:void(0);" class="avatar avatar-sm me-2">
                    <img src="{{ $supplyImage }}" alt="product">
                </a>
                <a href="javascript:void(0);">{{ $supplyName }}</a>
            </div>
        </td>

        <td class="action-table-data">
            <div class="edit-delete-action">
                <a class="me-2 print-lable" href="javascript:void(0);">
                        <i data-feather="printer-2" class="feather-printer"></i>
                    </a>
                <a class="me-2 edit-icon  p-2" href="{{ route('product.show', $product->id) }}">
                    <i data-feather="eye" class="feather-eye"></i>
                </a>
                <a class="me-2 p-2" href="{{ route('product.edit', $product->id) }}">
                    <i data-feather="edit" class="feather-edit"></i>
                </a>
                <a data-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#delete-modal" class="p-2 delete-product-btn" href="javascript:void(0);">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
@endforelse
