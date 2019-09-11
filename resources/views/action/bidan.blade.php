@isset($type)
    <button class="btn btn-dark" type="button" data-value="{{ $value }}">Pilih Bidan</button>
@else
    <div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" type="button" id="{{ $value['bidan_id'] }}"
                data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            Action
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $value['bidan_id'] }}">
            <a class="dropdown-item btn-reward"
               data-id="{{ $value['bidan_id'] }}"
               href="{{ route('reward-bidan', $value['bidan_id']) }}">Reward</a>
            <a class="dropdown-item btn-edit" href="{{ route('bidan.show', $value['bidan_id']) }}">Edit</a>
            <a class="dropdown-item btn-destroy" href="{{ route('bidan.destroy', $value['bidan_id']) }}">Hapus</a>
        </div>
    </div>
@endisset