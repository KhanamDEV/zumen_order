<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 11:13
 */
?>
@extends('worker::layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8"></div>
                <div class="col-sm-4 amount-project-by-type">
                    <div class="">
                        {{--                        <p class="date-amount-project mb-0">全て</p>--}}
                        <div class="list-type">
                            <div class="all" style="background-color: #8e44ad">{{$data['orders']['amount']['all']}}</div>
                            @foreach(config('project.status') as $key => $status)
                                @if(!empty(config('project.color_status')[$key]))
                                    <div class="{{$key}}" style="background-color: {{config('project.color_status')[$key]}}">{{$data['orders']['amount'][$key]}}</div>
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
                                <label class="form-label">現場名</label>
                                <input type="text" name="name"  autocomplete="off" class="form-control" value="{{request()->has('name') ? request()->get('name') : ''}}">
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
                                    <label class="form-label">営業者</label>
                                    <select name="user_id" class="form-control" id="">
                                        <option value=""></option>
                                        @foreach($data['users'] as $user)
                                            <option @if(request()->has('user_id') && request()->get('user_id') == $user->id) selected @endif value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
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
                                            <option value="{{$key}}" @if(request()->has('status') && request()->get('status') == $key) selected @endif>{{$value}}</option>
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
                                        <input name="delivery_date_range" placeholder="{{request()->has('delivery_date_range') ? request()->get('delivery_date_range') : ''}}"  autocomplete="off" type="text"  class="form-control date-picker float-right" id="reservation">
                                    </div>
                                </div>
                                <!-- /.input group -->
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
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <label class="form-label">案件番号</label>
                                <input type="text" name="number"  autocomplete="off" class="form-control" value="{{request()->has('number') ? request()->get('number') : ''}}">
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary">フィルター</button>
                                <a href="{{route('worker.order.index')}}" class="btn btn-danger"><i class="fas fa-times"></i> キャンセル</a>
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
                            <h3 class="card-title">図面発注一覧</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered" id="table-project">
                                <thead>
                                <tr>
                                    <th data-orderable="false" class="no-sort" style="width: 10px">No</th>
                                    <th data-orderable="false" class="no-sort" >現場名</th>
                                    <th data-orderable="false" class="no-sort">案件番号</th>
                                    <th data-orderable="false" class="no-sort" >図面種類</th>
                                    <th data-orderable="false" class="no-sort" >ステータス</th>
                                    <th>納品日</th>
                                    <th>発注日</th>
                                    <th>受付日</th>
                                    <th>完成日</th>
                                    <th data-orderable="false" class="no-sort" >営業者</th>
                                    <th data-orderable="false" class="no-sort" >作業者</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $index = 1; @endphp
                                @foreach($data['orders']['list'] as $key => $order)
                                    <tr class=" @if(!empty($order->project->importunate)) has-importunate @endif "  style="background-color: {{config('project.color_status')[$order->status]}}" >
                                        <td class="index"><a href="#">{{$index++}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{@$order->project->owner}}</a></td>
                                        <td><a href="#">{{@$order->project->number}}</a></td>
                                        <td><a href="#">{{!empty($order->project->type) ? config('project.type')[$order->project->type] : ''}}</a></td>
                                        <td><a href="#">{{config('project.status')[$order->status]}}</a></td>
                                        <td><a href="#">{{@$order->project->delivery_date}}</a></td>
                                        <td><a href="#">{{ !empty($order->project->created_at) ? date('Y-m-d', strtotime($order->project->created_at)): ''}}</a></td>
                                        <td><a href="#">{{date('Y-m-d', strtotime($order->created_at))}}</a></td>
                                        <td><a href="#">{{@$order->finish_day}}</a></td>
                                        <td><a href="#">{{@$order->project->user->first_name}} {{@$order->project->user->last_name}}</a></td>
                                        <td><a href="#">{{@$order->worker->first_name}} {{@$order->worker->last_name}}</a></td>
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
                pageLength: 50,
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
    </script>
@endsection
@section('extra-css')
    <style>
        #table-project tbody tr td a{color: black}
        tr td a{color: white !important;}
        tr.has-importunate td a{color: black !important;}
        tbody tr:hover{background-color: #0000ff1f}
        th.no-sort::before{display: none !important;}
        th.no-sort::after{display: none !important;}
    </style>
    @endsection
