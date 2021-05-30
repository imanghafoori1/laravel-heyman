<?php

namespace Imanghafoori\HeyManTests\Stubs;

class SomeClass
{
    public function someMethod()
    {
        return false;
    }

    public function someMethod2($p1, $p2)
    {
        return response()->json(['Wow' => (string) ($p1 + $p2)], 566);
    }

    public static function someStaticMethod($p1, $p2)
    {
        return response()->json(['Wow' => (string) ($p1 + $p2)], 201);
    }

    public static function someStaticMethod_2()
    {
        return response()->json(['Wow' => 'aaa'], 201);
    }
}
