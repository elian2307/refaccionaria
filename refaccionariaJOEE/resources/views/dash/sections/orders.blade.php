<h3>Quick resume</h3>

<section class="stats-grid">
    <div class="card">
        <h3><i class="fa-solid fa-ticket"></i> Active Orders</h3>
        <p class="value">{{ $orders->count() }}</p>
    </div>
    <div class="card">
        <h3><i class="fa-solid fa-sack-dollar"></i> Paid Orders</h3>
        <p class="value">{{ $orders->where('estado_pago', 'pagado')->count() }}</p>
    </div>
    <div class="card">
        <h3><i class="fa-solid fa-money-bill-transfer"></i> Refunded Orders</h3>
        <p class="value">{{ $orders->where('estado_pago', 'reembolsado')->count() }}</p>
    </div>
    <div class="card">
        <h3><i class="fa-regular fa-clock"></i> Pending Orders</h3>
        <p class="value">{{ $orders->where('estado_pago', 'pendiente')->count() }}</p>
    </div>
</section>

<h3>Sort by</h3>

<div class="filters">
    <div class="sort-container">
        <h4>Date:</h4>
        <select class="sort-selects" name="sort-time" id="sort-select">
            <option value="newest">Newest</option>
            <option value="oldest">Oldest</option>
        </select>
    </div>
    <div class="sort-container">
        <h4>Payment status:</h4>
        <select class="sort-selects" name="sort-level" id="sort-type">
            <option value="all">All</option>
            <option value="1">Pending</option>
            <option value="2">Done</option>
            <option value="0">Cancelled</option>
        </select>
    </div>
    <div class="sort-container">
        <h4>Shipping status:</h4>
        <select class="sort-selects" name="sort-level" id="sort-type">
            <option value="all">All</option>
            <option value="1">Pending</option>
            <option value="2">Done</option>
            <option value="0">Cancelled</option>
        </select>
    </div>
    <div class="sort-container2">
        <h4>Search</h4>
        <div class="search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="" id="" placeholder="Search something">
        </div>
    </div>
</div>

<h3>Results</h3>

<section class="order-container">
    @auth
        @foreach($orders as $order)
            <div class="order-card">
            <div class="order-header">
                <h3>
                <i class="fa-solid fa-ticket"></i>
                    Order {{ $order->id }} ({{ $order->numero_rastreo ?? 'No tracking' }})</h3>

                <span class=@if($order->estado_pago == 'pendiente') 'sec' @elseif($order->estado_pago == 'pagado') 'suc' @elseif($order->estado_pago == 'reembolsado') 'dan' @endif>
                    @if($order->estado_pago == 'pendiente')
                        <i class="fa-regular fa-clock"></i>
                    @elseif($order->estado_pago == 'pagado')
                        <i class="fa-solid fa-sack-dollar"></i>
                    @elseif($order->estado_pago == 'reembolsado')
                        <i class="fa-solid fa-money-bill-transfer"></i>
                    @endif  
                    {{ ucfirst($order->estado_pago) }}</span>
            </div>
            <div class="order-body">
                <p>Offer price: <b>${{ number_format($order->monto_total, 2) }}</b></p>
                <p>Order date: {{ \Carbon\Carbon::parse($order->fecha_pedido)->format('Y-m-d') }}</p>
            </div>
            <div class="order-actions">
                <button class="btn" onclick="openModal('detailsModalOrder_{{ $order->id }}')">Details</button>

                @if(in_array(auth()->user()->rol, ['admin', 'vendedor']))
                    <button class="btn" onclick="openModal('editModalOrder_{{ $order->id }}')">Edit</button>
                @endif
            </div>
        </div>

        <div id="detailsModalOrder_{{ $order->id }}" class="modal" style="display:none;">
            <div class="modal-content">
                <h2>Order Details</h2>
                <div class="modal-grid">
                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                    <p><strong>Tracking Number:</strong> {{ $order->numero_rastreo ?? 'Not assigned' }}</p>
                    <p><strong>Payment Status:</strong> <span class="sec">{{ ucfirst($order->estado_pago) }}</span></p>
                    <p><strong>Shipping Status:</strong> <span class="sec">{{ ucfirst($order->estado_envio) }}</span></p>
                    <p><strong>Total Amount:</strong> ${{ number_format($order->monto_total, 2) }}</p>
                    <p><strong>Commission:</strong> ${{ number_format($order->monto_comision, 2) }}</p>
                    <p><strong>Order Date:</strong> {{ $order->fecha_pedido }}</p>
                </div>
                <button class="btn" onclick="closeModal('detailsModalOrder_{{ $order->id }}')">Close</button>
            </div>
        </div>

        @if(in_array(auth()->user()->rol, ['admin', 'vendedor']))
            <div id="editModalOrder_{{ $order->id }}" class="modal" style="display:none;">
                <div class="modal-content">
                    <h2>Edit Order</h2>
                    <form class="edit-order-form" id="formEditOrder_{{ $order->id }}">
                        <div class="form-group">
                            <label>Tracking Number</label>
                            <input type="text" name="numero_rastreo" value="{{ $order->numero_rastreo }}" class="edit-input">
                        </div>

                        <div class="form-group">
                            <label>Payment Status</label>
                            <select name="estado_pago" class="edit-input eis">
                                <option value="pendiente" {{ $order->estado_pago == 'pendiente' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="pagado" {{ $order->estado_pago == 'pagado' ? 'selected' : '' }}>Paid</option>
                                <option value="reembolsado" {{ $order->estado_pago == 'reembolsado' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Shipping Status</label>
                            <select name="estado_envio" class="edit-input eis">
                                <option value="pendiente" {{ $order->estado_envio == 'pendiente' ? 'selected' : '' }}>Pending</option>
                                <option value="enviado" {{ $order->estado_envio == 'enviado' ? 'selected' : '' }}>Shipped</option>
                                <option value="entregado" {{ $order->estado_envio == 'entregado' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </div>

                        <div id="orderEditErrors_{{ $order->id }}" style="margin: 1rem 0;"></div>

                        <button type="button" class="btn btn-save-order" data-id="{{ $order->id }}">
                            Save Changes
                        </button>
                    </form>

                    @if(auth()->user()->rol === 'admin')
                        <button class="btn dan" onclick="openModal('deleteModalOrder_{{ $order->id }}')">Delete Order</button>
                    @endif

                    <button class="btn" onclick="closeModal('editModalOrder_{{ $order->id }}')">Close</button>
                </div>
            </div>
        @endif

        @if(auth()->user()->rol === 'admin')
            <div id="deleteModalOrder_{{ $order->id }}" class="modal" style="display:none;">
                <div class="modal-content">
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete Order {{ $order->id }}?</p>
                    <button class="btn dan" onclick="deleteOrder({{ $order->id }})">Yes, Delete</button>
                    <button class="btn" onclick="closeModal('deleteModalOrder_{{ $order->id }}')">Cancel</button>
                </div>
            </div>
        @endif
    @endforeach
    @endauth

</section>