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
        <h1 class="pull-left">Chi tiết chấm điểm cuộc gọi của MFS</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    <div class="grid">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Từ ngày: </label>
                                <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
                                    <input class="form-control" readonly="" type="text"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> 
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Đến ngày: </label>
                                <div id="datepicker2" class="input-group date" data-date-format="dd-mm-yyyy">
                                    <input class="form-control" readonly="" type="text"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> 
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Số điện thoại</label>
                                <div class="input-control text full-size"><input type="text" name="phone" value="" class="form-control"></div>
                                
                            </div>
                            <div class="col-md-3">
                                <label>Điện thoại viên</label>
                                <select class="js-example-disabled-results form-control" id="select2_dienthoaivien">
                                    <option value="one">Tất cả điện thoại viên</option>
                                    <option value="two"></option>
                                </select>
                            </div>
                        </div>
                        <br />
                        <p>
                           <a type="button" class="btn btn-success">Hiển thị danh sách cuộc gọi</a>
                           <a href="/file/mfs_4346316.xls" type="button" class="btn btn-success">Xuất file Excel</a>
                        </p>
                        <br />

                        <div class="row" style="overflow-x: auto; margin: 0px">
                            <table id="table-mark-items" class="table border bordered stripped hovered cell-hovered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">STT</th>
                                        <th rowspan="2">Điện thoại viên</th>
                                        <th rowspan="2">Mã số</th>
                                        <th rowspan="2">Cuộc gọi(Ngày)</th>
                                        <th rowspan="2">Cuộc gọi(Giờ)</th>
                                        <th rowspan="2">Thời lượng</th>
                                        <th rowspan="2">Ngày giám sát</th>
                                        <th rowspan="2">Người giám sát</th>
                                        <th rowspan="2">Đối tác</th>
                                        <th rowspan="2">SĐT KH</th>
                                        <th rowspan="2">Dạng câu hỏi</th>
                                        <th rowspan="2">Nội dung câu hỏi</th>
                                        <th rowspan="2">Hình thức giám sát</th>
                                        <th rowspan="2">Nhận xét</th>
                                        <th rowspan="2">Định hướng</th>
                                        <th>TC1 (Tiếp nhận cuộc gọi)</th>
                                        <th colspan="5">TC2 (Cung cấp &amp; Xử lý thông tin)</th>
                                        <th colspan="2">TC3 (Kết thúc)</th>
                                        <th rowspan="2">Tổng điểm</th>
                                        <th rowspan="2">Xếp loại</th>
                                        <th rowspan="2">Đánh giá</th>
                                        <th rowspan="2">Thống kê</th>
                                        <th rowspan="2">Chi tiết vi phạm</th>
                                    </tr>
                                    <tr>
                                        <th>Chào đón Khách hàng</th>
                                        <th>Nắm bắt nhu cầu KH</th>
                                        <th>Đưa phương án đúng</th>
                                        <th>Diễn đạt</th>
                                        <th>Thuyết phục</th>
                                        <th>Ý thức thái độ</th>
                                        <th>Cảm ơn/chào KH</th>
                                        <th>Ghi nhận thông tin</th>
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

