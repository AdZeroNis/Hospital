@extends('Panel.layout.master')

@section('content')


<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10"> <!-- استفاده از col-12 برای عرض کامل -->
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title"> اضاف کردن کاربر جدید</div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form method="POST" action="{{route('Panel.SaveUser')}}" id="my-form">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label"> نام</label>
                            <input
                                type="text"
                                class="form-control"
                                id="exampleInputEmail1"
                                aria-describedby="emailHelp"
                                name="name"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">تلفن</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="mobile" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">ایمیل</label>
                            <input type="email" class="form-control" id="exampleInputPassword1" name="email" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">رمز</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="password" />
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Quick Example-->
        </div>
    </div>
</div>
@endsection

@section("srcJs")
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Admin\UserRequest', '#my-form'); !!}
@endsection
