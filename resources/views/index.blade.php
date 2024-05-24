@extends('layouts.app') 
@section('css')
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/style.css')}}" rel="stylesheet"> 
@endsection 
@section('content')
<section class="insurance-tab-section">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card p-4 shadow" style="max-width: 440px; margin: auto;">
                    <h2 class="title-block header text-center pb-2">Keap</h2>
                    <nav class="tab-inner-block">
                        <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-explorer-tab" data-bs-toggle="tab" data-bs-target="#nav-explorer" type="button" role="tab" aria-controls="nav-explorer" aria-selected="true">Explorer Insurance</button>
                            <button class="nav-link" id="nav-travel-tab" data-bs-toggle="tab" data-bs-target="#nav-travel" type="button" role="tab" aria-controls="nav-travel" aria-selected="false">Travel Time Insurance</button>
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-explorer" role="tabpanel" aria-labelledby="nav-explorer-tab">
                            <div class="explore-insurance-block">
                                <form class="common-form-block" id="explorer-form" method="post" action="{{route('keap.import')}}" enctype="multipart/form-data">
                                    @csrf @method('post')
                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="mb-2">Upload<strong class="text-danger">*</strong></label>
                                        <input type="file" required data-msg="Upload Field is required" id="file" name="file" class="form-control mb-1"> @error('file')
                                        <span class="text-danger error" id="error-file">{{$message}}</span> @enderror
                                    </div>
                                    <button type="submit" name="insurance" value="1" class="btn btn-primary mt-4 btn-lg btn-animate">Upload</button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-travel" role="tabpanel" aria-labelledby="nav-travel-tab">
                            <div class="travel-insurance-block">
                                <form class="common-form-block" id="travel-form" method="post" action="{{route('keap.import')}}" enctype="multipart/form-data">
                                    @csrf @method('post')
                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="mb-2">Upload<strong class="text-danger">*</strong></label>
                                        <input type="file" required data-msg="Upload Field is required" id="file" name="file" class="form-control mb-1"> @error('file')
                                        <span class="text-danger error" id="error-file">{{$message}}</span> @enderror
                                    </div>

                                    <button type="submit" name="insurance" value="2" class="btn btn-primary btn-lg mt-4 btn-animate">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 
@section('js')
<!-- <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script> -->
<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/additional-methods.min.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>

@endsection