@extends('Panel.layout.master')

@section('content')

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-10">
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">ویرایش نقش پزشک</div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form method="POST" action="{{ route('Panel.UpdateRolesDoctor', $role->id) }}">
                    @csrf
                
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان نقش</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $role->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="quota" class="form-label">درصد سهم در جراحی</label>
                            <input type="number" class="form-control" id="quota" name="quota" value="{{ $role->quota }}" min="0" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="required" class="form-label">اجباری بودن نقش</label>
                            <select name="required" id="required" class="form-control" required>
                                <option value="1" {{ $role->required == 1 ? 'selected' : '' }}>بله</option>
                                <option value="0" {{ $role->required == 0 ? 'selected' : '' }}>خیر</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1" {{ $role->status == 1 ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ $role->status == 0 ? 'selected' : '' }}>غیرفعال</option>
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
