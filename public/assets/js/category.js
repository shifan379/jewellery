$(document).ready(function () {

    // ===== Edit Category Modal =====
    $(document).on('click', '.edit-category-btn', function () {
        const id = $(this).data('id');

        const status = $(this).data('status');
        const category = $(this).data('name');



        // Fill modal fields
        $('#edit_category_id').val(id);

        $('#edit_category_name').val(category);
        $('#edit_category_status').val(status); // hidden input
      //  $('#edit_category_image').val(image);

        const $checkbox = $('#user3');
        $checkbox.prop('checked', status == 1);

        // Sync checkbox with hidden input on change
        $checkbox.off('change').on('change', function () {
            $('#edit_category_status').val(this.checked ? 1 : 0);
        });


    });

    // ===== Filter Categories by Status =====
    $(document).on('click', '.dropdown-menu .dropdown-category', function () {
        const status = $(this).data('status');

        $('#product-loader').show();
        $('#product-table').addClass('dull');

        $.ajax({
            url: routes.categoriesFilter,
            type: 'POST',
            data: {
                status: status,
                _token: csrfToken
            },
            success: function (response) {
                $('#product-table-body').html(response.html);
                toastr.info('Review the list of categories that have been found.');
            },
            error: function () {
                toastr.error('Failed to load categories for this status.');
            },
            complete: function () {
                $('#product-loader').hide();
                $('#product-table').removeClass('dull');
            }
        });
    });

    // ===== Delete Category =====
    let deleteProductId = null;
    $(document).on('click', '.delete-product-btn', function () {
        deleteProductId = $(this).data('id');
        $('#delete-product-id').val(deleteProductId);
    });

    // ===== Add New Category with Image =====
    $('#submitCategory').on('click', function () {
        const $btn = $(this);
        const category = $('#category_name').val();
        const statusValue = $('input[name="addstatus"]').is(':checked') ? 1 : 0;


        if (!category) {
            toastr.warning('Please enter a category name.');
            return;
        }


        const formData = new FormData();
        formData.append('category', category);
        formData.append('status', statusValue);
        formData.append('_token', csrfToken);

      

        $btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1"></span> Saving...'
        );

        $.ajax({
            url: routes.categoriesStore,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                toastr.success('Category added!');
                location.reload();
            },
            error: function () {
                toastr.error('Error adding category.');
                $btn.prop('disabled', false).html('Try Again');
            }
        });
    });


    // ===== Update Category =====
    $('#editCategory').on('click', function () {
        const $btn = $(this);
        const id = $('#edit_category_id').val();
        const category = $('#edit_category_name').val();
        const slug = $('#edit_category_slug').val();
        const statusValue = $('input[name="status"]').is(':checked') ? 1 : 0;

        if (!category) {
            toastr.warning('Please enter a category name.');
            return;
        }


        $btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1"></span> Saving...'
        );

        $.ajax({
            url: routes.categoriesUpdate,
            type: 'POST',
            data: {
                id: id,
                category: category,
                slug: slug,
                status: statusValue,
                _token: csrfToken
            },
            success: function () {
                toastr.success('Category updated!');
                location.reload();
            },
            error: function () {
                toastr.error('Error updating category.');
                $btn.prop('disabled', false).html('Try Again');
            }
        });
    });

});
