@extends('errors::minimal')

@section('title', __('Servicio no disponible'))
@section('code', '503')
@section('message', __('Error de conexión con el servidor. Intenta más tarde'))
