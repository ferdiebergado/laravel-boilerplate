@if (session('status'))
<div id="divAlertSuccess" class="alert bg-blue alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><span><i class="fa fa-check"></i></span> {{ __('messages.success') }}</h4>
    <h5>{{ session('status') }}</h5>
</div>
@endif 

@if (session('warning'))
<div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
    <span><i class="fa fa-exclamation-triangle"></i></span>
    {{ session('warning') }}
</div>
@endif

@if (session('errors'))
<div id="divErrors" class="alert bg-maroon">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><span><i class="fa fa-ban"></i></span> {{ __('messages.error') }}</h4>
    <h5 id="errorMsg">{{ session('errors') }}</h5>
</div>
@endif 