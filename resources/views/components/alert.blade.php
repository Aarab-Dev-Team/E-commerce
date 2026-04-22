@props(['type' => 'info', 'message' => '', 'icon' => null])

@php
    $icons = [
        'success' => 'iconoir-check-circle',
        'error'   => 'iconoir-warning-circle',
        'warning' => 'iconoir-warning-triangle',
        'info'    => 'iconoir-info-circle',
    ];
    $icon = $icon ?? $icons[$type] ?? 'iconoir-info-circle';
@endphp

<div x-data="{ show: true }" x-show="show" x-transition.duration.300ms
     class="alert alert-{{ $type }}"
     style="display: flex; align-items: center; justify-content: space-between; 
            padding: 16px 20px ;
            background-color: var(--alert-bg, #f0f0f0); 
            color: var(--alert-text, #1a1a1a);
        
          ">
    
    <div style="display: flex; align-items: center; gap: 12px;">
        <i class="{{ $icon }}" style="font-size: 20px; flex-shrink: 0;"></i>
        <span>{{ $message }}</span>
    </div>
    
    <button type="button" @click="show = false" 
            style="background: none; border: none; cursor: pointer; font-size: 20px; line-height: 1; color: inherit; opacity: 0.7;">
        &times;
    </button>
</div>