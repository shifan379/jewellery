@forelse ($OutProducts as $out)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox" class="row-checkbox" value="{{ $out->id }}">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td>{{ $out->item_code ?? 00000 }} </td>
        @php
            $images = $out->images ? json_decode($out->images, true) : [];
            $imageUrl = !empty($images) ? $images[0] : asset('assets/img/products/istockphoto.png');
        @endphp
        <td>
            <div class="d-flex align-items-center">
                <a href="javascript:void(0);" class="avatar avatar-md me-2">
                    <img src="{{ $imageUrl }}" alt="product">
                </a>
                <a  href="javascript:void(0);">{{ $out->product_name ?? '' }} </a>
            </div>
        </td>
        <td>{{ !empty($out->cate) ? $out->cate->category : 'no data' }} </td>
        <td>{{ $out->location ?? 'no data' }}</td>
        <td style="color: red;" class="blinking">{{ $out->quantity ?? 0 }}</td>
        <td>{{ $out->quantity_alert ?? 0 }}</td>
        @php
            $supply = $out->supply ?? null;
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
                <a  data-id="{{ $out->id }}"
                    data-item_code="{{ $out->item_code }}"
                    data-product_name="{{ $out->product_name }}"
                    data-quantity="{{ $out->quantity }}"
                    data-quantity_alert="{{ $out->quantity_alert }}"
                    data-bs-toggle="modal"
                    data-bs-target="#edit-expired-product" class="me-2 p-2 edit-product-btn"  href="javascript:void(0);">
                    <i data-feather="edit" class="feather-edit"></i>
                </a>
                <a data-id="{{ $out->id }}" data-bs-toggle="modal" data-bs-target="#delete-modal"
                    class="p-2 delete-product-btn" href="javascript:void(0);">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
@endforelse
