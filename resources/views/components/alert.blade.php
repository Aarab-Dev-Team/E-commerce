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

<div x-data="{ show: true }" 
     x-show="show" 
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="alert alert-{{ $type }}"
     style="display: flex; align-items: center; justify-content: space-between; 
            padding: 16px 20px ;
            background-color: var(--alert-bg, #f0f0f0); 
            color: var(--alert-text, #1a1a1a);
            border-radius: 4px;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
          ">
    
    <div style="display: flex; align-items: center; gap: 12px;">
        <i class="{{ $icon }}" style="font-size: 20px; flex-shrink: 0;"></i>
        <span style="font-size: 14px; font-weight: 400;">{{ $message }}</span>
    </div>
    
    <button type="button" 
            @click="show = false" 
            onclick="this.closest('.alert').style.display='none'"
            style="background: none; border: none; cursor: pointer; font-size: 20px; line-height: 1; color: inherit; opacity: 0.5; transition: opacity 0.2s;"
            onmouseover="this.style.opacity=1"
            onmouseout="this.style.opacity=0.5">
        &times;
    </button>
</div>

<script>
    // Vanilla JS fallback for auto-dismiss if Alpine is not loaded
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert.style.display !== 'none') {
                alert.style.transition = 'opacity 0.3s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        });
    }, 5000);
</script>