@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10"> <!-- استفاده از col-12 برای عرض کامل -->
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">ویرایش تخصص</div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form method="POST" action="{{ route('Panel.UpdateSpeciality', $speciality->id) }}">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان تخصص</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $speciality->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1" {{ $speciality->status == 1 ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ $speciality->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">بروزرسانی</button>
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
