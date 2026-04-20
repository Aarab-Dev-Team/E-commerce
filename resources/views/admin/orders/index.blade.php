{{-- <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
    @csrf @method('PATCH')
    <select name="status" onchange="this.form.submit()" class="text-xs rounded border-gray-300">
        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
</form> --}}