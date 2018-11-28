<li class="{{ Request::is('account*') ? 'active' : '' }}">
    <a href="{!! route('account.index') !!}"><i class="fa fa-edit"></i><span>Quản lý tài khoản</span></a>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-book"></i>
            <span>Thiết lập báo cáo</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('requestTypes*') ? 'active' : '' }}">
            <a href="{!! route('requestTypes.index') !!}"><i class="fa fa-edit"></i><span>Quản lý dạng cuộc gọi</span></a>
        </li>

        <li class="{{ Request::is('criterias*') ? 'active' : '' }}">
            <a href="{!! route('criterias.index') !!}"><i class="fa fa-edit"></i><span>Quản lý tiêu chí chấm điểm</span></a>
        </li>

        <li class="{{ Request::is('ratingLevels*') ? 'active' : '' }}">
            <a href="{!! route('ratingLevels.index') !!}"><i class="fa fa-edit"></i><span>Quản lý mức xếp loại</span></a>
        </li>

        <li class="{{ Request::is('results*') ? 'active' : '' }}">
            <a href="{!! route('results.index') !!}"><i class="fa fa-edit"></i><span>Quản lý kết quả</span></a>
        </li>

        <li class="{{ Request::is('mistakes*') ? 'active' : '' }}">
            <a href="{!! route('mistakes.index') !!}"><i class="fa fa-edit"></i><span>Quản lý lỗi vi phạm</span></a>
        </li>
    </ul>
</li>
        
<li class="treeview">
    <a href="#">
        <i class="fa fa-book"></i>
            <span>Quản lý nhân sự</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('workgroups*') ? 'active' : '' }}">
            <a href="{!! route('workgroups.index') !!}"><i class="fa fa-edit"></i><span>Quản lý Nhóm điện thoại viên</span></a>
        </li>

        <li class="{{ Request::is('agents*') ? 'active' : '' }}">
            <a href="{!! route('agents.index') !!}"><i class="fa fa-edit"></i><span>Quản lý Điện thoại viên</span></a>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-book"></i>
            <span>Chấm điểm cuộc gọi</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('workgroups*') ? 'active' : '' }}">
            <a href="{!! route('mark_tool.avg') !!}"><i class="fa fa-edit"></i><span>AVG</span></a>
        </li>
        <li class="{{ Request::is('agents*') ? 'active' : '' }}">
            <a href="{!! route('mark_tool.mfs') !!}"><i class="fa fa-edit"></i><span>Mobifone Service</span></a>
        </li>
        <li class="{{ Request::is('agents*') ? 'active' : '' }}">
            <a href="{!! route('mark_tool.index') !!}"><i class="fa fa-edit"></i><span>Kiểm định cuộc gọi của MFS</span></a>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-book"></i>
            <span>Báo cáo/Thống kê</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('workgroups*') ? 'active' : '' }}">
            <a href="{!! route('report.mark_log') !!}"><i class="fa fa-edit"></i><span>Chi tiết cuộc gọi AVG</span></a>
        </li>
        <li class="{{ Request::is('agents*') ? 'active' : '' }}">
            <a href="{!! route('report.mark_log_mfs') !!}"><i class="fa fa-edit"></i><span>Chi tiết cuộc gọi MFS</span></a>
        </li>
        <li class="{{ Request::is('agents*') ? 'active' : '' }}">
            <a href="{!! route('report.avg') !!}"><i class="fa fa-edit"></i><span>Báo cáo AVG</span></a>
        </li>
        <li class="{{ Request::is('agents*') ? 'active' : '' }}">
            <a href="{!! route('report.mfs') !!}"><i class="fa fa-edit"></i><span>Báo cáo Mobifone Service</span></a>
        </li>
    </ul>
</li>
