@extends('Admin.layout.master')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card card-primary card-outline mb-4 shadow-lg rounded">
                <!--begin::Header-->
                <div class="card-header bg-primary text-white rounded-top">
                    <div class="card-title">
                        <i class="fas fa-plus-circle me-2"></i>
                        اضافه کردن تخصص جدید
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Form-->
                <form method="POST" action="{{ route('Panel.StoreSpeciality') }}" id="speciality-form">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-bold text-dark">عنوان تخصص</label>
                                <input
                                    type="text"
                                    class="form-control shadow-sm border-primary"
                                    id="title"
                                    name="title"
                                    required
                                />
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold text-dark">وضعیت</label>
                                <select class="form-control shadow-sm border-primary" id="status" name="status">
                                    <option value="1">فعال</option>
                                    <option value="0">غیرفعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary shadow-sm me-2">
                            <i class="fas fa-save me-2"></i>
                            ذخیره
                        </button>
                        <a href="{{ route('Panel.SpecialitiesList') }}" class="btn btn-secondary shadow-sm">
                            <i class="fas fa-arrow-right me-2"></i>
                            بازگشت
                        </a>
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
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
