<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ReferenceSystemController extends Controller
{
    use ApiResponser;

    public function status()
    {
        if (\App\Models\Setting::value('mlm_status') && \App\Models\ReferenceLevel::all()->count())
        {
            return $this->success(\App\Models\ReferenceLevel::all(),'Successful');
        } else {
            return $this->success('','Reference system is not active');
        }
    }

    public function list()
    {
        $list=[];
        $user = auth()->user();

        foreach ($user->children as $child)
        {
            $level=1;
            $list[] = [
                'name' => $child->name,
                'email' => $child->email,
                'register_date' => $child->created_at,
                'level' => $level,
                'childrens' => $this->grandchild($child,$level)
            ];
        }

        return $this->success($list,'Successful');
    }

    public function grandchild($child, $level)
    {
        $level += 1;
        $users = $child->children;
        foreach ($users as $child)
        {
            if ($level<\App\Models\ReferenceLevel::all()->count()+1)
            {
                return [
                    'name' => $child->name,
                    'email' => $child->email,
                    'register_date' => $child->created_at,
                    'level' => $level,
                    'childrens' => $child->children ? $this->grandchild($child,$level) : null
                ];
            }
        }
    }

    public function earnings()
    {
        return $this->success(auth()->user()->referral_earnings);
    }
}
