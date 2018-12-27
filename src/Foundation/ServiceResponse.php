<?php

namespace Sciice\Foundation;

trait ServiceResponse
{
    public function response()
    {
        return response()->json(['message' => __('操作成功')]);
    }
}
