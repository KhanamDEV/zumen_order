<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 10:59
 */
?>
@extends('worker::layouts.master')
@php
    $project = $data['project'];
@endphp
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="card">

            <div class="card-body">
                <p class="info">
                    <span>発注者</span>: {{@$project->user->first_name}} {{@$project->user->last_name}}
                </p>
                <p class="info"><span>発注日</span>: {{date('Y-m-d', strtotime($project->created_at))}}</p>
                <p class="info"><span>現場名</span>: {{@$project->owner}}</p>
                <p class="info"><span>現場住所</span>: {{@$project->name}}</p>
                <p class="info"><span>図面種類</span>: {{config('project.type')[$project->type]}}</p>
                <p class="info"><span>ステータス</span>: {{config('project.status')[$project->order->status]}}</p>
                <p class="info"><span>納品日</span>: {{ !empty($project->importunate) ?  '3日以内' : @$project->delivery_date}}</p>
                <p class="info"><span>納期相談希望</span>: {{!empty($project->importunate) ? 'はい' : 'いいえ'}}</p>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>郵便番号</span>: {{ @$project->postal_code}}</p>
                    </div>
                </div>
                <p class="info"><span>備考</span>: {{@$project->note}}</p>
                @php $information = json_decode($project->other_information) @endphp
                @if(!empty($information))
                    <p class="info"><span>図面情報</span>:
                    <ul>
                        @foreach($information as $value)
                            <li>{{config('project.other_information')[$value]}}</li>
                        @endforeach
                    </ul>
                    </p>
                @endif
                @php $urls = json_decode($project->url) @endphp
                @if(!empty($urls))
                    <p class="info"><span>URL</span>:
                    <ul>
                        @foreach($urls as $url)
                            <li><a href="{{$url}}">{{$url}}</a></li>
                        @endforeach
                    </ul>
                    </p>
                @endif
                @php $documents = json_decode($project->documents) @endphp

                @if(!empty($documents))
                    <p class="info"><span>Documents</span>:
                    <ul>
                        @foreach($documents as $document)
                            <li><a target="_blank" href="{{asset($document->path)}}">{{$document->name}}</a></li>
                        @endforeach
                    </ul>
                    </p>
                @endif
                @if($project->order->status == 1)
                <div class="w-100 text-center">
                    <a href="{{route('worker.project.do_project', ['id' => $project->id])}}" class="btn btn-success">受付</a>
                </div>
                    @endif
            </div>
        </div>
    </section>
@endsection
@section('extra-css')
    <style>
        p.info span {
            font-weight: bold
        }
    </style>
@endsection

