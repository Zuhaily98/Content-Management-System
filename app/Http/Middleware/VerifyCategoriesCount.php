<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;

class VerifyCategoriesCount
{
    /**
     * Make sure that there is categories existed before enabling user to create new post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Category::all()->count() == 0){
            return redirect()->back();
        }

        return $next($request);
    }
}
