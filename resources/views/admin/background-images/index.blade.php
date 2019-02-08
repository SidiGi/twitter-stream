@extends('layouts.admin')

@section('content')
    @include('admin.background-images.parts.create')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-3">
                <div class="images-list">
                    @foreach($images as $image)
                        <div class="card row">
                            <div class="col-xs-8">
                                <div class="media">
                                    <div class="media-left">
                                        <img class="img-thumbnail media-object" src="{{asset('storage/' . $image->path)}}" style="width: 350px">
                                    </div>
                                    <div class="media-body">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-4 approval">

                                <form action="{{ route('admin.background-images.destroy', ['image' => $image])}}" method="delete">
                                    <a href="#" style="float: right" class="delete-image">Delete</a>
                                </form>
                            </div>

                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection