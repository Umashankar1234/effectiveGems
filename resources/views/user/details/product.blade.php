@extends('user.layout')
@section('content')
@section('title',
!empty($productdetails->metaTitle)
? $productdetails->metaTitle
: $productdetails->productName .
' |
Effective Gems')
@section('description',
!empty($productdetails->metaDescription)
? $productdetails->metaDescription
: $productdetails->description .
' |
Effective Gems')
@section('image', asset($productdetails->image1))
<style>
    .wishlist-active i {
        color: red;
    }
</style>
<section class="container">
    <div class="as_breadcrum_wrapper" style="background-image: url('/user/assets/images/breadcrum-img-1.jpg');">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>{{ $productdetails->productName }}</h1>
                <ul class="breadcrumb">
                    <li><a href="{{ route('user.index') }}">Home</a></li>
                    <li><a
                            href="{{ route('user.categorywiseproduct', $productdetails->category->id) }}">{{ $productdetails->category->categoryName }}</a>
                    </li>
                    @if ($productdetails->subcategory)
                    <li>
                        <a href="{{ route('user.subCategory', $productdetails->subcategory->id) }}">
                            {{ $productdetails->subcategory->subCategoryName }}
                        </a>
                    </li>
                    @endif
                    <li>{{ $productdetails->productName }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="as_service_wrapper product-details-section as_breadcrum_top as_padderBottom40">
    <div class="container">
        <div class="row as_verticle_center">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="as_product_box mt-0" data-aos="fade-right">
                            <div class="as_product_img">
                                <div class="fotorama" data-nav="thumbs">
                                    @php
                                    $images = [
                                    $productdetails->image1,
                                    $productdetails->image2,
                                    $productdetails->image3,
                                    ];
                                    @endphp

                                    @foreach ($images as $image)
                                    <a href="{{ asset($image) }}">
                                        <img src="{{ asset($image ?? 'defaultImage.jpeg') }}" alt="Product Image" />
                                    </a>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="as_product_box product-details-page">
                            <div class="as_product_detail details-height">
                                <h4 class="as_subheading" data-aos="fade-up">{{ $productdetails->productName }}</h4>
                                <input type="hidden" id="productCategory" value="{{ $productdetails->categoryId }}">

                                <div class="main-price">
                                    <span class="as_price" data-aos="fade-up">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>
                                        <span
                                            id="product-price">{{ $productdetails->priceB2C }}/{{ $productdetails->price_type }}</span>
                                    </span>
                                    <span class="mrp-price" data-aos="fade-up">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>
                                        {{ $productdetails->priceMRP }}/{{ $productdetails->price_type }}
                                    </span>

                                </div>



                                <div class="delivery-cost" data-aos="fade-up">
                                    Delivery Charges Apply
                                    @if ($couriertype)
                                    <input type="hidden" id="courierTypeId" value="{{ $couriertype->id }}">
                                    <input type="hidden" id="courierPrice"
                                        value="{{ $couriertype->courier_price }}">
                                    @if ($couriertype->courier_price == 0)
                                    Free
                                    @else
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                    <span id="delivery-cost">{{ $productdetails->deliveryPrice }}</span>
                                    @endif
                                    @else
                                    Not available
                                    @endif
                                </div>


                                @if ($productdetails->categoryId == 1)
                                <div class="quantity-select mt-2" data-aos="fade-up">
                                    <select name="quantity" id="quantityDd" class="form-select" required>
                                        <option value="">--Select Size (Carat/Ratti)--</option>
                                        @for ($i = $productdetails->min_product_qty; $i <= $productdetails->max_product_qty; $i += 0.5)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>
                                </div>
                                @else
                                <div class="quantity-option mt-2" data-aos="fade-up">
                                    <span class="minus" id="minus" style="cursor: pointer;"><i
                                            class="fa-regular fa-minus"></i></span>
                                    <input type="number" id="quantity" value="1" min="1"
                                        name="quantity" readonly>
                                    <span class="plus" id="plus" style="cursor: pointer;"><i
                                            class="fa-regular fa-plus"></i></span>
                                </div>
                                @endif



                                @php
                                $activation = App\Models\Activations::where(
                                'id',
                                $productdetails->activationId,
                                )->first();
                                $Certification = App\Models\Certification::where(
                                'id',
                                $productdetails->certificationId,
                                )->first();
                                @endphp

                                @if (!($activation && $activation->id == 2) || !($Certification && $Certification->id == 2))
                                <div class="extra-checkbox" data-aos="fade-up">
                                    @if (!($activation && $activation->id == 2))
                                    <div class="data-check">
                                        <label>

                                            Activation (+{{ $activation->amount ?? 'N/A' }})
                                            <input type="checkbox" id="activationCheckbox" name="is_act"
                                                value="1" data-price="{{ $activation->amount ?? 0 }}">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    @endif
                                    @if (!($Certification && $Certification->id == 2))
                                    <div class="data-check">
                                        <label>
                                            Certification (+{{ $Certification->amount ?? 'N/A' }})
                                            <input type="checkbox" id="certificationCheckbox" name="is_cert"
                                                value="1" data-price="{{ $Certification->amount ?? 0 }}">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    @endif

                                </div>
                                <div id="activationFields" style="display: none;">
                                    <div class="form-group">
                                        <label for="activationUserName">Activation User Name</label>
                                        <input type="text" id="activationUserName" placeholder="Enter Activation User Name" name="activationUserName" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="gotra">Gotra</label>
                                        <input type="text" id="gotra" name="gotra" placeholder="Enter gotra" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="text" id="dob" name="dob" placeholder="dob" class="form-control">
                                    </div>
                                </div>
                                @endif

                                @if ($productdetails->categoryId == 1)
                                <div class="mt-1">
                                    <!-- Add Ring Checkbox -->
                                    <div class="extra-checkbox">
                                        <label>
                                            <input type="checkbox" id="add-ring"> Add Ring
                                        </label>
                                    </div>
                            
                                    <!-- Radio buttons for gold and silver selection -->
                                    <div id="metal-selection" class="hidden form-group">
                                        <div class="d-flex justify-content-between">
                                        <label class="metal-option col-6" style="margin: 0px 10px;">
                                            <input type="radio" name="metal" value="gold">
                                            <span class="icon-text">
                                                <i class="fas fa-coins" style="font-size:28px; color:rgb(255, 215, 0);"></i>
                                                Gold
                                            </span>
                                        </label>
                                        <label class="metal-option col-6">
                                            <input type="radio" name="metal" value="silver">
                                            <span class="icon-text">
                                                <i class="fas fa-coins" style="font-size:28px; color:rgb(192, 192, 192);"></i>
                                                Silver
                                            </span>
                                        </label>
                                        </div>
                                    </div>
                            
                                    <!-- Dropdowns for Gold and Silver Prices -->
                                    <div id="gold-selection" class="hidden form-group">
                                        <label for="gold-price">Select Gold Price:</label>
                                        <select id="gold-price" class="form-control">
                                            <option value="">Select Gold Price</option>
                                            <!-- Options will be populated dynamically -->
                                        </select>
                                    </div>
                            
                                    <div id="silver-selection" class="hidden form-group">
                                        <label for="silver-price">Select Silver Price:</label>
                                        <select id="silver-price" class="form-control">
                                            <option value="">Select Silver Price</option>
                                            <!-- Options will be populated dynamically -->
                                        </select>
                                    </div>
                                   <input type="hidden" id="ring-price" value="0">
                                    <!-- Display the selected price -->
                                </div> 
                                @endif
                            


                                <div class="total-price-details" data-aos="fade-up">
                                    <span>Total :</span>

                                    <input type="hidden" id="productPrice" value="{{ $productdetails->priceB2C }}">
                                    <span class="as_price">
                                        <i class="fa-solid fa-indian-rupee-sign"></i>
                                        <span id="product-price-total">{{ $productdetails->priceB2C }}</span>
                                    </span>
                                </div>


                                <!--button start-->
                                <div class="main-btn mt-2 space-between justify-content-start" data-aos="zoom-in">
                                    <a href="javascript:;" onclick="return buyNow({{ $productdetails->id }})"
                                        class="as_btn"><span>Buy Now</span></a>
                                    <a href="javascript:;" class="as_btn-2 btn-res"
                                        onclick="return addToCart({{ $productdetails->id }})"><span>Add
                                            to Cart</span>
                                    </a>
                                    <a href="javascript:;"
                                        class="wishlist-btn-details {{ $isInWishlist ? 'wishlist-active' : '' }}"
                                        title="Add to Wishlist"
                                        onclick="return addToWishlist({{ $productdetails->id }}, this)">
                                        <i class="fa-light fa-heart"></i>
                                    </a>

                                </div>
                                <!--button end-->

                                <ul class="short-note">
                                    {!! $productdetails->productDesc1 !!}
                                </ul>


                                <!--product variant start-->
                                @if (count($variants) != 0)
                                <div class="product-variant-section"> 
                                    <h3>Product Variant :</h3>
                                    @foreach ($variants as $variant)
                                    <div class="variant-item">
                                        @if (!empty($variant->prodid))
                                        <a
                                            href="{{ route('user.productdetails', ['prodid' => $variant->prodid]) }}">
                                            <h4>{{ $variant->variantName ?? $variant->productName }}<br>₹<strong>{{ $variant->priceB2C ?? '' }}</strong>
                                            </h4>
                                        </a>
                                        @else
                                        <h4>{{ $variant->variantName ?? $variant->productName }}<br>₹<strong>{{ $variant->priceB2C ?? '' }}</strong>
                                        </h4>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @endif


                                <div class="clearfix">&nbsp;</div>
                                <!--product variant end-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Start product details tab section -->
<section class="as_padderBottom40">
    <div class="container">
        <div id="horizontalTab">
            <ul class="resp-tabs-list">
                <li>{{ $productdetails->productHeading2 ?? 'Description' }}</li>
                <li>{{ $productdetails->productHeading3 ?? 'Shipping Policy' }}</li>
                <li>{{ $productdetails->productHeading4 ?? 'Return Policy' }}</li>
                <li>{{ $productdetails->productHeading5 ?? 'Payment Method' }}</li>
            </ul>
            <div class="resp-tabs-container">
                <div>
                    <p>{!! $productdetails->productDesc2 ?? 'No Description Available' !!}</p>
                </div>

                <!--tab 1 end-->
                <div>
                    @if ($productdetails->productDesc3)
                    {!! $productdetails->productDesc3 !!}
                    @else
                    <p>Worldwide Shipping is available.<br>
                        1. Free shipping on orders over INR 5,000 in India.<br>
                        2. COD is available for orders over INR 5,000 in India.<br>
                        3. International Express Shipping takes 4-7 days for delivery.</p>
                    @endif
                </div>
                <!--tab 2 end-->
                <div>
                    @if ($productdetails->productDesc4)
                    {!! $productdetails->productDesc4 !!}
                    @else
                    <p> 1. Get 100% moneyback on returning loose gemstones within 10 days for a full refund of the
                        gemstone price.<br>
                        2. Return Shipment is at customer's cost.<br>
                        3. Shipping Charges, GST/VAT and duties are not refundable.</p>
                    @endif

                </div>
                <!--tab 3 end-->
                <div>
                    @if ($productdetails->productDesc5)
                    {!! $productdetails->productDesc5 !!}
                    @else
                    <p> 1. Credit Cards: All Visa, MasterCard and American Express Credit Cards are accepted<br>
                        2. Debit Cards (India): All Visa and Maestro Debit Cards are accepted.<br>
                        3. PayPal, Net Banking, Cash Cards</p>
                    @endif
                </div>
                <!--tab 4 end-->
            </div>
        </div>
    </div>
</section>
<!-- End product details tab section -->

<!--Related Products start-->

<!-- Related Products start -->
@if ($relatedProducts->count() > 0)
<section class="as_product_wrapper as_padderBottom40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 text-center">
                <div class="inline-header">
                    <h1 class="as_heading">Related Products</h1>
                    <div class="text-center" data-aos="zoom-in">
                        <a href="product.html" class="as_btn">view more</a>
                    </div>
                </div>
                <div class="row mt-2" data-aos="fade-down" data-aos-duration="1500">
                    @foreach ($relatedProducts as $related)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="as_product_box">
                            <a href="{{ route('user.productdetails', $related->id) }}"
                                class="as_product_img">
                                <img src="{{ asset($related->image1 ?? 'defaultImage.jpeg') }}"
                                    class="img-responsive" alt="Product Image" />
                            </a>
                            <div class="as_product_detail">
                                <h4 class="as_subheading">{{ $related->productName }}</h4>
                                <span class="as_price">
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                    <span
                                        style="text-decoration: line-through;">{{ $related->priceMRP }}</span>
                                    <span>{{ $related->priceB2C }} / {{ $related->price_type }}</span>
                                </span>

                                <div class="space-between">
                                    <a href="{{ route('user.productdetails', $related->id) }}"
                                        class="as_btn_cart"><span>View Details</span></a>
                                    <a href="javascript:;" class="enquire_btn" data-bs-toggle="modal"
                                        data-bs-target="#enquire_modal"><span>Order Now</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- Related Products end -->

<!-- Popular Products start -->
@if ($popularproducts->count() > 0)
<section class="as_product_wrapper as_padderBottom40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 text-center">
                <div class="inline-header">
                    <h1 class="as_heading">Popular Products</h1>
                    <div class="text-center" data-aos="zoom-in">
                        <a href="popular-product.html" class="as_btn">view more</a>
                    </div>
                </div>
                <div class="row mt-2" data-aos="fade-down" data-aos-duration="1500">
                    @foreach ($popularproducts as $popular)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="as_product_box">
                            <a href="{{ route('user.productdetails', $popular->id) }}"
                                class="as_product_img">
                                <img src="{{ asset($popular->image1 ?? 'defaultImage.jpeg') }}"
                                    class="img-responsive" alt="Product Image" />
                            </a>
                            <div class="as_product_detail">
                                <h4 class="as_subheading">{{ $popular->productName }}</h4>
                                <span class="as_price">
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                    <span
                                        style="text-decoration: line-through;">{{ $popular->priceMRP }}</span>
                                    <span>{{ $popular->priceB2C }} / {{ $popular->price_type }}</span>
                                </span>

                                <div class="space-between">
                                    <a href="{{ route('user.productdetails', $popular->id) }}"
                                        class="as_btn_cart"><span>View Details</span></a>
                                    <a href="javascript:;" class="enquire_btn" data-bs-toggle="modal"
                                        data-bs-target="#enquire_modal"><span>Order Now</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!--Popular Products end-->
@endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    const addToWishlist = (proId, element) => {

        if (!document.querySelector('meta[name="user-logged-in"]').content) {
            toastr.error("Please login to add to wishlist.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{ route('euser.wishlist-add') }}",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: proId,
            },
            success: function(response) {
                if (response.status === "success") {
                    $(element).addClass("wishlist-active");
                    toastr.success(response.message);
                } else if (response.status === "removed") {
                    $(element).removeClass("wishlist-active");
                    toastr.info(response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.error("An error occurred: " + error);
            },
        });
    };
    // const addToCart = (proId) => {
        
    //     var quantity = parseFloat($('input[name="quantity"], select[name="quantity"]').val());
    //     var isActive = $('input[name="is_act"]').is(':checked') ? $('input[name="is_act"]').val() : 0;
    //     var isCert = $('input[name="is_cert"]').is(':checked') ? $('input[name="is_cert"]').val() : 0;
    //     $.ajax({
    //         type: "POST",
    //         url: "{{ route('addToCart') }}",
    //         data: {
    //             _token: "{{ csrf_token() }}",
    //             product_id: proId,
    //             quantity: quantity,
    //             isActive: isActive,
    //             isCert: isCert,
    //         },
    //         success: function(response) {
    //             $(".cartCount").text(response.totalCartItems);
    //             alert(response.message);
    //             // toastr.success(response.message);
    //         },
    //         error: function(xhr, status, error) {
    //             // toastr.error("An error occurred: " + error);
    //         },
    //     });
    // };
    const addToCart = (proId) => {
        var quantity = parseFloat($('input[name="quantity"], select[name="quantity"]').val());
        var isActive = $('input[name="is_act"]').is(':checked') ? $('input[name="is_act"]').val() : 0;
        var isCert = $('input[name="is_cert"]').is(':checked') ? $('input[name="is_cert"]').val() : 0;
        debugger;

        // Validate quantity
        if (isNaN(quantity) || quantity <= 0) {
            alert("Please enter a valid quantity.");
            return; // Stop further execution if quantity is invalid
        }

        // Collect activation fields if activation is checked
        var activationUserName = $("#activationCheckbox").is(":checked") ? $("#activationUserName").val() : null;
        var gotra = $("#activationCheckbox").is(":checked") ? $("#gotra").val() : null;
        var dob = $("#activationCheckbox").is(":checked") ? $("#dob").val() : null;

        // Validate activationUserName if activation is checked
        if ($("#activationCheckbox").is(":checked") && (!activationUserName || activationUserName.trim() === "")) {
            alert("Please enter a valid activation user name.");
            return; // Stop further execution if activation user name is invalid
        }

        // Collect ring selection data
        var addRing = $("#add-ring").is(":checked") ? 1 : 0;
        var selectedMetal = $("input[name='metal']:checked").val() || null;
        var goldPrice = $("#gold-price").val() || null;
        var silverPrice = $("#silver-price").val() || null;
        var ringPrice = $("#ring-price").val() || 0;

        // Validate addRing if it is checked
        if (addRing && ringPrice == 0) {
            alert("Please select a metal and select a valid price.");
            return; // Stop further execution if ring selection is invalid
        }

        
        $.ajax({
            type: "POST",
            url: "{{ route('addToCart') }}",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: proId,
                quantity: quantity,
                isActive: isActive,
                isCert: isCert,
                activationUserName: activationUserName,
                gotra: gotra,
                dob: dob,
                addRing: addRing,
                selectedMetal: selectedMetal,
                goldPrice: goldPrice,
                silverPrice: silverPrice,
                ringPrice: ringPrice,
            },
            success: function(response) {
                $(".cartCount").text(response.totalCartItems);
                // alert(response.message);
                // toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                console.error("An error occurred: " + error);
                // toastr.error("An error occurred: " + error);
            },
        });
    };

    const buyNow = (proId) => {

        var quantity = parseFloat($('input[name="quantity"], select[name="quantity"]').val());
        var isActive = $('input[name="is_act"]').is(':checked') ? $('input[name="is_act"]').val() : 0;
        var isCert = $('input[name="is_cert"]').is(':checked') ? $('input[name="is_cert"]').val() : 0;

        $.ajax({
            type: "POST",
            url: "{{ route('addToCart') }}",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: proId,
                quantity: quantity,
                isActive: isActive,
                isCert: isCert,
            },
            success: function(response) {
                $(".cartCount").text(response.totalCartItems);
                // alert(response.message);
                window.location.href = '/checkout';
                // toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                // toastr.error("An error occurred: " + error);
            },
        });
    };
</script>
<style>
    .hidden {
        display: none;
    }
</style>
<style>
    .metal-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        border: 2px solid transparent;
        border-radius: 30px;
        background-color: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .metal-option:hover, .metal-option input:checked + .icon-text {
        border-color: #007bff;
        background-color: #e9ecef;
    }

    .metal-option input {
        display: none;
    }

    .metal-option .icon-text {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        font-size: 18px;
    }
</style>
@push('scripts')
<script>
    flatpickr('#dob', {
            dateFormat: 'd-m-Y', // Set the desired format
            allowInput: true, // Allow manual input
        });
    // Data for Gold and Silver Prices
    const ringData = @json($ringSizes);

    // Function to populate dropdowns
    function populateDropdowns() {
        const goldDropdown = document.getElementById('gold-price');
        const silverDropdown = document.getElementById('silver-price');

        // Clear existing options
        goldDropdown.innerHTML = '<option value="">Select Gold Price</option>';
        silverDropdown.innerHTML = '<option value="">Select Silver Price</option>';

        // Populate options
        ringData.forEach(item => { 
            const goldOption = document.createElement('option');
            goldOption.value = item.gold_price;
            goldOption.textContent = `${item.size} - ${item.gold_price.toLocaleString('en-IN')}`;
            goldDropdown.appendChild(goldOption);

            const silverOption = document.createElement('option');
            silverOption.value = item.silver_price;
            silverOption.textContent = `${item.size} - ${item.silver_price.toLocaleString('en-IN')}`;
            silverDropdown.appendChild(silverOption);
        });
    }

    // Event Listeners
    document.getElementById('add-ring').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('metal-selection').classList.remove('hidden');
            populateDropdowns(); // Populate dropdowns when "Add Ring" is checked
        } else {
            document.getElementById('metal-selection').classList.add('hidden');
            document.getElementById('gold-selection').classList.add('hidden');
            document.getElementById('silver-selection').classList.add('hidden');
            document.getElementById('price-display').classList.add('hidden');
        }
    });

    document.querySelectorAll('input[name="metal"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'gold') {
                document.getElementById('gold-selection').classList.remove('hidden');
                document.getElementById('silver-selection').classList.add('hidden');
            } else if (this.value === 'silver') {
                document.getElementById('silver-selection').classList.remove('hidden');
                document.getElementById('gold-selection').classList.add('hidden');
            }
            document.getElementById('price-display').classList.add('hidden'); // Hide price display on metal change
        });
    });

    document.getElementById('gold-price').addEventListener('change', function() {
        const selectedPrice = this.value;
        document.getElementById('ring-price').value = selectedPrice;
        document.getElementById('price-display').classList.remove('hidden');
        console.log('Selected Gold Price:', selectedPrice);
    });

    document.getElementById('silver-price').addEventListener('change', function() {
        const selectedPrice = this.value;
        document.getElementById('ring-price').value = selectedPrice;
        document.getElementById('price-display').classList.remove('hidden');
        console.log('Selected Silver Price:', selectedPrice);
    });

    $('#activationCheckbox').change(function() {
        if (this.checked) {
            // Show the activationFields div if the checkbox is checked
            $('#activationFields').show();
        } else {
            // Hide the activationFields div if the checkbox is unchecked
            $('#activationFields').hide();
        }
    });


</script>
@endpush