<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<div class="row" id="showlist">

    <div class="col-sm-3 col-md-3" v-for="(ite, index) in items">

        <div class="thumbnail">
            <a v-bind:href="ite.product_url" target="_blank">
                <img v-bind:src="ite.main_pic">
            </a>
            <div class="caption">
                <p class="text-center">@{{ ite.product_no }}</p>
                <h3 class="text-center">@{{ ite.price }}</h3>
            </div>
            <p class="text-center">@{{ ite.title }}</p>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12 text-center">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @for($i = 1 ; $i<=$maxpage; $i++)
                    <li id="li{{$i}}" class="active"><a href="javascript:void(0);" onclick="vm.init({{ $i }});">{{$i}}</a></li>
                @endfor
            </ul>
        </nav>
    </div>
</div>


<!-- Small modal -->
<div class="modal fade bs-example-modal-sm" id="loading" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            数据加载中。。。
        </div>
    </div>
</div>

<script src="//cdn.bootcss.com/jquery/3.1.0/jquery.js"></script>
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(function () {
        vm.init(1);
    });
    var vm = new Vue({
        el: '#showlist',
        data: {
            currpage: 1,
            items: []
        },
        methods: {
            init: function (p) {
                if (p == 'undefinded' || isNaN(p)) {
                    p = 1;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('getda') }}',
                    data: "&p=" + p + '&_token={{ csrf_token() }}',
                    dataType: 'json',
                    beforeSend:function () {
                        $('#loading').modal('show');
                    },
                    success: function (data) {
                        $('.pagination>li').removeClass('active');
                        $('#li'+p).addClass('active');
                        $('#loading').modal('hide');
                        vm.currpage = p;
                        vm.items = data.list;
                    }
                });
            }
        }
    });
</script>