@props(['status', 'type' => 'order'])

@php
    $classes = 'status-badge ';
    
    switch($type) {
        case 'order':
            switch($status) {
                case 'pending':
                    $classes .= 'status-pending';
                    break;
                case 'processing':
                case 'confirmed':
                    $classes .= 'status-processing';
                    break;
                case 'shipped':
                    $classes .= 'status-shipped';
                    break;
                case 'delivered':
                    $classes .= 'status-delivered';
                    break;
                case 'cancelled':
                case 'refunded':
                    $classes .= 'status-cancelled';
                    break;
                default:
                    $classes .= 'status-pending';
            }
            break;
            
        case 'product':
            switch($status) {
                case 'active':
                case 'published':
                    $classes .= 'status-active';
                    break;
                case 'inactive':
                case 'unpublished':
                    $classes .= 'status-inactive';
                    break;
                case 'draft':
                    $classes .= 'status-draft';
                    break;
                default:
                    $classes .= 'status-inactive';
            }
            break;
            
        case 'verification':
            switch($status) {
                case 'verified':
                case 'approved':
                    $classes .= 'status-verified';
                    break;
                case 'rejected':
                case 'declined':
                    $classes .= 'status-rejected';
                    break;
                case 'pending':
                default:
                    $classes .= 'status-pending';
            }
            break;
            
        default:
            $classes .= 'status-pending';
    }
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ ucfirst($status) }}
</span>
