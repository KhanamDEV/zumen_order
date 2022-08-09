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
    $feedback = $data['feedback'];
@endphp
@section('content')


    <section class="content">
        <div class="card card-primary mt-3">
            <div class="card-header">
                <h3 class="card-title">図面依頼</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display:block;">
                <div class="row">
                    <div class="col-md-4">
                        <p class="info">
                            <span>発注者</span>: {{$feedback->project->user->first_name}} {{$feedback->project->user->last_name}}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>発注日</span>: {{date('Y-m-d', strtotime($feedback->project_created_at))}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>現場名</span>: {{@$feedback->owner}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>現場住所</span>: {{@$feedback->name}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>図面種類</span>: {{config('project.type')[$feedback->type]}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info">
                            <span>納品日</span>: {{  @$feedback->delivery_date}}</p>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>納期相談希望</span>: {{!empty($feedback->importunate) ? 'はい' : 'いいえ'}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info">
                            <span>郵便番号</span>: {{ !empty($feedback->postal_code) ? substr($feedback->postal_code, 0, 3).'-'.substr($feedback->postal_code, 3, 6) : ''}}
                        </p>
                    </div>
                </div>

                <p class="info pre-line"><span>備考</span>: {{@$feedback->note}}</p>
                @php $information = json_decode($feedback->other_information) @endphp
                @if(!empty($information))
                    <p class="info"><span>図面情報</span>:
                    <ul>
                        @foreach($information as $value)
                            <li>{{config('project.other_information')[$value]}}</li>
                        @endforeach
                    </ul>
                    </p>
                @endif
                @php $urls = json_decode($feedback->url) @endphp
                @if(!empty($urls))
                    <p class="info"><span>URL</span>:
                    <ul>
                        @foreach($urls as $url)
                            <li><a href="{{$url}}">{{$url}}</a></li>
                        @endforeach
                    </ul>
                    </p>
                @endif
                @php $documents = json_decode($feedback->documents) @endphp

                @if(!empty($documents))
                    <p class="info"><span>Documents</span>:
                    <ul>
                        @foreach($documents as $document)
                            <li><a target="_blank" href="{{asset($document->path)}}">{{$document->name}}</a></li>
                        @endforeach
                    </ul>
                    </p>
                @endif

                @php $documents = json_decode($feedback->documents_of_worker) @endphp
                @if(!empty($documents))
                    <p class="info"><span>Documents of Worker</span>:
                    <ul>
                        @foreach($documents as $document)
                            <li><a target="_blank" href="{{asset($document->path)}}">{{$document->name}}</a></li>
                        @endforeach
                    </ul>
                    </p>
                @endif
            </div>

        </div>


        <div class="card-info  card">
            <div class="card-header">
                <h3 class="card-title">補足</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <form>
                    <div class="">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="owner">補足</label>

                                    <p class="pre-line">{{@$feedback->additional}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                @php $urls = !empty($feedback->url_additional) ? json_decode($feedback->url_additional) : []; @endphp

                                <p class="info"><span>URL</span>:
                                <ul>
                                    @foreach($urls as $url)
                                        <li><a href="{{$url}}">{{$url}}</a></li>
                                    @endforeach
                                </ul>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Documents</label>
                                </div>
                                <div class="group-add-documents">

                                    <div class="list-documents">
                                        @php $documents = !empty($feedback->documents_additional) ? json_decode($feedback->documents_additional) : []; @endphp
                                        @foreach($documents as $key => $document)
                                            <div class="item-document mt-2">
                                                    <span><a target="_blank"
                                                             href="{{asset($document->path)}}">{{$document->name}}</a></span>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

        </div>

    </section>
@endsection
