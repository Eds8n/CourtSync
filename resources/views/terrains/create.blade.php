@extends('layouts.app')

@section('content')
<h1>Ajouter un terrain</h1>
<form method="post" action="{{ route('terrains.store') }}" enctype="multipart/form-data">
<p><a href="{{ route('terrains.index') }}">Annuler</a></p>
@endsection