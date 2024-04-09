<?php

namespace App\Http\Middleware;

use App\Exceptions\Product\ProductIsNotActiveException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $product = $request->route("product");
        if ($product->isActive()) {
            return $next($request);
        } else {
            throw new ProductIsNotActiveException();
            // return response()->json(["message" => __("messages.model_not_found")], 404);
        }
    }
}
