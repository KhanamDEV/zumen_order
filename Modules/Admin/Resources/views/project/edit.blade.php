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
    <div class="row pl-1 pr-1">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">発注情報</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>発注者</label>
                                <input type="text" class="form-control"
                                       placeholder="{{@$project->user->first_name}} {{@$project->user->last_name}}"
                                       disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>発注日</label>
                                <input type="text" class="form-control" name="dayorder" value="{{date('Y-m-d', strtotime($project->created_at))}}"
                                       disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <section class="content">
        <form action="" method="POST" id="form-update">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">発注入力</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group position-relative">
                                        <label for="owner">現場名</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="owner" name="owner" value="{{@$project->owner}}" class="form-control">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="button" id="button-search-project">探す</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="col-md-1 col-4">
                                            <div class="form-group">
                                                <label for="">郵便番号</label>
                                                <input type="text" name="postal_code_head" value="{{!empty($project->postal_code) ? substr($project->postal_code, 0, 3) : ''}}" class="form-control p-postal-code text-center" size="3">
                                            </div>
                                        </div>
                                        <div style="width: 30px">
                                            <div class="form-group">
                                                <label for="" style="opacity: 0">1</label>
                                                <div class="form-control" style="border: none; text-align: center">
                                                    -
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-4">
                                            <div class="form-group">
                                                <label for="" style="opacity: 0">郵便番号</label>
                                                <input type="text" name="postal_code_end" value="{{!empty($project->postal_code) ? substr($project->postal_code, 3, 6) : ''}}" class="form-control p-postal-code text-center" size="4">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">現場住所</label>
                                        <input type="text" name="name"  value="{{@$project->name}}" class="form-control p-region p-locality p-street-address p-extended-address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>図面種類</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="type">
                                            <option selected="selected" disabled></option>
                                            @foreach(config('project.type') as $key => $value)
                                                <option @if($key == $project->type) selected @endif value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label class="form-label">納品日</label>

                                        <input type="hidden" class="form-control" value="{{ \Carbon\Carbon::now()->dayOfWeek  <= 2 ? \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') : \Carbon\Carbon::now()->addDays(5)->format('Y-m-d')}}" name="delivery_date">
                                        <input type="text" class="form-control delivery-date-show" value="{{@$project->delivery_date}}" @if(!empty($project->importunate)) disabled @endif name="delivery_date">

                                    </div>
                                </div>

                            </div>
                            <!-- checkbox -->
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" @if(!empty($project->importunate)) checked @endif name="importunate" id="importunate"
                                           type="checkbox">
                                    <label for="importunate" class="form-check-label">納期相談希望</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">備考</label>
                                <textarea id="inputDescription" name="note" class="form-control"
                                          rows="4">{{@$project->note}}</textarea>
                            </div>

                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">図面情報</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                @php $information = json_decode($project->other_information) @endphp
                                @foreach(config('project.other_information') as $key => $value)
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input @if(in_array($key, $information)) checked @endif class="custom-control-input" name="other_information[]" type="checkbox"
                                                       id="customCheckbox{{$key}}" value="{{$key}}">
                                                <label for="customCheckbox{{$key}}"
                                                       class="custom-control-label">{{$value}}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">URL</label>
                            </div>
                            <div class="group-add-url">
                                @php $urls = json_decode($project->url); @endphp
                                @foreach($urls as $key => $url)
                                    <div class="item-url mb-3">
                                        <input type="text" name="url[]" class="form-control" value="{{$url}}">
                                        <button class="btn add-url btn-success ml-1" type="button">追加</button>
                                        <button class="btn delete-url btn-danger ml-1" type="button">削除</button>
                                    </div>
                                @endforeach
                                <div class="item-url mb-3">
                                    <input type="text" name="url[]" class="form-control">
                                    <button class="btn add-url btn-success ml-1" type="button">追加</button>
                                    <button class="btn delete-url btn-danger ml-1" type="button">削除</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Documents</label>
                            </div>
                            <div class="group-add-documents">
                                <input type="hidden" id="listDocument" name="documents" value="{{$project->documents}}">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="uploadDocument">
                                    <label class="custom-file-label" for="customFile">ファイルを選択</label>
                                </div>
                                <div class="list-documents">
                                    @php $documents = json_decode($project->documents); @endphp
                                    @foreach($documents as $key => $document)
                                        <div class="item-document mt-2">
                                            <span><a target="_blank" href="{{asset($document->path)}}">{{$document->name}}</a></span>
                                            <img class="remove-document" data-path="{{$document->path}}" src="{{asset('static/images/x.png')}}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- /.card-body -->
            </div>
            <div class="group-button-end" style="width: 100%; display: flex; justify-content: center;  ">
                <button class="btn-success btn button-width" >保存</button>
                <a class="btn button-width btn-secondary" href="{{route('admin.project.show', ['id' => request()->route('id')])}}">戻る</a>
            </div>
        </form>
        <div class="modal fade" id="modal-search-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">の検索結果</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered" id="table-search">
                            <thead>
                            <tr>
                                <th>現場名</th>
                                <th>郵便番号</th>
                                <th>現場住所</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="body-search">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection
@section('validation')
    {!! JsValidator::formRequest('Modules\Admin\Http\Requests\UpdateProjectRequest', '#form-update') !!}
@endsection
@section('extra-css')
    <style>
        .group-add-url .item-url{display: flex; align-items: center}
        .group-add-url .item-url input{max-width: 400px}
        .group-add-url .item-url:last-child button.delete-url{display: none}
        .group-add-url .item-url:not(:last-child) button.add-url{display: none}
        .item-document{display: flex; justify-content: space-between; align-items: center}
        #table-search_info{display: none !important;}

    </style>
@endsection
@section('scripts')
    <script>
        let templateUrl = `<div class="item-url mb-3">
                                    <input type="text" name="url[]" class="form-control">
                                    <button class="btn add-url btn-success ml-1" type="button">追加</button>
                                    <button class="btn delete-url btn-danger ml-1" type="button">削除</button>
                                </div>`;
        $(function (){
            let projectSearch = [];
            function autoFillData(){
                $(".use-project").click(function (){
                    let id = $(this).data('id');
                    let project = projectSearch.filter(value => value.id == id)[0];
                    $("#owner").val(project.owner);
                    if (project.postal_code){
                        let head = project.postal_code.substring(0,3);
                        let end = project.postal_code.substring(3, 7);
                        $("input[name='postal_code_head']").val(head);
                        $("input[name='postal_code_end']").val(end);
                    }
                    $("input[name='name']").val(project.name);
                    $("#modal-search-data").modal('hide');
                })
            }
            let tableSearch = $("#table-search").DataTable({
                language: {
                    "lengthMenu": " _MENU_ アイテム",
                    "paginate": {
                        "previous": "前のページ",
                        "next": "次のページ",
                        "search": "探す"
                    },
                    ordering:  true,
                    paging: true,
                    lengthChange: true,
                    pageLength: 10,
                    info: false,
                    bInfo : false,
                    bDestroy: true
                },
            });
            $("#button-search-project").click(function (){
                if($("#owner").val()){
                    Swal.fire({
                        title: '検索中...',
                        didOpen: () => {
                            Swal.showLoading()
                        },
                        allowOutsideClick: false
                    })
                    $.ajax({
                        url: '{{route('user.project.search')}}',
                        method: 'GET',
                        data: {owner: $("#owner").val(), user_id: '{{$project->user->id}}'},
                        success: function (res){
                            projectSearch = res;
                            let template = "";
                            if (res.length){
                                tableSearch.destroy();
                                $(".body-search").html('');
                                res.forEach(item => {
                                    console.log(item);
                                    let head = item.postal_code.substring(0,3);
                                    let end = item.postal_code.substring(3, 7);
                                    template += `<tr>`;
                                    template += `<td>${item.owner}</td>`;
                                    template += `<td>${head}-${end}</td>`;
                                    template += `<td>${item.name??''}</td>`;
                                    template += `<td style="text-align: center"><button data-id="${item.id}" class="btn btn-info use-project">使用する</button></td>`;
                                    template += '</tr>';
                                })
                                $(".body-search").html(template);
                                tableSearch = $("#table-search").DataTable({
                                    language: {
                                        "lengthMenu": " _MENU_ アイテム",
                                        "paginate": {
                                            "previous": "前のページ",
                                            "next": "次のページ",
                                            "search" : "探す"
                                        },
                                        ordering:  true,
                                        paging: true,
                                        lengthChange: true,
                                        pageLength: 10,
                                        info: false,
                                        bInfo : false,
                                        bDestroy: true
                                    },
                                });
                                autoFillData();
                                Swal.close();
                                $("#modal-search-data").modal('show');
                            } else{
                                Swal.fire({
                                    icon: 'error',
                                    title: '一致する図面がありません',
                                })
                            }

                            autoFillData();
                        }
                    })
                }

            })
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
                    console.log(1);
                    $('input[name=delivery_date]').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        minDate: dateAdd,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });
                }
            });
            function removeUrl(){
                $('.delete-url').click(function (){
                    $(this).parent().remove();
                })
            }
            function addUrl(){
                $(".add-url").click(function (){
                    if($(".group-add-url .item-url:last-child input").val()){
                        $(".group-add-url").append(templateUrl);
                        addUrl();
                        removeUrl();
                    }
                })
            }
            addUrl();
            removeUrl();

            function removeDocument(){
                $(".remove-document").click(function (){
                    let path =$(this).data('path');
                    let documents = JSON.parse($("#listDocument").val());
                    documents = documents.filter(function (document){
                        return document.path != path;
                    })
                    $("#listDocument").val(JSON.stringify(documents));
                    $(this).parent().remove();
                });
            }
            removeDocument();
            $('#uploadDocument').change(function (){
                Swal.showLoading();
                let formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                formData.append('_token', '{{csrf_token()}}');
                $.ajax({
                    url :'{{route('user.upload_file')}}',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: formData,
                    success: function (res){
                        Swal.close();
                        if (res.meta.status == 200){
                            let documents = JSON.parse($("#listDocument").val());
                            documents.push(res.response);
                            $("#listDocument").val(JSON.stringify(documents));
                            $(".list-documents").append(`<div class="item-document mt-2">
                                        <span><a target="_blank" href=${res.response.preview}>${res.response.name}</a></span>
                                        <img class="remove-document" data-path="${res.response.path}" src="{{asset('static/images/x.png')}}" alt="">
                                    </div>`)
                            removeDocument();
                        } else{
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
