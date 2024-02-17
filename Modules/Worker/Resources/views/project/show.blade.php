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
    $childProjects = $data['childProjects'];

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
                            <span>発注者</span>: {{$project->user->first_name}} {{$project->user->last_name}}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>図面種類</span>: {{config('project.type')[$project->type]}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>現場名</span>: {{@$project->owner}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info">
                            <span>納品日</span>: {{ !empty($project->importunate) ? '5日以内' : @$project->delivery_date}}</p>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info">
                            <span>顧客番号</span>: {{$project->control_number}}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>ステータス</span>: {{config('project.status')[$project->order->status]}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info">
                            <span>郵便番号</span>: {{ !empty($project->postal_code) ? substr($project->postal_code, 0, 3).'-'.substr($project->postal_code, 3, 6) : ''}}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>発注日</span>: {{date('Y-m-d', strtotime($project->created_at))}}</p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="info"><span>現場住所</span>: {{@$project->name}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>納期相談希望</span>: {{!empty($project->importunate) ? 'はい' : 'いいえ'}}</p>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4">
                        <p class="info"><span>案件番号</span>: {{@$project->number}}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>建物</span>: @if(!empty($project->building)) {{config('project.building')[$project->building]}} @endif</p>
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
                                        @if(!empty($message->created_by))
                                            @php $seederName = $message->sender == 'order' ? $data['users'][$message->created_by] ?? '' : $data['workers'][$message->created_by] ?? '';
                                            @endphp
                                        @else
                                            @php $seederName = $message->sender == 'order' ? $project->user->first_name.' '.$project->user->last_name :
                                                    $project->order->worker->first_name.' '.$project->order->worker->last_name @endphp
                                        @endif

                                        <div class="item-message">
                                            <span class="sender"><strong>{{$seederName}}</strong> ({{date('Y-m-d H:i', strtotime($message->created_at))}})</span>
                                            <div class="message-content">
                                                <p class="mb-0 pre-line">内容: {!! $message->content !!}</p>
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
                        @if(!in_array($project->order->status , [3,4,5]))
                            @if(!empty($messages))
                                <div class="line-row"></div>
                            @endif

                            <div class="col-md-12" >
                                <form method="POST" action="{{route('worker.order.add_message', ['id' => $project->id])}}" id="form-chat">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">内容</label>
                                        <textarea class="form-control" rows="3" name="content"></textarea>
                                    </div>
{{--                                    @if(auth('workers')->user()->id == $project->order->worker_id)--}}

                                    {{--                                    @if(auth('workers')->user()->id == $project->order->worker_id)--}}
                                    <div class="form-group">
                                        <label for="" class="mb-0">Documents</label>
                                    </div>
                                    <div class="group-add-documents">
                                        <input type="hidden"  class="listDocument" name="documents" value="{{json_encode([])}}">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input upload-document" >
                                            <label class="custom-file-label" for="customFile">ファイルを選択</label>
                                        </div>
                                        <div class="list-documents">
                                        </div>
                                    </div>
{{--                                    @endif--}}
{{--                                    @endif--}}
                                    <div class="group-button mt-2 d-flex justify-content-end">
                                        <button class="btn btn-success mr-2 btn-send-message" type="submit">送信</button>
                                    </div>
                                </form>
                            </div>
                        @endif

                    </div>

                </div>

            </div>
        @endif
        @if(!empty($childProjects) && empty($project->parent_project_id))
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">案件アップデート</h3>
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
                        @if(!empty($childProjects))
                            @foreach($childProjects as $key => $feedback)

                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->parent_project_id])}}">{{config('project.type')[$feedback->type]}}</a></td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->parent_project_id])}}">{{@$feedback->order->finish_day}}</a></td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->parent_project_id])}}">{{date('Y-m-d', strtotime($feedback->delivery_date))}}</a></td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->parent_project_id])}}">{{$feedback->importunate ? 'はい' : 'いいえ'}}</a></td>
                                    <td><a href="{{route('worker.project.feedback.detail', ['id' => $feedback->id, 'project_id' => $feedback->parent_project_id])}}">{{$feedback->order->worker->first_name ?? ''}} {{$feedback->order->worker->last_name ?? ''}}</a></td>
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
@section('scripts')
    <script>

        @if(session()->has('send_message_success'))
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{session()->get('send_message_success')}}',
            showConfirmButton: false,
            timer: 3000
        })
        @endif

        function removeDocument() {
            $(".remove-document").click(function () {
                let path = $(this).data('path');
                let inputListDocument = $(this).parent().parent().parent().find('.listDocument').first();
                let documents = JSON.parse($(inputListDocument).val());
                documents = documents.filter(function (document) {
                    return document.path != path;
                })
                $(inputListDocument).val(JSON.stringify(documents));
                $(this).parent().remove();
            });
        }

        removeDocument();
        $('.upload-document').change(function () {
            Swal.showLoading();
            let formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            formData.append('_token', '{{csrf_token()}}');
            let that = $(this);
            let listDocuments = $(this).parent().parent().find('.listDocument').first();
            console.log(listDocuments);
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
                        let documents = JSON.parse($(listDocuments).val());
                        documents.push({name: res.response.name, path: res.response.path});
                        $(listDocuments).val(JSON.stringify(documents));
                        $(that).parent().parent().parent().find('.list-documents').append(`<div class="item-document mt-2">
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
    </script>
    @endsection

