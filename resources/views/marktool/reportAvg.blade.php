@extends('layouts.app')

@section('extents_css')
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <style type="text/css">
        .table.border {
            border: 1px #999999 solid;
        }
        .table.bordered th, .table.bordered td {
            border: 1px #999999 solid;
            vertical-align: middle;
        }
        .table thead th, .table thead td {
            cursor: default;
            color: #52677a;
            border-color: transparent;
            text-align: left;
            font-style: normal;
            font-weight: 700;
            line-height: 100%;
        }
        .table th, .table td {
            padding: 0.625rem;
        }
        td, th {
            display: table-cell;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Báo cáo điện thoại viên</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    <div class="grid">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Từ ngày: </label>
                                <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
                                    <input class="form-control" readonly="" type="text"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Đến ngày: </label>
                                <div id="datepicker2" class="input-group date" data-date-format="dd-mm-yyyy">
                                    <input class="form-control" readonly="" type="text"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> 
                                </div>
                            </div>
                        </div>
                        <br />
                        <p>
                           <a type="button" class="btn btn-success">Báo cáo</a>
                           <a href="/file/bao_cao_dien_thoai_vien_9311106.xls" type="button" class="btn btn-success">Xuất file Excel</a>
                        </p>
                        <br />

                        <div class="row" style="overflow-x: auto; margin: 0px">
                            <table id="table-report" class="table border bordered striped hovered cell-hovered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">STT</th>
                                        <th rowspan="2">Họ tên</th>
                                        <th rowspan="2">Mã số ĐTV</th>
                                        <th rowspan="2">Tổng điểm</th>
                                        <th rowspan="2">Tổng cuộc gọi</th>
                                        <th rowspan="2">Điểm trung bình</th>
                                        <th rowspan="2">Xếp loại</th>
                                        <th colspan="9">Thống kê chất lượng cuộc gọi</th>
                                        <th colspan="7">Phân loại cuộc gọi chưa đạt</th>
                                    </tr>
                                    <tr>
                                        <th>Cuộc gọi đạt</th>
                                        <th>Cuộc gọi không đạt</th>
                                        <th>Cuộc gọi xuất sắc</th>
                                        <th>Cuộc gọi tốt</th>
                                        <th>Cuộc gọi khá</th>
                                        <th>Cuộc gọi TBK</th>
                                        <th>Cuộc gọi TB</th>
                                        <th>Cuộc gọi yếu</th>
                                        <th>Cuộc gọi kém</th>
                                        <th>Chưa đạt NV (1)</th>
                                        <th>Chưa đạt kỹ năng (2)</th>
                                        <th>Chưa đạt thái độ (3)</th>
                                        <th>Chưa đạt nghiệp vụ + kỹ năng (12)</th>
                                        <th>Chưa đạt nghiệp vụ + thái độ (13)</th>
                                        <th>Chưa đạt kỹ năng + thái độ (23)</th>
                                        <th>Chưa đạt kỹ năng + nghiệp vụ + thái độ (123)</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('extents_js')
    <link rel="stylesheet prefetch" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"><script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#datepicker").datepicker({         
                autoclose: true,         
                todayHighlight: true 
            }).datepicker('update', new Date());

            $("#datepicker2").datepicker({         
                autoclose: true,         
                todayHighlight: true 
            }).datepicker('update', new Date());
            $("#select2_dienthoaivien").select2();
        })
    </script>
@endsection

