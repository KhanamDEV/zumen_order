<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 10:59
 */
?>
@extends('user::layouts.master')
@php
    $project = $data['project'];
@endphp
@section('content')


    <section class="content">

        @if(empty($project->order->worker_id) && $project->order->status != 5 && auth('users')->id() == $project->user_id)
            <div class="card-header">
                <div class="w-100 text-right">
                    @if(request()->has('from'))
                        <a class="btn btn-secondary"
                           href="{{route('user.project.edit', ['id' => $project->id, 'from' => 'all'])}}">変更</a>
                    @else
                        <a class="btn btn-secondary"
                           href="{{route('user.project.edit', ['id' => $project->id])}}">変更</a>
                    @endif
                </div>
            </div>
        @endif
        <div class="card card-primary">
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
                            <span>発注者</span>: {{$project->user->first_name}} {{$project->user->last_name}}
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
                        <p class="info">
                            <span>納品日</span>: {{ !empty($project->importunate) ? '3日以内' : @$project->delivery_date}}</p>

                    </div>
                    <div class="col-md-4">
                        <p class="info"><span>納期相談希望</span>: {{!empty($project->importunate) ? 'はい' : 'いいえ'}}</p>
                    </div>
                </div>
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
                @php $documents = json_decode($project->documents); @endphp

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
                @if(empty($project->order->worker_id) && $project->order->status == 1 && auth('users')->id() == $project->user_id)
                    <div class="group-button-end ">
                        <a class="btn button-width btn-secondary"
                           href="{{!request()->has('from') ? route('user.project.index') : route('user.project.all')}}">戻る</a>
                        <a href="{{route('user.project.delete', ['id'=> $project->id])}}"
                           class="btn btn-danger delete-project button-width">削除</a>
                    </div>

                @endif
            </div>

        </div>


        @if(!empty($project->order->worker_id))
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
                    @php
                        $subDate = \Carbon\Carbon::parse($project->delivery_date)->subDays(2)->format('Y-m-d');
                            $isEditAdditional =  auth('users')->id() == $project->user_id && strtotime($subDate) >= strtotime(date('Y-m-d'));
                    @endphp
                    <form action="{{route('user.project.update_additional', ['id' => request()->route('id')])}}"
                          method="POST" id="form-update">
                        @csrf
                        <div class="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="owner">補足</label>
                                        @if($isEditAdditional)

                                            <textarea name="additional" class="form-control"
                                                      rows="5">{{@$project->additional}}</textarea>
                                        @else
                                            <p class="pre-line">{{@$project->additional}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    @php $urls = !empty($project->url_additional) ? json_decode($project->url_additional) : []; @endphp
                                    @if($isEditAdditional)

                                        <div class="form-group">
                                            <label for="">URL</label>
                                        </div>
                                        <div class="group-add-url">
                                            @foreach($urls as $key => $url)
                                                <div class="item-url mb-3">
                                                    <input type="text" name="url_additional[]" class="form-control"
                                                           value="{{$url}}">
                                                    <button class="btn add-url btn-success ml-1" type="button">追加
                                                    </button>
                                                    <button class="btn delete-url btn-danger ml-1" type="button">削除
                                                    </button>
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
                                        @if($isEditAdditional)
                                            <input type="hidden" id="listDocument" class="listDocument" name="documents_additional"
                                                   value="{{empty($project->documents_additional) ? json_encode([]) : $project->documents_additional}}">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="uploadDocument">
                                                <label class="custom-file-label" for="customFile">ファイルを選択</label>
                                            </div>
                                        @endif
                                        <div class="list-documents">
                                            @php $documents = !empty($project->documents_additional) ? json_decode($project->documents_additional) : []; @endphp
                                            @foreach($documents as $key => $document)
                                                <div class="item-document mt-2">
                                                    <span><a target="_blank"
                                                             href="{{asset($document->path)}}">{{$document->name}}</a></span>
                                                    @if(auth('users')->id() == $project->user_id)
                                                        <img class="remove-document" data-path="{{$document->path}}"
                                                             src="{{asset('static/images/x.png')}}" alt="">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($isEditAdditional)
                                <div style="width: 100%; display: flex; justify-content: end; ">
                                    <button class="btn-success btn" >保存</button>
                                </div>
                            @endif
                        </div>

                    </form>
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
                    @if($project->order->status == 3)
                        <div class="wrap-button" style="text-align: end">
                            <button style="margin-bottom: 20px"  type="button" class="btn btn-success create-feedback">追加</button>
                        </div>
                    @endif
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
            <div class="modal fade" id="modal-create-feedback" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">新しいフィードバック</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('user.project.feedback.create', ['project_id' => $project->id])}}" method="POST" id="form-create-feedback">
                                @csrf
                                <input type="hidden" name="project_id" value="{{$project->id}}">
                                <div class="form-group">
                                    <label>図面種類</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="type">
                                        <option selected="selected" disabled></option>
                                        @foreach(config('project.type') as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">納品日</label>
                                    <input type="hidden" class="form-control" value="{{ \Carbon\Carbon::now()->dayOfWeek  <= 2 ? \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') : \Carbon\Carbon::now()->addDays(5)->format('Y-m-d')}}" name="delivery_date">
                                    <input type="text" class="form-control delivery-date-show" value="{{\Carbon\Carbon::now()->addDays(3)->format('Y-m-d')}}" name="delivery_date">                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" name="importunate" id="importunate"
                                               type="checkbox">
                                        <label for="importunate" class="form-check-label">納期相談希望</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">備考</label>
                                    <textarea name="note" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="">Documents</label>
                                    </div>
                                    <div class="group-add-documents">
                                        <input type="hidden"  class="listDocument" name="documents" value="">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input upload-document-feedback" >
                                            <label class="custom-file-label" for="customFile">ファイルを選択</label>
                                        </div>
                                        <div class="list-documents">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                            <button type="submit" form="form-create-feedback" class="btn btn-primary">保存</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-detail-feedback" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="info"><span>発注日</span>: <span class="feedback-created_at"></span></p>
                            <p class="info"><span>図面種類</span>: <span class="feedback-type"></span></p>
                            <p class="info"><span>納品日</span>: <span class="feedback-delivery_date"></span></p>
                            <p class="info"><span>納期相談希望</span>: <span class="feedback-importunate">いいえ</span> </p>
                            <p class="info"><span>備考</span>: <span class="feedback-note"></span></p>
                            <p class="info"><span>URL</span>: </p>
                            <ul class="feedback-url"></ul>
                            <p class="info"><span>Documents</span>: </p>
                            <ul class="feedback-documents"></ul>
                        </div>

                    </div>
                </div>
            </div>
    </section>
@endsection
@section('validation')
    {!! JsValidator::formRequest('Modules\User\Http\Requests\UpdateAdditionalProjectRequest', '#form-update') !!}
    {!! JsValidator::formRequest('Modules\User\Http\Requests\CreateFeedbackRequest', '#form-create-feedback') !!}
@endsection
@section('scripts')
    <script>

        let dateAdd = moment().day() <= 2 ?  moment().add(3, 'days') : moment().add(5, 'days');
        $('input[name=delivery_date]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: dateAdd,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        $("#importunate").change(function (){
            if($(this).is(':checked')){
                $(".delivery-date-show").attr('disabled', true)
                $(".delivery-date-show").val(dateAdd.format('YYYY-MM-DD'))
            } else{
                $(".delivery-date-show").removeAttr('disabled');
            }
        });
        $(".create-feedback").click(function (){
            $("#modal-create-feedback").modal('show');
        })
        $(".delete-project, .delete-feedback").click(function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            Swal.fire({
                title: '削除しますか？',
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
        @if(session()->has('message'))
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{session()->get('message')}}',
            showConfirmButton: false,
            timer: 2000
        })
        @endif
        @if(session()->has('update_project'))
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: '変更しました',
            showConfirmButton: false,
            timer: 2000
        })
        @endif
        let templateUrl = `<div class="item-url mb-3">
                                    <input type="text" name="url[]" class="form-control">
                                    <button class="btn add-url btn-success ml-1" type="button">追加</button>
                                    <button class="btn delete-url btn-danger ml-1" type="button">削除</button>
                                </div>`;
        $(function () {

            function removeUrl() {
                $('.delete-url').click(function () {
                    $(this).parent().remove();
                })
            }

            function addUrl() {
                $(".add-url").click(function () {
                    if ($(".group-add-url .item-url:last-child input").val()) {
                        $(".group-add-url").append(templateUrl);
                        addUrl();
                        removeUrl();
                    }
                })
            }

            addUrl();

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
            $('#uploadDocument, .upload-document-feedback').change(function () {
                Swal.showLoading();
                let parent = $(this).parent().parent().parent();
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
                        Swal.close();
                        if (res.meta.status == 200) {
                            let documents = $(parent).find(".listDocument").val() ?  JSON.parse($(parent).find(".listDocument").val()) : [];
                            documents.push(res.response);
                            $(parent).find(".listDocument").val(JSON.stringify(documents));
                            $(parent).find(".list-documents").append(`<div class="item-document mt-2">
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
