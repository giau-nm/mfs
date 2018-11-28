<ol class="breadcrumb">
    <li><a href="{{ route ('home')}}"><i class="fa fa-dashboard"></i> @lang('label.breadcrumbs.home')</a></li>
    @foreach($breadcrumbs as $key => $breadcrumb)
        @if ($key > 0)
            <li><a href="{{ $breadcrumb->url }}"><i class="fa fa-dashboard"></i> {{ $breadcrumb->title }}</a></li>
        @elseif ($key > 0 && $key == count($breadcrumbs) - 1)
            <li class="active">{{ $breadcrumb->title }}</li>
        @endif
    @endforeach
</ol>