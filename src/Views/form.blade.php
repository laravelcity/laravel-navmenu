<div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well well-sm">
                <div class="nav-form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <select name="position" class="form-control">
                            @foreach(config('navmenu.register_nav_menu') as $key=>$val)
                                <option @if(@$nav->position==$key) selected @endif value="{{$key}}"> {{$val}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" value="{{@$nav->title}}" type="text" name="title" >
                    </div>
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option  @if(@$nav->status==0) selected @endif value="0"> غیر فعال  </option>
                            <option @if(@$nav->status) selected @endif value="1"> فعال </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">ذخیره</button>
                    </div>
                </div>
            </div>
        </div>
</div>