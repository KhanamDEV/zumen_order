<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 11:13
 */
?>
@extends('admin::layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <a href="{{route('admin.company.create')}}" class="btn btn-success btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                        <span class="text">会社名入力</span>
                    </a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">検索</h3>
                    </div>
                    <div class="card-body">
                        <form action="" class="row g-3" method="get" autocomplete="off">
                            <div class="col-md-4">
                                <label class="form-label">会社名</label>
                                <input type="text" name="name"  autocomplete="off" class="form-control" value="{{request()->has('name') ? request()->get('name') : ''}}">
                            </div>
                            <div class="col-4">
                                <label style="opacity: 0" class="form-label">ユーザー名	</label>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">フィルター</button>
                                    <a href="{{route('admin.worker.index')}}" class="btn btn-danger"><i class="fas fa-times"></i> キャンセル</a>
                                </div>
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
                        <h3 class="card-title">会社一覧</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="table-worker">
                            <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>会社名</th>
                                <th>住所</th>
                                <th>電話番号</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['companies'] as $key => $company)
                                <tr >
                                    <td><a href="{{route('admin.company.edit', ['id' => $company->id])}}">{{$key + 1}}</a></td>
                                    <td><a href="{{route('admin.company.edit', ['id' => $company->id])}}">{{@$company->name}}</a></td>
                                    <td><a href="{{route('admin.company.edit', ['id' => $company->id])}}">{{@$company->address}}</a></td>
                                    <td><a href="{{route('admin.company.edit', ['id' => $company->id])}}">{{@$company->phone_number}}</a></td>
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
            $('#table-worker').DataTable({
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
                lengthChange: false,
                pageLength: 15,
                info: false
            });

            $('#table-project').on( 'order.dt', function () {
                $("td.index").each(function (index, value){
                    $(value).find('a').text(index + 1);
                });
            });
        } );
        @if(session()->has('message'))
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{session()->get('message')}}',
            showConfirmButton: false,
            timer: 2000
        })
        @endif
    </script>
@endsection
@section('extra-css')
    <style>
        #table-project tbody tr td a{color: black}
        tbody tr:hover{background-color: #0000ff1f}

    </style>
@endsection