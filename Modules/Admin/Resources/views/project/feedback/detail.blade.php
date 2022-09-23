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
                        <p class="info"><span>発注日</span>: {{date('Y-m-d', strtotime($feedback->project_created_at))}}
                        </p>
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
                <form method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="">Documents of Worker: </label>
                            </div>
                            @php $documentsOfWorker = json_decode($feedback->documents_of_worker) @endphp
                            <div class="list-documents">
                                @foreach($documentsOfWorker as $document)
                                    <div class="item-document mt-2">
                                        <span><a target="_blank"
                                                 href="{{asset($document->path)}}">{{$document->name}}</a></span>
                                            <img class="remove-document" data-path="{{$document->path}}"
                                                 src="{{asset('static/images/x.png')}}" alt="">
                                    </div>
                                @endforeach
                            </div>
                                <div class="group-add-documents mt-3">
                                    <input type="hidden"  name="documents_of_worker" class="listDocument"
                                           value="{{$feedback->documents_of_worker ?? json_encode([])}}">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input upload-document" id="uploadDocument">
                                        <label class="custom-file-label" for="customFile">ファイルを選択</label>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="">Documents: </label>
                            </div>
                            @php $documents = json_decode($feedback->documents) @endphp
                            <div class="list-documents">
                                @foreach($documents as $document)
                                    <div class="item-document mt-2">
                                        <span><a target="_blank"
                                                 href="{{asset($document->path)}}">{{$document->name}}</a></span>
                                        <img class="remove-document" data-path="{{$document->path}}"
                                             src="{{asset('static/images/x.png')}}" alt="">
                                    </div>
                                @endforeach
                            </div>
                            <div class="group-add-documents mt-3">
                                <input type="hidden"  name="documents" class="listDocument"
                                       value="{{$feedback->documents ?? json_encode([])}}">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input upload-document" id="uploadDocument">
                                    <label class="custom-file-label" for="customFile">ファイルを選択</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success">Update </button>
                </form>
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
                <h3 class="card-title">チャット</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @php
                    $messages = !empty($feedback->messages) ? json_decode($feedback->messages) : [];
                @endphp
                <div class="row">
                    <div class="col-md-12">
                        @if(!empty($messages))
                            <div class="list-message">
                                @foreach($messages as $message)
                                    @php $seederName = $message->sender == 'order' ? $feedback->project->user->first_name.' '.$feedback->project->user->last_name :
                                                    $feedback->worker->first_name.' '.$feedback->worker->last_name @endphp
                                    <div class="item-message">
                                        <span class="sender"><strong>{{$seederName}}</strong> ({{date('Y-m-d H:i', strtotime($message->created_at))}})</span>
                                        <div class="message-content">
                                            <p class="mb-0">内容: {{$message->content}}</p>
                                            @php $documents = !empty($message->documents) ? json_decode($message->documents) : []; @endphp
                                            @if(!empty($documents))
                                                <p class="mb-0">Documents</p>
                                                <ul>
                                                    @foreach($documents as $document)
                                                        <li><a href="{{asset($document->path)}}"
                                                               target="_blank">{{$document->name}}</a></li>
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


    </section>
@endsection
@section('scripts')
    <script>
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
