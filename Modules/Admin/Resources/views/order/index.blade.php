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
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">フィルター</h3>
                    </div>
                    <div class="card-body">
                        <form action="" class="row g-3" method="get" autocomplete="off">
                            <div class="col-md-6">
                                <label class="form-label">現場住所</label>
                                <input type="text" name="name"  autocomplete="off" class="form-control" value="{{request()->has('name') ? request()->get('name') : ''}}">
                            </div>
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>納品日</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input name="delivery_date_range"  autocomplete="off" type="text"  class="form-control float-right" id="reservation">
                                    </div>
                                </div>
                                <!-- /.input group -->
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
                                    <th style="width: 10px">No</th>
                                    <th>現場住所</th>
                                    <th>図面種類</th>
                                    <th>ステータス</th>
                                    <th>納品日</th>
                                    <th>発注日</th>
                                    <th>受付日</th>
                                    <th>完成日</th>
                                    <th>営業者</th>
                                    <th>作業者</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['orders'] as $key => $order)
                                    <tr>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{@$order->id}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{@$order->project->name}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{!empty($order->project->type) ? config('project.type')[$order->project->type] : ''}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{config('project.status')[$order->status]}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{@$order->project->delivery_date}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{date('Y-m-d', strtotime($order->project->created_at))}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{date('Y-m-d', strtotime($order->created_at))}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{@$order->finish_day}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{@$order->project->owner}}</a></td>
                                        <td><a href="{{route('worker.order.show', ['id' => $order->id])}}">{{@$order->worker->first_name}} {{@$order->worker->last_name}}</a></td>
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
        $('input[name="delivery_date_range"]').daterangepicker({
            autoUpdateInput: false,
        });
        $('input[name="delivery_date_range"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        });
        $('input[name="delivery_date_range"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    </script>
@endsection
@section('extra-css')
    <style>
        #table-project tbody tr td a{color: black}
    </style>
    @endsection
