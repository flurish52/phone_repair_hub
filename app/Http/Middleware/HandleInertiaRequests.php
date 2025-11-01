<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        if (! $user) {
            return [
                'auth' => ['user' => null],
            ];
        }

        $roles = $user->getRoleNames()->toArray();  // e.g. ['vendor']
        $singleRole = $roles[0] ?? null;

        return [
            'auth' => [
                'user' => array_merge(
                    $user->toArray(),
                    ['role' => $singleRole]
                ),
            ],
        ];
    }

}
