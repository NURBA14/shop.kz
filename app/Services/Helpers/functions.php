<?php

function responseFailed(string $message = null, $code = 400)
{
    return response()->json([
        "message" => $message
    ], $code);
}