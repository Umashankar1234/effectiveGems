@extends('admin.layout')
@section('page-title', $activationedit->amount ?? '')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Activation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="{{route('admin.dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{route('admin.listactivation')}}">Activation</a></li>
                        <li class="breadcrumb-item active">{{$activationedit->amount ?? ''}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.updateactivation',$activationedit->id) }}" enctype="multipart/form-data">
                            @csrf
                            {{-- <input type="hidden" name="_token" value=""> --}}
                            <div class="tab-content">
                                <div class="tab-pane show active" id="basictab">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <fieldset class="fieldset-style">
                                                <div class="row">
                                                    <div class="col-xl-8">
                                                        <div class="form-group">
                                                            <label>Amount</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="e.g. Set Free or Amount of activation" name="amount"
                                                                value="{{$activationedit->amount}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div> <!-- end col -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection