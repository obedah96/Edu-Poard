{{-- resources/views/filament/admin/partials/sidebar-header.blade.php --}}

@php
    $user = auth()->user();
    $avatarUrl = $user ? $user->getFilamentAvatarUrl() : null;
@endphp

<div class="flex flex-col items-center justify-center p-4 mb-4">
    @if ($avatarUrl)
        <img
            src="{{ $avatarUrl }}"
            alt="{{ $user->name ?? 'User Avatar' }}"
            {{-- إضافة الأنماط المضمنة هنا --}}
            style="
                width: 150px !important;    /* 6rem = 96px */
                height: 150px !important;   /* يجب أن تكون متطابقة تمامًا للعرض */
                border-radius: 50% !important; /* 50% أو 9999px يعمل كدائري كامل */
                object-fit: cover !important;
                object-position: center !important;
                flex-shrink: 0 !important;
                flex-grow: 0 !important;
                display: block !important;
            "
            class="fi-user-avatar" {{-- احتفظ بالفئة لأي CSS إضافي مثل الظل أو الحلقة --}}
        />
    @else
        <div
            {{-- إضافة الأنماط المضمنة للـ div البديل --}}
            style="
                width: 96px !important;
                height: 96px !important;
                max-width: 96px !important;
                min-width: 96px !important;
                border-radius: 50% !important;
                flex-shrink: 0 !important;
                flex-grow: 0 !important;
                font-size: 3rem !important; /* تكبير حجم الخط البديل */
                line-height: 1 !important;  /* لضبط محاذاة النص العمودية */
            "
            class="fi-user-avatar flex items-center justify-center bg-gray-200 text-gray-700"
        >
            {{ substr($user->name ?? '', 0, 1) }}
        </div>
    @endif

    <span class="mt-3 text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name ?? 'Guest' }}</span>

</div>
