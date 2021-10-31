<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\CalendarDate
 *
 * @property int $id
 * @property string $date
 * @property int $is_work_day
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarDate query()
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarDate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalendarDate whereIsWorkDay($value)
 */
	class CalendarDate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ClockLog
 *
 * @property int $id
 * @property int $user_id
 * @property int $type 1 上班 2 下班
 * @property string $status
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClockLog whereUserId($value)
 */
	class ClockLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NueipUser
 *
 * @property int $user_id
 * @property string|null $company
 * @property string|null $account
 * @property string|null $password
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|NueipUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NueipUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NueipUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|NueipUser whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NueipUser whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NueipUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NueipUser whereUserId($value)
 */
	class NueipUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\NueipUser|null $nueipUser
 * @property-read \App\Models\UserSetting|null $setting
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserSetting
 *
 * @property int $user_id
 * @property string|null $line_notify_token
 * @property int $auto_clock_in
 * @property int $auto_clock_out
 * @property string|null $clock_in_time
 * @property string|null $clock_out_time
 * @property float $lat 打卡位置
 * @property float $lng 打卡位置
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereAutoClockIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereAutoClockOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereClockInTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereClockOutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereLineNotifyToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereUserId($value)
 */
	class UserSetting extends \Eloquent {}
}

