<?php
namespace Enum;

class Status {
    const INACTIVE = 'inactive';
    const ACTIVE = 'active';
    const TRAINING = 'training';

    static function convert_to_enum(int $id_status): string {
        if($id_status == 1)
            return self::ACTIVE;
        elseif ($id_status == 2)
            return self::TRAINING;
        else
            return self::INACTIVE;
    }

    static function convert_to_id_status(string $status): int {
        if($status == self::ACTIVE)
            return 1;
        elseif ($status == self::TRAINING)
            return 2;
        else
            return 0;
    }

    static function is_valid(string $status): bool {
        return $status == self::INACTIVE || $status == self::ACTIVE || $status == self::TRAINING;
    }
}