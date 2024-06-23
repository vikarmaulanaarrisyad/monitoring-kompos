@extends('layouts.app')

@section('title', 'Setting')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link @if (request('pills') == '') active @endif" href="#settings"
                                data-toggle="tab">Setting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (request('pills') == 'logo') active @endif" href="#logo"
                                data-toggle="tab">Logo</a>
                        </li>
                    </ul>
                </x-slot>

                <div class="tab-content">
                    <div class="tab-pane @if (request('pills') == '') show active @endif" id="settings">
                        @include('setting.general')
                    </div>

                    <div class="tab-pane @if (request('pills') == 'logo') show active @endif" id="logo">
                        @include('setting.logo')
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection

<x-toast />
