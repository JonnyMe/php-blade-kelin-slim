@extends('layouts.master')

@section('content')
	
	@if ($messaggio["errori"] == 0)
	    {{{ $messaggio["data"] }}}
	@else
	    Errore!
	@endif

@endsection