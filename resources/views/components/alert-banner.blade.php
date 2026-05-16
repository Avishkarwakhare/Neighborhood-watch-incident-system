@props(['type' => 'success', 'message'])

@php
    $bgClass = match($type) {
        'success' => 'background: #EDF3EC; border-left: 4px solid #5C6B3A; color: #3B6D11;',
        'error'   => 'background: #FDF3F3; border-left: 4px solid #C94040; color: #A32D2D;',
        'warning' => 'background: #FEF9F1; border-left: 4px solid #E8A030; color: #B57B23;',
        default   => 'background: #F0F4F8; border-left: 4px solid #1E2A4A; color: #1E2A4A;',
    };
    
    $icon = match($type) {
        'success' => '<i class="ti ti-check" style="font-size:20px; flex-shrink:0;"></i>',
        'error'   => '<i class="ti ti-alert-circle" style="font-size:20px; flex-shrink:0;"></i>',
        'warning' => '<i class="ti ti-alert-triangle" style="font-size:20px; flex-shrink:0;"></i>',
        default   => '<i class="ti ti-info-circle" style="font-size:20px; flex-shrink:0;"></i>',
    };
@endphp

<div x-data="{ show: true }" 
     x-show="show" 
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform -translate-y-4"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="position: fixed; top: 20px; right: 20px; z-index: 9999; {{ $bgClass }} padding: 16px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 400px; display: flex; align-items: flex-start; gap: 12px;">
    
    {!! $icon !!}
    
    <div style="flex: 1; font-size: 14px; font-weight: 500; margin-top: 1px; line-height: 1.4;">
        {{ $message }}
    </div>

    <button @click="show = false" style="background:transparent; border:none; color:inherit; opacity:0.6; cursor:pointer; padding:0; display:flex; align-items:center; justify-content:center;">
        <i class="ti ti-x" style="font-size:16px;"></i>
    </button>
</div>
