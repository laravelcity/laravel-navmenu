@extends('NavMenu::layout')
@section('content')
    <div class="well">
        <h3>مکان : {{config('navmenu.register_nav_menu.'.$nav->position)}}</h3>
    </div>
    <div class="row">
        <div class="col-md-4">
            <button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#addLinkModal">
                افزودن لینک دستی
            </button>
            <br>
            <div  class="well">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @if(count($link_category['static'])>0)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        لینک های ثابت
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div  class="panel-body">
                                    {!! \Laravelcity\NavMenu\LydaNavHelpers::getLinksList($nav->nav_id,$link_category['static']) !!}

                                </div>
                            </div>
                        </div>
                    @endif

                    @if(count($link_category['dynamic'])>0)

                        @foreach($link_category['dynamic'] as  $category)
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
                                            {{$category['title']}}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse{{$loop->index}}" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                    <div  class="panel-body">
                                        @if(isset($category['search'])&& $category['search']==true)
                                            <div class="well well-sm">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <button data-input-target="search_title_{{$loop->index}}"  data-target="dynamic_link_{{$loop->index}}" data-nav-id="{{$nav->nav_id}}" data-controller="{{$category['controller']}}" data-method="{{$category['method']}}" class="btn btn-sm btn-primary search_submit">جستجو</button>
                                                    </div>
                                                    <div class="col-xs-9">
                                                        <input id="search_title_{{$loop->index}}" class="search form-control input-sm">
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                        <div id="dynamic_link_{{$loop->index}}">
                                            {!!
                                                \Laravelcity\NavMenu\LydaNavHelpers::getLinksList($nav->nav_id,app()->call(
                                                    [ $category['controller'],$category['method'] ]
                                                ))
                                            !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    @endif


                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="well router" >
                <div id="router-list">

                </div>
                    <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addLinkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">افزودن لینک</h4>
                </div>
                <div class="modal-body">
                    <div id="storeForm">
                        <div class="form-group">
                            <input  type="text" name="title" class="title form-control" placeholder="موضوع">
                        </div>
                        <div class="form-group">
                            <input  style="direction: ltr;text-align: left" dir="ltr" type="text" name="link" class="link form-control" placeholder="لینک">
                        </div>
                        <div class="form-group">
                            <input  style="direction: ltr;text-align: left" dir="ltr" type="text" name="image" class="image form-control" placeholder="عکس لینک">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">خروج</button>
                    <button type="button" class="btn btn-primary modalSaveLink">ذخیره </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')@parent
        <script type="">
    var prefix="{{config('navmenu.prefix')}}";

    function getLinks () {
        $.ajax({
            data:{'nav_id':{{$nav->nav_id}}},
            url: "{{route('link.index')}}",
            success: function(result){
                $("#router-list").html(result);
                $(".loading").hide();
            }
        });
    }

    function storeLink(data) {
        $.ajax({
            data:data,
            type:'post',
            url: "{{route('link.store')}}",
            success: function(result){
                getLinks();
            }
        });
    }
    $(document).ready(function(){
        getLinks();

        $(".search_submit").click(function () {
            var data={
                'nav_id':$(this).data('nav-id'),
                'title':$('#'+$(this).data('input-target')).val(),
                'controller':$(this).data('controller'),
                'method':$(this).data('method'),
                '_token':'{{csrf_token()}}'
            };

            var target=$(this).data('target');

            $.ajax({
                data:data,
                type:'get',
                url: prefix+"/link/search/title/",
                success: function(result){
                    $('#'+target).html(result);
                    $(".saveLink").click(function () {
                        var data={
                            'nav_id':$(this).data('nav-id'),
                            'title':$(this).data('title'),
                            'link':$(this).data('link'),
                            'image':$(this).data('image'),
                            'parent':0,
                            '_token':'{{csrf_token()}}'
                        };

                        storeLink(data);
                    });
                }
            });
        });

        $(".saveLink").click(function () {
            var data={
                'nav_id':$(this).data('nav-id'),
                'title':$(this).data('title'),
                'link':$(this).data('link'),
                'image':$(this).data('image'),
                'parent':0,
                '_token':'{{csrf_token()}}'
            };

            storeLink(data);
        });

        $(".modalSaveLink").click(function () {
           var form= $("#storeForm");
            var data={
                'nav_id':{{$nav->nav_id}},
                'title':form.find(".title").val(),
                'link':form.find(".link").val(),
                'image':form.find(".image").val(),
                'parent':0,
                '_token':'{{csrf_token()}}'
            };
            storeLink(data);
            $("#addLinkModal").modal('hide');
        });
    });
</script>
@endsection


