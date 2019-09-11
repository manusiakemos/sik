<div class="dropdown">
    <button class="btn btn-dark dropdown-toggle" type="button" id="{{ $value['user_id'] }}"
            data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Action
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $value['user_id'] }}">
{{--        <a class="dropdown-item btn-edit" href="{{ route('user.edit', $value['id']) }}">Edit</a>--}}
        <a class="dropdown-item btn-destroy" href="{{ route('user.destroy', $value['user_id']) }}">Hapus</a>
    </div>
</div>