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
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">図面依頼</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <p class="info">
                    <span>発注者</span>: {{@$project->user->first_name}} {{@$project->user->last_name}}
                </p>
                <p class="info"><span>発注日</span>: {{date('Y-m-d', strtotime($project->created_at))}}</p>
                <p class="info"><span>現場名</span>: {{@$project->owner}}</p>
                <p class="info"><span>現場住所</span>: {{@$project->name}}</p>
                <p class="info"><span>図面種類</span>: {{config('project.type')[$project->type]}}</p>
                <p class="info"><span>ステータス</span>: {{config('project.status')[$project->order->status]}}</p>
                <p class="info">
                    <span>納品日</span>: {{ !empty($project->importunate) ?  '3日以内' : @$project->delivery_date}}</p>
                <p class="info"><span>納期相談希望</span>: {{!empty($project->importunate) ? 'はい' : 'いいえ'}}</p>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info">
                            <span>郵便番号</span>: {{ !empty($project->postal_code) ? substr($project->postal_code, 0, 3).'-'.substr($project->postal_code, 3, 6) : ''}}
                        </p>
                    </div>
                </div>
                <p class="info pre-line"><span>備考</span>: {{@$project->note}}</p>
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
                @php $documents = json_decode($project->order->documents) @endphp
                @if(!empty($documents))
                    <p class="info"><span>Documents of Worker</span>:
                    <ul>
                        @foreach($documents as $document)
                            <li><a target="_blank" href="{{asset($document->path)}}">{{$document->name}}</a></li>
                        @endforeach
                    </ul>
                    </p>
                @endif

                <div class="w-100 text-center">
                    <a href="{{route('worker.project.index')}}" class="btn btn-secondary  button-width">戻る</a>
                    @if($project->order->status == 1)
                        <a href="{{route('worker.project.do_project', ['id' => $project->id])}}"
                           class="btn btn-success mr-2 button-width">受付</a>
                    @endif

                </div>
            </div>
        </div>
        @if(!empty($project->order->worker_id))
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">チャット</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $messages = !empty($project->messages) ? json_decode($project->messages) : [];

                        @endphp
                        <div class="col-md-12">
                            @if(!empty($messages))
                                <div class="list-message">
                                    @foreach($messages as $message)
                                        <div class="item-message">
                                            <span class="sender"><strong>{{$message->sender == 'order' ? 'あなた' : '作業者'}}</strong> ({{date('Y-m-d H:i', strtotime($message->created_at))}})</span>
                                            <div class="message-content">
                                                <p class="mb-0">内容: {{$message->content}}</p>
                                                @php $documents = !empty($message->documents) ? json_decode($message->documents) : []; @endphp
                                                @if(!empty($documents))
                                                    <p class="mb-0">Documents</p>
                                                    <ul>
                                                        @foreach($documents as $document)
                                                            <li><a href="{{asset($document->path)}}" target="_blank">{{$document->name}}</a> </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            @endif

                        </div>
                    </div>

                </div>

            </div>

        @endif
        @if(!empty($project->feedbacks))
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">フィードバック</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table-feedback">
                        <thead>
                        <tr>
                            <th data-orderable="false" class="no-sort" style="width: 10px">No</th>
                            <th>図面種類</th>
                            <th>納品日</th>
                            <th>発注日</th>
                            <th>納期相談希望</th>
                            <th>作業者</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($project->feedbacks))
                            @foreach($project->feedbacks as $key => $feedback)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->project_id])}}">{{config('project.type')[$feedback->type]}}</a></td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->project_id])}}">{{@$feedback->finish_day}}</a></td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->project_id])}}">{{date('Y-m-d', strtotime($feedback->delivery_date))}}</a></td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->project_id])}}">{{$feedback->importunate ? 'はい' : 'いいえ'}}</a></td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->project_id])}}">{{$feedback->worker->first_name ?? ''}} {{$feedback->worker->last_name ?? ''}}</a></td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>

        @endif
    </section>
@endsection
@section('extra-css')
    <style>
        p.info span {
            font-weight: bold
        }
    </style>
@endsection

