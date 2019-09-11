<div class="dropdown">
    <button class="btn btn-dark dropdown-toggle" type="button" id="{{ $value['puskesmas_id'] }}"
            data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Action
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $value['puskesmas_id'] }}">
        <a class="dropdown-item btn-edit" href="{{ route('puskesmas.show', $value['puskesmas_id']) }}">Edit</a>
        <a class="dropdown-item btn-destroy" href="{{ route('puskesmas.destroy', $value['puskesmas_id']) }}">Hapus</a>
    </div>
</div>