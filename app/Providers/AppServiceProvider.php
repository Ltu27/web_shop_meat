<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        view()->composer('*', function($view) {
            $cats_home = Category::orderBy('name', 'ASC')->where('status', 1)->get();
            $carts = Cart::where('customer_id', auth('cus')->id())->get();
            $view->with(compact('cats_home','carts'));
        });

        Builder::macro('search', function (array $attributes, ?string $searchTermString) {
            $array = explode(',', $searchTermString);
            foreach ($array as $searchTerm) {
                $this->orWhere(function (Builder $query) use ($attributes, $searchTerm) {
                    foreach ($attributes as $attribute) {
                        $query->when(
                            str_contains($attribute, ':'),
                            function (Builder $query) use ($attribute, $searchTerm) {
                                [$relation, $relationAttribute] = explode(':', $attribute);
                                $query->orWhereHas($relation, function (Builder $query) use (
                                    $relationAttribute,
                                    $searchTerm
                                ) {
                                    if (str_contains($relationAttribute, ',')) {
                                        [$first, $last] = explode(',', $relationAttribute);
                                        $query->where(DB::raw("concat({$first}, ' ', {$last})"), 'LIKE', '%' . $searchTerm . '%');
                                        return;
                                    }
                                    $query->where($relationAttribute, 'LIKE', '%' . $searchTerm . '%');
                                });
                            },
                            function (Builder $query) use ($attribute, $searchTerm) {
                                if (str_contains($attribute, ',')) {
                                    [$first, $last] = explode(',', $attribute);
                                    $query->orWhere(DB::raw("concat({$first}, ' ', {$last})"), 'LIKE', '%' . $searchTerm . '%');
                                    return;
                                }
                                $query->orWhere($attribute, 'LIKE', '%' . $searchTerm . '%');
                            }
                        );
                    }
                });
            }
            return $this;
        });

        Builder::macro('filterBy', function (array $filterData, array $filterFields) {
            $this->where(function (Builder $query) use ($filterData, $filterFields) {
                foreach ($filterData as $key => $value) {
                    if (empty($filterFields[$key]) || !isset($value)) {
                        continue;
                    }
                    if (strstr($value, '-')) {
                        try {
                            if ($date = Carbon::parse($value)) {
                                $query->whereDate($filterFields[$key], $date);
                                continue;
                            }
                        } catch (InvalidFormatException $e) {
                            // not a valid date, we will continue filtering this value
                        }
                    }
                    //filter by multiple values
                    if (!empty($value) || is_numeric($value)) {
                        $query->whereIn($filterFields[$key], explode(',', $value));
                    }
                }
            });
            return $this;
        });

        Builder::macro('sortBy', function (array $sortData, array $sortConditions) {
            foreach ($sortData as $key => $value) {
                if (!empty($sortConditions[$key]) && !empty($value)) {
                    if (is_array($sortConditions[$key])) {
                        foreach ($sortConditions[$key] as $field) {
                            $this->orderBy($field, $value);
                        }
                    } else {
                        $this->orderBy($sortConditions[$key], $value);
                    }
                }
            }

            return $this;
        });

        Builder::macro('searchBy', function (array $searchData, array $searchConditions) {
            foreach ($searchData as $key => $value) {
                if (!empty($searchConditions[$key]) && !empty($value)) {
                    $this->where(function (Builder $query) use ($key, $searchConditions, $value) {
                        $attribute = $searchConditions[$key];
                        $query->when(
                            str_contains($attribute, ':'),
                            function (Builder $query) use ($attribute, $value) {
                                [$relation, $relationAttribute] = explode(':', $attribute);
                                $query->orWhereHas($relation, function (Builder $query) use (
                                    $relationAttribute,
                                    $value
                                ) {
                                    if (str_contains($relationAttribute, ',')) {
                                        [$first, $last] = explode(',', $relationAttribute);
                                        $query->where(DB::raw("concat({$first}, ' ', {$last})"), 'LIKE', '%' . $searchTerm . '%');
                                        return;
                                    }
                                    $query->where($relationAttribute, 'LIKE', '%' . $value . '%');
                                });
                            },
                            function (Builder $query) use ($attribute, $value) {
                                if (str_contains($attribute, ',')) {
                                    [$first, $last] = explode(',', $attribute);
                                    $query->orWhere(DB::raw("concat({$first}, ' ', {$last})"), 'LIKE', '%' . $searchTerm . '%');
                                    return;
                                }
                                $query->orWhere($attribute, 'LIKE', '%' . $value . '%');
                            }
                        );
                    });
                }
            }
            return $this;
        });

        Builder::macro('hasBy', function (array $searchData, array $searchConditions) {
            foreach ($searchData as $key => $value) {
                if (!empty($searchConditions[$key]) && isset($value)) {
                    $this->where(function (Builder $query) use ($key, $searchConditions, $value) {
                        $attribute = $searchConditions[$key];
                        $query->when(
                            str_contains($attribute, ':'),
                            function (Builder $query) use ($attribute, $value) {
                                [$relation, $relationAttribute] = explode(':', $attribute);

                                $valuesArray = array_map('trim', explode(',', $value));
                                $valuesArray = array_filter($valuesArray, 'strlen');

                                if (!empty($valuesArray)) {
                                    // check all value in hasby exist in relation
                                    foreach ($valuesArray as $val) {
                                        $query->whereHas($relation, function (Builder $query) use ($relationAttribute, $val) {
                                            $query->where($relationAttribute, $val);
                                        });
                                    }
                                }
                            },
                            function (Builder $query) use ($attribute) {
                                $query->has($attribute);
                            }
                        );
                    });
                }
            }
            return $this;
        });

        Builder::macro('from', function (array $data, array $conditions) {
            foreach ($data as $key => $value) {
                if (empty($conditions[$key]) || empty($value)) {
                    continue;
                }

                $this->where(function (Builder $query) use ($key, $value, $conditions) {
                    $attribute = $conditions[$key];

                    if (!empty($value) && is_numeric($value)) {
                        $query->when(
                            str_contains($attribute, ':'),
                            function (Builder $query) use ($value, $attribute) {
                                [$relation, $column] = explode(':', $attribute);

                                $query->whereHas($relation, function (Builder $query) use ($value, $column) {
                                    $query->where($column, '>=', $value);
                                });
                            },
                            function (Builder $query) use ($value, $attribute) {
                                $query->where($attribute, '>=', $value);
                            }
                        );
                    }

                    if (!empty($value) && str_contains($value, '-')) {
                        [$year, $month, $day] = explode('-', $value);
                        $query->when(
                            str_contains($attribute, ':'),
                            function (Builder $query) use ($value, $attribute) {
                                [$year, $month, $day] = explode('-', $value);
                                [$relation, $column] = explode(':', $attribute);
                                if (!empty($year) && !empty($month) && !empty($day)) {
                                    $query->whereHas($relation, function (Builder $query) use ($value, $column) {
                                        $query->whereDate($column, '>=', $value);
                                    });
                                } else if (!empty($year) || !empty($month) || !empty($day)) {
                                    $query->whereHas($relation, function (Builder $query) use ($year, $month, $day, $column) {
                                        $year && $query->whereYear($column, '>=', $year);
                                        $month && $query->whereMonth($column, '>=', $month);
                                        $day && $query->whereDay($column, '>=', $day);
                                    });
                                } else {
                                    //else something
                                }
                            },
                            function (Builder $query) use ($value, $attribute) {
                                [$year, $month, $day] = explode('-', $value);
                                if (!empty($year) && !empty($month) && !empty($day)) {
                                    $query->whereDate($attribute, '>=', $value);
                                } else if (!empty($year) || !empty($month) || !empty($day)) {
                                    $year && $query->whereYear($attribute, '>=', $year);
                                    $month && $query->whereMonth($attribute, '>=', $month);
                                    $day && $query->whereDay($attribute, '>=', $day);
                                } else {
                                    //else something
                                }
                            }
                        );
                    }
                });
            }
            return $this;
        });

        Builder::macro('to', function (array $data, array $conditions) {
            foreach ($data as $key => $value) {
                if (empty($conditions[$key]) || empty($value)) {
                    continue;
                }
                $this->where(function (Builder $query) use ($key, $value, $conditions) {
                    $attribute = $conditions[$key];

                    if (!empty($value) && is_numeric($value)) {
                        $query->when(
                            str_contains($attribute, ':'),
                            function (Builder $query) use ($value, $attribute) {
                                [$relation, $column] = explode(':', $attribute);

                                $query->whereHas($relation, function (Builder $query) use ($value, $column) {
                                    $query->where($column, '<=', $value);
                                });
                            },
                            function (Builder $query) use ($value, $attribute) {
                                $query->where($attribute, '<=', $value);
                            }
                        );
                    }
                    if (!empty($value) && str_contains($value, '-')) {
                        $query->when(
                            str_contains($attribute, ':'),
                            function (Builder $query) use ($value, $attribute) {
                                [$year, $month, $day] = explode('-', $value);
                                [$relation, $column] = explode(':', $attribute);
                                if (!empty($year) && !empty($month) && !empty($day)) {
                                    $query->whereHas($relation, function (Builder $query) use ($value, $column) {
                                        $query->whereDate($column, '<=', $value);
                                    });
                                } else if (!empty($year) || !empty($month) || !empty($day)) {
                                    $query->whereHas($relation, function (Builder $query) use ($year, $month, $day, $column) {
                                        $year && $query->whereYear($column, '<=', $year);
                                        $month && $query->whereMonth($column, '<=', $month);
                                        $day && $query->whereDay($column, '<=', $day);
                                    });
                                } else {
                                    //else something
                                }
                            },
                            function (Builder $query) use ($value, $attribute) {
                                [$year, $month, $day] = explode('-', $value);
                                if (!empty($year) && !empty($month) && !empty($day)) {
                                    $query->whereDate($attribute, '<=', $value);
                                } else if (!empty($year) || !empty($month) || !empty($day)) {
                                    $year && $query->whereYear($attribute, '<=', $year);
                                    $month && $query->whereMonth($attribute, '<=', $month);
                                    $day && $query->whereDay($attribute, '<=', $day);
                                } else {
                                    //else something
                                }
                            }
                        );
                    }
                });
            }
            return $this;
        });

        Builder::macro('findInSet', function (array $data, array $conditions) {
            foreach ($data as $key => $value) {
                if (empty($value) || empty($conditions[$key])) {
                    continue;
                }
                $values = explode(',', $value);
                $this->where(function (Builder $query) use ($values, $conditions, $key) {
                    $column = $conditions[$key];
                    $query->when(
                        str_contains($column, ':'),
                        function (Builder $query) use ($column, $values) {
                            [$relation, $relationAttribute] = explode(':', $column);
                            $query->orWhereHas($relation, function (Builder $query) use (
                                $relationAttribute,
                                $values,
                            ) {
                                foreach ($values as $value) {
                                    $query->Where(DB::raw("FIND_IN_SET('{$value}', {$relationAttribute})"), ">", 0);
                                }
                            });
                        },
                        function (Builder $query) use ($values, $column) {
                            $this->where(function (Builder $query) use ($values, $column) {
                                foreach ($values as $value) {
                                    $query->Where(DB::raw("FIND_IN_SET('{$value}', {$column})"), ">", 0);
                                }
                            });
                        }

                    );
                });
            }
            return $this;
        });
    }
}
