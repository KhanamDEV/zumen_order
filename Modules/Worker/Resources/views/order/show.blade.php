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
    $order = $data['order'];
    $isWorkerOfProject = auth('workers')->id() == $order->worker_id;
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
                <div class="row">
                    <div class="col-md-4">
                        <p class="info">
                            <span>発注者</span>: {{@$order->project->user->first_name}} {{@$order->project->user->last_name}}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>発注日</span>: {{date('Y-m-d', strtotime($order->project->created_at))}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>現場名</span>: {{@$order->project->owner}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>現場住所</span>: {{@$order->project->name}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>図面種類</span>: {{config('project.type')[$order->project->type]}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>ステータス</span>: {{config('project.status')[$order->status]}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info">
                            <span>納品日</span>: {{ !empty($order->project->importunate) ? '3日以内' : @$order->project->delivery_date}}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>納期相談希望</span>: {{!empty($order->project->importunate) ? 'はい' : 'いいえ'}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info">
                            <span>郵便番号</span>: {{ !empty($order->project->postal_code) ? substr($order->project->postal_code, 0, 3).'-'.substr($order->project->postal_code, 3, 6) : ''}}
                        </p>
                    </div>
                </div>
                <p class="info pre-line"><span>備考</span>: {{@$order->project->note}}</p>
                @php $information = json_decode($order->project->other_information) @endphp
                @if(!empty($information))
                    <p class="info"><span>図面情報</span>:
                    <ul>
                        @foreach($information as $value)
                            <li>{{config('project.other_information')[$value]}}</li>
                        @endforeach
                    </ul>
                    </p>
                @endif
                <div class="row">
                    @php $urls = json_decode($order->project->url) @endphp
                    @if(!empty($urls))
                        <div class="col-md-4">
                            <p class="info"><span>URL</span>:
                            <ul>
                                @foreach($urls as $url)
                                    <li><a href="{{$url}}">{{$url}}</a></li>
                                @endforeach
                            </ul>
                            </p>
                        </div>
                    @endif
                    @php $documents = json_decode($order->project->documents) @endphp

                    @if(!empty($documents))
                        <div class="col-md-4">

                            <p class="info"><span>Documents</span>:
                            <ul>
                                @foreach($documents as $document)
                                    <li><a target="_blank" href="{{asset($document->path)}}">{{$document->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            </p>
                        </div>
                    @endif
                </div>
                @php $documentsOfWorker = empty($order->documents) ? [] : json_decode($order->documents) @endphp
                @php
                    $readonly = strtotime(date('Y-m-d')) > strtotime(date('Y-m-d', strtotime($order->project->delivery_date))) ||
                    $order->status == 5 || $order->status == 3;
                @endphp
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="">Documents of Worker: </label>
                            </div>

                            <div class="list-documents">
                                @foreach($documentsOfWorker as $document)
                                    <div class="item-document mt-2">
                                        <span><a target="_blank"
                                                 href="{{asset($document->path)}}">{{$document->name}}</a></span>
                                        @if($isWorkerOfProject)
                                            <img class="remove-document" data-path="{{$document->path}}"
                                                 src="{{asset('static/images/x.png')}}" alt="">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if($isWorkerOfProject)
                                <div class="group-add-documents mt-3">
                                    <input type="hidden" id="listDocument" name="documents"
                                           value="{{$order->documents ?? json_encode([])}}">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="uploadDocument">
                                        <label class="custom-file-label" for="customFile">ファイルを選択</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                    @if($isWorkerOfProject)
                        <div class="row">
                            @if(!$readonly)
                                <div class="col-md-3">
                                    <div class="form-group mt-3">
                                        <label for="">ステータス</label>
                                        <select name="status" id="" class="form-control">
                                            @foreach(config('project.status') as $key => $value)
                                                @if(!in_array($key, [1,5, 3]))
                                                    <option @if($key == $order->status) selected
                                                            @endif value="{{$key}}">{{$value}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                @endif
            </div>
        </div>
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">補足</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="owner">補足</label>
                            <p class="pre-line">{{@$order->project->additional}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @php $urls = !empty($order->project->url_additional) ? json_decode($order->project->url_additional) : []; @endphp
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

                            <div class="">
                                @php $documents = !empty($order->project->documents_additional) ? json_decode($order->project->documents_additional) : []; @endphp
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
        </div>
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
                    @if(!empty($order->project->feedbacks))
                        @foreach($order->project->feedbacks as $key => $feedback)
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

    @if($isWorkerOfProject)
            <div class="group-button-end ">
                <a href="{{route('worker.order.index')}}" class="btn button-width btn-secondary">戻る</a>

                <button type="submit" class="btn btn-info button-width mr-2">確認</button>
                @php $documents = empty($order->documents) ? [] : json_decode($order->documents) @endphp
                @if(!empty($documents))
                    <a href="{{route('worker.order.done_project', ['id' => $order->id])}}"
                       class="btn button-width btn-success ">完了</a>
                @endif
                @if(!$readonly )
                    <a href="{{route('worker.order.leave_project', ['id' => $order->id])}}"
                       class="btn button-width leave-project btn-danger">中止</a>
                @endif

            </div>
        @endif
    </section>
@endsection
@section('extra-css')
    <style>
        p.info span {
            font-weight: bold
        }

        .item-document {
            display: flex;
            justify-content: space-between;
            align-items: center
        }
    </style>
@endsection
@section('scripts')
    <script>
        @if(session()->has('error'))
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: '{{session()->get('error')}}',
            showConfirmButton: false,
            timer: 3000
        })
        @endif
        $(function () {
            $(".leave-project").click(function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                Swal.fire({
                    title: '中止しますか？',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'はい',
                    cancelButtonText: 'いいえ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace(url);
                    }
                })
            })

            function removeDocument() {
                $(".remove-document").click(function () {
                    let path = $(this).data('path');
                    let documents = JSON.parse($("#listDocument").val());
                    documents = documents.filter(function (document) {
                        return document.path != path;
                    })
                    $("#listDocument").val(JSON.stringify(documents));
                    $(this).parent().remove();
                });
            }

            removeDocument();
            $('#uploadDocument').change(function () {
                Swal.showLoading();
                let formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                formData.append('_token', '{{csrf_token()}}');
                $.ajax({
                    url: '{{route('user.upload_file')}}',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: formData,
                    success: function (res) {
                        console.log(res);
                        Swal.close();
                        if (res.meta.status == 200) {
                            let documents = JSON.parse($("#listDocument").val());
                            documents.push({name: res.response.name, path: res.response.path});
                            $("#listDocument").val(JSON.stringify(documents));
                            $(".list-documents").append(`<div class="item-document mt-2">
                                        <span><a target="_blank" href=${res.response.preview}>${res.response.name}</a></span>
                                        <img class="remove-document" data-path="${res.response.path}" src="{{asset('static/images/x.png')}}" alt="">
                                    </div>`)
                            removeDocument();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: res.meta.message,
                            })
                        }
                    }
                })
            })
        });
    </script>
@endsection

