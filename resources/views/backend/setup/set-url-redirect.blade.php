@extends('layouts/layoutMaster')

@section('title', 'Set URL Redirect')

@section('content')
@if($permissions['isAllowedToSetUrlRedirect'])
<h4 class="fw-bold py-3 mb-1"><span class="text-primary fw-light"></span>Set URL Redirect</h4>

<div class="row">
    <div class="col-xl-8 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Form Set URL Redirect</h4>
                </div>
            </div>

            {{-- Start Form Set URL Redirect --}}
            <div class="card-body">
                @livewire('backend.setup.config.set-url-redirect.form')
            </div>
            {{-- End Form Set URL Redirect --}}
        </div>
    </div>
</div>
@endif
@endsection
