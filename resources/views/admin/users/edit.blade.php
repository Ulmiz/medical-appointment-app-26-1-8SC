<x-admin-layout title="Usuarios" :breadcrumbs="[
    [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Crear',
    ]
]">
    <x-wire-card>
        <x-validation-errors class="mb-4" />
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
                <div class="space-y-4">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <x-wire-input label="Nombre" name="name" placeholder="Nombre completo" autocomplete="name" required :value="old('name', $user->name)"></x-wire-input>

                        <x-wire-input label="Correo Electronico" name="email" placeholder="Correo electronico" autocompelete="email" required :value="old('email', $user->email)"></x-wire-input>

                        <x-wire-input label="Contraseña" type="password" name="password" placeholder="Mínimo 8 caracteres" autocomplete="new-password"></x-wire-input>
                        
                        <x-wire-input label="Confirmar Contraseña" type="password" name="password_confirmation" placeholder="Repita la contraseña" autocomplete="new-password"></x-wire-input>
                        
                        <x-wire-input label="Número de ID" name="id_number" placeholder="Número de identificación" required autocomplete="off" inputmode="numeric"  :value="old('id_number', $user->id_number)"></x-wire-input>

                        <x-wire-input label="Teléfono" name="phone" placeholder="Número de teléfono" required autocomplete="tel" inputmode="tel" :value="old('phone', $user->phone)"></x-wire-input>
                    </div>
                    <x-wire-input name="address" label="Dirección" placeholder="Ej. Calle 90 123" autocomplete="street-address" required :value="old('address', $user->address)"></x-wire-input>

                    <div class="space-y-1">
                        <x-wire-native-select name="role_id" label="Rol" required>
                            <option value="">Seleccionar rol</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected(old('role_id', $user->roles->first()->id) == $role->id)>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </x-wire-native-select>
                        <p class="text-sm text-gray-500">
                            Define los permisos y accesos del usuario
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <x-wire-button blue type="submit">
                            Actualizar
                        </x-wire-button>
                    </div>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>