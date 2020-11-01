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
            session()->flash('error', 'You need to add categories before creating a post.');

            return redirect(route('categories.create'));
        }

        return $next($request);
    }
}
