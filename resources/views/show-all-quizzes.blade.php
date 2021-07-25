@extends('app')

@section('title', $data['title'])

@section('content')
    @include('shared.display-quizzes')
@endsection
