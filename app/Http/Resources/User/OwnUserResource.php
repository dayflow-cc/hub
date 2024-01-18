<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var OwnUserResource|User $this */
        return [
            'id' => $this->getRouteKey(),
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'emailVerifiedAt' => $this->when($this->email_verified_at, fn() => $this->email_verified_at->toIso8601String()),
            'loginCount' => $this->login_count ?? 0,
            'lastLoginAt' => $this->when($this->last_login_at, fn() => $this->last_login_at->toIso8601String()),
            'languageIso' => $this->preferredLocale(),
            'settings' => $this->settings->toArray(),
        ];
    }
}
