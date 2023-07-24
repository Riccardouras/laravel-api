@extends('layouts.app')
@section('page-title', 'projects')
@section('content')
{{-- Metodo da rivedere --}}
<script>
     function confirmDelete() {
    return confirm('Sei sicuro di voler eliminare questo elemento?');
}
</script>
<h1>projects</h1>
<div class="card p-0 mb-4" style="width: 18rem;">
    <img class="card-img-top" src="{{ asset("storage/".$project->image) }}" alt="{{ $project->title }}">
    <div class="card-body">
        <h5 class="card-title">{{ $project->title }}</h5>
            <p>Categoria: {{ $project->content }} </p>

        <p>types: 
            <span>{{$project->$type}}</span>
        </p>
        <form action="{{ route('admin.projects.destroy', $project) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="confirmDelete();">Delete</button>
            @if ($project->technologies->count() > 0)
                <h2>Tecnologie utilizzate:</h2>
                <ul>
                    @foreach ($project->technologies as $technology)
                        <li>{{ $technology->name }}</li>
                    @endforeach
                </ul>
            @endif

            </form>
        <button class="btn btn-warning"><a class="text-white" href="{{ route('admin.projects.edit', $project->id)}}">Edit</a>

    </div>
</div>

@endsection