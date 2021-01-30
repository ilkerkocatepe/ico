<div class="auth-footer-btn d-flex justify-content-center">
    @foreach(App\Models\Social::where('status','1')->get() as $social)

        <a href="{{ $social->link }}" class="btn">
            <i class="fab {{ $social->icon }} fa-2x" @if(isset($social->color))style="color:{{$social->color}};"@endif></i>
        </a>

    @endforeach
</div>
