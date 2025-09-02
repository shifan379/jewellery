@forelse ($products as $product)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox" class="row-checkbox" value="{{ $product->id }}">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td>{{ $product->item_code ?? 00000 }} </td>
        @php
            $images = $product->images ? json_decode($product->images, true) : [];
            $imageUrl = !empty($images) ? $images[0] : asset('assets/img/products/istockphoto.png');
        @endphp
        <td>
            <div class="d-flex align-items-center">
                <a href="javascript:void(0);" class="avatar avatar-md me-2">
                    <img src="{{ $imageUrl }}" alt="product">
                </a>
                <a href="javascript:void(0);">{{ $product->product_name ?? '' }} </a>
            </div>
        </td>
        <td>{{ !empty($product->cate) ? $product->cate->category : 'no data' }} </td>
        <td>{{ $product->location ?? 'no data' }}</td>
        <td>{{ $product->quantity ?? 0 }}</td>
        <td>{{ $product->quantity_alert ?? 0 }}</td>
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
                <a  data-id="{{ $product->id }}"
                    data-item_code="{{ $product->item_code }}"
                    data-product_name="{{ $product->product_name }}"
                    data-quantity="{{ $product->quantity }}"
                    data-quantity_alert="{{ $product->quantity_alert }}"
                    data-bs-toggle="modal"
                    data-bs-target="#edit-expired-product" class="me-2 p-2 edit-product-btn"  href="javascript:void(0);">
                    <i data-feather="edit" class="feather-edit"></i>
                </a>
                <a data-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#delete-modal"
                    class="p-2 delete-product-btn" href="javascript:void(0);">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
@endforelse
