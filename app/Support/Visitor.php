<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Visitor
{
    public static function id(Request $request): string
    {
        $id = $request->cookie('blog_visitor');
        if (!is_string($id) || !Str::isUuid($id)) {
            $id = (string) Str::uuid();
            Cookie::queue(cookie('blog_visitor', $id, 525600, '/', null, $request->isSecure(), true, false, 'lax'));
        }

        return $id;
    }
}
