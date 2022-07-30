<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 11:13
 */
?>
@extends('user::layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <a href="{{route('user.project.create')}}" class="btn btn-success btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                        <span class="text">図面依頼</span>
                    </a>
                </div>
                <div class="col-sm-4 amount-project-by-type">
                    <div class="">
{{--                        <p class="date-amount-project mb-0">全て</p>--}}
                        <div class="list-type">
                            <div class="all" style="background-color: #8e44ad">{{$data['projects']['amount']['all']}}</div>
                        @foreach(config('project.status') as $key => $status)
                                @if(!empty(config('project.color_status')[$key]))
                                <div class="{{$key}}" style="background-color: {{config('project.color_status')[$key]}}">{{$data['projects']['amount'][$key]}}</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">フィルター</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none">
                        <form action="" class="row g-3" method="get" autocomplete="off">
                            <div class="col-md-4">
                                <label class="form-label">現場住所</label>
                                <input type="text" name="name"  autocomplete="off" class="form-control" value="{{request()->has('name') ? request()->get('name') : ''}}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">営業者</label>
                                    <select name="user_id" class="form-control" id="">
                                        <option value=""></option>
                                        @foreach($data['users'] as $user)
                                            <option @if(request()->has('user_id') && request()->get('user_id') == $user->id ) selected @endif value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>図面種類</label>
                                    <select class="form-control select2bs4" name="type" style="width: 100%;">
                                        <option selected="selected"></option>
                                        @foreach(config('project.type') as $key => $value)
                                            <option value="{{$key}}" @if(request()->has('type') && request()->get('type') == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>ステータス</label>
                                    <select class="form-control select2bs4" name="status" style="width: 100%;">
                                        <option selected="selected"></option>
                                        @foreach(config('project.status') as $key => $value)
                                            <option  value="{{$key}}" @if(request()->has('status') && request()->get('status') == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">作業者</label>
                                    <select name="worker_id" class="form-control" id="">
                                        <option value=""></option>
                                        @foreach($data['workers'] as $user)
                                            <option @if(request()->has('worker_id') && request()->get('worker_id') == $user->id ) selected @endif value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>納品日</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input name="delivery_date_range" placeholder="{{request()->has('delivery_date_range') ? request()->get('delivery_date_range') : ''}}"   autocomplete="off" type="text"  class="form-control date-picker float-right" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>発注日</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input name="created_at" placeholder="{{request()->has('created_at') ? request()->get('created_at') : ''}}"  autocomplete="off" type="text"  class="form-control date-picker float-right" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>受付日</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input name="order_created"  placeholder="{{request()->has('order_created') ? request()->get('order_created') : ''}}" autocomplete="off" type="text"  class="form-control date-picker float-right" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>完成日</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input name="finish_day" placeholder="{{request()->has('finish_day') ? request()->get('finish_day') : ''}}" autocomplete="off" type="text"  class="form-control date-picker float-right" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary">フィルター</button>
                                <a href="{{route('admin.project.index')}}" class="btn btn-danger"><i class="fas fa-times"></i> キャンセル</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
    </section>
    <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title w-100 text-center">マイ図面</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered" id="table-project">
                                <thead>
                                <tr>
                                    <th data-orderable="false" class="no-sort" style="width: 10px">No</th>
                                    <th data-orderable="false" class="no-sort">現場名</th>
                                    <th data-orderable="false" class="no-sort">図面種類</th>
                                    <th data-orderable="false" class="no-sort">ステータス</th>
                                    <th>納品日</th>
                                    <th>発注日</th>
                                    <th>受付日</th>
                                    <th>完成日</th>
                                    <th data-orderable="false" class="no-sort"  >営業者</th>
                                    <th data-orderable="false" class="no-sort">作業者</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['projects']['list'] as $key => $project)
                                    <tr  class=" @if(!empty($project->importunate)) has-importunate @endif "
                                        style="background-color: {{config('project.color_status')[$project->order->status]}}"
                                    >
                                        <td class="index"><a href="{{route('user.project.show', ['id' => $project->id])}}">{{$key + 1}}</a></td>
                                        <td><a href="{{route('user.project.show', ['id' => $project->id])}}">{{@$project->owner}}</a></td>
                                        <td><a href="{{route('user.project.show', ['id' => $project->id])}}">{{!empty($project->type) ? config('project.type')[$project->type] : ''}}</a></td>
                                        <td><a href="{{route('user.project.show', ['id' => $project->id])}}">{{config('project.status')[$project->order->status]}}</a></td>
                                        <td><a href="{{route('user.project.show', ['id' => $project->id])}}">{{ !empty($project->importunate) ? '3日以内' : @$project->delivery_date}}</a></td>
                                        <td><a href="{{route('user.project.show', ['id' => $project->id])}}">{{date('Y-m-d', strtotime($project->created_at))}}</a></td>
                                        <td><a href="{{route('user.project.show', ['id' => $project->id])}}">{{ !empty($project->order->worker_id) ? date('Y-m-d', strtotime($project->order->created_at)) : ''}}</a></td>
                                        <td><a href="{{route('user.project.show', ['id' => $project->id])}}">{{@$project->order->finish_day}}</a></td>
                                        <td><a href="{{route('admin.project.show', ['id' => $project->id])}}">{{@$project->user->first_name}} {{@$project->user->last_name}}</a></td>
                                        <td><a href="{{route('user.project.show', ['id' => $project->id])}}">{{@$project->order->worker->first_name}} {{@$project->order->worker->last_name}}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.content-wrapper -->
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('scripts')
    <script src="{{asset('static/js/jquery-ui.min.js')}}"></script>
    <script>
        $(document).ready( function () {
            @if(session()->has('message'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{session()->get('message')}}',
                showConfirmButton: false,
                timer: 2000
            })
            @endif
            $('#table-project').DataTable({
                language: {
                    "lengthMenu": " _MENU_ アイテム",
                    "paginate": {
                        "previous": "前のページ",
                        "next": "次のページ"
                    }
                },
                searching: false,
                ordering:  true,
                paging: true,
                lengthChange: true,
                pageLength: 10,
                info: false
            });
            $('#table-project').on( 'order.dt', function () {
                $("td.index").each(function (index, value){
                    $(value).find('a').text(index + 1);
                });
            });
        } );
        $('input.date-picker').daterangepicker({
            autoUpdateInput: false,
        });
        $('input.date-picker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        });
        $('input.date-picker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        $.datepicker.setDefaults({
            closeText: "关闭",
            prevText: "&#x3C;上月",
            nextText: "下月&#x3E;",
            currentText: "今天",
            monthNames: [ "一月","二月","三月","四月","五月","六月",
                "七月","八月","九月","十月","十一月","十二月" ],
            monthNamesShort: [ "一月","二月","三月","四月","五月","六月",
                "七月","八月","九月","十月","十一月","十二月" ],
            dayNames: [ "星期日","星期一","星期二","星期三","星期四","星期五","星期六" ],
            dayNamesShort: [ "周日","周一","周二","周三","周四","周五","周六" ],
            dayNamesMin: [ "日","一","二","三","四","五","六" ],
            weekHeader: "周",
            dateFormat: "yy-mm-dd",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: true,
            yearSuffix: ""
        });
        $(".date-picker-month-year").datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            maxDate: new Date(),
            dateFormat: 'yy-mm',
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });
    </script>
@endsection
@section('extra-css')
    <link rel="stylesheet" href="{{asset('static/css/jquery-ui.css')}}">
    <style>
        .ui-datepicker-calendar {
            display: none;
        }

    </style>
    @endsection
