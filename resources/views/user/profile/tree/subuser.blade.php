@php($level+=1)
@foreach($childs as $child)
    @if($level<\App\Models\ReferenceLevel::all()->count()+1)
        <li class="tree-item">
            <div class="tree-node">{{$child->name}} <br> LEVEL {{ $level }}</div>
            @if(count($child->children))
                <ul class="tree-branch">
                    @include('user.profile.tree.subuser',['childs' => $child->children, 'level' => $level])
                </ul>
            @endif
        </li>
    @endif
@endforeach
