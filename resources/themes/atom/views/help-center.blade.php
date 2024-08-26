@extends('layouts.app')

@push('title', __('Welcome to the best hotel on the web!'))

@section('content')
    <div class="flex flex-col col-span-12 gap-4 lg:flex-row">
        <x-help-center.list :categories="$categories->where('small_box', false)" />
        <x-help-center.list :categories="$categories->where('small_box', true)" small />
    </div>
@endsection