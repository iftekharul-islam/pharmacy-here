@extends('layouts.app')
@section('style')
    <style>
        #searchResult {
            /*padding-top: 8px;*/
            margin-top: -11px;
            background: white;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            max-height:300px;
            overflow-y:auto;

        }
        #searchResult li {
            padding-left: 2rem;
            padding-top: 2px;
            padding-bottom: 10px;
            text-align: left;
            cursor: pointer;

        }
        #searchResult li:last-child {
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        #searchResult li:hover {
            background: #ddd;
        }
        .text-resize {
            font-size: 19px;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    @if(session('success'))
        <div id="successMessage" class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('failed'))
        <div id="successMessage" class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <!-- Medicine section -->
    <section class="medicine-search-section" style="background: url(images/main-bg.png); background-repeat: no-repeat; background-position: center; background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <h2>{{ __('text.home_h1') }}</h2>
                    <p>{{ __('text.home_h2') }}</p>
                    <label class="w-100 label-search">
                        <form id="form" action="{{ route('product-list') }}" method="GET">
                            <input type="text" id="medicine_search" class="form-control" name="medicine" placeholder="{{ __('text.search_medicine') }}">
                            <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                        </form>
                    </label>
                    <ul id="searchResult">
                    </ul>
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
                            <p class="text-resize">{{ __('text.home_delivery') }}</p>
                            <p>{{ __('text.delivery_title') }}</p>
                            <a href="{{ route('product-list') }}" class="btn--shop-now">Shop Now</a>
                        </div>
                        <div class="right">
                            <img src="{{ asset('images/card-image-1.svg') }}" alt="card 1">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 delivery-card">
                    <div class="card-item">
                        <div class="left">
                            <p class="text-resize">{{ __('text.prescription_holder') }}</p>
                            <p>{{ __('text.prescription_title') }}</p>
                            <a href="{{ route('customer.details', '#v-pills-prescription') }}" class="btn--shop-now">Try now</a>
                        </div>
                        <div class="right">
                            <img src="{{ asset('images/prescription.svg') }}" alt="card 1">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 delivery-card">
                    <div class="card-item">
                        <div class="left">
                            <p class="text-resize">{{ __('text.medicine_alarm') }}</p>
                            <p>{{ __('text.alarm_title') }}</p>
                            <a href="https://play.google.com/store/apps/details?id=com.subidha.customer" target="_blank" class="btn--shop-now">Try now</a>
                        </div>
                        <div class="right">
                            <img src="{{ asset('images/clock.svg') }}" alt="card 1">
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
                <div class="col-md-12 mx-auto">
                    <div class="download">
                        <div class="left">
                            <h2>{{ __('text.download_app') }}!</h2>
                            <p>{{ __('text.download_app_description') }}</p>
                        </div>
                        <div class="right">
                            <a href="https://play.google.com/store/apps/details?id=com.subidha.customer" target="tab"><img src="{{ asset('images/google-play.svg') }}" alt="play store"></a>
                            <a href="#"><img src="{{ asset('images/apple.svg') }}" alt="apple store"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
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
                                console.log(response);
                                var len = response.length;
                                $("#searchResult").empty();
                                $("#searchResult").append(`<li value=""></li>`);
                                for (var i = 0; i < len; i++) {
                                    console.log(response[i]);
                                    var id = response[i]['id'];
                                    var name = response[i]['name'];
                                    var image = response[i]['form']['slug'];
                                    if(image === 'tablet' || image === 'capsul'){
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/pill.png') }}" class="pill mr-2" alt="pill">`;
                                    }
                                    else if (image === 'syrup') {
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/syrup.png') }}" class="pill mr-2" alt="pill">`;
                                    }
                                    else if (image === 'injection') {
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/injection.png') }}" class="pill mr-2" alt="pill">`;
                                    }
                                    else if (image === 'suppository') {
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/suppositories.png') }}" class="pill mr-2" alt="pill">`;
                                    }else {
                                        var pill = `<img width="20px" height="20px" src="{{ asset('images/pill.png') }}" class="pill mr-2" alt="pill">`;
                                    }

                                    if (search != name) {
                                        $("#searchResult")
                                            .append(`<li value='" + id + "'>` +
                                                 pill + name +
                                                `</li> ` );
                                    }

                                }
                                // binding click event to li
                                $("#searchResult li").bind("click", function () {
                                    console.log(this);
                                    setText(this);
                                    isNameSet = true;

                                    console.log(isNameSet);
                                    $('#form').submit();
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
