<form wire:submit="store">
    <div class='row'>
        <div class="col-md-4 mb-4">
            <label>Nama</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.blur="name" />

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-4 mb-4">
            <label>Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" wire:model.blur="username" />

            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-4 mb-4">
            <label>Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.blur="email" />

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-12 mb-4">
            <label>Jabatan</label>
            <select class="form-select @error('role') is-invalid @enderror" wire:model.blur="role">
                @foreach ($roles as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                @endforeach
            </select>

            @error('type')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-md-12 mb-4">
            <label>Password</label>
            @if ($objId)
                <div class='fst-italic'>*Diisi jika ingin mengubah password</div>
            @endif
            <input type="password" class="form-control @error('password') is-invalid @enderror"
                wire:model.blur="password" />

            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        @if ($role === 'Admin' || $role === 'Staff')
            <div class="col-md-12 mb-4">
                <div class="w-100" wire:ignore>
                    <label>Hak Akses Studio</label>
                    <select id="select2-user-studio" class="form-select" multiple>
                        @foreach ($userStudios as $item)
                            <option value="{{ $item['id'] }}" selected>{{ $item['text'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

    </div>

    <button type="submit" class="btn btn-success mt-3">
        <i class='ki-duotone ki-check fs-1'></i>
        Save
    </button>
</form>

@push('js')
    <script>
        $(() => {
            // SELECT 2 STUDIO
            $('#select2-user-studio').select2({
                placeholder: "Pilih Studio",
                ajax: {
                    url: "{{ route('user.get.studio') }}",
                    dataType: "json",
                    type: "GET",
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        console.log(data)
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    "id": item.id,
                                    "text": item.text,
                                }
                            })
                        };
                    },
                },
                cache: true
            });

            $('#select2-user-studio').on('select2:select', function(e) {
                @this.call('selectStudio', e.params.data)
            });

            $('#select2-user-studio').on('select2:unselect', function(e) {
                @this.call('unselectStudio', e.params.data)
            });
        })
    </script>
@endpush
