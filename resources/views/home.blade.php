@extends('master')

@section('content')
<div class="app-main__inner">
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Funds Transfer</div>
                        <div class="widget-subheading">Last year transfer</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>1896</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-arielle-smile">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Funds</div>
                        <div class="widget-subheading">Total Funds</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>$ 568</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-grow-early">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Payee</div>
                        <div class="widget-subheading">No of Payee</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>0</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var email = "<?php echo Auth::user()->email;?>";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function checkUserExists() {
        $.ajax({
            type : 'POST',
            url : "<?php echo URL::to("user/checkUserExistsOrNot");?>",
            data : {
                unique_id : email
            },
            success : function(response) {
                if (response == 'success') {
                    alert('ok');
                    generateRandomNo("rabin1",false);
                }
            }
        });
    }
    //checkUserExists();
</script>
@endsection

