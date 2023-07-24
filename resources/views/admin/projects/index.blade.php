@extends('layouts.admin')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-between">
        @foreach ($projects as $project)
            <div class="card p-0 mb-4" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset("storage/".$project->image) }}" alt="{{ $project->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $project->title }}</h5>
                        <p>Categoria: {{ $project->content }} </p>

                    <p>types: 
                    @forelse ($types as $type)
                        <span>{{$type->name}}</span>
                    @empty
                        <span>Nessuno</span>
                    @endforelse
                    </p>
              
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection