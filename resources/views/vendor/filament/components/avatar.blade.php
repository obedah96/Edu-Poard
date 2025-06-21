@props([
    'circular' => true,   // افتراضياً الصورة ستكون دائرية
    'size' => 'md',       // الافتراضي هو الحجم المتوسط
    'src' => '',          // إضافة `src` لتمرير رابط الصورة
])

<img
    {{ $attributes->class([
        'fi-avatar object-cover object-center',
        'rounded-md' => ! $circular,  // إذا كانت `circular` false
        'rounded-full' => $circular,  // إذا كانت `circular` true
        match ($size) {
            'sm' => 'h-6 w-6',
            'md' => 'h-8 w-8',
            'lg' => 'h-10 w-10',
            default => $size,
        },
    ]) }}
    src="{{ $src }}"
    alt="User Avatar"
/>
