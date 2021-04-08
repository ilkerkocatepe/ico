<div id="tree" class="tree mx-auto" style="max-width: 100%;">
    <div class="tree-widget">
        <div class="tree-structure">
            <div class="tree-node">{{ $user->name }}</div>
            <ul class="tree-branch">
                @foreach($user->children as $child)
                    @php($level=1)
                    <li class="tree-item">
                        <div class="tree-node">{{ $child->name }} <br> LEVEL {{ $level }} {{ $user->referral_earning_amount($child->id) ?? '<br> GAIN: '.$user->referral_earning_amount($child->id) . ' ' . env('TOKEN_SYMBOL')  }}</div>
                        @if(count($child->children))
                                <ul class="tree-branch">
                                    @include('user.profile.tree.subuser',['childs' => $child->children, 'level' => $level])
                                </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
