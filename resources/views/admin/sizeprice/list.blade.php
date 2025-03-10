@extends('admin.layout')
@section('page-title', 'Ring Price')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Ring Price</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ring Price</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" id="addPriceBtn">
                            <i class="fas fa-plus"></i> Add Price
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="priceTable" class="datatable table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Gold Price</th>
                                            <th>Silver Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ringSize as $item)
                                        <tr>
                                            <td>{{ $item->size }}</td>
                                            <td>₹{{ $item->gold_price }}</td>
                                            <td>₹{{ $item->silver_price }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning editPriceBtn"
                                                    data-id="{{ $item->id }}"
                                                    data-size="{{ $item->size }}"
                                                    data-gold="{{ $item->gold_price }}"
                                                    data-silver="{{ $item->silver_price }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
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

    <!-- Add/Edit Price Modal -->
    <div id="priceModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Ring Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="priceForm">
                    @csrf
                    <input type="hidden" id="ring_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Ring Size</label>
                            <input type="text" class="form-control" id="size" required>
                        </div>
                        <div class="form-group">
                            <label>Gold Price</label>
                            <input type="number" class="form-control" id="gold_price" required>
                        </div>
                        <div class="form-group">
                            <label>Silver Price</label>
                            <input type="number" class="form-control" id="silver_price" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery & DataTable Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#priceTable').DataTable();

            // Show Add Price Modal
            $('#addPriceBtn').click(function() {
                $('#modalTitle').text('Add Ring Price');
                $('#ring_id').val('');
                $('#size').val('');
                $('#gold_price').val('');
                $('#silver_price').val('');
                $('#priceModal').modal('show');
            });

            // Show Edit Modal and Fill Data
            $('.editPriceBtn').click(function() {
                $('#modalTitle').text('Edit Ring Price');
                $('#ring_id').val($(this).data('id'));
                $('#size').val($(this).data('size'));
                $('#gold_price').val($(this).data('gold'));
                $('#silver_price').val($(this).data('silver'));
                $('#priceModal').modal('show');
            });

            // Submit Form (AJAX)
            $('#priceForm').submit(function(e) {
                e.preventDefault();
                var ringId = $('#ring_id').val();
                var url = ringId ? "{{ route('admin.product.ring.size.update', '') }}/" + ringId : "{{ route('admin.product.ring.size.store') }}";
                var method = ringId ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        _token: "{{ csrf_token() }}",
                        size: $('#size').val(),
                        gold_price: $('#gold_price').val(),
                        silver_price: $('#silver_price').val()
                    },
                    success: function(response) {
                        location.reload();
                        toastr.success(response.message);
                    },
                    error: function(response) {
                        alert('Something went wrong! Please try again.');
                    }
                });
            });
        });
    </script>
@endsection
