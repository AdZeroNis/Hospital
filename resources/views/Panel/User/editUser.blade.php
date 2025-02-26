@extends('Panel.layout.master')

@section('content')


<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10"> <!-- استفاده از col-12 برای عرض کامل -->
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">   ویرایش کاربر</div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form method="POST" action="{{route('Panel.UpdateUser',$user->id)}}">
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
                                value="{{$user->name}}"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">تلفن</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="phone"  value="{{$user->mobile}}"/>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">ایمیل</label>
                            <input type="email" class="form-control" id="exampleInputPassword1" name="email" value="{{$user->email}}" />
                        </div>

                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ویرایش</button>
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
