@extends('errors::minimal')

@section('title', __('No autorizado'))
@section('code', '401')
@section('message', __('No estás autorizado a entrar a esta página'))
