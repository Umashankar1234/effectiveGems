@extends('user.layout')
@section('content')
    @include('eusers.partials.header')
    <section class="container mb-5">
        <div class="account-body">
            <div class="profile-info">
                <div class="profile-img">
                    <img src="{{ $userdata->profile_img ? asset('user/assets/images/profile/' . $userdata->profile_img) : asset('user/assets/images/profile-img.jpg') }}"
                        alt="image">
                    <div class="text-3">
                        <h3>{{ $userdata->first_name }} {{ $userdata->last_name }}</h3>
                        <h6 class="d-block">Email: {{ $userdata->email ? $userdata->email : 'N/A' }}</h6>
                        <h6 class="d-block">Phone: {{ $userdata->phone ? $userdata->phone : 'N/A' }}</h6>
                        <h6 class="d-block">Gender: {{ $userdata->gender == 1 ? 'Male' : 'Female' }}</h6>
                    </div>
                    <a href="{{route('euser.setting')}}" class="edit-btn d-block"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                </div>
            </div>
        </div>
    </section>
@endsection
