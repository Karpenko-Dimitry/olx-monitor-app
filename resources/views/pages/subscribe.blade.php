<?php
    use Illuminate\Support\Facades\Session;
?>
@extends('layout')

@section('content')
    <div class="container">

        <main>
            @if(Session::has('success'))
                <div class="py-5 text-center">
                    <img class="d-block mx-auto mb-4" src="{{ asset('assets/img/olx-logo.webp') }}" alt="olx-logo" height="90">
                    <h2>{{ Session::get('success') }}</h2>
                </div>
            @else
                <div class="py-5 text-center">
                    <img class="d-block mx-auto mb-4" src="{{ asset('assets/img/olx-logo.webp') }}" alt="olx-logo" height="90">
                    <h2>{{ trans('subscribe.title') }}</h2>
                    <p class="lead">{{ trans('subscribe.subtitle') }}</p>
                </div>
                <div class="row g-5">
                <div class="col-md-12 col-lg-12">
                    <h4 class="mb-3">{{ trans('subscribe.form.title') }}</h4>
                    {{ Form::open([
                        'method' => 'post',
                        'url' => route('subscribe.store'),
                        'class' => 'needs-validation',
                    ]) }}
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="email" class="form-label">
                                {{ trans('subscribe.label.email') }}
                                <span class="text-body-secondary">{{ trans('subscribe.required_field') }}</span>
                            </label>
                            {{ Form::text('email', old('email'), [
                                'class' => 'form-control' . ($errors->first('email') ? ' is-invalid' : ''),
                                'placeholder' => trans('subscribe.placeholder.email'),
                                'id' => 'email',
                            ]) }}
                            <div class="invalid-feedback">{{  $errors->first('email') }}</div>
                        </div>

                        <div class="col-12">
                            <label for="url" class="form-label">{{ trans('subscribe.label.url') }}</label>
                            {{ Form::text('url', old('email'), [
                                'class' => 'form-control' . ($errors->first('url') ? ' is-invalid' : ''),
                                'placeholder' => trans('subscribe.placeholder.url'),
                                'id' => 'url',
                            ]) }}
                            <div class="invalid-feedback">{{  $errors->first('url') }}</div>
                        </div>

                        <hr class="my-4">

                        <button class="w-100 btn btn-primary btn-lg" type="submit">{{ trans('subscribe.submit') }}</button>
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
        </main>
    </div>
    @include('includes.footer')
@endsection
