@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/apps.css') }}" />
@endpush



@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">


                <h3 class="content-title mb-2">{{ $page_title }}</h3>
                <div class="d-flex">
                    <a href="/"><i class="mdi mdi-home text-muted hover-cursor"></i></a>
                    <p class="text-primary mb-0 hover-cursor">&nbsp;/&nbsp;{{ $page_title }}</p>
                </div>
            </div>

        </div>
        <!-- /breadcrumb -->

        <div class="notify__area">
            @foreach ($notifications as $notification)
                <a class="notify__item @if ($notification->read_status == 0) unread--notification @endif"
                    href="{{ route('admin.notification.read', $notification->id) }}">
                    <div class="notify__thumb bg--primary">
                        <img
                            src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$notification->user->image, imagePath()['profile']['user']['size']) }}">
                    </div>
                    <div class="notify__content">
                        <h6 class="title">{{ __($notification->title) }}</h6>
                        <span class="date"><i class="las la-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @endforeach
            {{ paginateLinks($notifications) }}
        </div>
    </div>
@endsection
