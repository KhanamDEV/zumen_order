<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 10:59
 */
?>
@extends('user::layouts.master')
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
                                       placeholder="{{auth('users')->user()->first_name}} {{auth('users')->user()->last_name}}"
                                       disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>発注日</label>
                                <input type="text" class="form-control" name="dayorder" value="{{date('Y-m-d')}}"
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
        <form action="" method="POST" id="form-create" class="h-adr">
            <span class="p-country-name" style="display:none;">Japan</span>
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
                                            <input type="text" id="owner" name="owner" class="form-control">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="button" id="button-search-project">探す</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">管理番号</label>
                                        <input type="text" name="control_number" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-12 ">
                                    <div class="form-row">
                                        <div class="col-md-1 col-4">
                                            <div class="form-group">
                                                <label for="">郵便番号</label>
                                                <input type="text" name="postal_code_head" class="form-control text-center p-postal-code" size="3">
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
                                                <input type="text" name="postal_code_end" class="form-control text-center p-postal-code" size="4">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">現場住所</label>
                                        <input type="text"  name="name" class="form-control p-region p-locality p-street-address p-extended-address">
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
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label class="form-label">納品日</label>
                                            <input type="hidden" class="form-control" value="{{ \Carbon\Carbon::now()->dayOfWeek  <= 2 ? \Carbon\Carbon::now()->addDays(5)->format('Y-m-d') : \Carbon\Carbon::now()->addDays(7)->format('Y-m-d')}}" name="delivery_date">
                                            <input type="text" class="form-control delivery-date-show" value="{{\Carbon\Carbon::now()->addDays(5)->format('Y-m-d')}}" name="delivery_date">
                                        </div>
                                    </div>

                                </div>
                                <!-- checkbox -->
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" name="importunate" id="importunate"
                                               type="checkbox">
                                        <label for="importunate" class="form-check-label">納期相談希望</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputDescription">備考</label>
                                    <textarea id="inputDescription" name="note" class="form-control"
                                              rows="4"></textarea>
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
                                @foreach(config('project.other_information') as $key => $value)
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" name="other_information[]" type="checkbox"
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
                                <input type="hidden" id="listDocument" name="documents" value="[]">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="uploadDocument">
                                    <label class="custom-file-label" for="customFile">ファイルを選択</label>
                                </div>
                                <div class="list-documents">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- /.card-body -->
            </div>
            <div style="width: 100%; display: flex; justify-content: end; ">

            </div>
            <div class="group-button-end " >
                <a class="btn button-width btn-secondary" href="{{ route('user.project.index')}}">戻る</a>
                <button class="btn-success btn button-width" style="margin-bottom: 20px">保存</button>
            </div>
        </form>
    </section>
    <div class="modal fade" id="modal-confirm" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">図面依頼情報</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="info"><span>発注日</span>: <span>{{date('Y-m-d')}}</span></p>
                    <p class="info"><span>現場名</span>: <span class="owner-confirm"></span></p>
                    <p class="info"><span>管理番号</span>: <span class="control_number-confirm"></span></p>
                    <p class="info"><span>現場住所</span>: <span class="name-confirm"></span></p>
                    <p class="info"><span>図面種類</span>: <span class="type-confirm"></span></p>
                    <p class="info"><span>納品日</span>: <span class="delivery_date-confirm"></span></p>
                    <p class="info"><span>納期相談希望</span>: <span class="importunate-confirm">いいえ</span> </p>
                    <p class="info"><span>郵便番号</span>: <span class="postal_code_head-confirm"></span>-<span class="postal_code_end-confirm"></span></p>
                    <p class="info"><span>備考</span>: <span class="note-confirm"></span></p>
                    <p class="info"><span>図面情報</span>: <span class="other_information-confirm"></span></p>
                    <p class="info"><span>URL</span>: </p>
                    <ul class="url-confirm"></ul>
                    <p class="info"><span>Documents</span>: </p>
                    <ul class="documents-confirm"></ul>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn submit-form btn-primary">確認</button>
                </div>
            </div>
        </div>
    </div>
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

@endsection
@section('validation')
    {!! JsValidator::formRequest('Modules\User\Http\Requests\CreateProjectRequest', '#form-create') !!}
@endsection
@section('extra-css')
    <style>
        .group-add-url .item-url{display: flex; align-items: center}
        .group-add-url .item-url input{max-width: 400px}
        .group-add-url .item-url:last-child button.delete-url{display: none}
        .group-add-url .item-url:not(:last-child) button.add-url{display: none}
        .item-document{display: flex; justify-content: space-between; align-items: center}
        .modal-body p span:first-child{font-weight: bold}
        .modal-body span:last-child{font-weight: normal}
        #table-search_info{display: none !important;}
    </style>
@endsection
@section('scripts')
    <script>
        const projectInformation = JSON.parse('{!!  json_encode(config('project.other_information'))!!}');
        const projectType = JSON.parse('{!!  json_encode(config('project.type'))!!}')
        let templateUrl = `<div class="item-url mb-3">
                                    <input type="text" name="url[]" class="form-control">
                                    <button class="btn add-url btn-success ml-1" type="button">追加</button>
                                    <button class="btn delete-url btn-danger ml-1" type="button">削除</button>
                                </div>`;
        $(function (){

            $("#form-create").submit(function (e){
                e.preventDefault();
                setTimeout(function (){
                    let formData = $("#form-create").serializeArray();
                    let statusErrors = false;
                    $(".invalid-feedback").each(function (index, value){
                        if ($(value).text()) statusErrors = true;
                    })
                    $(".other_information-confirm").text('')
                    $(".documents-confirm").html('');
                    $(".url-confirm").html('')
                    formData.forEach(input => {
                        if (!input.name.includes('[]')){
                            if (input.name == 'documents'){
                                let documents = JSON.parse(input.value);
                                documents.forEach(value => {
                                    $(".documents-confirm").append(`<li><a href="${value.path}">${value.name}</a></li>`)
                                })
                            } else{
                                if (input.name == 'importunate') input.value = input.value == 'on' ? 'はい' : 'いいえ'
                                if (input.name == 'type') input.value = projectType[input.value];
                                $(`.${input.name}-confirm`).text(input.value);
                            }

                        } else{
                            if (input.name.includes('other_information')){
                                let currentText = $(".other_information-confirm").text();
                                if (currentText){
                                    $(".other_information-confirm").text(`${currentText}, ${projectInformation[input.value]}`)
                                } else{
                                    $(".other_information-confirm").text(projectInformation[input.value])
                                }
                            } else if(input.name.includes('url')){
                                $(".url-confirm").append(`<li>${input.value}</li>`)
                            }
                        }
                    })
                    if (!statusErrors){
                        $("#modal-confirm").modal('show');
                        $(".submit-form").click(function (){
                            $(this).attr('disabled', true);
                            $('#form-create').unbind('submit').submit();
                        })
                    }
                }, 500)
            })
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
                    pageLength: 50,
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
                        data: {owner: $("#owner").val(), user_id: '{{auth('users')->id()}}'},
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
                                        pageLength: 50,
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
            let dateAdd = moment().add(7, 'days')
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
