@foreach($user->children as $child)
    @php($level=1)
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
    @include('user.profile.grandchildren',['childs' => $child->children, 'level' => $level])
@endforeach
