@php($level+=1)
@foreach($childs as $child)
    @if($level<\App\Models\ReferenceLevel::all()->count()+1)
        <tr>
            <td>
                {{ $child->name }}
            </td>
            <td>
                {{ $level }}
            </td>
            <td>
                {{ $child->created_at }}
            </td>
        </tr>
            @if(count($child->children))
                    @include('user.profile.grandchildren',['childs' => $child->children, 'level' => $level])
            @endif
    @endif
@endforeach
