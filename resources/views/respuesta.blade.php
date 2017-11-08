@extends('layouts.app')

@section('title')
  Admin
@endsection
@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main block-center">
    <!-- Timeline -->
    <div class="timeline">
        <article class="panel panel-danger panel-outline">
            <div class="panel-heading icon">
                <h2 class="panel-title">Respuesta de apertura</h2>
            </div>
            <div class="panel-body">
                <strong>Someone</strong> favourited your photo.
            </div>
        </article>

        <article class="panel panel-default panel-outline">
            <div class="panel-body d-inline-block">
                <img class="img-responsive img-rounded" src="//placehold.it/350x150"/>
            </div>
        </article>

        <article class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="panel-title">Respuesta de seguimiento</h2>
            </div>
            <div class="panel-body">
                Some new content has been added.
            </div>
        </article>
    </div>
    <!-- /Timeline -->
</div>
@endsection