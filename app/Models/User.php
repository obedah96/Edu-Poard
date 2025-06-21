<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use Notifiable,HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function client()
    {
        return $this->hasOne(\App\Models\Client::class);
    }

    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

   public function getFilamentAvatarUrl(): ?string
    {
        // تحقق من دور المستخدم واجلب الصورة المناسبة
        if ($this->admin && $this->admin->avatar) {
            return Storage::url($this->admin->avatar);
        } elseif ($this->owner && $this->owner->avatar) {
            return Storage::url($this->owner->avatar);
        }
        // إذا كان لدى العميل شعار (شعار الشركة) وليس صورة أفاتار خاصة
        // يمكنك تعديل هذا السلوك حسب حاجتك
        elseif ($this->client && $this->client->logo) {
            return Storage::url($this->client->logo);
        }

        // إذا لم يتم العثور على صورة، يمكن لـ Filament استخدام ui-avatars.com تلقائيًا
        // أو يمكنك توفير رابط صورة افتراضية هنا
        return null; // سيؤدي هذا إلى استخدام مزود الأفاتار الافتراضي (مثل ui-avatars.com)
    }

    public function canAccessPanel(Panel $panel): bool
{
    // عدّل بحسب حاجتك: هنا نسمح لكل المستخدمين
    return true;
}
}
