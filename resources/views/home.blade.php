@extends('layouts.app')
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- Medicine section -->
    <section class="medicine-search-section" style="background: url(images/main-bg.png); background-repeat: no-repeat; background-position: center; background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <h2>We Deliver Your Medication</h2>
                    <p>Say goodbye to all your healthcare worries with us</p>
                    <label class="w-100 label-search">
                        <form action="{{ route('product-list') }}" method="GET">
                            <input type="text" id="medicine_search" class="form-control" name="medicine" placeholder="Search your medicine here">
                            <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                        </form>
{{--                        <input type="search" id="medicine_search" class="form-control" placeholder="Search your medicine here">--}}
{{--                        <button type="submit" class="search-button"><i class="fas fa-search"></i></button>--}}
                    </label>
                    <ul id="searchResult"></ul>
                </div>
            </div>
        </div>
    </section>
    <!-- card -->
    <section class="card-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 delivery-card">
                    <div class="card-item">
                        <div class="left">
                            <h4>Home Delivery</h4>
                            <p>With extra care we deliver
                                your products.</p>
                            <a href="#" class="btn--shop-now">Shop Now</a>
                        </div>
                        <div class="right">
                            <img src="{{ asset('images/card-image-1.svg') }}" alt="card 1">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 delivery-card">
                    <div class="card-item">
                        <div class="left">
                            <h4>Home Delivery</h4>
                            <p>With extra care we deliver
                                your products.</p>
                            <a href="#" class="btn--shop-now">Shop Now</a>
                        </div>
                        <div class="right">
                            <img src="{{ asset('images/card-image-2.svg') }}" alt="card 1">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 delivery-card">
                    <div class="card-item">
                        <div class="left">
                            <h4>Home Delivery</h4>
                            <p>With extra care we deliver
                                your products.</p>
                            <a href="#" class="btn--shop-now">Shop Now</a>
                        </div>
                        <div class="right">
                            <img src="{{ asset('images/card-image-3.svg') }}" alt="card 1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- download section -->
    <section class="download-section">
        <div class="container">
            <div class="row">
                <div class="col-md-11 mx-auto">
                    <div class="download">
                        <div class="left">
                            <h2>Download the app now!</h2>
                            <p>Download now and get all our services through the app.</p>
                        </div>
                        <div class="right">
                            <a href="#"><img src="{{ asset('images/google-play.svg') }}" alt="play store"></a>
                            <a href="#"><img src="{{ asset('images/apple.svg') }}" alt="apple store"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script type="text/javascript">
        var isNameSet = false;
        $(document).ready(function(){

            console.log(isNameSet);

            if (!isNameSet) {
                $("#medicine_search").keyup(function () {
                    var search = $(this).val();
                    console.log(search);
                    if (search != "") {
                        $.ajax({
                            url: "search/medicine-name",
                            type: 'get',
                            data: {medicine: search},
                            dataType: 'json',
                            success: function (response) {
                                var len = response.length;
                                $("#searchResult").empty();
                                for (var i = 0; i < len; i++) {
                                    console.log(response[i]);
                                    var id = response[i]['id'];
                                    var name = response[i]['name'];

                                    if (search != name) {
                                        $("#searchResult").append("<li value='" + id + "'>" + name + "</li>");
                                    }


                                }
                                // binding click event to li
                                $("#searchResult li").bind("click", function () {
                                    console.log(this);
                                    setText(this);
                                    isNameSet = true;
                                    console.log(isNameSet);
                                });
                            }
                        });
                    } else {
                        $("#searchResult").empty();
                    }
                });
            }
        });
        // Set Text to search box and get details
        function setText(element){
            var value = $(element).text();
            $("#medicine_search").val(value);
            $("#searchResult").empty();
        }
    </script>
@endsection
