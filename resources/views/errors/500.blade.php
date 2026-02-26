@extends('errors::minimal')

@section('title', __('Error del servidor'))
@section('code', '500')
@section('message', $exception->getMessage() ?: __('Error en el servidor'))
