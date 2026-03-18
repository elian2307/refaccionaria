<h3>Quick resume</h3>

<section class="stats-grid">
    <div class="card">
        <h3>Active Auctions</h3>
        <p class="value">{{ $auctions->where('estado', 'abierta')->count() }}</p>
    </div>
    <div class="card">
        <h3>Completed Auctions</h3>
        <p class="value">{{ $auctions->where('estado', 'finalizada')->count() }}</p>
    </div>
    <div class="card">
        <h3>Cancelled Auctions</h3>
        <p class="value">{{ $auctions->where('estado', 'cancelada')->count() }}</p>
    </div>
</section>

@if(in_array(auth()->user()->rol, ['admin', 'vendedor']))
    <h3>Create auction</h3>

    <div class="filters">
        <form id="formCreateAuction" style="width: 100%;">
            @csrf

            <div class="filters">
                <div class="sort-container">
                    <h4>User:</h4>
                    <select class="sort-selects" name="user_id" required>
                        <option value="">Select user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                #{{ $user->id }} - {{ $user->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sort-container">
                    <h4>Brand:</h4>
                    <input class="sort-selects" type="text" name="marca_vehiculo" required>
                </div>

                <div class="sort-container">
                    <h4>Model:</h4>
                    <input class="sort-selects" type="text" name="modelo_vehiculo" required>
                </div>

                <div class="sort-container">
                    <h4>Year:</h4>
                    <input class="sort-selects" type="text" name="anio_vehiculo" required>
                </div>

                <div class="sort-container">
                    <h4>Part name:</h4>
                    <input class="sort-selects" type="text" name="nombre_refaccion" required>
                </div>

                <div class="sort-container">
                    <h4>Priority:</h4>
                    <select class="sort-selects" name="urgencia" required>
                        <option value="baja">Low</option>
                        <option value="media">Medium</option>
                        <option value="alta">High</option>
                    </select>
                </div>

                <div class="sort-container">
                    <h4>Status:</h4>
                    <select class="sort-selects" name="estado" required>
                        <option value="abierta">Open</option>
                        <option value="cerrada">Closed</option>
                        <option value="cancelada">Cancelled</option>
                        <option value="finalizada">Completed</option>
                    </select>
                </div>

                <div class="sort-container">
                    <h4>Expiration date:</h4>
                    <input class="sort-selects" type="date" name="fecha_expiracion">
                </div>
            </div>

            <div style="margin-top: 1rem;">
                <h4>Description:</h4>
                <textarea class="sort-selects" name="descripcion_problema" rows="4" style="width: 100%;" required></textarea>
            </div>

            <div id="auctionErrors" style="margin: 1rem 0;"></div>

            <button type="button" class="btn" onclick="createAuction()">Create auction</button>
        </form>
    </div>
@endif

<h3>Results</h3>

<section class="auction-container">
    @foreach ($auctions as $auction)
        @php
            $user = $users->firstWhere('id', $auction->user_id);
        @endphp

        <div class="auction-card">
            <div class="autismo">
                <div class="auctionleft">
                    <div class="auction-header">
                        <h3>{{ $auction->marca_vehiculo }} {{ $auction->modelo_vehiculo }} {{ $auction->anio_vehiculo }}</h3>
                    </div>
                    <div class="auction-body">
                        <p>Piece: <b>{{ $auction->nombre_refaccion }}</b></p>
                        <p>User: <b>{{ $user->nombre ?? 'N/A' }}</b></p>
                        <p>Priority: <b>{{ ucfirst($auction->urgencia) }}</b></p>
                        <p>Expiration date: {{ $auction->fecha_expiracion ?? 'N/A' }}</p>
                        <p>Status:
                            <span class="suc">
                                <b>{{ ucfirst($auction->estado) }}</b>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="auctionright">
                    <img src="{{ asset('/joee/img/default.jpg') }}" alt="">
                </div>
            </div>

            <div class="auction-actions">
                <button class="btn" onclick="openModal('detailsModalAuction{{ $auction->id }}')">Details</button>
            </div>
        </div>

        <div id="detailsModalAuction{{ $auction->id }}" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('detailsModalAuction{{ $auction->id }}')">&times;</span>
                <h3>Auction Details #{{ $auction->id }}</h3>

                <form id="formEditAuction_{{ $auction->id }}">
                    @csrf

                    <div class="form-group">
                        <label>User</label>
                        <select name="user_id" class="edit-input eis" required>
                            @foreach ($users as $userOption)
                                <option value="{{ $userOption->id }}" {{ $auction->user_id == $userOption->id ? 'selected' : '' }}>
                                    #{{ $userOption->id }} - {{ $userOption->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" name="marca_vehiculo" class="edit-input" value="{{ $auction->marca_vehiculo }}" required>
                    </div>

                    <div class="form-group">
                        <label>Model</label>
                        <input type="text" name="modelo_vehiculo" class="edit-input" value="{{ $auction->modelo_vehiculo }}" required>
                    </div>

                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="anio_vehiculo" class="edit-input" value="{{ $auction->anio_vehiculo }}" required>
                    </div>

                    <div class="form-group">
                        <label>Part name</label>
                        <input type="text" name="nombre_refaccion" class="edit-input" value="{{ $auction->nombre_refaccion }}" required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="descripcion_problema" class="edit-input" rows="4" required>{{ $auction->descripcion_problema }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Priority</label>
                        <select name="urgencia" class="edit-input eis" required>
                            <option value="baja" {{ $auction->urgencia == 'baja' ? 'selected' : '' }}>Low</option>
                            <option value="media" {{ $auction->urgencia == 'media' ? 'selected' : '' }}>Medium</option>
                            <option value="alta" {{ $auction->urgencia == 'alta' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="estado" class="edit-input eis" required>
                            <option value="abierta" {{ $auction->estado == 'abierta' ? 'selected' : '' }}>Open</option>
                            <option value="cerrada" {{ $auction->estado == 'cerrada' ? 'selected' : '' }}>Closed</option>
                            <option value="cancelada" {{ $auction->estado == 'cancelada' ? 'selected' : '' }}>Cancelled</option>
                            <option value="finalizada" {{ $auction->estado == 'finalizada' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Expiration date</label>
                        <input type="date" name="fecha_expiracion" class="edit-input" value="{{ $auction->fecha_expiracion }}">
                    </div>

                    <div id="auctionEditErrors_{{ $auction->id }}" style="margin: 1rem 0;"></div>

                    @if(in_array(auth()->user()->rol, ['admin', 'vendedor']))
                        <div class="modal-actions">
                            <button type="button" class="btn btn-save-auction" data-id="{{ $auction->id }}">Save changes</button>
                            <button type="button" class="btn dan" onclick="openModal('deleteModalAuction{{ $auction->id }}')">Delete</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
        @if(in_array(auth()->user()->rol, ['admin', 'vendedor']))
            <div id="deleteModalAuction{{ $auction->id }}" class="modal">
                <div class="modal-content">
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete Auction {{ $auction->id }}?</p>

                    <button class="btn dan" onclick="deleteAuction({{ $auction->id }})">
                        Yes, Delete
                    </button>

                    <button class="btn" onclick="closeModal('deleteModalAuction{{ $auction->id }}')">
                        Cancel
                    </button>
                </div>
            </div>
        @endif
    @endforeach
</section>