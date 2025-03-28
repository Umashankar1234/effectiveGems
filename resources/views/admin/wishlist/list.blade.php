@extends('admin.layout')
@section('page-title', 'Wishlist Details - ' . $productName)
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Wishlist Details - {{ $productName }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.aWishlistData') }}">Wishlist</a></li>
                        <li class="breadcrumb-item active">{{ $productName }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-danger mb-3" id="deleteSelected">Delete Selected</button>
                        <div class="table-responsive">
                            <table id="WishlistTable" class="datatable table table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Sl No.</th>
                                        <th>User ID</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Date/Time</th>
                                        <th>Followup</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Wishlist as $index => $Wishlistdata)
                                    <tr>
                                        <td><input type="checkbox" class="wishlist-checkbox" value="{{ $Wishlistdata->id }}"></td>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ optional($Wishlistdata->userDetails)->user_id ?? 'N/A' }}</td>
                                        <td>{{ optional($Wishlistdata->userDetails)->email ?? 'N/A' }}</td>
                                        <td>{{ optional($Wishlistdata->userDetails)->mobile ?? 'N/A' }}</td>
                                        <td>{{ optional($Wishlistdata->created_at)->format('d-m-Y / h:i a') }}</td>
                                        <td>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="onoffswitch928"
                                                    class="onoffswitch-checkbox"
                                                    id="wishlistOnStatus{{ $Wishlistdata->id }}" tabindex="0"
                                                    {{ $Wishlistdata->follow_off ? 'checked' : '' }}
                                                    onchange="toggleOnStatus({{ $Wishlistdata->id }})">
                                                <label class="onoffswitch-label"
                                                    for="wishlistOnStatus{{ $Wishlistdata->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="deleteWishlist({{ $Wishlistdata->id }})">Cancel</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#WishlistTable')) {
            $('#WishlistTable').DataTable().destroy();
        }

        $('#WishlistTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "columnDefs": [{
                "orderable": false,
                "targets": 'no-sort'
            }]
        });

        // Select all checkboxes
        $('#selectAll').on('click', function() {
            $('.wishlist-checkbox').prop('checked', this.checked);
        });

        // Delete selected wishlists
        $('#deleteSelected').on('click', function() {
            var selectedIds = $('.wishlist-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length === 0) {
                toastr.warning('Please select at least one wishlist to delete.');
                return;
            }

            if (confirm('Are you sure you want to delete the selected wishlists?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.wishlist.massDelete') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'wishlistIds': selectedIds
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred: ' + error);
                    }
                });
            }
        });
    });

    function toggleOnStatus(wishlistId) {
        var isChecked = $('#wishlistOnStatus' + wishlistId).is(':checked');
        var status = isChecked ? 1 : 0;

        $.ajax({
            type: "POST",
            url: "{{ route('admin.wishlistOnStatus') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'wishlistId': wishlistId,
                'status': status
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred: ' + error);
            }
        });
    }

    function deleteWishlist(wishlistId) {
        if (confirm('Are you sure you want to remove this wishlist item?')) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.wishlist.delete') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'wishlistId': wishlistId
                },
                success: function(response) {
                    toastr.success(response.message);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + error);
                }
            });
        }
    }
</script>

@endsection
