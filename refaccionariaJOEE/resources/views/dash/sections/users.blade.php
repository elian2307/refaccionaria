<h3>Quick resume</h3>

<section class="stats-grid">
    <div class="card">
        <h3>Total Users</h3>
        <p class="value">241</p>
    </div>
    <div class="card">
        <h3>Total Sellers</h3>
        <p class="value">12</p>
    </div>
    <div class="card">
        <h3>Total Adminstrators</h3>
        <p class="value">2</p>
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
        <h4>Level:</h4>
        <select class="sort-selects" name="sort-level" id="sort-type">
            <option value="all">All</option>
            <option value="users">Only user</option>
            <option value="seller">Only seller</option>
            <option value="admin">Only admin</option>
        </select>
    </div>
    <div class="sort-container2">
        <h4>Search</h4>
        <div class="search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="" id="" placeholder="Search someone">
        </div>
    </div>
</div>

<h3>Results</h3>

<section class="users-container">
        @foreach($users as $user)
            <div class="user-card">
                <div class="user-header">
                    <h3>{{ $user->nombre }}</h3>
                    <span class="sec">{{ ucfirst($user->tipo_usuario) }}</span>
                </div>
                <div class="user-body">
                    <p>Reputation: <span class="suc">{{ $user->reputacion }} ★</span></p>
                    <p>Joined: {{ $user->created_at?->format('Y-m-d') ?? 'No date' }}</p>
                </div>
                <div class="user-actions">
                    <button class="btn" onclick="openModal('detailsModal_{{ $user->id }}')">Details</button>
                    <button class="btn" onclick="openModal('editModal_{{ $user->id }}')">Edit</button>
                </div>
            </div>

            <div id="detailsModal_{{ $user->id }}" class="modal" style="display:none;">
                <div class="modal-content">
                    <h2>User Details</h2>
                    <div class="modal-grid">
                        <p><strong>Name:</strong> {{ $user->nombre }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Level:</strong> <span class="sec">{{ ucfirst($user->tipo_usuario) }}</span></p>
                        <p><strong>Fiscal ID:</strong> {{ $user->id_fiscal }}</p>
                        <p><strong>Phone number:</strong> {{ $user->telefono }}</p>
                        <p><strong>Reputation:</strong> <span class="suc">{{ $user->reputacion }}</span></p>
                        <p><strong>Premium:</strong> <span
                                class="{{ $user->is_premium ? 'suc' : 'sec' }}">{{ $user->is_premium ? 'Activated' : 'Inactive' }}</span>
                        </p>
                        <p><strong>Joined at:</strong> {{ $user->created_at?->format('Y-m-d') ?? 'No date' }}</p>
                        <p><strong>Addresses:</strong> <span class="sec"
                                onclick="openModal('addressesModal_{{ $user->id }}')" style="cursor:pointer;">Show</span>
                        </p>
                    </div>
                    <button class="btn" onclick="closeModal('detailsModal_{{ $user->id }}')">Close</button>
                </div>
            </div>

            <div id="addressesModal_{{ $user->id }}" class="modal" style="display:none;">
                <div class="modal-content">
                    <h2>User Addresses</h2>
                    <div class="modal-grid">
                        <p>Las direcciones de {{ $user->nombre }} irán aquí...</p>
                    </div>
                    <button class="btn" onclick="closeModal('addressesModal_{{ $user->id }}')">Close</button>
                </div>
            </div>

            <div id="editModal_{{ $user->id }}" class="modal" style="display:none;">
                <div class="modal-content">
                    <h2>Edit User</h2>
                    <form class="edit-user-form" id="formEdit_{{ $user->id }}">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="nombre" value="{{ $user->nombre }}" class="edit-input">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="edit-input">
                        </div>

                        <div class="form-group">
                            <label>Level</label>
                            <select name="tipo_usuario" class="edit-input eis">  
                                <option value="vendedor" {{ $user->tipo_usuario == 'vendedor' ? 'selected' : '' }}>Seller
                                </option>
                                <option value="admin" {{ $user->tipo_usuario == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="usuario" {{ $user->tipo_usuario == 'usuario' ? 'selected' : '' }}>User
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Fiscal ID</label>
                            <input type="text" name="id_fiscal" value="{{ $user->id_fiscal }}" class="edit-input">
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="telefono" value="{{ $user->telefono }}" class="edit-input">
                        </div>

                        <div class="form-group">
                            <label>Reputation (0-5)</label>
                            <input type="number" name="reputacion" value="{{ $user->reputacion }}" step="0.1" min="0"
                                max="5" class="edit-input">
                        </div>

                        <div class="form-group-checkbox">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="is_premium" value="1" {{ $user->is_premium ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                Premium Account
                            </label>
                        </div>

                        <button type="button" class="btn btn-save-user" data-id="{{ $user->id }}">
                            Save Changes
                        </button>
                    </form>

                    <button class="btn dan" onclick="openModal('deleteModal_{{ $user->id }}')">Delete User</button>
                    <button class="btn" onclick="closeModal('editModal_{{ $user->id }}')">Close</button>
                </div>
            </div>

        @endforeach
</section>