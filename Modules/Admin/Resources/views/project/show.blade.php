<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 10:59
 */
?>
@extends('admin::layouts.master')
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
            @if($project->order->status != 5)
            <div class="card-header">
                <div class="w-100 text-right">
                    <a class="btn btn-secondary" href="{{route('admin.project.edit', ['id' => $project->id])}}">変更</a>
                </div>
            </div>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p class="info">
                            <span>発注者</span>: {{@$project->user->first_name}} {{@$project->user->last_name}}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>発注日</span>: {{date('Y-m-d', strtotime($project->created_at))}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>現場名</span>: {{@$project->owner}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>現場住所</span>: {{@$project->name}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>図面種類</span>: {{config('project.type')[$project->type]}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>ステータス</span>: {{config('project.status')[$project->order->status]}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>納品日</span>: {{@$project->delivery_date}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>納期相談希望</span>: {{!empty($project->importunate) ? 'はい' : 'いいえ'}}</p>
                    </div>
                </div>
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

                    <div class="text-center pb-3">
                        @if($project->order->status  != 3)
                            @if($project->order->status == 5)
                            <a href="{{route('admin.project.continue', ['id' => $project->id])}}" class="btn btn-success">続き</a>
                            @endif
                            @if($project->order->status != 5)
                            <a href="{{route('admin.project.cancel' , ['id' => $project->id])}}" class="btn btn-secondary">キャンセル</a>
                                @endif
                        @endif
                        <a href="{{route('admin.project.delete', ['id'=> $project->id])}}" class="btn btn-danger">削除</a>
                    </div>
            </div>
        </div>
        @if(!empty($project->order->worker_id))
            <div class="card">
                <form action="{{route('user.project.update_additional', ['id' => request()->route('id')])}}" method="POST" id="form-update">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="owner">補充</label>
                                    @if(auth('users')->id() == $project->user_id)

                                        <textarea name="additional" class="form-control" rows="5">{{@$project->additional}}</textarea>
                                    @else
                                        <p>{{@$project->additional}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                @php $urls = !empty($project->url_additional) ? json_decode($project->url_additional) : []; @endphp
                                @if(auth('users')->id() == $project->user_id)

                                    <div class="form-group">
                                        <label for="">URL</label>
                                    </div>
                                    <div class="group-add-url">
                                        @foreach($urls as $key => $url)
                                            <div class="item-url mb-3">
                                                <input type="text" name="url_additional[]" class="form-control" value="{{$url}}">
                                                <button class="btn add-url btn-success ml-1" type="button">追加</button>
                                                <button class="btn delete-url btn-danger ml-1" type="button">削除</button>
                                            </div>
                                        @endforeach
                                        <div class="item-url mb-3">
                                            <input type="text" name="url_additional[]" class="form-control">
                                            <button class="btn add-url btn-success ml-1" type="button">追加</button>
                                            <button class="btn delete-url btn-danger ml-1" type="button">削除</button>
                                        </div>
                                    </div>
                                @else
                                    <p class="info"><span>URL</span>:
                                    <ul>
                                        @foreach($urls as $url)
                                            <li><a href="{{$url}}">{{$url}}</a></li>
                                        @endforeach
                                    </ul>
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Documents</label>
                                </div>
                                <div class="group-add-documents">
                                    @if(auth('users')->id() == $project->user_id)
                                        <input type="hidden" id="listDocument" name="documents_additional" value="{{empty($project->documents_additional) ? json_encode([]) : $project->documents_additional}}">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="uploadDocument">
                                            <label class="custom-file-label" for="customFile">ファイルを選択</label>
                                        </div>
                                    @endif
                                    <div class="list-documents">
                                        @php $documents = !empty($project->documents_additional) ? json_decode($project->documents_additional) : []; @endphp
                                        @foreach($documents as $key => $document)
                                            <div class="item-document mt-2">
                                                <span><a target="_blank" href="{{asset($document->path)}}">{{$document->name}}</a></span>
                                                @if(auth('users')->id() == $project->user_id)
                                                    <img class="remove-document" data-path="{{$document->path}}" src="{{asset('static/images/x.png')}}" alt="">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(auth('users')->id() == $project->user_id)
                            <div style="width: 100%; display: flex; justify-content: end; ">
                                <button class="btn-success btn" style="margin-bottom: 20px">保存</button>
                            </div>
                        @endif
                    </div>

                </form>

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

