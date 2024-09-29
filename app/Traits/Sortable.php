<?php

namespace App\Traits;

trait Sortable
{
    /**
     * Apply sorting to the given query based on request parameters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applySorting($query, $request)
    {
        // Sort dari defaultnya by title dan ascending
        $sortBy = $request->input('sort_by', 'title');
        $orderBy = $request->input('order', 'asc');

        // aplikasiin sorting dari query yang ada ke database
        if (in_array($sortBy, ['title', 'created_at', 'updated_at'])) {
            $query->orderBy($sortBy, $orderBy);
        }

        return $query;
    }
}
