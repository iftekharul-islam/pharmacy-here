@extends('layouts.app')
<style>
    /*.btn-link {*/
    /*    color: #00AE4D!important;*/
    /*}*/
</style>
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-9 mx-auto mb-5">
                    <h3 class="text-center">{{ __('text.faqs') }}</h3>
                    <div class="bs-example mt-5">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"><i class="fa fa-plus"></i> Who operates Subidha?</button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>Subidha is mainly operated by several A grade registered pharmacists from Pharmacy Faculty of University of Dhaka.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"><i class="fa fa-plus"></i> Does Subidha own any pharmacy?</button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>Subidha does not own any pharmacy. So Subidha provides healthcare services to customers without biasedness and Subidha can take actions against assigned pharmacies if any violation occurs.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"><i class="fa fa-plus"></i> What kind of medicines does Subidha manage?</button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>Subidha manages all types of medicines which are registered by government of Bangladesh. Subidha continuously update the list. If you find anything wrong or missing, notify Subidha. Subidha will take necessary actions as soon as possible. But managing few medicines may require longer time than usual due to expensiveness, extra monitoring, slow purchase history. You’ll get notification before purchasing those medicines.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseFour"><i class="fa fa-plus"></i> Does Subidha cover all areas of Bangladesh?</button>
                                    </h2>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>Customers living any area of Bangladesh can purchase, collect medicines from designated pharmacies of Subidha. At present, for home delivery - Subidha covers only specific areas of each district and almost all areas of Dhaka. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFive">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseFive"><i class="fa fa-plus"></i> Delivery timing?</button>
                                    </h2>
                                </div>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>Subidha can arrange to deliver medicines within minimum 2.05 hours. But managing few medicines may require longer time than usual due to expensiveness, extra monitoring, slow purchase history. You’ll get notification before purchasing those medicines.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingSix">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseSix"><i class="fa fa-plus"></i> Price of medicines?</button>
                                    </h2>
                                </div>
                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>Subidha keeps the price of medicines not more than MRP/IP. If the price mismatches with MRP/IP of any medicine, Subidha requests you not to purchase that medicine and report to Subidha. Subidha will take corrective measures as soon as possible.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mx-auto mt-5">
                    <h2 class="text-center mb-5">{{ __('text.no_ans_found') }}?</h2>
                    <form action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname"><b>{{ __('text.fname') }} :</b></label>
                                    <input type="email" class="form-control" id="fname" aria-describedby="fnameHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname"><b>{{ __('text.lname') }} :</b></label>
                                    <input type="email" class="form-control" id="lname" aria-describedby="lnameHelp">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="phone-number"><b>{{ __('text.phone_number') }} :</b></label>
                                    <input type="email" class="form-control" id="phone-number" aria-describedby="phoneHelp">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="question"><b>{{ __('text.add_ques') }} :</b></label>
                                    <textarea type="email" class="form-control" rows="4" id="question" aria-describedby="addressHelp"></textarea>
                                </div>
                            </div>
                            <div class="mx-auto mb-5">
                                <button type="submit" class="btn btn--primary px-5" disabled>{{ __('text.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function(){
                $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
                $(this).prev(".card-header").find(".btn-link").css('color', '#00AE4D');
            });

            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus").css('color', '#00AE4D');
                $(this).prev(".card-header").find(".btn-link").css('color', '#00AE4D');
            }).on('hide.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus").css('color', '#000000');
                $(this).prev(".card-header").find(".btn-link").css('color', '#000000');
            });
        });
    </script>
@endsection
