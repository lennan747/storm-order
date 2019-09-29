<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
           <span id="alert"></span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">选择渠道</div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <input type="text" class="form-control col-sm-12" name="channel_name" value="" required>
                            </div>
                            <div class="clo-sm-3">
                                <button type="button" id="check_channel" class="btn btn-primary" onclick="check_channel()">查询
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box">
                    <div class="box-header">指派渠道
                    </div>
                    <div class="box-body">
                        <form id="myFormId" action="/admin/plans/add_plans" class="form-horizontal" method="post">
                            @csrf
                        <div class="row">
                            <div class="col-sm-2">

                                <select class="form-control channels" data-placeholder="选择渠道" style="width: 100%;">
                                    <option value="">请选择渠道</option>
                                    @foreach($channels as $k => $v)
                                <option value="{{ $k }}">{{$v }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" class="form-control pull-right" name="channels" value="" placeholder="选择渠道">
                            </div>

                            <div class="col-sm-3">
                                <select class="form-control wechats" multiple="multiple" data-placeholder="微信编号"
                                        style="width: 100%;">
                                    @foreach($wechats as $wechat)
                                        <option value="{{ $wechat->id }}">{{ $wechat->code }} {{ $wechat->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="wechats" value="[]">
                            </div>

                            <div class="col-sm-3">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="datetime" class="form-control pull-right" id="datepicker" placeholder="选择日期">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <input type="text" class="form-control pull-right" name="mark">
                            </div>
                            <div class="clo-sm-1">
                                <button type="submit" class="btn btn-primary"> +
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="btn-group pull-right grid-create-btn">
                            <a href="/admin/plans/create" class="btn btn-sm btn-success">添加时间</a>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                            <tr role="row">
                                <td>进线时间</td>
                                @foreach($wechats as $wechat)
                                    <td>{{ $wechat->code }}</td>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($plans as $key => $plan)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach($wechats as $wkey => $wechat)
                                        <td>
                                            @if($plan[$wkey]['channel_id'])
                                                <a href='#' onclick="clear_channel({{ $plan[$wkey]['id']}})">×</a>
                                                <a href='#'
                                                   onclick="edit_channel({{ $plan[$wkey]['id'].','.$plan[$wkey]['channel_id'].',"'.$plan[$wkey]['datetime'].'","'. $wechat['id'].'","'.$plan[$wkey]['mark'].'"'}})">{{ $plan[$wkey]['mark'] != null ? $plan[$wkey]['mark'] : '备注'}}</a>
                                            @else
                                                <a href='#' onclick="add_channel({{ $plan[$wkey]['id'].',"'.$plan[$wkey]['datetime'].'",'.$wechat['id']}})">+</a>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="box-footer clearfix">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="row">
            <div class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            添加渠道
                            <div onclick="close_modal()" class="box-tools pull-right"><i class="fa fa-times"></i></div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <label class="col-sm-3 control-label" id="check_tip">选择相似渠道</label>
                                <div class="col-sm-9">
                                    <select multiple class="check_channle form-control" name="check_channle">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-8" id="add_html">

                            </div>
                            <a href="#" class="btn btn-primary" id="sure">
                                确定添加到新渠道
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        // 微信多选下拉
        $('.wechats').select2();
        // 微信多选下拉事件
        $(".wechats").on('change',function () {
            $('input[name="wechats"]').val($('.wechats').val());
        });

        $('.channels').select2();
        $(".channels").on('change',function () {
            $('input[name="channels"]').val($('.channels').val());
        });
        // 日期
        $('#datepicker').datepicker({autoclose: true, format: 'yyyy-mm-dd', language: 'zh-CN',});

        // 选择渠道后改变事件
        $('.check_channle').on('change',function () {
            var options = $(".check_channle option:selected");
            var html =  '<a href="#" class="btn btn-primary" onclick="checked_channel('+options.val()+')">选择渠道到计划</a>';
            $('#add_html').html(html)
        });

        // 确定添加到渠道
        $('#sure').on('click',function () {
            console.log(11111);
            var name = $('input[name="channel_name"]').val();
            if (name) {
                $.post('/admin/channels/add_channel', {
                    _token: LA.token,
                    'name': name,
                }, function (data) {
                    //添加渠道成功
                    if(data.status){
                        $('.channels').append('<option value="'+data.id+'">'+name+'</option>');
                        $('.channels').val(data.id).select2();
                        $('input[name="channels"]').val($('.channels').val());
                    }else{
                        alert('当前渠道已存在');
                    }
                    close_modal();
                });
            }else{
                $('#alert').html('请输入渠道名称');
                $('.alert').css('display', 'block').addClass("in");
                setTimeout(function () {
                    $('#alert').html('');
                    $('.alert').css('display', 'none').removeClass("in");
                }, 2000);
            }
        });

    });

    // 检查渠道
    function check_channel() {
        var name = $('input[name="channel_name"]').val();
        if (name) {
            $.post('/admin/channels/check_channel', {
                _token: LA.token,
                'name': name,
            }, function (data) {
                console.log(data);
                // 找到相似渠道
                if (data.length > 0) {
                    var html= '';
                    $('#check_tip').html('找到相似渠道');
                    // 添加到渠道选择框
                    data.forEach(function (item) {
                        html = html + '<option value="'+ item.id+'">'+ item.name +'</option>';
                    });
                    $('.check_channle').html(html);
                    // 显示选择框
                    $('.check_channle').css('display', 'block');
                } else {
                    $('#check_tip').html('未找到相似渠道');
                    $('.check_channle').css('display', 'none');
                }
                //
                open_modal();
            });
        }else{
            $('#alert').html('请输入渠道名称');
            $('.alert').css('display', 'block').addClass("in");
            setTimeout(function () {
                $('#alert').html('');
                $('.alert').css('display', 'none').removeClass("in");
            }, 2000);
        }
    }

    // 选中选择的渠道
    function checked_channel(id) {
        $('.channels').val(id).select2();
        $('input[name="channels"]').val(id);
        // 复原选择按钮
        // html ='<a href="#" class="btn btn-primary" id="sure" ">确定添加到新渠道</a>';
        $('#add_html').html('');
        close_modal()
    }

    // 关闭弹窗
    function close_modal() {
        $('#check_tip').html('');
        $('.check_channle').html('');
        $('body').removeClass('modal-open');
        $('.modal').css('display', 'none').removeClass("in");
    }

    // 打开弹窗
    function open_modal() {
        $('body').addClass('modal-open');
        $('.modal').css('display', 'block').addClass("in");
    }

    //
    function add_channel(id,datetime,wechat_id) {
        $('input[name="datetime"]').val(datetime);
        //$('.channels').val([wechat_id]).select2();
        $('.wechats').select2().val([wechat_id]).select2();
        $('input[name="wechats"]').val([wechat_id]);
    }

    function edit_channel(id,channel,datetime,wechat_id,mark) {
        $('input[name="datetime"]').val(datetime);
        $('.channels').val(channel).select2();
        $('input[name="channels"]').val(channel);

        $('.wechats').select2().val([wechat_id]).select2();
        $('input[name="wechats"]').val([wechat_id]);
        $('input[name="mark"]').val(mark);
    }

    // 清除当前计划的渠道计划
    function clear_channel(id) {
        // 返回的是微信id
        var r = confirm("确认删除");
        if (r == true) {
            $.post('/admin/plans/clear',{
                _token: LA.token,
                'id': id
            },function (data) {
                //console.log(data);
                if(data){
                    location.reload();
                }
            });
        }
    }
</script>
