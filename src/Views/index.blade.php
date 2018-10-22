@extends('NavMenu::layout')
@section('content')
    @forelse($navs as $key=> $nav )

        <div class="well well-sm">
            <h3>مکان : {{config('navmenu.register_nav_menu.'.$key)}}</h3>
            <table class="table table-striped">
                <tr>
                    <th>id</th>
                    <th>نام</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                @foreach($nav as $n)
                    <tr>
                        <td>{{$n->nav_id}}</td>
                        <td>{{$n->title}}</td>
                        <td>@if($n->status) فعال @else  غیر فعال@endif</td>
                        <td>
                            @if($n->status==0)
                                <a href="{{route('nav.active',['id'=>$n->nav_id,'position'=>$n->position])}}" class="link btn btn-success">فعال</a>
                            @endif
                            <a href="{{route('nav.edit',['id'=>$n->nav_id])}}" class="link btn btn-warning">ویرایش</a>
                            <a href="{{route('nav.show',['id'=>$n->nav_id])}}" class="link btn btn-info">افزودن لینک ها</a>

                            {!! button_destroy(route('nav.destroy',['id'=>$n->nav_id]),'آیا مطمئن به حذف این فهرست هستید ؟','حذف','حذف') !!}
                        </td>
                    </tr>

                @endforeach

            </table>
        </div>
    @empty

    @endforelse
@endsection


