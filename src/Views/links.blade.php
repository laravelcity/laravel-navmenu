<div class="dd">
   {!! $lists !!}
</div>
<!-- Modal -->
<div class="modal fade" id="editLink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">ویرایش لینک</h4>
            </div>
            <div class="modal-body">
                <div id="editForm">
                    <div class="form-group">
                        <input type="hidden" class="id" name="id" >
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
                <button type="button" class="btn btn-primary updateLink">ذخیره </button>
            </div>
        </div>
    </div>
</div>

<script type="">
    var prefix="{{config('navmenu.prefix')}}";
    var editForm=$("#editForm");

    function saveChange() {
        $.ajax({
            url: "{{route('nav.link.serialize')}}",
            type:'post',
            data:{
                links:$('.dd').nestable('serialize'),
                _token:'{{csrf_token()}}'
            },
            success: function(result){
            }
        });
    }
    (function($){

        $(".removeLink").click(function () {
            $.ajax({
                url: prefix+ "/nav/link/remove/id/" + $(this).data('link-id'),
                type:'get',
                success: function(result){
                    getLinks();
                }
            });
        });

        $(".editLink").click(function () {
            editForm.find(".title").val($(this).data('title'));
            editForm.find(".link").val($(this).data('link'));
            editForm.find(".id").val($(this).data('id'));
            editForm.find(".image").val($(this).data('image'));

            $("#editLink").modal('show');
        });

        $(".updateLink").click(function () {
            var data={
                _token:'{{csrf_token()}}',
                title:editForm.find(".title").val(),
                link:editForm.find(".link").val(),
                id:editForm.find(".id").val(),
                image:editForm.find(".image").val()
            };
            edit(data);
        });

        $('.dd').nestable({group: 1000});

        $('.dd').on('change', function() {
            saveChange();
        });
    })(jQuery);

    function edit(data) {
        $.ajax({
            url: prefix+ "/link/" + data.id,
            type:'put',
            data:data,
            success: function(result){
                $("#editLink").modal('hide');

                setTimeout(function () {
                    getLinks();
                },1000);

            }
        });
        return true;

    }
</script>