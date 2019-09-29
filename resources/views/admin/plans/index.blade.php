<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">

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
                                        <a href='#' onclick="clear_channel({{ $plan[$wkey]['id']}})"><p style="color: red;"><strong>-</strong></p></a>
                                        <a href='#'
                                           onclick="edit_channel({{ $plan[$wkey]['id'].','.$plan[$wkey]['channel_id'].',"'.$plan[$wkey]['datetime'].'","'. $channels[$plan[$wkey]['channel_id']].'"'}})">{{ $plan[$wkey]['mark'] != null ? $plan[$wkey]['mark'] : '*'}}</a>
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
    <div class="col-md-12">
        <div class="row">
            <div class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            指派渠道
                            <div onclick="close_modal()" class="box-tools pull-right"><i class="fa fa-times"></i></div>
                        </div>
                        <form id="myFormId" action="" class="form-horizontal" method="post" onsubmit="return validateForm()">
                            {{ method_field('PUT') }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="channel_name" class="col-sm-2 control-label">渠道</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control col-sm-12" name="channel_name" value=""
                                               required>
                                        @error('channel')
                                        <div class="mb-3 bg-danger text-white">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="clo-sm-2">
                                        <button type="button" id="check_channel" class="btn-sm btn-primary">查询
                                        </button>
                                        <button type="button" id="add_channel" class="btn-sm btn-primary">添加
                                        </button>
                                    </div>
                                </div>
                                <div id="show_channel_form_group" class="form-group">
                                    <label for="check_channel" class="col-sm-2 control-label" id="channel_tip">查询结果</label>
                                    <div class="col-sm-10" id="show_channel">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">日期:</label>
                                    <div class="col-sm-8">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="datetime" class="form-control pull-right" id="datepicker">
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label for="wechats" class="col-sm-2 control-label">微信编号</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2" multiple="multiple" data-placeholder="微信编号" style="width: 100%;">
                                            @foreach($wechats as $wechat)
                                                <option value="{{ $wechat->id }}">{{ $wechat->code }} {{ $wechat->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="wechats" value="[]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mark" class="col-sm-2 control-label">备注</label>
                                    <div class="col-sm-10">
                                        <textarea name="mark" id="" cols="30" rows="3" class="form-control"></textarea>
                                        @error('mark')
                                        <div class="mb-3 bg-danger text-white">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @csrf
                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="channel_id" value="">
                                <button type="submit" class="btn btn-primary">
                                    确定
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(function () {
        //
        $('.select2').select2();
        //Date picker
        $('#datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
        });
        //
        $(".select2").on('change',function () {
            $('input[name="wechats"]').val($('.select2').val());
        });

        $('#datepicker').on('change',function () {
            // 获取当前渠道，当前日期得所有微信号
          console.log(0);
        });

        // 添加渠道
        $('#add_channel').on('click',function () {
            var show = $('#show_channel');
            var name = $('input[name="channel_name"]').val();
            if(name){
                $.post('/admin/channels/add_channel', {
                    _token: LA.token,
                    'name': name,
                }, function (data) {
                    if(data.status){
                        console.log(data);
                        show.html("");
                        var html = '<label style="color: red; class="col-sm-12" for=""><input name="check_channel" type="radio" checked value="' + data.id + '">' + name + '</label>';
                        show.append(html);
                    }else{
                        alert('当前渠道名称已存在');
                    }
                });
            }else{
                alert('请输入渠道名称');
            }
        });

        // 检测渠道
        $('#check_channel').on('click',function () {
            var html = '';
            var show = $('#show_channel');
            var name = $('input[name="channel_name"]').val();
            var show_group = $('#show_channel_form_group');
            if (name) {
                $.post('/admin/channels/check_channel', {
                    _token: LA.token,
                    'name': name,
                }, function (data) {
                    show_group.addClass('hidden');
                    console.log(data);
                    show.html("");
                    if (data.length > 0) {
                        data.forEach(function (item) {
                            html = html + '<label style="color: red; class="col-sm-12" for=""><input name="check_channel" type="radio" value="' + item.id + '">' + item.name + '</label>'
                        });
                    } else {
                        html = '<strong style="color: red;">没有找到该渠道</strong>';
                    }
                    show.append(html);
                    show_group.removeClass('hidden');
                });
            }else{
                alert('请输入渠道名称');
            }
        })
    });

    // 表单验证
    function validateForm() {
        if(!$('input[name="check_channel"]').val()){
            alert('请选择渠道');
            return false;
        };
    }

    // 清除当前计划的渠道计划
    function clear_channel(id) {
        // 返回的是微信id
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

    // 添加渠道到微信号
    function add_channel(id,datetime,wechat_id) {
        console.log(id,datetime);
        // 清除选择得渠道
        var show = $('#show_channel');
        show.html('');
        // 设置提交路径
        $("#myFormId").attr("action", "/admin/plans/" + id);
        // 清空微信选择框
        $('.select2').select2().val([wechat_id]).select2();
        // 清空渠道名称
        $('input[name="channel_name"]').val('');
        // 清空渠道id
        $('input[name="channel_id"]').val('');
        // 设置当前悬着日期
        $('input[name="datetime"]').val(datetime);
        // 打开弹窗
        $('body').addClass('modal-open');
        $('.modal').css('display', 'block').addClass("in");
    }

    // 修改渠道到微信号
    /**
     *
     * @param id 关系id
     * @param channel 渠道id
     * @param datetime 当前选择的日期
     * @param name 渠道名称
     */
    function edit_channel(id,channel,datetime,name) {
        console.log(id,channel,datetime,name);

        //显示选择了得渠道
        var show = $('#show_channel');
        show.html('');
        var html = '<label style="color: red; class="col-sm-12" for=""><input name="check_channel" type="radio" checked value="' + channel + '">' + name + '</label>';
        show.append(html);
        $('#show_channel_form_group').removeClass('hidden');

        $('.select2').select2().val('').select2();
        $("#myFormId").attr("action", "/admin/plans/" + id);
        $('input[name="datetime"]').val(datetime);
        $('input[name="channel_name"]').val(name);
        $('input[name="channel_id"]').val(channel);
        $('body').addClass('modal-open');
        $('.modal').css('display', 'block').addClass("in");

        // 返回的是微信id
        $.post('/admin/plans/data_plans',{
            _token: LA.token,
            'channel_id': channel,
            'datetime': datetime
        },function (data) {
            console.log(data);
            $('.select2').select2().val(data).select2();
            //console.log($(".select2").val());
            $('input[name="wechats"]').val(data);
        });
    }


    // 关闭弹窗
    function close_modal() {
        $('body').removeClass('modal-open');
        $('.modal').css('display', 'none').removeClass("in");
    }


</script>
