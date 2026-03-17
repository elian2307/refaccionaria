<h3>Quick resume</h3>

<section class="stats-grid">
    <div class="card">
        <h3>Active Offers</h3>
        <p class="value">{{ $offers->count() }}</p>
    </div>
    <div class="card">
        <h3>Declined Offers</h3>
        <p class="value">{{ $offers->where('es_aceptada', 0)->count() }}</p>
    </div>
    <div class="card">
        <h3>Accepted Offers</h3>
        <p class="value">{{ $offers->where('es_aceptada', 1)->count() }}</p>
    </div>
</section>

<h3>Create offer</h3>

<div class="filters">
    <form id="formCreateOffer" style="width: 100%;">
        @csrf

        <div class="filters">
            <div class="sort-container">
                <h4>Auction:</h4>
                <select class="sort-selects" name="subasta_id" required>
                    <option value="">Select auction</option>
                    @foreach ($auctions as $auction)
                        <option value="{{ $auction->id }}">
                            #{{ $auction->id }} - {{ $auction->marca_vehiculo }} {{ $auction->modelo_vehiculo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sort-container">
                <h4>Provider:</h4>
                <select class="sort-selects" name="proveedor_id" required>
                    <option value="">Select provider</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            #{{ $user->id }} - {{ $user->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sort-container">
                <h4>Price:</h4>
                <input class="sort-selects" type="number" step="0.01" min="0" name="precio_ofertado" required>
            </div>

            <div class="sort-container">
                <h4>Days:</h4>
                <input class="sort-selects" type="number" min="0" name="dias_entrega" required>
            </div>

            <div class="sort-container">
                <h4>Condition:</h4>
                <select class="sort-selects" name="condicion_pieza" required>
                    <option value="nueva">Nueva</option>
                    <option value="usada">Usada</option>
                    <option value="reconstruida">Reconstruida</option>
                </select>
            </div>

            <div class="sort-container">
                <h4>Warranty:</h4>
                <input class="sort-selects" type="number" min="0" name="meses_garantia" required>
            </div>

            <div class="sort-container">
                <h4>Accepted:</h4>
                <select class="sort-selects" name="es_aceptada" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="sort-container">
                <h4>Date:</h4>
                <input class="sort-selects" type="date" name="fecha_oferta" required>
            </div>
        </div>

        <div id="offerErrors" style="margin: 1rem 0;"></div>

        <button type="button" class="btn" onclick="createOffer()">Create offer</button>
    </form>
</div>

<h3>Results</h3>

<section class="offer-container">
    @foreach ($offers as $offer)
        @php
            $auction = $auctions->firstWhere('id', $offer->subasta_id);
            $provider = $users->firstWhere('id', $offer->proveedor_id);
        @endphp

        <div class="offer-card">
            <div class="offer-header">
                <h3>Auction {{ $offer->subasta_id }} - Offer {{ $offer->id }}</h3>
                <span class="sec">{{ $offer->es_aceptada ? 'Accepted' : 'Pending' }}</span>
            </div>
            <div class="offer-body">
                <p>Provider: <b>{{ $provider->nombre ?? 'N/A' }}</b></p>
                <p>Offer price: <b>${{ $offer->precio_ofertado }}</b></p>
                <p>Delivery days: {{ $offer->dias_entrega }}</p>
                <p>Condition: {{ $offer->condicion_pieza }}</p>
                <p>Warranty: {{ $offer->meses_garantia }} months</p>
                <p>Offer date: {{ \Carbon\Carbon::parse($offer->fecha_oferta)->format('Y-m-d') }}</p>
                @if($auction)
                    <p>Vehicle: {{ $auction->marca_vehiculo }} {{ $auction->modelo_vehiculo }}</p>
                @endif
            </div>
            <div class="offer-actions">
                <button class="btn" onclick="openModal('detailsModalOffer{{ $offer->id }}')">Details</button>
            </div>
        </div>

        <div id="detailsModalOffer{{ $offer->id }}" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('detailsModalOffer{{ $offer->id }}')">&times;</span>
                <h3>Offer Details #{{ $offer->id }}</h3>

                <form id="formEditOffer_{{ $offer->id }}">
                    @csrf

                    <div class="form-group">
                        <label>Auction</label>
                        <select name="subasta_id" class="edit-input eis" required>
                            @foreach ($auctions as $auctionOption)
                                <option value="{{ $auctionOption->id }}" {{ $offer->subasta_id == $auctionOption->id ? 'selected' : '' }}>
                                    #{{ $auctionOption->id }} - {{ $auctionOption->marca_vehiculo }} {{ $auctionOption->modelo_vehiculo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Provider</label>
                        <select name="proveedor_id" class="edit-input eis" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $offer->proveedor_id == $user->id ? 'selected' : '' }}>
                                    #{{ $user->id }} - {{ $user->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="0.01" min="0" name="precio_ofertado" class="edit-input" value="{{ $offer->precio_ofertado }}" required>
                    </div>

                    <div class="form-group">
                        <label>Delivery days</label>
                        <input type="number" min="0" name="dias_entrega" class="edit-input" value="{{ $offer->dias_entrega }}" required>
                    </div>

                    <div class="form-group">
                        <label>Condition</label>
                        <select name="condicion_pieza" class="edit-input eis" required>
                            <option value="nueva" {{ $offer->condicion_pieza == 'nueva' ? 'selected' : '' }}>Nueva</option>
                            <option value="usada" {{ $offer->condicion_pieza == 'usada' ? 'selected' : '' }}>Usada</option>
                            <option value="reconstruida" {{ $offer->condicion_pieza == 'reconstruida' ? 'selected' : '' }}>Reconstruida</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Warranty months</label>
                        <input type="number" min="0" name="meses_garantia" class="edit-input" value="{{ $offer->meses_garantia }}" required>
                    </div>

                    <div class="form-group">
                        <label>Accepted</label>
                        <select name="es_aceptada" class="edit-input eis" required>
                            <option value="0" {{ !$offer->es_aceptada ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $offer->es_aceptada ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="fecha_oferta" class="edit-input" value="{{ \Carbon\Carbon::parse($offer->fecha_oferta)->format('Y-m-d') }}" required>
                    </div>

                    <div id="offerEditErrors_{{ $offer->id }}" style="margin: 1rem 0;"></div>

                    <div class="modal-actions">
                        <button type="button" class="btn btn-save-offer" data-id="{{ $offer->id }}">Save changes</button>
                        <button type="button" class="btn dan" onclick="deleteOffer({{ $offer->id }})">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</section>