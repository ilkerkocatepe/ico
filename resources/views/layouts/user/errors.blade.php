@if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <h4 class="alert-heading">{{ __('Error!') }}</h4>
        <div class="alert-body">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif
