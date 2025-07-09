<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'Super Admin';
    case COMPANY_ADMIN = 'Company Admin';
    case STANDARD = 'Standard';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toArray(): array
    {
        $data = [];

        foreach (RoleEnum::cases() as $types) {
            $data[] = [
                'name' => $types->name,
                'label' => $types->value,
            ];
        }

        return $data ?? [];
    }

    public static function types(): array
    {
        return RoleEnum::collect()->pluck('name')->toArray();
    }

    public static function collect(): Collection
    {
        return collect(self::toArray());
    }

    public static function fromName(string $name): ?array
    {
        return self::collect()->filter(function ($value, $key) use ($name) {
            return $value['name'] === $name;
        })->first();
    }
}
