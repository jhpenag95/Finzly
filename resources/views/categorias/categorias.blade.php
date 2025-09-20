@extends('components.plantillabase')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/categorias/categorias.css') }}">
    <link rel="stylesheet" href="{{ asset('css/categorias/responsi_categorias.css') }}">
    <link rel="stylesheet" href="{{ asset('css/categorias/modal_categorias.css') }}">
    <link rel="stylesheet" href="{{ asset('css/categorias/responsi_modal_categorias.css') }}">
@endpush

@section('content')
    <div class="categorias-container">
        <form action="" class="config-form">
            <div class="categories-tab">
                <h3>Gestión de Categorías</h3>
                <div class="section-description">
                    <p>
                        En esta sección, puedes gestionar tus categorías de gastos. Puedes agregar nuevas categorías, editar
                        las existentes y eliminar aquellas que ya no necesites.
                    </p>
                </div>

                {{-- Listado de Categorías --}}

                <div class="categories-list">
                    <div class="category-item">
                        <div class="category-color"></div>
                        <div class="category-name">Servicios</div>
                        <div class="category-actions">
                            <button type="button" class="edit-category" onclick="openModal()">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Botón para agregar categoría --}}

                <div class="cont_add">
                    <button type="button" class="add-category-btn" onclick="openCreateModal()">
                        <i class="fas fa-plus"></i> Agregar Categoría
                    </button>
                </div>


                <!-- Modal para crear categoría -->
                <div class="category-modal" id="create-category-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Crear Nueva Categoría</h3>
                            <button class="close-modal" onclick="closeCreateModal(event)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="create-category-form">
                                <div class="form-group">
                                    <label for="create-category-name-input">Nombre</label>
                                    <input type="text" id="create-category-name-input" placeholder="Nombre de la categoría">
                                </div>

                                <div class="form-group">
                                    <label for="create-category-color-input">Color</label>
                                    <input type="color" id="create-category-color-input" value="#3498db">
                                </div>

                                <div class="form-group">
                                    <label for="create-category-icon">Ícono</label>
                                    <div class="icon-selector">
                                        <div class="selected-icon">
                                            <i class="fas fa-bolt" id="create-selected-icon-preview"></i>
                                            <input type="hidden" id="create-category-icon" value="fa-bolt">
                                        </div>
                                        <button type="button" class="btn btn-outline" id="create-change-icon-btn" onclick="showCreateIconsGrid()">
                                            Cambiar ícono
                                        </button>
                                    </div>
                                    <div class="icons-grid" id="create-icons-grid">
                                        <button type="button" class="icon-option" data-icon="fa-home"><i
                                                class="fas fa-home"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-bolt"><i
                                                class="fas fa-bolt"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-tv"><i
                                                class="fas fa-tv"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-money-bill-wave"><i
                                                class="fas fa-money-bill-wave"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-university"><i
                                                class="fas fa-university"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-utensils"><i
                                                class="fas fa-utensils"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-gamepad"><i
                                                class="fas fa-gamepad"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-medkit"><i
                                                class="fas fa-medkit"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-plane"><i
                                                class="fas fa-plane"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-car"><i
                                                class="fas fa-car"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-graduation-cap"><i
                                                class="fas fa-graduation-cap"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-shopping-cart"><i
                                                class="fas fa-shopping-cart"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" id="create-cancel-category" onclick="closeCreateModal()">Cancelar</button>
                            <button class="btn btn-primary" id="create-save-category">Crear Categoría</button>
                        </div>
                    </div>
                </div>

                <!-- Modal para editar categoría -->
                <div class="category-modal" id="category-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Editar Categoría</h3>
                            <button class="close-modal" onclick="closeModal(event)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="category-form">
                                <div class="form-group">
                                    <label for="category-name-input">Nombre</label>
                                    <input type="text" id="category-name-input" placeholder="Nombre de la categoría">
                                </div>

                                <div class="form-group">
                                    <label for="category-color-input">Color</label>
                                    <input type="color" id="category-color-input" value="#3498db">
                                </div>

                                <div class="form-group">
                                    <label for="category-icon">Ícono</label>
                                    <div class="icon-selector">
                                        <div class="selected-icon">
                                            <i class="fas fa-bolt" id="selected-icon-preview"></i>
                                            <input type="hidden" id="category-icon" value="fa-bolt">
                                        </div>
                                        <button type="button" class="btn btn-outline" id="change-icon-btn" onclick="showIconsGrid()">
                                            Cambiar ícono
                                        </button>
                                    </div>
                                    <div class="icons-grid" id="icons-grid">
                                        <button type="button" class="icon-option" data-icon="fa-home"><i
                                                class="fas fa-home"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-bolt"><i
                                                class="fas fa-bolt"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-tv"><i
                                                class="fas fa-tv"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-money-bill-wave"><i
                                                class="fas fa-money-bill-wave"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-university"><i
                                                class="fas fa-university"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-utensils"><i
                                                class="fas fa-utensils"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-gamepad"><i
                                                class="fas fa-gamepad"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-medkit"><i
                                                class="fas fa-medkit"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-plane"><i
                                                class="fas fa-plane"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-car"><i
                                                class="fas fa-car"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-graduation-cap"><i
                                                class="fas fa-graduation-cap"></i></button>
                                        <button type="button" class="icon-option" data-icon="fa-shopping-cart"><i
                                                class="fas fa-shopping-cart"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" id="delete-category">Eliminar</button>
                            <button class="btn btn-secondary" id="cancel-category" onclick="closeModal()">Cancelar</button>
                            <button class="btn btn-primary" id="save-category">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/categorias/categorias.js') }}" defer></script>
@endpush
