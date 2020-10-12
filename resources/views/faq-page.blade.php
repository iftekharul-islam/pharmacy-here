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
                    <h3 class="text-center">FAQs</h3>
                    <div class="bs-example mt-5">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"><i class="fa fa-plus"></i> What is HTML?</button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>HTML stands for HyperText Markup Language. HTML is the standard markup language for describing the structure of web pages. <a href="https://www.tutorialrepublic.com/html-tutorial/" target="_blank">Learn more.</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"><i class="fa fa-plus"></i> What is Bootstrap?</button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>Bootstrap is a sleek, intuitive, and powerful front-end framework for faster and easier web development. It is a collection of CSS and HTML conventions. <a href="https://www.tutorialrepublic.com/twitter-bootstrap-tutorial/" target="_blank">Learn more.</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"><i class="fa fa-plus"></i> What is CSS?</button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc. <a href="https://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mx-auto mt-5">
                    <h2 class="text-center mb-5">Got no answer for your desired questions?</h2>
                    <form action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname"><b>First Name :</b></label>
                                    <input type="email" class="form-control" id="fname" aria-describedby="fnameHelp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname"><b>Last Name :</b></label>
                                    <input type="email" class="form-control" id="lname" aria-describedby="lnameHelp">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="phone-number"><b>Phone Number :</b></label>
                                    <input type="email" class="form-control" id="phone-number" aria-describedby="phoneHelp">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="question"><b>Additional questions :</b></label>
                                    <textarea type="email" class="form-control" rows="4" id="question" aria-describedby="addressHelp"></textarea>
                                </div>
                            </div>
                            <div class="mx-auto mb-5">
                                <button type="submit" class="btn btn--primary px-5" disabled>Sent</button>
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
