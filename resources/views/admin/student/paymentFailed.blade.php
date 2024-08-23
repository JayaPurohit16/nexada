@extends('admin.layouts.app')
@section('content')
<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <h4 class="text-center ql-color-green">Payment has been failed</h4>
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"><a href="{{ route('admin.student.index') }}">Back</a></button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-js')
@endsection